<?php

namespace App\Models\Crm;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    //https://stackoverflow.com/questions/19937565/disable-laravels-eloquent-timestamps
    public $timestamps = false;

//https://stackoverflow.com/questions/46668700/disable-laravel-pluralization-for-person-to-people
    protected $table = 'persons';
    /**
     * @var string[]
     */
//aby moc uzywac metod masowych przypisan w lara 9 np all() w kontrolerze
    protected $fillable = ['name', 'email', 'phone', 'photo', 'surname'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
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

    /**
     * @param $value
     * @return void
     *
     * mutator
     */
    public function setSurnameAttribute($value)
    {
        $this->attributes['surname'] = ucfirst($value);
    }
}
