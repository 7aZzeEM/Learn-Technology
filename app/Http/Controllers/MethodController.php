<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MethodController
{
    public function details () {
        $path = base_path('resources/JSON/details.json');
        if (!File::exists($path)) {
            return response()->json(['Error' => 'File Not Found'], 404);
        }
        return response()->json(json_decode(File::get($path)));
    }
    public function CoursesWelcome ($path, $path2) {
        $relative = resource_path("Courses/".$path."/".$path2);
        if (file_exists($relative)) {
            return response()->file($relative);
        }
        abort(404);
    }
    public function watchVideo ($course,$video) {
        $directive = resource_path("Courses/{$course}/Course/{$video}");

        if (file_exists($directive)) {
            return response()->file($directive);
        }
        
        return response()->json(['message' => 'Video Not Found'], 404);
    }
    public function imageRoadmap ($image) {
        $directive = resource_path("img/Roadmaps/{$image}");
        if (file_exists($directive)) {
            return response()->file($directive);
        }
        return response()->json(['message' => 'Image Not Found']);
    }
    public function imageProfile ($image) {
        $directive = resource_path("img/users/{$image}");
        if (file_exists($directive)) {
            return response()->file($directive);
        }
        return response()->json(['message' => 'Video Not Found'], 500);
    }
}
