<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['studentName','bankAccount','identity','birth', 'tel', 'bornIn', 'email'];

    protected $primarkey =  'studentId';
    protected $table = 'student';
}
