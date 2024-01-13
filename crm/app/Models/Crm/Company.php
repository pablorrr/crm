<?php

namespace App\Models\Crm;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;


    public $timestamps = false;

    protected $fillable = ['name', 'email', 'phone', 'photo'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function interest()
    {
        return $this->belongsTo(Interest::class);
    }


    /**
     * @param $value
     * @return void
     *
     * mutator
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }


}
