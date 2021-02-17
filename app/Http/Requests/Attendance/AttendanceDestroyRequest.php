<?php

namespace App\Http\Requests\Attendance;

use App\Attendance;
use App\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AttendanceDestroyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $authorizedUser = Auth::user();

        if ($authorizedUser->role == 'TEACHER') {
            $student = $this->route('student');
            $student = Student::findOrFail($student);

            $attendance = $this->route('attendance');
            $attendance = Attendance::findOrFail($attendance);

            $authorizedTeacher = $authorizedUser->profile;

            if ($attendance->student->id == $student->id && $student->section->teacher->id == $authorizedTeacher->id)
                return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
