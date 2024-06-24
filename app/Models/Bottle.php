<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bottle extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bottles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'variant_id', 'asin', 'slug', 'name', 'price', 'image', 'status', 'featured'
    ];

    function createFreeBottle($data) {
        return $this->create($data) ?? [];
    }

    function getFeaturedBottle() {
        return $this
            ->where('status', 1)
            // ->where('featured', 1)
            ->get() ?? [];
    }
    
    function getBottleByAsin($ids) {
        $order = 'FIELD(id, '. trim(implode(',', $ids)) .')';
        return $this
            ->select('id', 'variant_id', 'slug', 'name', 'image')
            ->where('status', 1)
            // ->where('featured', 1)
            ->whereIn('id', $ids)
            ->orderByRaw($order)
            ->get() ?? [];
    }
    
    function getActiveBottles() {
        return $this
            ->where('status', 1)
            ->get() ?? [];
    }
    
    function getBottleByIDs($ids) {
        return $this
            ->whereIn('id', $ids)
            ->where('status', 1)
            // ->where('featured', 1)
            ->get() ?? [];
    }

    /** get bottle name by ID */
    function getBottleNameByID($id) {
        return $this
            ->select('name')
            ->where('id', $id)
            ->where('status', 1)
            // ->where('featured', 1)
            ->first() ?? [];
    }

    /** list of bottles for dropdown with except asin */
    function getBottleList($columns, $except_asin = []) {
        return $this
            ->select($columns)
            ->where('status', 1)
            ->where(function ($query) use ($except_asin) {
                if($except_asin) {
                    $query->whereNotIn('asin', $except_asin);
                }
            })
            ->get() ?? [];
    }

    /** list of bottles for dropdown with except asin */
    function getBottleListArray($except_asin = []) {
        return $this
            ->where('status', 1)
            ->where(function ($query) use ($except_asin) {
                if($except_asin) {
                    $query->whereNotIn('asin', $except_asin);
                }
            })
            ->pluck('name', 'id') ?? [];
    }

    /** list of bottles for dropdown */
    function bottleImageByID($ids = []) {
        $order = 'id ASC';
        if($ids) $order = 'FIELD(id, '. trim(implode(',', $ids)) .')';

        return $this
            ->select('id', 'name', 'image')
            ->where('status', 1)
            ->where(function ($query) use ($ids) {                
                if($ids) {
                    $query->whereIn('id', $ids);
                }                
            })
            ->orderByRaw($order)
            ->get() ?? [];
    }

    /** list of bottles for dropdown */
    function bottleByAsin($asin) {
        return $this
            ->select('id', 'variant_id', 'asin', 'name', 'image')
            ->where('status', 1)
            ->where('asin', $asin)
            ->first() ?? [];
    }

    /** get bottle info by asin */
    function bottleInfoByAsin($asin, $columns = '*') {
        return $this
            ->select($columns)
            ->where('status', 1)
            ->where('asin', $asin)
            ->first() ?? [];
    }

    /** get bottle count by asin */
    function bottleCountByAsin($asin = []) {        
        return $this
            ->whereIn('asin', $asin)
            ->where('status', 1)
            ->count() ?? 0;
    }
}
