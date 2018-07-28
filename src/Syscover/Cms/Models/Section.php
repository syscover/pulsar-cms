<?php namespace Syscover\Cms\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Syscover\Core\Models\CoreModel;

/**
 * Class Section
 * @package Syscover\Cms\Models
 */

class Section extends CoreModel
{
	protected $table        = 'cms_section';
    protected $primaryKey   = 'ix';
    protected $fillable     = ['ix', 'id', 'name', 'family_id', 'attachment_families'];
    protected $casts        = [
        'attachment_families'   => 'array'
    ];
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
            ->addSelect('cms_family.*', 'cms_section.*', 'cms_family.name as family_name', 'cms_section.name as section_name');
    }

    public function scopeCalculateFoundRows($query)
    {
        return $query->select(DB::raw('SQL_CALC_FOUND_ROWS cms_section.ix'));
    }

    public function family()
    {
        return $this->belongsTo(Family::class, 'family_id');
    }
}