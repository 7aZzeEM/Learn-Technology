<?php

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CourseController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\MethodController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AdminController;

use App\Http\Middleware\CheckAuth;

Route::get('/API/Welcome/Courses',[CourseController::class,'coursesWelcomePage']);
Route::get('/subscribe/course/{CourseID}/user/{UserID}',[CourseController::class, 'subscribe']);
Route::get('/remove/course/{CourseID}/user/{UserId}', [CourseController::class, 'remove']);
Route::post('/video/end',[CourseController::class, 'EndVideo']);
Route::post('/End/Course', [CourseController::class, 'EndCourse']);
Route::get('/Get/Courses/{courses}', [CourseController::class, 'getCourses']);
Route::post('/get/all/courses', [CourseController::class, 'getAll']);
Route::post('/get/all/roadmaps', [CourseController::class, 'getAllRoadmaps']);

Route::get('/',[PageController::class, 'index']);
Route::get('/login', [PageController::class, 'index'])->name('login');
Route::get('/Courses', [PageController::class, 'courses'])->middleware('auth:web');
Route::get('/Watch/{courseName}', [PageController::class, 'WatchCourse'])->middleware('auth:web');
Route::get('/RoadMaps', [PageController::class, 'RoadMaps'])->middleware('auth:web');
Route::get('/Chats', [PageController::class, 'chats'])->middleware('auth:web');
Route::get('/Profile', [PageController::class, 'profile'])->middleware('auth:web');
Route::get('/Edit/username', [PageController::class, 'editUsername'])->middleware('auth:web');
Route::get('/Edit/email', [PageController::class, 'editEmail'])->middleware('auth:web');
Route::get('/Edit/password', [PageController::class, 'editPass'])->middleware('auth:web');
Route::get('/Edit/phone', [PageController::class, 'editPhone'])->middleware('auth:web');
Route::get('/search', [PageController::class, 'resaultSearch'])->middleware('auth:web');
Route::get('/user/profile', [PageController::class, 'visitUser'])->middleware('auth:web');

Route::post('/server/register', [ServerController::class, 'registerAccount']);
Route::post('/server/login', [ServerController::class, 'loginAccount']);
Route::get('/logout', [ServerController::class, 'logout']);
Route::post('/upload/photo', [ServerController::class, 'uploadProfilePhoto']);
Route::post('/remove/profile/photo' , [ServerController::class, 'removePhotoProfile']);
Route::post('/update/category', [ServerController::class, 'changeCategory']);
Route::post('/add/link', [ServerController::class, 'addNewLink']);
Route::post('/delete/link/{index}', [ServerController::class, 'deleteLink']);
Route::post('/add/project', [ServerController::class, 'addNewProject']);
Route::post('/delete/project/{index}', [ServerController::class, 'deleteProject']);
Route::post('/edit/username/user', [ServerController::class, 'editUser']);
Route::post('/edit/email/user', [ServerController::class, 'editEmailuser']);
Route::post('/edit/password/user', [ServerController::class, 'editPassword']);
Route::post('/edit/phone/user', [ServerController::class, 'editPhoneUser']);
Route::post('/get/all/users', [ServerController::class, 'getAllUsers']);

Route::get('/API/details', [MethodController::class, 'details']);
Route::get('/photos/{path}/{path2}', [MethodController::class, 'CoursesWelcome']);
Route::get('/video/watch/{course}/{video}', [MethodController::class, 'watchVideo']);
Route::get('/Image/Roadmap/{image}', [MethodController::class, 'imageRoadmap']);
Route::get('/Profile/Photo/{image}', [MethodController::class, 'imageProfile']);

Route::post('/chat/send/message', [ChatController::class, 'SaveMessage']);
Route::post('/chat/get/chats', [ChatController::class, 'getChat']);

Route::get('/Administrator', [AdminController::class, 'loginPage']);
Route::post('/Admin/Authentication', [AdminController::class , 'AuthAdmin']);
Route::get('/Admin/{name}', [AdminController::class, 'controlPage'])->middleware('auth:admin');
Route::get('/logout/admin', [AdminController::class, 'logout'])->middleware('auth:admin');
Route::get('/Admin/Control/Courses', [AdminController::class, 'Courses'])->middleware('auth:admin');
Route::post('/Admin/Add/Course', [AdminController::class, 'addCourse'])->middleware('auth:admin');
Route::post('/Admin/remove/course/{id}', [AdminController::class, 'removeCourse'])->middleware('auth:admin');
Route::get('/Admin/Control/RoadMaps', [AdminController::class, 'Roadmaps'])->middleware('auth:admin');
Route::post('/Admin/Add/Roadmap', [AdminController::class, 'addRoadmap'])->middleware('auth:admin');
Route::post('/Admin/Update/Roadmap', [AdminController::class, 'updateRoadmap'])->middleware('auth:admin');
Route::post('/Admin/Remove/Roadmap/{id}', [AdminController::class, 'removeRoadmap'])->middleware('auth:admin');
Route::get('/Admin/Control/Users', [AdminController::class, 'Users'])->middleware('auth:admin');
Route::get('/Admin/Visit/User', [AdminController::class, 'profileVisiting'])->middleware('auth:admin');
Route::post('/Admin/Remove/User', [AdminController::class, 'removeUser'])->middleware('auth:admin');
Route::get('/Admin/Control/Admins', [AdminController::class, 'admins'])->middleware('auth:admin');
Route::get('/Admin/Add/Admin', [AdminController::class, 'addAdminPage'])->middleware('auth:admin');
Route::post('/Admin/Create/Admin', [AdminController::class, 'CreateAdmin'])->middleware('auth:admin');
Route::post('/Admin/Remove/Admin', [AdminController::class, 'DeleteAdmin'])->middleware('auth:admin');
Route::get('/Admin/Control/Chats', [AdminController::class, 'Chats'])->middleware('auth:admin');
Route::post('/Admin/Clear/Chat', [AdminController::class, 'clearChat'])->middleware('auth:admin');
Route::get('/Admin/Edit/Username', [AdminController::class, 'EditUsernamePage'])->middleware('auth:admin');
Route::post('/Admin/Change/Username', [AdminController::class, 'EditUsername'])->middleware('auth:admin');
Route::get('/Admin/Edit/Email', [AdminController::class, 'EditEmailPage'])->middleware('auth:admin');
Route::post('/Admin/Change/Email', [AdminController::class, 'EditEmail'])->middleware('auth:admin');
Route::get('/Admin/Edit/Password', [AdminController::class, 'EditPasswordPage'])->middleware('auth:admin');
Route::post('/Admin/Change/Password', [AdminController::class, 'EditPassword'])->middleware('auth:admin');
Route::get('/Admin/Edit/Phone', [AdminController::class, 'EditPhonePage'])->middleware('auth:admin');
Route::post('/Admin/Change/Phone', [AdminController::class, 'EditPhone'])->middleware('auth:admin');
