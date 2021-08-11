<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelAbstract extends Model
{
    protected $rules;

    public function getValidatorRules($name)
    {
        return isset($this->rules[$name]) ? $this->rules[$name] : [];
    }
}