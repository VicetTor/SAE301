<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validation extends Model
{
    use HasFactory;
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'GRP2_VALIDATION';


    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'VALID_ID';
}
