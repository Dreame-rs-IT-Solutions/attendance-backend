<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Http\Requests\Attendance\AttendanceDestroyRequest;
use App\Http\Requests\Attendance\AttendanceIndexRequest;
use App\Http\Requests\Attendance\AttendanceShowRequest;
use App\Http\Requests\Attendance\AttendanceStoreRequest;
use App\Http\Requests\Attendance\AttendanceUpdateRequest;
use App\Http\Resources\AttendanceResource;
use App\Student;
use Illuminate\Http\Request;

class StudentAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AttendanceIndexRequest $request, int $student)
    {
        $student = Student::findOrFail($student);
        $studentAttendances = $student->attendances;

        return AttendanceResource::collection($studentAttendances);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttendanceStoreRequest $request, int $student)
    {
        $attendance = Attendance::create(
            array_merge(
                $request->validated(),
                ['student_id' => $student]
            )
        );

        return new AttendanceResource($attendance);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(AttendanceShowRequest $request, int $student, int $attendance)
    {
        $attendance = Attendance::whereId($attendance)->whereStudentId($student)->first();

        return new AttendanceResource($attendance);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttendanceUpdateRequest $request, int $student, int $attendance)
    {
        $attendance = Attendance::whereId($attendance)->whereStudentId($student)->first();
        $attendance->update($request->validated());

        return new AttendanceResource($attendance);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttendanceDestroyRequest $request, int $student, int $attendance)
    {
        $attendance = Attendance::whereId($attendance)->whereStudentId($student)->first();
        $attendance->delete();

        return response(null);
    }
}
