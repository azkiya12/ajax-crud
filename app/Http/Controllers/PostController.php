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

    public function show(Post $post)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail Post',
            'data' => $post 
        ]);
    }

    public function update(Request $request, Post $post)
    {
         //buat validasi
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);

        //cek jika validasi salah
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
            Log::info("error masuk");
        }

        //Update post
        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil diupdate',
            'data' => $post,
        ]);
    }

    public function destroy($id)
    {
        // delete Post by ID
        Post::Where('id',$id)->delete();

        //return response
        return response()->json([
            'success'=>true, 
            'message'=> 'Data post berhasil di hapus!.'
        ]);
    }
}
