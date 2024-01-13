<?php

namespace App\Models\Crm;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    use HasFactory;


    public $timestamps = false;


    public function users()
    {
        return $this->belongsToMany(User::class);
    }


    public function person()
    {
        return $this->hasOne(Person::class,'interest_id');
    }

    public function company()
    {
        return $this->hasOne(Company::class,'interest_id');
    }

}
