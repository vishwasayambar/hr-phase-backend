<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;

    public const ID = 'id';

    public const NAME = 'name';
    public const USER_TYPE_EMPLOYEE = 2;


}
