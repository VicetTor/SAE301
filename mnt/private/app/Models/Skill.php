<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'GRP2_SKILL';


    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'SKILL_ID';
}
