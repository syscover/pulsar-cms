<?php namespace Syscover\Cms\Models;

use Illuminate\Support\Facades\Validator;
use Syscover\Core\Models\CoreModel;

/**
 * Class Section
 * @package Syscover\Pulsar\Models
 */

class Section extends CoreModel
{
	protected $table        = 'section';
    protected $fillable     = ['id', 'name', 'article_family_id'];
    public $incrementing    = false;
    public $timestamps      = false;
    public $with = [
        'family'
    ];

    private static $rules   = [];

    public static function validate($data, $specialRules = [])
    {
        return Validator::make($data, static::$rules);
	}

    public function scopeBuilder($query)
    {
        return $query->leftJoin('article_family', 'section.article_family_id', '=', 'article_family.id')
            ->select('article_family.*', 'section.*', 'article_family.name as article_family_name', 'section.name as section_name');;
    }

    public function family()
    {
        return $this->belongsTo(Family::class, 'article_family_id');
    }
}