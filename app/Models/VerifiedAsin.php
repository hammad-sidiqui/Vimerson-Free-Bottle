<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifiedAsin extends Model
{    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'verified_asin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asin', 'status'
    ];
    
    /** get all asin */
    function getAllAsin() {
        return $this->paginate(10) ?? [];
    }

    /** get all asin in list format */
    function getAsinList() {
        return $this->pluck('asin')->toArray() ?? [];
    }

    /** get all asin */
    function insertListData($data) {
        return $this->insert($data) ?? [];
    }    
}
