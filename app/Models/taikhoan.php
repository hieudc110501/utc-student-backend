<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class taikhoan extends Model implements Authenticatable
{
    use HasFactory;
    protected $fillable = ['maTaiKhoan', 'maPhanQuyen', 'tenTaiKhoan', 'matKhau'];
    protected $primaryKey =  'maTaiKhoan';
    protected $table = 'taikhoan';
    public $timestamps = false;

    public function getAuthIdentifierName()
    {
        // Phương thức trả về tên cột chứa ID người dùng
        return 'maTaiKhoan';
    }

    public function getAuthIdentifier()
    {
        // Phương thức trả về giá trị ID người dùng
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        // Phương thức trả về mật khẩu người dùng
        return $this->matKhau;
    }

    public function getRememberToken()
    {
        // Phương thức trả về giá trị Remember Token người dùng
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        // Phương thức thiết lập giá trị Remember Token người dùng
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        // Phương thức trả về tên cột chứa Remember Token
        return 'remember_token';
    }

}
