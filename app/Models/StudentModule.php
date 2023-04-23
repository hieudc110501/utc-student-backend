<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentModule extends Model
{
    protected $fillable = ['moduleId','moduleName','moduleCredit','studentId','times', 'evaluate'];

    protected $primarkey =  'studentModuleId';
    protected $table = 'studentModule';
}
