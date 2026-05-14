<?php

namespace App\Models;

use CodeIgniter\Model;

class JobHistoryModel extends Model
{
    protected $table = 'job_history';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'personal_id', 'position', 'salary', 'description', 'promote_occupation', 'consent'
    ];
}
