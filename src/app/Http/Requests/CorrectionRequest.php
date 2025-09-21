<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CorrectionRequest extends FormRequest
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
    return [
        'work' => ['required', 'min:'],
        'rest' => ['required'],
        'remark' => ['required']
    ];
    }

    public function messages()
  {
    return [
      'remarks.required' => '備考を記入してください',
    ];
  }
}
