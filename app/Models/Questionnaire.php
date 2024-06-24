<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'questionnaire';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question', 'status', 'featured'
    ];

    /**
     * creation question
     * @var array
     */
    function createQuestion($data) {
        return $this->create($data) ?? [];
    }

    /** get all featured questions */
    function getFeaturedQuestion() {
        return $this
            ->where('status', 1)
            ->where('featured', 1)
            ->get() ?? [];
    }

    /** get all active questions */
    function getActiveQuestionnaire() {
        return $this
            ->where('status', 1)
            ->get() ?? [];
    }
}
