<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectDetail extends Model
{
    protected $fillable = ['studentTermId', 'subjectId', 'subjectName' , 'startDay', 'endDay', 'lesson', 'weekday'];

    protected $primarkey =  'subjectdetailId';
    protected $table = 'subjectdetail';
}
