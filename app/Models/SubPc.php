<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubPc extends Model
{
    use HasFactory;

    protected $table = 'sub_pcs';
    protected $fillable = ['ip_address', 'vnc_port', 'pc_name', 'device_status'];
}