<?php

namespace App\Http\Requests\Attendance;

use App\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AttendanceStoreRequest extends FormRequest
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

            $authorizedTeacher = $authorizedUser->profile;

            if ($student->section->teacher->id == $authorizedTeacher->id)
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
            'date' => 'required|date',
            'status' => 'required|in:PRESENT,ABSENT,EXCUSED'
        ];
    }
}
