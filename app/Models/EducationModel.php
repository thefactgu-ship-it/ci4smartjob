<?php

namespace App\Models;

use CodeIgniter\Model;

class EducationModel extends Model
{
    protected $table = 'educations';
    protected $primaryKey = 'education_id';
    protected $allowedFields = ['education_level', 'school'];

    public function getEducations($id = null)
    {
        if ($id === null) {
            return $this->findAll();
        }

        return $this->find($id);
    }
}