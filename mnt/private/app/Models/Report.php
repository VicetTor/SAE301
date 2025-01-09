<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'report';
    protected $primaryKey = 'REPORT_ID';

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class, 'USER_ID');
    }

    public function club()
    {
        return $this->belongsTo(Club::class, 'CLUB_ID');
    }
}
?>
