<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClassroomRequest extends FormRequest
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
            'section' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'room' => 'required|string|max:255',
            // 'cover_image' => 'image|dimensions:width=200,height=100',
            'cover_image' => [
                $this->method()==="PUT"?'nullable':'required',

                // 'max:1024'  this line for files
                // Rule::dimensions([
                //     'min_width'=>600,
                //     'min_height'=>200,
                // ]),

                Rule::imageFile(),

            ],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required'=>'The name is requierd bro :)',
            'cover_image.dimensions'=>'Something Error In Image :)',
        ];
    }
}
