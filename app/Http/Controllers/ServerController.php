<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ServerController
{
    public function registerAccount (Request $request) {
        $data = $request->validate([
            'account.Fname' => ['required', 'regex:/^[A-Za-z]{3,}$/'],
            'account.Lname' => ['required', 'regex:/^[A-Za-z]{3,}$/'],
            'account.email' => ['required', 'regex:/^[A-Za-z0-9]+([-._][A-Za-z0-9]+)?@(gmail|hotmail|yahoo)\.com$/'],
            'account.password' => ['required', 'regex:/^\w{10,}$/'],
            'account.phone' => ['required', 'regex:/^\d{11}$/']
        ]);
        if (strtolower($data['account']['Fname']) === 'admin' || strtolower($data['account']['Lname']) === 'admin') {
            return response()->json(['message' => 'U can\'t use admin name'],500);
        }
        $data['account']['password'] = Hash::make($data['account']['password']);
        $user = User::create([
            'first_name' => $data['account']['Fname'],
            'last_name' => $data['account']['Lname'],
            'email' => $data['account']['email'],
            'password' => $data['account']['password'],
            'phone' => $data['account']['phone'],
            'photo' => 'profile.png',
            'courses_sub' => json_encode(array()),
            'courses_end' => json_encode(array()),
            'category' => 'Student',
            'links' => json_encode(array()),
            'projects' => json_encode(array()),
        ]);

        Auth::guard('web')->login($user);

        return response()->json(['message' => 'Registration successful!'],201);
    }
    public function loginAccount (Request $request) {
        $data = $request->validate([
            'account.email' => ['required', 'regex:/^[A-Za-z0-9]+([-._][A-Za-z0-9]+)?@(gmail|hotmail|yahoo)\.com$/'],
            'account.pass' => ['required', 'regex:/^\w{10,}$/'],
        ]);

        $user = User::where('email', $data['account']['email'])->first();
        if ($user && Hash::check($data['account']['pass'], $user->password)) {
            Auth::guard('web')->login($user);
            return response()->json(["message" => $user['first_name']],200);
        }
        return response()->json(["message" => "not found"],404);
    }
    public function logout () {
        Auth::guard('web')->logout();
        return redirect('/');
    }
    public function uploadProfilePhoto (Request $request) {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);
        if ($request->file('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $directive = resource_path("img/users");
            if (!file_exists($directive)) {
                mkdir($directive, 0777, true);
            }
            $file->move($directive, $filename);
            $usr = Auth::guard('web')->user();
            $oldPhoto = $usr->photo;
            $pathOldPhoto = $directive . '/' . $oldPhoto;
            $staticPhoto = resource_path("img/users/profile.png");
            if ($pathOldPhoto && $pathOldPhoto !== $staticPhoto) {
                unlink($pathOldPhoto);
            }
            $usr->photo = $filename;
            $usr->save();
            return response()->json(['image' => $filename],200);
        }
        return response()->json(['message' => 'something wrong try again'], 500);
    }
    public function removePhotoProfile () {
        $usr = Auth::guard('web')->user();
        $oldPhoto = $usr->photo;
        $directive = resource_path("img/users");
        if (!file_exists($directive)) {
            mkdir($directive, 0777, true);
        }
        $pathOldPhoto = $directive . '/' . $oldPhoto;
        if (file_exists($pathOldPhoto)) {
            unlink($pathOldPhoto);
        }
        $usr->photo = "profile.png";
        $usr->save();
        return response()->json(['image' => 'profile.png'],200);
    }
    public function changeCategory (Request $request) {
        $request->validate([
            'category' => ['required', 'regex:/^(?=.{5,24}$)[a-zA-Z]+(?:[-._][a-zA-Z]+)*(?: [a-zA-Z]+)*$/'],
        ]);
        $data = $request->all();
        $newCategory = $data['category'];
        $usr = Auth::guard('web')->user();
        if ($usr) {
            $usr->category = $newCategory;
            $usr->save();
            return response()->json(['category' => $newCategory]);
        }
        return response()->json(['message' => 'Can\'t Found User'], 500);
    }
    public function addNewLink (Request $request) {
        $request->validate([
            'name' => ['required', 'regex:/^\w{0,15}/'],
            'url' => ['required', 'regex:/^https:\/\/[a-zA-Z0-9]+([-_.][a-zA-Z0-9]+)*\.[a-zA-Z]{2,}(\/[a-zA-Z0-9]+[-._][a-zA-Z0-9]+)*/']
        ]);
        $data = $request->all();
        $usr = Auth::guard('web')->user();
        $linksUser = json_decode($usr->links);
        if (count((array)$linksUser) < 5) {
            $linksUser[] = (object) $data;
            $usr->links = json_encode($linksUser);
            $usr->save();
            return response()->json(['links' => $linksUser],200);
        }
        return response()->json(['message' => 'You can have more than 5 links'],500);
    }
    public function deleteLink ($index) {
        if(is_numeric($index)) {
            $usr = Auth::guard('web')->user();
            if ($usr) {
                $links = json_decode($usr->links);
                unset($links[$index]);
                $usr->links = json_encode($links);
                $usr->save();
                return response()->json(['links' => $links],200);
            }
            return response()->json(['message' => 'Not found user'], 500);
        }
        return response()->json(['message' => 'Not a number'],500);
    }
    public function editUser (Request $request) {
        $request->validate([
            'first_name' => ['required', 'regex:/^[A-Za-z]{3,}$/'],
            'last_name' => ['required', 'regex:/^[A-Za-z]{3,}$/']
        ]);
        $data = $request->all();
        $usr = Auth::guard('web')->user();
        $fname = $usr->first_name;
        $lname = $usr->last_name;
        if ($data['first_name'] !== $fname && $data['last_name'] !== $lname) {
            $usr->first_name = $data['first_name'];
            $usr->last_name = $data['last_name'];
            $usr->save();
            return response()->json(['message' => 'Done'],200);
        }
        return response()->json(['message' => 'You not updata username'],500);
    }
    public function editEmailuser (Request $request) {
        $request->validate([
            'email' => ['required', 'regex:/^[A-Za-z0-9]+([-._][A-Za-z0-9]+)?@(gmail|hotmail|yahoo)\.com$/'],
        ]);
        $data = $request->all();
        $usr = Auth::guard('web')->user();
        $email = $usr->email;
        if ($data['email'] !== $email) {
            $usr->email = $data['email'];
            $usr->save();
            return response()->json(['message' => 'Done'],200);
        }
        return response()->json(['message' => 'You not updata email'],500);
    }
    public function editPassword (Request $request) {
        $request->validate([
            'oldPass' => ['required', 'regex:/^\w{10,}$/'],
            'pass' => ['required', 'regex:/^\w{10,}$/'],
            'CurrentPass' => ['required', 'regex:/^\w{10,}$/']
        ]);
        $data = $request->all();
        $usr = Auth::guard('web')->user();
        $oldPass = $usr->password;
        if (Hash::check($data['oldPass'], $oldPass)) {
            if ($data['pass'] === $data['CurrentPass']) {
                $usr->password = Hash::make($data['pass']);
                $usr->save();
                return response()->json(['message' => 'Done'],200);
            }
            return response()->json(['message' => 'Wrong Current Password Try Again'], 500);
        }
        return response()->json(['message' => 'Wrong Password try again Old Password'],500);
    }
    public function editPhoneUser (Request $request) {
        $request->validate([
            'phone' => ['required', 'regex:/^\d{11}$/']
        ]);
        $data = $request->all();
        $usr = Auth::guard('web')->user();
        $phoneOld = $usr->phone;
        if ($data['phone'] !== $phoneOld) {
            $usr->phone = $data['phone'];
            $usr->save();
            return response()->json(['message' => 'Done'],200);
        }
        return response()->json(['message' => 'You not updata phone'],500);
    }
    public function addNewProject (Request $request) {
        $request->validate([
            'name' => ['required', 'regex:/^\w{0,15}/'],
            'url' => ['required', 'regex:/^https:\/\/[a-zA-Z0-9]+([-_.][a-zA-Z0-9]+)*\.[a-zA-Z]{2,}(\/[a-zA-Z0-9]+[-._][a-zA-Z0-9]+)*/']
        ]);
        $data = $request->all();
        $usr = Auth::guard('web')->user();
        $projectsUser = json_decode($usr->projects);
        $projectsUser[] = (object) $data;
        $usr->projects = json_encode($projectsUser);
        $usr->save();
        return response()->json(['projects' => $projectsUser]);
    }
    public function deleteProject ($index) {
        if(is_numeric($index)) {
            $usr = Auth::guard('web')->user();
            if ($usr) {
                $projects = json_decode($usr->projects);
                unset($projects[$index]);
                $usr->projects = json_encode($projects);
                $usr->save();
                return response()->json(['projects' => $projects],200);
            }
            return response()->json(['message' => 'Not found user'], 500);
        }
        return response()->json(['message' => 'Not a number'],500);
    }
    public function getAllUsers () {
        $users = User::select('id', 'first_name', 'last_name', 'category','photo')->get();
        return response()->json(['users' => $users]);
    }
}
