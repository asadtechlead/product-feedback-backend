<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Feedback;
use App\Models\Setting;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $setting = Setting::where("name", "commentState")->first();
        if($setting && $setting->value !== "Enabled")
        {
            return $this->sendJson(['message' => 'Commenting is disabled'], false);
        }
        $fields = $request->validate([
            'content' => 'required|string',
            'feedback_id' => 'required|integer|exists:feedbacks,id'
        ]);
        $comment = new Comment($fields);
        $comment->user_id = auth()->user()->id;
        $comment->save();
        return $this->sendJson(['comment' => $comment->load('user')], true);
    }
}
