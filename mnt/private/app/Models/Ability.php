<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'GRP2_ABILITY';


    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'ABI_ID';
}
