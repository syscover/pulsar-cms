<?php namespace Syscover\Cms\Models;

use Illuminate\Support\Facades\Validator;
use Syscover\Core\Models\CoreModel;

/**
 * Class Section
 * @package Syscover\Cms\Models
 */

class Section extends CoreModel
{
	protected $table        = 'cms_section';
    protected $fillable     = ['id', 'name', 'family_id'];
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
        return $query->leftJoin('cms_family', 'cms_section.family_id', '=', 'cms_family.id')
            ->select('cms_family.*', 'cms_section.*', 'cms_family.name as family_name', 'cms_section.name as section_name');
    }

    public function family()
    {
        return $this->belongsTo(Family::class, 'family_id');
    }
}