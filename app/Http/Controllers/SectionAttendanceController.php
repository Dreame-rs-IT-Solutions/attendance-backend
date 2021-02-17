<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Http\Requests\SectionAttendance\SectionAttendanceIndexRequest;
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
}
