<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDetails extends Model
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'product_details';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'asin', 'status', 'bottle_ids'
    ];

    /** get all product */
    function getAllProduct()
    {
        // return $this->paginate(10) ?? [];
        return $this->get() ?? [];
    }

    /** get product by ASIN */
    function getProductByAsin($asin)
    {
        return $this
            ->where('asin', $asin)
            ->first() ?? [];
    }

    /** get all product */
    function getAllProductWithBottles()
    {        
        return $this
            ->with('bottleData:asin,name,image')
            ->get() ?? [];
    }

    /** get product by ASIN */
    function getBottleIdsByAsin($asin)
    {
        return $this
            ->whereIn('asin', $asin)
            ->pluck('bottle_ids', 'asin')->all() ?? [];
    }

    /** get product by ASIN */
    function productBottlesByAsin($asin)
    {
        return $this
            ->where('asin', $asin)
            ->pluck('bottle_ids')->first() ?? [];
    }

    /** Get Bottles Data */
    function bottleData()
    {
        return $this->hasOne(Bottle::class, 'asin', 'asin');
    }

    /** coundt product by asin */
    function productCountByAsin($asin = [])
    {
        return $this
            ->whereIn('asin', $asin)
            ->where('status', 1)
            ->count() ?? 0;
    }
}
