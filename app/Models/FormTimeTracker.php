<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\IncompleFormEmail;
use Illuminate\Support\Facades\Log;

// Models
use App\User;

class FormTimeTracker extends Model
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'form_time_tracker';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'user_id', 'form_id', 'step_one_time', 'step_two_time', 'step_three_time', 'step_four_time', 'e_status'
    ];

    /** get all time tracker data */
    function getAllTimeTracker()
    {
        return $this
            ->with('userData:id,first_name,last_name,email')
            ->get() ?? [];
    }

    /** Get user Data */
    function userData()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /** get form data by user */
    function getDataByFormUser($filter)
    {
        return $this
            ->where($filter)
            ->first() ?? [];
    }

    /** create */
    function createFormTimeTracker($data)
    {
        return $this->create($data) ?? [];
    }

    /** send incomplete form tracker email */
    function sendFormTrackerEmail($interval_mintues)
    {
        return $this
            ->with('userData:id,email,first_name')
            // ->where('id', 1)->get();
            ->whereNull('step_four_time')
            // ->where('e_status', 0)
            ->where('created_at', '>=', $interval_mintues)
            ->get() ?? [];
    }

    /** send incomplete form tracker email */
    function cronSendEmailFormTracker()
    {   
        Log::info('cron is working :)');
        $interval_mintues = date('Y-m-d H:i:s', strtotime('-10 minutes'));
        $users = $this
            ->with('userData:id,email,first_name')
            ->whereNull('step_four_time')
            // ->where('e_status', 0)
            ->where('created_at', '>=', $interval_mintues)
            ->get() ?? [];
        
        foreach ($users as $user) {
            $email = $user->userData->email;
            $name = $user->userData->first_name;
            
            try {
                Mail::to([$email])->send(new IncompleFormEmail(['name' => $name]));
                $user->e_status = 1;
                $user->update();
            } catch (Exception $e) {
                Log::info($e->getMessage());                
            }
        }
    }
}
