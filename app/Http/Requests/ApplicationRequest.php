<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->isStudent() || auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cover_letter' => 'required|min:200',
            'message' => 'nullable|min:100',
            'attachments' => 'nullable',
            'attachment_files' => 'nullable|array|max:10',
            'attachment_files.*' => 'file|max:10240',
        ];
    }
}
