<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Http\Requests\SectionAttendance\SectionAttendanceIndexRequest;
use App\Http\Requests\SectionAttendance\SectionAttendanceStoreRequest;
use App\Http\Resources\AttendanceResource;
use App\Section;
use Illuminate\Http\Request;

class SectionAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SectionAttendanceIndexRequest $request, int $section)
    {
        if ($request->input('date')) {
            $date = $request->input('date');

            $attendances = Attendance::select('attendances.*')
                                ->join('students', 'students.id', 'attendances.student_id')
                                ->where('students.section_id', $section)
                                ->where('attendances.date', $date)
                                ->get();

            return AttendanceResource::collection($attendances);
        }

        return response(null);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $section
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectionAttendanceStoreRequest $request, int $section)
    {
        $students = $request->validated()['students'];
        $attendanceDate = $request->validated()['date'];

        foreach($students as $student) {
            $studentAttendanceData = [
                'student_id' => $student['id'],
                'status' => $student['status'],
                'date' => $attendanceDate,
            ];

            Attendance::create($studentAttendanceData);
        }

        return response('Attendance Submitted');
    }
}
