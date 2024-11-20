<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Course;
use App\Models\Roadmap;
use App\Models\User;

class PageController
{
    public function index () {
        if (Auth::guard('web')->check()) {
            return redirect('/Courses');
        }
        elseif (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();
            return redirect("/Admin/{$admin->first_name}");
        }
        return view('index');
    }
    public function courses () {
        $usr = Auth::guard('web')->user();
        $courses = Course::all();
        return view('courses', ['User' => $usr, 'Courses' => $courses]);
    }
    public function WatchCourse ($courseName) {
        $directive = resource_path("/Courses/${courseName}/Course");
        if (file_exists($directive)) {
            $videos = File::files($directive);
            if ($videos) {
                $videosName = array_map(function ($v) {
                    return $v->getFilename();
                }, $videos);
                $usr = Auth::guard('web')->user();
                return view('watch', ['videos' => json_encode($videosName), 'User' => $usr , 'Course' => $courseName]);
            }
            return redirect()->back()->with(['message' => 'This Course not have videos']);
        }
        return redirect()->back()->withErrors(['errors' => 'This Course Not Found']);
    }
    public function RoadMaps () {
        $usr = Auth::guard('web')->user();
        $courses = Course::all();
        $roadmaps = Roadmap::all();
        return view('roadmaps', ['User' => $usr, 'Courses' => $courses , 'Roadmaps' => $roadmaps]);
    }
    public function chats () {
        $usr = Auth::guard('web')->user();
        return view('chats', ['User' => $usr]);
    }
    public function profile () {
        $usr = Auth::guard('web')->user();
        return view('profile',['User' => $usr]);
    }
    public function editUsername () {
        $usr = Auth::guard('web')->user();
        return view('EditUsername', ['User' => $usr]);
    }
    public function editEmail () {
        $usr = Auth::guard('web')->user();
        return view('EditEmail', ['User' => $usr]);
    }
    public function editPass () {
        $usr = Auth::guard('web')->user();
        return view('EditPass', ['User' => $usr]);
    }
    public function editPhone () {
        $usr = Auth::guard('web')->user();
        return view('EditPhone', ['User' => $usr]);
    }
    public function resaultSearch (Request $request) {
        $value = $request->query('q');
        if (preg_match("/^[a-zA-Z0-9\+]+([-_.~][a-zA-Z0-9\+]+)*(\s[a-zA-Z0-9\+]+([-_.~][a-zA-Z0-9\+]+)*)*$/",$value)) {
            $usr = Auth::guard('web')->user();
            return view('search', ['User' => $usr, 'q' => $value]);
        }
        return redirect()->back();
    }
    public function visitUser (Request $request) {
        $id = (int) $request->query('id');
        $myId = Auth::guard('web')->user();
        if ($myId) {
            if ((int) $myId->id !== $id) {
                if (is_numeric($id)) {
                    $usrTest = User::select('photo', 'first_name', 'last_name', 'courses_sub', 'category', 'projects','links')->where('id', $id)->first();
                    if ($usrTest) {
                        $usr = Auth::guard('web')->user();
                        return view('visit',['User' => $usr , 'ID' => $id, 'Visit' => json_encode($usrTest)]);
                    }
                    return redirect()->back()->withErrors(['message' => 'this user not found']);
                }
                return redirect()->back()->withErrors(['message' => 'this not a number']);
            }
            return redirect()->back()->withErrors(['message' => 'U can\'t Visit Self']);
        }
        return redirect()->back()->withErrors(['message' => 'U must login before visit User']);
    }
}
