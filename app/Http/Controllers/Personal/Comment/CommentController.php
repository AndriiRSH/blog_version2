<?php

namespace App\Http\Controllers\Personal\Comment;

use App\Http\Controllers\Controller;


class CommentController extends Controller
{
    public function __invoke()
    {
        $comments = auth()->user()->comments;
//        dd($comment);
        return view('personal.comment.index', compact('comments'));
    }
}
