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
        $count = DB::table('grp2_user')
            ->join('grp2_attendee','grp2_attendee.USER_ID','=','grp2_user.USER_ID')
            ->where('grp2_attendee.USER_ID', end($value))->count();



        foreach ($value as $initiator){
                if ($initiator == end($value)) {
                    $count++;
                }
        }

        $count--;

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
