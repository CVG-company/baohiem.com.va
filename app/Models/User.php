<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'TBL_USER';
    public $timestamps = false;

    protected $fillable = [
        'MANHANVIEN',
        'TENDANGNHAP',
        'MATKHAU',
        'QUYENYTRUYCAP',
        'ACTIVE',
        'Tenquyen',
    ];

    protected $casts = [
        'ACTIVE' => 'boolean',
    ];

    public function nhanvien()
    {
        return $this->belongsTo(Nhanvien::class, 'MANHANVIEN', 'MANHANVIEN');
    }
}
