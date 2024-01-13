<?php

namespace App\Models;

use App\Models\Crm\Booking;
use App\Models\Crm\Company;
use App\Models\Crm\Interest;
use App\Models\Crm\Person;
use App\Models\Crm\Task;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'email', 'password','address'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.?????
     *
     * @var array
     */
    //todo?? co to jest??
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the phone associated with the user.
     */
    public function person()
    {
        return $this->hasOne(Person::class,'user_id');
    }

    public function company()
    {
        return $this->hasMany(Company::class,'user_id');
    }

    public function interest()
    {
        return $this->belongsToMany(Interest::class,'interests', 'user_id', 'interest_id');
    }

    //dany uzytkownik ma przypisana konwesacje
    public function conversation( )
    {
        return $this->belongsTo(Conversation::class ,'conversation_id');

    }


}
