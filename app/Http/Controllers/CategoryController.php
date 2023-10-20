<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $categories = CategoryResource::collection(Category::with('posts.user')->get());
            return response()->json([
                'status' => 200,
                'message' => 'success',
                'amount' => $categories->count(),
                'datas' => $categories,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 400,
                'message' => $th->getMessage(),
                'amount' => null,
                'datas' => null,
            ], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $storeCategoryRequest)
    {
        DB::beginTransaction();
        try {
            $validated = $storeCategoryRequest->validated();

            $photo = fopen($storeCategoryRequest->file('image'), 'r');
            $image = Http::acceptJson()->attach(
                'image',
                $photo
            )->post('https://image-api-icourse.000webhostapp.com/api/upload-image', [
                'code' => '38@0$%8%^8/8471'
            ]);

            $validated['image'] = $image['image'];

            $store = Category::create($validated);
            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $store
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 400,
                'message' => $th->getMessage(),
                'data' => null,
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        try {
            $category = new CategoryResource(Category::where('slug', $slug)->with('posts.user')->firstOrFail());

            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $category
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => $th->getMessage(),
                'data' => null,
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $updateCategoryRequest, $slug)
    {
        DB::beginTransaction();
        try {
            $validated = $updateCategoryRequest->validated();

            if ($updateCategoryRequest->file('image')) {
                $photo = fopen($updateCategoryRequest->file('image'), 'r');
                $image = Http::acceptJson()->attach(
                    'image',
                    $photo
                )->post('https://image-api-icourse.000webhostapp.com/api/upload-image', [
                    'code' => '38@0$%8%^8/8471'
                ]);

                $validated['image'] = $image['image'];
            }

            $category = Category::where('slug', $slug)->firstOrFail();
            $category->update($validated);

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Updated successfully',
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 400,
                'message' => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        DB::beginTransaction();
        try {
            $Category = Category::where('slug', $slug)->firstOrFail();
            $Category->delete();
            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'deleted successfully'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 400,
                'message' => $th->getMessage()
            ], 400);
        }
    }
}
