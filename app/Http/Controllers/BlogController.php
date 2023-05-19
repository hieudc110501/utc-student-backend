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
        $image = $request->input('image');
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $check = DB::table('blog')->insert([
            'studentId' => $id,
            'body' => $body,
            'image' => $image,
            'createdAt' => $now,
        ]);

        if ($check) {
            return response()->json(true, 200);
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

    public function update(Request $request, $id) {
        $body = $request->input('body');
        $studentId = $request->input('studentId');
        $image = $request->input('image');
        $createdAt = $request->input('createdAt');
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $updatedAt = Carbon::now()->format('Y-m-d H:i:s');
        $check = DB::table('blog')
        ->where('blogId', $id)
        ->update([
            'studentId' => $studentId,
            'body' => $body,
            'image' => $image,
            'createdAt' => $createdAt,
            'updatedAt' => $updatedAt,
        ]);

        if ($check) {
            return response()->json(true, 200);
        } else {
            return response()->json(false, 400);
        }
    }

    public function delete($id) {
        $deteteLike = DB::table('likes')
        ->where('blogId', $id)
        ->delete();

        $deteteComment = DB::table('comments')
        ->where('blogId', $id)
        ->delete();

        $check = DB::table('blog')
        ->where('blogId', $id)
        ->delete();

        if ($check && $deteteLike && $deteteComment) {
            return response()->json(true, 200);
        } else {
            return response()->json(false, 400);
        }
    }




    //get all blog
    public function getAll($studentId)
    {
        $posts = DB::table('blog')
            ->select(
                'blog.*',
                'student.studentName',
                DB::raw('(SELECT COUNT(*) FROM comments WHERE comments.blogId = blog.blogId) as commentCount'),
                DB::raw('(SELECT COUNT(*) FROM likes WHERE likes.blogId = blog.blogId) as likeCount'),
                DB::raw('CASE WHEN likes.blogId IS NULL THEN false ELSE true END AS isLiked'),
            )
            ->leftJoin('student', 'student.studentId', '=', 'blog.studentId')
            ->leftJoin('likes', function ($join) use ($studentId) {
                $join->on('blog.blogId', '=', 'likes.blogId')
                     ->where('likes.studentId', '=', $studentId);
            })
            ->orderBy('blog.createdAt', 'desc')
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
            return response()->json(true, 200);
        } else {
            return response()->json(null, 400);
        }
    }

    //delete like
    public function deleteLike(Request $request, $id)
    {
        $studentId = $request->input('studentId');
        $check = DB::table('likes')
            ->where('studentId', $studentId)
            ->where('blogId', $id)
            ->delete();

        if ($check) {
            return response()->json(true, 200);
        } else {
            return response()->json(null, 400);
        }
    }

    //insert like
    public function getComment($id)
    {
        $check = DB::table('comments')
        ->select('comments.*', 'student.studentName')
        ->where('blogId', $id)
        ->join('student', 'comments.studentId', '=', 'student.studentId')
        ->orderBy('comments.createdAt', 'desc')
        ->get();

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
        $image = $request->input('image');
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $check = DB::table('comments')->insert([
            'blogId' => $id,
            'studentId' => $studentId,
            'content' => $content,
            'image' => $image,
            'createdAt' => $now,
        ]);

        if ($check) {
            return response()->json(true, 200);
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
            return response()->json(true, 200);
        } else {
            return response()->json(null, 400);
        }
    }
}
