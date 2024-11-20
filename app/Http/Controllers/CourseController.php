<?php

namespace App\Http\Controllers;
use App\Models\Course;
use App\Models\User;
use App\Models\Roadmap;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class CourseController
{
    public function coursesWelcomePage () {
        $courses = Course::limit(4)->get();
        $newCourses = [];
        foreach ($courses as $course) {
            $obj = new \stdClass();
            $obj->name = $course->name;
            $obj->color = $course->color;
            $obj->image = $course->image;
            $newCourses[] = $obj;
        }
        return $newCourses;
    }
    public function subscribe ($CourseID,$UserID) {
        $course = Course::find($CourseID);
        $usr = User::find($UserID);
        if ($course && $usr) {
            $courses_sub = json_decode($usr->courses_sub, true);
            $usersCourse = json_decode($course->users, true);
            $IDs = [];
            foreach ($courses_sub as $c) {
                $IDs[] = (int) $c['id'];
            }
            if (!in_array((int) $UserID, $usersCourse) && !in_array((int) $CourseID, $IDs)) {
                $usersCourse[] = (int) $UserID;
                $course->users = json_encode($usersCourse);

                $objectCourse = (object) [
                    'id' => (int) $course->id,
                    'name' => $course->name,
                    'videos' => (int) $course->videos,
                    'videosEnd' =>  (int) 0,
                    'color' => $course->color
                ];
                $courses_sub[] = (object) $objectCourse;
                $usr->courses_sub = json_encode($courses_sub);

                $course->save();
                $usr->save();

                return redirect('/Courses')->with(['done' => "You Are Subscribed Now"]);
            }
            return redirect()->back()->with(['message' => "You Are Already Subscribed"]);
        }
        return redirect()->back()->withErrors(['message' => 'Not Found Course Or User']);
    }
    public function remove ($CourseID, $UserId) {
        $course = Course::find($CourseID);
        $usr = User::find($UserId);
        if ($course && $usr) {
            $usersCourse = json_decode($course->users, true);
            $courses_subUser = json_decode($usr->courses_sub, true);
            $IDs = [];
            foreach ($courses_subUser as $c) {
                $IDs[] = (int) $c['id'];
            }
            if (in_array((int) $CourseID,$IDs) && in_array((int) $UserId, $usersCourse)) {
                $usersCourse = array_filter($usersCourse, fn ($value) => $value !== (int) $UserId);
                $course->users = json_encode($usersCourse);

                $newCourses_sub = [];

                foreach ($courses_subUser as $c) {
                    if ((int) $c['id'] !== (int) $CourseID) {
                        $newCourses_sub[] = $c;
                    }
                }
                $courses_subUser = $newCourses_sub;
                $course->users = json_encode($usersCourse);
                $usr->courses_sub = json_encode($courses_subUser);
                $course->save();
                $usr->save();
                return redirect('/Courses')->with(['done' => "Completed Remove Course"]);
            }
            return redirect()->back()->with(['message' => 'You Are Already Not Subscribed']);
        }
        return redirect()->back()->withErrors(['message' => 'Not Found Course Or User']);
    }
    public function EndVideo (Request $request) {
        $data = $request->all();
        $usr = User::find($data['id']);
        $indexVideo = $data['indexVideo'];
        $IndexCourse = $data['IndexCourse'];
        if ($usr) {
            $courses_sub = json_decode($usr->courses_sub);
            if ($courses_sub[$IndexCourse]->videosEnd === $indexVideo) {
                $courses_sub[$IndexCourse]->videosEnd++;
                $usr->courses_sub = json_encode($courses_sub);
                $usr->save();
                return response()->json(['message' => 'Done Video']);
            }
            return response()->json(['message' => 'not ++ vides end']);
        }
        return response()->json(['message' => 'not found user'],404);
    }
    public function EndCourse (Request $request) {
        $data = $request->all();
        $userID = $data['userID'];
        $usr = User::find($userID);
        $IndexCourse = $data['IndexCourse'];
        if ($usr) {
            $courses_sub = json_decode($usr->courses_sub);
            if ($courses_sub) {
                $targetCourse = $courses_sub[$IndexCourse];
                $courses_end = json_decode($usr->courses_end);
                foreach($courses_end as $c) {
                    if ($c->id === $targetCourse->id) {
                        return response()->json(['message' => 'You Are Already End This Course']);
                    }
                }
                $courses_end[] = (object) $targetCourse;
                $usr->courses_end = json_encode($courses_end);
                $usr->save();
                return response()->json(['message' => 'Completed End Course']);
            }
            return response()->json(['message' => 'Something wrong']);
        }
        return response()->json(['message' => 'Not Found User'],404);
    }
    public function getCourses ($courses) {
        $usr = Auth::guard('web')->user();
        $courses = json_decode($courses);
        if ($usr) {
            $courses_sub = json_decode($usr['courses_sub']);
            $idCourses = array_map(fn($c) => $c->id,$courses_sub);
            $targetCourses = [];
            foreach ($courses as $c) :
                if (!in_array((int) $c , $idCourses)) {
                    $targetCourses[] = $c;
                }
            endforeach;
            if (count($targetCourses)) {
                foreach($targetCourses as $id) {
                    $c = Course::find($id);
                    $users = json_decode($c->users);
                    $users[] = $usr->id;
                    $c->users = json_encode($users);
                    $c->save();
                    $objectCourse = (object) [
                        'id' => $c['id'],
                        'name' => $c->name,
                        'videos' => (int) $c->videos,
                        'videosEnd' =>  (int) 0,
                        'color' => $c->color
                    ];
                    $courses_sub[] = $objectCourse;
                }
                $usr->courses_sub = json_encode($courses_sub);
                $usr->save();
                return redirect('/RoadMaps')->with(['done' => 'Completed Subscribe Courses']);
            }
            return redirect('/RoadMaps')->with(['message' => 'You Are Already Subscribed this courses']);
        }
        return redirect('/RoadMaps')->withErrors(['message' => 'Not Found This User']);
    }
    public function getAll () {
        $courses = Course::all();
        return response()->json(['courses' => $courses],200);
    }
    public function getAllRoadmaps () {
        $roadmaps = Roadmap::all();
        return response()->json(['roadmaps' => $roadmaps],200);
    }
}
