<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Models
use App\Models\Feedback;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'phone_number'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function getUserByEmail($email)
    {
        return $this
            ->where('email', $email)
            ->first() ?? [];
    }

    function createUser($data)
    {
        return $this->create($data) ?? [];
    }

    /** step details */
    function stepDetails($id)
    {
        return $this
            ->with('feedbackLastData:user_id,stars,feedback')
            ->find($id) ?? [];
    }

    /** Get last feedback Data */
    function feedbackLastData()
    {
        return $this->hasMany(Feedback::class, 'user_id', 'id')->orderBy('created_at', 'DESC')->limit(1);
    }

    /** Get feedback Data */
    function feedbackData()
    {
        return $this->hasMany(Feedback::class, 'user_id', 'id');
    }

    /** user list except admin*/
    function getUserlist() {
        return $this
            ->whereNull('password')
            ->paginate(30) ?? [];
    }
}
