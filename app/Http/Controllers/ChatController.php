<?php

namespace App\Http\Controllers;

use App\Events\ChatMessage;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function showViewAdmin()
    {
        return view("admin.pages.chat.index");
    }

    public function send(Request $request)
    {
        $rules = [
            'message'=>'required|string|max:200'
        ];

        $messages = [
            'message.max' => 'Tin nhắn không được vượt quá 200 ký tự!'
        ];
        $request->validate($rules,$messages);
        $dataMessage = [
            //            "sender_id" => Auth::id(),
            "sender_id" => $request->input("sender_id"),
            "message" => $request->input('message'),
            "receiver_id" => $request->input('receiver_id'),
        ];
        $message = Message::create($dataMessage);
        $message->load('userSender');
        broadcast(new ChatMessage($message));
        return response()->json([
            "message" => $request->input("message"),
            "receiver_id" => $request->input("receiver_id")
        ]);
    }

    // lay tat ca tin nhan lien quan den user
    public function allChatOfMe(Request $request)
    {
        $userId = $request->query("userId");
        $messages = Message::with("userSender")->where("receiver_id", $userId)->orWhere("sender_id", $userId)->get()->toArray();
        //        dd($messageReceiver->toArray(), $userId);
        return response()->json([
            "messages" => $messages,
        ]);
    }

    public function deleteMessage(Request $request)
    {
        $userId = $request->input("userId");
        try {
            $result = Message::where("receiver_id", $userId)
                ->orWhere("sender_id", $userId)
                ->delete();
            return response()->json([
                "message" => "Xoa thanh cong" . $result
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                "message" => $exception->getMessage()
            ], 400);
        }
    }

    public function getChatUser(Request $request)
    {
        $users = $request->query("userId");
    }

    // id cua user nao nhan tin
    public function messageOfRoom($id) {}
}
