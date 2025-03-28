<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = 'logs'; // Specify the table name if different

    protected $fillable = ['pc_name', 'action', 'status', 'timestamp'];

    public $timestamps = false; // Disable automatic timestamps since we already have a `timestamp` column
}