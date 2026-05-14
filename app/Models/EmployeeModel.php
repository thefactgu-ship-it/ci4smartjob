<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $table = 'employee';
    protected $primaryKey = 'em_id';
    protected $allowedFields = ['username', 'password', 'em_fullname', 'position', 'em_pic'];
}


