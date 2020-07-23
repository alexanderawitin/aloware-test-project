<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\StoreComment;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreComment $request
     * @return Response
     */
    public function store(StoreComment $request)
    {
        $input = $request->validated();

        $post = $input['post_id'];
        $parent = $input['parent_id'];

        if ($post) {
            $post = Post::findOrFail($input['post_id']);
        } else {
            $parent = Comment::findOrFail($input['parent_id']);
        }

        $comment = new Comment([
            'user_name' => $input['user_name'],
            'body' => $input['body'],
        ]);

        if ($post) {
            $post->comments()->save($comment);
        } else {
            $parent->replies()->save($comment);
        }

        return response($comment->load(['commentable', 'replies', 'replies.parent']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
