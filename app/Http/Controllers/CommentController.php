<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Resources\Comment as CommentResource;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($number = 4)
    {
        $comments = Comment::orderBy('created_at', 'desc')->take($number)->get();
        $commentsCount = Comment::count();
        return CommentResource::collection(
            $comments)->additional(['total_comments' => $commentsCount]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validate($request, [
            'text' => 'required|max:200',
        ]);

        $comment = new Comment();
        $comment->text = $request->input('text');
        $comment->user_id = $request->input('user_id');

        $return = ['success' => 'Comment Created'];
        if($comment->save()) {
            return response()->json($return);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        $return = ['success' => 'Comment Deleted'];
        if ($comment->delete()) {
            return response()->json($return);
        }
    }

//    @todo: delete after testing
    public function show(Comment $comment) {
        $user = \App\User::findOrFail(1);
//        dd(gettype($user->comments));
//        dd($user->comments->count());
//        dd($user->comments);
        dd($comment->user);
    }
}
