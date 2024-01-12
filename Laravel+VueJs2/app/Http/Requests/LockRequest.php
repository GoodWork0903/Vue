<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LockRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $input = $this->all();
        $input['title'] = trim($input['title']);
        $this->replace($input);

        return [
            'title' => 'required|string|max:255',
        ];
    }
}
