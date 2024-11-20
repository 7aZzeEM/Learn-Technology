<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use App\Models\Admin;

class ChatController
{
    public function SaveMessage (Request $request) {
        $data = $request->all();
        if ($data) {
            $id_course = $data['course_id'];
            $id_user = $data['user_id'];
            $message = $data['message'];
            $username = $data['username'];
            $targetChat = Chat::where('id_course', $id_course)->first();
            if ($targetChat) {
                $chats = json_decode($targetChat->chat);
                $usr = User::find($id_user);
                if ($usr) {
                    $chats[] = (object) [
                        'id_user' => $id_user,
                        'message' => $message,
                        'username' => $username,
                    ];
                    $targetChat->chat = json_encode($chats);
                    $targetChat->save();
                    return response()->json(['message' => 'Completed Save Message']);
                }
                $admin = Admin::find($id_user);
                if ($admin) {
                    $chats[] = (object) [
                        'id_user' => $id_user,
                        'message' => $message,
                        'username' => $username,
                    ];
                    $targetChat->chat = json_encode($chats);
                    $targetChat->save();
                    return response()->json(['message' => 'Completed Save Message']);
                }
                return response()->json(['message' => 'not found user']);
            }
            return response()->json(['message' => 'not found chat']);
        }
        return response()->json(['message' => 'no data sended']);
    }
    public function getChat(Request $request) {
        $data = $request->all();
        if ($data) {
            $id_course = $data['id_course'];
            $targetChat = Chat::where('id_course', $id_course)->first();
            if ($targetChat) {
                return response()->json(['message' => $targetChat->chat],200);
            }
            Chat::create([
                'id_course' => $id_course,
                'chat' => json_encode([]),
            ]);
            return response()->json(['message' => $targetChat->chat],200);
        }
        return response()->json(['message' => 'No Data Sended'], 500);
    }
}
