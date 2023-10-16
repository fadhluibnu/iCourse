<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostCollection;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $posts = PostCollection::collection(Post::with('user')->get());
            return response()->json([
                'status' => 200,
                'message' => 'success',
                'amount' => $posts->count(),
                'datas' => $posts,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 400,
                'message' =>$th->getMessage(),
                'amount' => null,
                'datas' => null,
            ],400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $storePostRequest)
    {
        DB::beginTransaction();
        try {
            $store = Post::create($storePostRequest->validated());
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $store
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 400,
                'message' => $th->getMessage(),
                'data' => null,
            ],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        try {
            $post = new PostCollection(Post::where('slug', $slug)->with('user')->first());
            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $post
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => $th->getMessage(),
                'data' => null,
            ],404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        return $slug;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}