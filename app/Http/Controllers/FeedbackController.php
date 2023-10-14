<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::orderBy('id', 'desc')->with('user')->paginate(4);
        return $this->sendJson(['feedbacks' => $feedbacks], true);
    }

    public function show(Feedback $feedback)
    {
        return $this->sendJson(['feedback' => $feedback->load(['comments.user' => function ($query) {
            $query->orderBy('id', 'desc');
        }, 'user'])], true);
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string'
        ]);

        $fields['votes'] = 0;
        $fields['user_id'] = auth()->user()->id;
        $feedback = Feedback::create($fields);
        return $this->sendJson(['feedback' => $feedback->load("user")], true);
    }

    public function vote(Feedback $feedback)
    {
        $feedback->votes += 1;
        $feedback->save();
        return $this->sendJson(['votes' => $feedback->votes], true);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Feedback $feedback)
    {
        $this->authorize('delete', Feedback::class);

        $feedback->delete();
        return $this->sendJson(["success"=>true], true);
    }

}
