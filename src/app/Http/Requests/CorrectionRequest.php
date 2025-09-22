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
      'punch_in' => 'before:punch_out',
      'rests.*.rest_in' => 'before:rests.*.rest_out',
      'remark' => 'required'
    ];
    }

    public function messages()
  {
    return [
      'punch_in.before' => '出勤時間もしくは退勤時間が不適切な値です',
      'rests.*.rest_in.before' => '休憩時間が勤務時間外です',
      'remark.required' => '備考を記入してください',
    ];
  }
}
