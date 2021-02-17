<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\StudentDestroyRequest;
use App\Http\Requests\Student\StudentIndexRequest;
use App\Http\Requests\Student\StudentShowRequest;
use App\Http\Requests\Student\StudentStoreRequest;
use App\Http\Requests\Student\StudentUpdateRequest;
use App\Http\Resources\StudentResource;
use App\Section;
use App\Student;
use Illuminate\Http\Request;

class SectionStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int  $section
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StudentIndexRequest $request, int $section)
    {
        $section = Section::findOrFail($section);
        $sectionStudents = $section->students;

        return StudentResource::collection($sectionStudents);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $section
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentStoreRequest $request, int $section)
    {
        $student = Student::create(
            array_merge(
                $request->validated(),
                ['section_id' => $section]
            )
        );

        return new StudentResource($student);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $section
     * @param  int  $student
     * @return \Illuminate\Http\Response
     */
    public function show(StudentShowRequest $request, int $section, int $student)
    {
        $student = Student::whereId($student)->whereSectionId($section)->first();

        return new StudentResource($student);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $section
     * @param  int  $student
     * @return \Illuminate\Http\Response
     */
    public function update(StudentUpdateRequest $request, int $section, int $student)
    {
        $student = Student::whereId($student)->whereSectionId($section)->first();
        $student->update($request->validated());

        return new StudentResource($student);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $section
     * @param  int  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentDestroyRequest $request, int $section, int $student)
    {
        $student = Student::whereId($student)->whereSectionId($section)->first();
        $student->delete();

        return response(null);
    }
}
