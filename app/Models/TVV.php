<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TVV extends Model
{
    protected $fillable = ['TenTVV','Link','SoDienThoai','Anh'];

    protected $primarkey =  'MaTVV';
    protected $table = 'TVV';
}
