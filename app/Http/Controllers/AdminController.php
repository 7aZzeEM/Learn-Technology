<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Admin;
use App\Models\Course;
use App\Models\User;
use App\Models\Chat;
use App\Models\Roadmap;

class AdminController
{
    public function loginPage() {
        if (Auth::guard('admin')->check() || Auth::guard('web')->check()) {
            return redirect('/');
        }
        return view('admin.login');
    }
    public function AuthAdmin (Request $request) {
        $data = $request->all();
        $admin = Admin::where('email', $data['email'])->first();
        if ($admin) {
            if (Hash::check($data['pass'], $admin->password)) {
                Auth::guard('admin')->login($admin);
                return response()->json(['nameAdmin' => $admin['first_name']],200);
            }
            return response()->json(['message' => 'Wrong Password'], 500);
        }
        return response()->json(['message' => 'Not Found This Admin'],404);
    }
    public function controlPage() {
        return view('admin.control');
    }
    public function logout () {
        Auth::guard('admin')->logout();
        return redirect('/Administrator');
    }
    public function Courses () {
        $courses = Course::all();
        return view('admin.courses',['courses' => $courses]);
    }
    public function addCourse (Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:12'],
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,gif','max:8192'],
            'color' => ['required', 'string', 'max:20'],
            'videos' => ['required', 'array', 'min:1'],
            'videos.*' => ['file', 'mimes:mp4,avi,mkv'],
        ]);
        $data = $request->all();
        $name = $data['name'];
        $directive = resource_path('Courses/') . $name;
        $dirCourse = $directive . '/Course';
        if (!file_exists($directive)) {
            mkdir($directive,0777,true);
            mkdir($dirCourse,0777,true);
            $photo = $request->file('photo');
            $photo->move($directive,$photo->getClientOriginalName());
            $videos = $request->file('videos');
            foreach ($videos as $video) :
                $video->move($dirCourse,$video->getClientOriginalName());
            endforeach;
            $color = $data['color'];
            Course::create([
                'name' => $name,
                'color' => $color,
                'image' => $name . '/' . $photo->getClientOriginalName(),
                'videos' => count($videos),
                'users' => json_encode([]),
            ]);
            $allCourses = Course::all();
            return response()->json(['allCourses' => $allCourses],200);
        }
        return response()->json(['message' => 'This Course is already found'],500);
    }
    public function removeCourse ($courseId) {
        $course = Course::find($courseId);
        if ($course) {
            $users_sub = json_decode($course->users,true);
            foreach($users_sub as $id) {
                $u = User::find($id);
                if (!$u) {
                    return response()->json(['message' => 'Wrong when search to user'],500);
                }
                $courses = json_decode($u->courses_sub,true);
                $newCourses = [];
                foreach ($courses as $c) {
                    if ((int) $c['id'] !== (int) $courseId) {
                        $newCourses[] = $c;
                    }
                }
                $courses2 = json_decode($u->courses_end,true);
                $newCourses2 = [];
                foreach ($courses2 as $c) {
                    if ((int) $c['id'] !== (int) $courseId) {
                        $newCourses2[] = $c;
                    }
                }
                $u->courses_sub = json_encode($newCourses);
                $u->courses_end = json_encode($newCourses2);
                $u->save();
            }

            $course->delete();
            $chat = Chat::where('id_course',$courseId)->first();
            if ($chat) {
                $chat->delete();
            }
            $nameCourse = $course->name;
            $directiveCourse = $directive = resource_path('Courses/' . $nameCourse);
            if (File::exists($directiveCourse)) {
                File::deleteDirectory($directiveCourse);
            }
            $roadmaps = Roadmap::all();
            foreach ($roadmaps as $roadmap) {
                $coursesRoadmap = json_decode($roadmap->courses, true);
                $tmpArr = [];
                foreach ($coursesRoadmap as $tmp) {
                    if ((int) $tmp !== (int) $courseId) {
                        $tmpArr[] = $tmp;
                    }
                }
                $coursesRoadmap = $tmpArr;
                $roadmap->courses = json_encode($coursesRoadmap);
                $roadmap->count_courses = count($coursesRoadmap);
                $roadmap->save();
            }
            $courses = Course::all();
            return response()->json(['allCourses' => $courses],200);
        }
        return response()->json(['message' => 'This Course is not found'],404);
    }
    public function Roadmaps () {
        $roads = Roadmap::all();
        $courses = Course::all();
        return view('admin.roadmaps',['Roadmaps' => $roads, 'Courses' => $courses]);
    }
    public function addRoadmap (Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:30'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:8192'],
            'courses' => ['required', 'string'],
            'count' => ['required', 'integer', 'min:1'],
        ]);
        $data = $request->all();
        $photo = $request->file('image');
        $directivePhoto = resource_path('img/Roadmaps');
        if (file_exists($directivePhoto)) {
            $namePhoto = time() . $photo->getClientOriginalName();
            $photo->move($directivePhoto, $namePhoto);
            $courses = json_decode($data['courses']);
            Roadmap::create([
                'name_track' => $data['name'],
                'image' => $namePhoto,
                'count_courses' => (int) $data['count'],
                'courses' => $data['courses'],
            ]);
            $roadmaps = Roadmap::all();
            return response()->json(['Roadmaps' => $roadmaps],200);
        }
        return response()->json(['message' => 'Server Can\'t Found Photos Directory'], 500);
    }
    public function updateRoadmap (Request $request) {
        $request->validate([
            'id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:30'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:8192'],
            'courses' => ['required', 'string'],
            'count' => ['required', 'integer', 'min:1'],
        ]);
        $data = $request->all();
        $roadmap = Roadmap::find($data['id']);
        if ($roadmap) {
            if ($request->hasFile('image')) {
                $photo = $request->file('image');
                $directivePhoto = resource_path('img/Roadmaps');
                $oldPhoto = $directivePhoto . '/' . $roadmap->image;
                if (file_exists($oldPhoto)) {
                    File::delete($oldPhoto);
                }
                $namePhoto = time() . $photo->getClientOriginalName();
                $photo->move($directivePhoto , $namePhoto);
                $roadmap->image = $namePhoto;
            }
            $roadmap->name_track = $data['name'];
            $roadmap->count_courses = (int) $data['count'];
            $roadmap->courses = $data['courses'];
            $roadmap->save();
            $roadmaps = Roadmap::all();
            return response()->json(['newRoadmaps' => $roadmaps],200);
        }
        return response()->json(['message' => 'Not Found This Roadmap'],404);
    }
    public function removeRoadmap ($id) {
        $roadmap = Roadmap::find($id);
        if ($roadmap) {
            $directivePhoto = resource_path('img/Roadmaps/');
            $photo = $directivePhoto . $roadmap->image;
            if (file_exists($photo)) {
                File::delete($photo);
            }
            $roadmap->delete();
            $roadmaps = Roadmap::all();
            return response()->json(['allRoadmaps' => $roadmaps],200);
        }
        return response()->json(['message' => 'Can\'t Find This Roadmap'], 404);
    }
    public function Users () {
        $users = User::all();
        return view('admin.users',['Users' => $users]);
    }
    public function profileVisiting (Request $request) {
        $id = (int) $request->query('id');
        $usr = User::find($id);
        if ($usr) {
            return view('admin.viewing',['User' => $usr]);
        }
        return redirect()->back();
    }
    public function removeUser (Request $request) {
        $id = (int) $request->query('id');
        if (is_numeric($id)) {
            $usr = User::find($id);
            if ($usr) {
                $courses = json_decode($request->query('courses'));
                foreach($courses as $course) {
                    $c = Course::find($course);
                    $usrCourses = json_decode($c->users);
                    if (in_array($id,$usrCourses)) {
                        $key = array_search($id,$usrCourses);
                        if ($key !== false) {
                            unset($usrCourses[$key]);
                        }
                    }
                    $c->users = json_encode($usrCourses);
                    $c->save();
                }
                $usr->delete();
                $users = User::all();
                return response()->json(['allUsers' => $users], 200);
            }
            return response()->json(['message' => 'This User Not Found'],404);
        }
        return response()->json(['message' => 'This is Not ID'],500);
    }
    public function admins () {
        $admin = Auth::guard('admin')->user();
        $admins = Admin::all();
        return view('admin.admins', ['Admins' => $admins, 'Admin' => $admin]);
    }
    public function addAdminPage () {
        $admin = Auth::guard('admin')->user();
        if ($admin && $admin->powers) {
            return view('admin.addadmin',['Admin' => $admin]);
        }
        return redirect()->back();
    }
    public function CreateAdmin (Request $request) {
        $request->validate([
            'first_name' => ['required', 'regex:/^[A-Za-z]{3,}$/'],
            'last_name' => ['required', 'regex:/^[A-Za-z]{3,}$/'],
            'email' => ['required', 'regex:/^[A-Za-z0-9]+([-._][A-Za-z0-9]+)?@(gmail|hotmail|yahoo)\.com$/'],
            'password' => ['required', 'regex:/^\w{10,}$/'],
            'phone' => ['required', 'regex:/^01\d{9}$/'],
            'powers' => ['required', 'boolean'],
        ]);
        $data = $request->all();
        Admin::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'powers' => (boolean) $data['powers']
        ]);
        return response()->json(['message' => 'Completed Create Admin!'],200);
    }
    public function DeleteAdmin (Request $request) {
        $id = (int) $request->query('id');
        if ($id && is_numeric($id)) {
            $admin = Admin::find($id);
            if ($admin) {
                $AuthAdmin = Auth::guard('admin')->user();
                if ($AuthAdmin) {
                    if ($AuthAdmin->email === 'learntechnology@learntechnology.org') {
                        $admin->delete();
                        return response()->json(['message' => 'Completed Delete Admin'],200);
                    }
                    if ($AuthAdmin->powers && !$admin->powers) {
                        $admin->delete();
                        return response()->json(['message' => 'Completed Delete Admin'],200);
                    }
                    return response()->json(['message' => 'U Can\'t Delete This Admin'],500);
                }
                return response()->json(['message' => 'U Are Not Admin'],500);
            }
            return response()->json(['message' => 'Not Found This Admin'], 404);
        }
        return response()->json(['message' => 'What Is ID'],500);
    }
    public function Chats () {
        $admin = Auth::guard('admin')->user();
        return view('admin.chats', ['Admin' => $admin]);
    }
    public function clearChat (Request $request) {
        $id = (int) $request->query('id');
        if (is_numeric($id)) {
            $chat = Chat::where('id_course', $id)->first();
            if ($chat) {
                $admin = Auth::guard('admin')->user();
                if ($admin) {
                    $chat->chat = json_encode([]);
                    $chat->save();
                    return response()->json(['message' => $chat->chat],200);
                }
                return response()->json(['message' => "U are not admin"],500);
            }
            return response()->json(['message' => "Not Found This Chat"],404);
        }
        return response()->json(['message' => "This Is Not ID"],500);
    }
    public function EditUsernamePage () {
        $admin = Auth::guard('admin')->user();
        return view('admin.settings.editUsername', ['Admin' => $admin]);
    }
    public function EditUsername (Request $request) {
        $request->validate([
            'first_name' => ['required', 'regex:/^[A-Za-z]{3,}$/'],
            'last_name' => ['required', 'regex:/^[A-Za-z]{3,}$/'],
        ]);
        $admin = Auth::guard('admin')->user();
        if ($admin) {
            $data = $request->all();
            $admin->first_name = $data['first_name'];
            $admin->last_name = $data['last_name'];
            $newData = (object) [
                'fname' => $admin->first_name,
                'lname' => $admin->last_name
            ];
            $admin->save();
            return response()->json(['data' => $newData],200);
        }
        return response()->json(['message' => 'U must be login admin'], 500);
    }
    public function EditEmailPage () {
        $admin = Auth::guard('admin')->user();
        return view('admin.settings.editEmail', ['Admin' => $admin]);
    }
    public function EditEmail (Request $request) {
        $request->validate([
            'email' => ['required', 'regex:/^[A-Za-z0-9]+([-._][A-Za-z0-9]+)?@(gmail|hotmail|yahoo)\.com$/'],
        ]);
        $data = $request->all();
        $admin = Auth::guard('admin')->user();
        if ($admin) {
            $admin->email = $data['email'];
            $admin->save();
            return response()->json(['email' => $admin->email],200);
        }
        return response()->json(['message' => 'U must be login admin'], 500);
    }
    public function EditPasswordPage () {
        return view('admin.settings.editPassword');
    }
    public function EditPassword (Request $request) {
        $request->validate([
            'old_pass' => ['required', 'regex:/^\w{10,}$/'],
            'new_pass' => ['required', 'regex:/^\w{10,}$/'],
            'current_pass' => ['required', 'regex:/^\w{10,}$/']
        ]);
        $admin = Auth::guard('admin')->user();
        if ($admin) {
            $data = $request->all();
            if (Hash::check($data['old_pass'], $admin->password)) {
                if ($data['new_pass'] === $data['current_pass']) {
                    $admin->password = Hash::make($data['new_pass']);
                    $admin->save();
                    return response()->json(['message' => 'Completed Change Password'],200);
                }
                return response()->json(['message' => 'Current Password Is Wrong'],500);
            }
            return response()->json(['message' => 'Old Password Is Wrong, Try Again'],500);
        }
        return response()->json(['message' => 'U must be login admin'], 500);
    }
    public function EditPhonePage () {
        $admin = Auth::guard('admin')->user();
        return view('admin.settings.editPhone', ['Admin' => $admin]);
    }
    public function EditPhone (Request $request) {
        $request->validate([
            'phone' => ['required', 'regex:/^01\d{9}$/']
        ]);
        $admin = Auth::guard('admin')->user();
        if ($admin) {
            $data = $request->all();
            $admin->phone = $data['phone'];
            $admin->save();
            return response()->json(['phone' => $admin->phone],200);
        }
        return response()->json(['message' => 'U must be login admin'], 500);
    }
}
