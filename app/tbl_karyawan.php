<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_karyawan extends Model
{
    public $timestamps = false;
    protected $table = "tbl_karyawan";
    protected $fillable = ['nama','jabatan','umur','alamat','foto'];
}
