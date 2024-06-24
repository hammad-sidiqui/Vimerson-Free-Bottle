<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'order_details';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'user_id', 'shopify_order_id', 'order_id', 'bottle', 'address', 'state', 'city', 'zip', 'shopify_order_status'
    ];

    /** update order details by ID */
    public function updateOrderById($filter, $data)
    {   
        return 
            $this
            ->where($filter)
            ->update($data) ?? [];
    }
}
