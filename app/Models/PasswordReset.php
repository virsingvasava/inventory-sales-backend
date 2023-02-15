<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class PasswordReset extends Model
{
	protected $connection = 'mongodb';
    protected $table = 'password_resets';
}
