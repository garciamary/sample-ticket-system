<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Routing\Redirector;

class CommentController extends Controller
{
    public function store(Request $request){

        $ticket_id =  $request->input('ticket_id');
        $messages =  $request->input('messages');
        $user_id =  $request->user()->id;

        var_dump([$ticket_id, $messages]);
        $comments = new Comment;

        $comments->ticket_id = $ticket_id;
        $comments->messages = $messages;
        $comments->user_id = $user_id;
        $comments->save();

        // return redirect()->route('tickets', ['id => $ticket_id']);
        return redirect()->back();

    }

    public function destroy($id, Request $request){


    }
}
