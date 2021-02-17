<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TeacherDestroyRequest extends FormRequest
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
