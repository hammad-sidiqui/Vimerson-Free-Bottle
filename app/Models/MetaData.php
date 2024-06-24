<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetaData extends Model
{
    protected $table = 'meta_data';
    
    /** timestamp false */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['meta_key', 'meta_value'];    

    /**
     * get data by meta key
     */
    public function findByKey($key, $method = 'first') {        
        return $this
            ->where('meta_key', $key)
            ->{$method}() ?? [];
    }

    /**
     * save meta value by meta key
     */
    public function updateValueByKey($key, $value) {
        return $this
            ->updateOrCreate(
                ['meta_key' => $key],
                ['meta_value' => $value]
            );
    }
}
