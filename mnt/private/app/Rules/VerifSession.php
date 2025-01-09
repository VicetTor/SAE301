<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerifSession implements Rule
{

    protected $request;

    /**
     * Crée une instance de la règle de validation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $count = DB::table('GRP2_USER')
            ->join('grp2_attendee','grp2_attendee.USER_ID','=','GRP2_USER.USER_ID')
            ->where('grp2_attendee.USER_ID', $value)->count();


        foreach ($this->request->initiator_id as $studentId){
            if ($studentId == $value){
                $count++;
            }
        }

        return $count < 2;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'l' . 'initiateur a deja 2 eleves';
    }
}
