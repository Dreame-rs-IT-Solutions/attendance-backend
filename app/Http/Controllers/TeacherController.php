<?php

namespace App\Http\Controllers;

use App\Http\Requests\Teacher\TeacherDestroyRequest;
use App\Http\Requests\Teacher\TeacherIndexRequest;
use App\Http\Requests\Teacher\TeacherShowRequest;
use App\Http\Requests\Teacher\TeacherStoreRequest;
use App\Http\Requests\Teacher\TeacherUpdateRequest;
use App\Http\Resources\TeacherResource;
use App\Teacher;
use App\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TeacherIndexRequest $request)
    {
        $teachers = Teacher::all();

        return TeacherResource::collection($teachers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeacherStoreRequest $request)
    {
        $user = User::create(
            array_merge(
                $request->validated(),
                ['role' => 'TEACHER']
            )
        );

        $teacher = Teacher::create(array_merge(
            $request->validated(),
            ['user_id' => $user->id]
        ));

        return new TeacherResource($teacher);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(TeacherShowRequest $request, int $teacher)
    {
        $teacher = Teacher::findOrFail($teacher);

        return new TeacherResource($teacher);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(TeacherUpdateRequest $request, int $teacher)
    {
        $teacher = Teacher::findOrFail($teacher);
        $teacher->update($request->validated());

        $teacherUser = User::findOrFail($teacher->user_id);
        $teacherUser->update($request->validated());

        return new TeacherResource($teacher);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeacherDestroyRequest $request, int $teacher)
    {
        $teacher = Teacher::findOrFail($teacher);
        $teacher->delete();

        return response(null);
    }
}
