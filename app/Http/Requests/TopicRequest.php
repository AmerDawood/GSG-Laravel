<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopicRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [

            'name' => ['required','string','max:255',function($attribute , $value,$fail){
                if($value == 'admin'){
                  return $fail("The name is Not Available");
                }
            }],
            'classroom_id' => 'required|string|max:255',

        ];
    }


    public function messages(): array
    {
        return [
            'name.required'=>'The name is requierd bro :)',
            'classroom_id.required'=>'Classroom id is required',
        ];
    }
}
