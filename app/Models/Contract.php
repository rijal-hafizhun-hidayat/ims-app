<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contract';
    protected $guarded = ['id'];

    public function installmentSchedules()
    {
        return $this->hasMany(InstallmentSchedule::class, 'contract_id', 'id');
    }
}
