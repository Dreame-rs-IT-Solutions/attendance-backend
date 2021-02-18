<?php

namespace App\Http\Requests\Teacher;

use App\Teacher;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TeacherShowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $authorizedUser = Auth::user();

        if ($authorizedUser->role == 'ADMINISTRATOR')
            return true;

        if ($authorizedUser->role == 'TEACHER') {
            $teacher = $this->route('teacher');
            $teacher = Teacher::findOrFail($teacher);

            $authorizedTeacher = $authorizedUser->profile;

            if ($teacher->id == $authorizedTeacher->id)
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
