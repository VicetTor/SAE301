<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    use HasFactory;
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'GRP2_ATTENDEE';


    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'ATTE_ID';
}
