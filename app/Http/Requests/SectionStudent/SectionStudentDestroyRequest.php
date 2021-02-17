<?php

namespace App\Http\Requests\Student;

use App\Section;
use App\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SectionStudentDestroyRequest extends FormRequest
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
            $section = $this->route('section');
            $section = Section::findOrFail($section);

            $student = $this->route('student');
            $student = Student::findOrFail($student);

            $authorizedTeacher = $authorizedUser->profile;

            if ($student->section->id == $section->id && $section->teacher->id == $authorizedTeacher->id)
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
