<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentValidates\PostRequest;
use App\Models\Comment;

class CommentsController extends Controller
{
    /**
     * 140字以内かどうかチェックし、storeComment()で保存する。
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
