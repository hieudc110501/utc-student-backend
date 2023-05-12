<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Carbon;

class BlogController extends Controller
{
    //insert blog
    public function insert(Request $request, $id)
    {
        $body = $request->input('body');
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $check = DB::table('blog')->insert([
            'studentId' => $id,
            'body' => $body,
            'image' => '',
            'createdAt' => $now,
        ]);

        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }

    //get blog
    public function get($id)
    {
        $check = DB::table('blog')
            ->where('blogId', $id)->first();

        if ($check) {
            return response()->json([], 200);
        } else {
            return response()->json(false, 400);
        }
    }

    //get all blog
    public function getAll()
    {
        $posts = DB::table('blog')
            ->select('blog.*', 'student.studentName', DB::raw('(SELECT COUNT(*) FROM comments WHERE comments.blogId = blog.blogId) as comments_count'), DB::raw('(SELECT COUNT(*) FROM likes WHERE likes.blogId = blog.blogId) as likes_count'))
            ->leftJoin('student', 'student.studentId', '=', 'blog.studentId')
            ->get();

        if ($posts) {
            return response()->json($posts, 200);
        } else {
            return response()->json(false, 400);
        }
    }

    //insert like
    public function insertLike(Request $request, $id)
    {
        $studentId = $request->input('studentId');
        $check = DB::table('likes')->insert([
            'blogId' => $id,
            'studentId' => $studentId,
        ]);

        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }

    //delete like
    public function deleteLike(Request $request)
    {
        $studentId = $request->input('studentId');
        $blogId = $request->input('blogId');
        $check = DB::table('likes')
            ->where('studentId', $studentId)
            ->where('blogId', $blogId)
            ->delete();

        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }

    //insert like
    public function getComment($id)
    {
        $check = DB::table('comments')->where('blogId', $id)->get();

        if ($check) {
            return response()->json($check, 200);
        } else {
            return response()->json(null, 400);
        }
    }

    //insert like
    public function insertComment(Request $request, $id)
    {
        $studentId = $request->input('studentId');
        $content = $request->input('content');
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $check = DB::table('comments')->insert([
            'blogId' => $id,
            'studentId' => $studentId,
            'content' => $content,
            'createdAt' => $now,
        ]);

        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }

    //delete like
    public function deleteComment($id)
    {
        $check = DB::table('comments')
            ->where('commentsId', $id)
            ->delete();

        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }
}
