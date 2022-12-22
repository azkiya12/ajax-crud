<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();
        return view('post', compact('posts'));
    }

    public function store(Request $request)
    {
        //buat validasi
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);

        //cek jika validasi salah
        if ($validator ->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil disimpan',
            'data' => $post,
        ]);
    }
}
