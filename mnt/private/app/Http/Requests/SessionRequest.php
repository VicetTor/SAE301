<?php

namespace App\Http\Requests;

use App\Rules\VerifSession;
use Illuminate\Foundation\Http\FormRequest;

class SessionRequest extends FormRequest
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
            'DATE' => 'required|after_or_equal:today',
            'time' => 'required',
            'lieu' => 'required|in:Milieu Naturel,Piscine',
            'user_id.*' => 'required|exists:grp2_user,USER_ID',
            'aptitude_id1.0' => 'required|exists:grp2_ability,ABI_ID',
            'initiator_id.*' => 'required|exists:grp2_user,USER_ID',
            //'initiator_id' => [new VerifSession($this)],
        ];
    }
}
