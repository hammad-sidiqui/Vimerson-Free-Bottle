<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QualifyBottles extends Model
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'qualify_bottles';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'user_id', 'order_id', 'total_free_bottles', 'qualify_free_bottles', 'qualified_bottles'
    ];

    // create or update qualify bottles
    function createOrUpdateQualifyBottle($data) {
        return $this->updateOrCreate(
            ['order_id' => $data['order_id']], 
            $data) ?? [];
    }

    // create or update qualify bottles
    function getQualifyBottlesByOrder($order_id) {
        return $this->where('order_id', $order_id)->first() ?? [];
    }

    // get free bottle available quantity
    function getBottlesToQualify($filter) {
        return $this->where($filter)->first() ?? [];
    }
}
