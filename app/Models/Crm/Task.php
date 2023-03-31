<?php

namespace App\Models\Crm;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title','description', 'start_date', 'end_date','test'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
