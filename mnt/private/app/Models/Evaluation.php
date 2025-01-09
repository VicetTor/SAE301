<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $table = 'grp2_evaluation';
    protected $primaryKey = 'EVAL_ID';

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class, 'USER_ID');
    }

    public function validation()
    {
        return $this->hasOne(Validation::class, 'EVAL_ID');
    }
}
?>