<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTutorialRequest;
use App\Http\Requests\UpdateTutorialRequest;
use App\Http\Resources\TutorialResource;
use App\Models\Tutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TutorialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $tutorial = TutorialResource::collection(Tutorial::all());

            return response()->json([
                'status' => 200,
                'message' => 'success',
                'amount' => $tutorial->count(),
                'datas' => $tutorial
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 400,
                'message' => $th->getMessage(),
                'amount' => 0,
                'datas' => null
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
    public function store(StoreTutorialRequest $storeTutorialRequest)
    {
        DB::beginTransaction();
        try {
            $validated = $storeTutorialRequest->validated();

            $photo = fopen($storeTutorialRequest->file('image'), 'r');
            $image = Http::acceptJson()->attach(
                'image',
                $photo
            )->post('https://image-api-icourse.000webhostapp.com/api/upload-image', [
                'code' => '38@0$%8%^8/8471'
            ]);

            $validated['image'] = $image['image'];

            $tutorial = Tutorial::create($validated);
            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $tutorial
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'status' => 400,
                'message' => $th->getMessage(),
                'data' => null
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tutorial  $tutorial
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        try {
            $tutorial = Tutorial::where('slug', $slug)->firstOrFail();

            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $tutorial
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 400,
                'message' => $th->getMessage(),
                'data' => null
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tutorial  $tutorial
     * @return \Illuminate\Http\Response
     */
    public function edit(Tutorial $tutorial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tutorial  $tutorial
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTutorialRequest $updateTutorialRequest, $slug)
    {
        DB::beginTransaction();
        try {
            $validated = $updateTutorialRequest->validated();

            if ($updateTutorialRequest->file('image')) {
                $photo = fopen($updateTutorialRequest->file('image'), 'r');
                $image = Http::acceptJson()->attach(
                    'image',
                    $photo
                )->post('https://image-api-icourse.000webhostapp.com/api/upload-image', [
                    'code' => '38@0$%8%^8/8471'
                ]);

                $validated['image'] = $image['image'];
            }
            $tutorial = Tutorial::where('slug', $slug)->firstOrfail();
            $tutorial->update($validated);

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'success',
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 400,
                'message' => $th->getMessage(),
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tutorial  $tutorial
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        DB::beginTransaction();
        try {
            $tutorial = Tutorial::where('slug', $slug)->firstOrFail();
            $tutorial->delete();
            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'success',
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'status' => 400,
                'message' => $th->getMessage(),
            ], 400);
        }
    }
}
