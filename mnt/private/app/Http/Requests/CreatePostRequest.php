<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
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
            'TYPE_ID' => 'required|integer',
            'LEVEL_ID' => 'required|integer',
            'LEVEL_ID_RESUME' => 'required|integer',
            'USER_MAIL' => 'required|email',
            'USER_LASTNAME' => 'required|string|max:25',
            'USER_FIRSTNAME' => 'required|string|max:25',
            'USER_ADDRESS' => 'required|string|max:255',
            'USER_POSTALCODE' => 'required|integer|min:1000|max:99999',
            'USER_LICENSENUMBER' => 'required|string|regex:/^A-\d{2}-\d{7}$/|unique:grp2_user,USER_LICENSENUMBER',
            'USER_MEDICCERTIFICATEDATE' => 'required|date|before_or_equal:today',
            'USER_BIRTHDATE' => 'required|date|before_or_equal:today',
            'USER_PHONENUMBER' => 'required|numeric|digits_between:10,10|regex:/^0/',
        ];
    }
}