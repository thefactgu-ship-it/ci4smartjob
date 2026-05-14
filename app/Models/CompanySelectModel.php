<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanySelectModel extends Model
{
    protected $table = 'company_select';
    protected $primaryKey = 'id';
    protected $allowedFields = ['company_id', 'personal_id'];
}


