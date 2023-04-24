<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['studentId','moduleId','moduleName','credit', 'date', 'lesson', 'type', 'identity', 'room'];

    protected $primarkey =  'examId';
    protected $table = 'exam';
}
