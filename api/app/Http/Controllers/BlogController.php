<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use App\Http\Requests\BlogRequest;
use Illuminate\Http\Request;


class BlogController extends Controller
{

    public function index(Request $req)
    {
        return Blog::where('user_id', $req->user()->id)->get();
    }

    public function show(Request $req, $id)
    {
        return Blog::where('user_id', $req->user()->id)->find($id);
    }

    public function store(BlogRequest $req)
    {
        Blog::create($req->all());
        return response()->json([
            'message' => 'Blog successfully created'
        ], 201);
    }

    public function edit(BlogRequest $req)
    {
        $blog = Blog::find($req['_id']);

        if (!$blog) {
            return response()->json([
                'message' => 'Blog not found'
            ], 404);
        }

        $blog->update($req->all());
        return response()->json([
            'message' => 'Blog successfully updated'
        ], 201);
    }

    public function destroy($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json([
                'message' => 'Blog not found'
            ], 404);
        }

        $blog->delete();
        return response()->json([
            'message' => 'Blog successfully deleted'
        ], 201);
    }
}
