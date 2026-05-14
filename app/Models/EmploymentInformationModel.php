<?php

namespace App\Models;

use CodeIgniter\Model;

class EmploymentInformationModel extends Model
{
    protected $table = 'employment_information';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'personal_id', 'job_status', 'termination_reason', 'company_name', 'company_type',
        'date_out', 'job_position', 'company_address', 'company_province', 'company_district',
        'company_subdistrict', 'salary', 'bank_name', 'bank_no', 'bank_pic'
    ];
}
