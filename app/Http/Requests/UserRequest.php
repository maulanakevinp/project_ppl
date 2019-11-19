<?php

namespace App\Http\Requests;

use App\Rules\NewHeadDepartement;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name'  => ['required','max:60'],
            'image' => ['image', 'mimes:jpeg,png,gif', 'max:2048']
        ];

        if (request()->isMethod('post')) {
            $rules['nip']   = ['required', 'digits:18', 'unique:users'];
            $rules['role']  = ['required', new NewHeadDepartement];
            $rules['image'] = ['required','image', 'mimes:jpeg,png,gif', 'max:2048'];
        } elseif (request()->isMethod('put')) {
            $rules['nip']   = ['required', 'digits:18'];
            $rules['role']  = ['required', new NewHeadDepartement];
        }

        return $rules;
    }
}
