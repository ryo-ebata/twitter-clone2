<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentValidates\PostRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request, Comment $comment)
    {
        $user_id = auth()->id();
        $data = $request->all();
        $comment->storeComment($user_id, $data);

        return back();
    }
}
