<?php

namespace App\Enums;

enum Entity: string
{
    case USER = 'user';
    case EMPLOYEE = 'employee';
    case ADDRESS = 'address';
    case BANK = 'bank';
}
