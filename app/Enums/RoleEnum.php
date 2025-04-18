<?php

namespace App\Enums;
use Illuminate\Support\Facades\DB;

enum RoleEnum: string
{
    case Admin = 'admin';
    case Employee = 'employee';
}
