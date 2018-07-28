<?php namespace Syscover\Cms\Models;

use Illuminate\Support\Facades\DB;
use Syscover\Core\Models\CoreModel;
use Illuminate\Support\Facades\Validator;
use Syscover\Admin\Traits\Translatable;

/**
 * Class Category
 * @package Syscover\Cms\Models
 */

class Category extends CoreModel
{
    use Translatable;

	protected $table        = 'cms_category';
    protected $primaryKey   = 'ix';
	protected $fillable     = ['ix', 'id', 'lang_id', 'name', 'slug', 'section_id', 'sort', 'data_lang', 'data'];
    protected $casts        = [
        'data_lang' => 'array',
        'data'      => 'array'
    ];
    public $with            = ['lang', 'section'];

    private static $rules   = [
        'name' => 'required|between:2,100'
    ];

    public static function validate($data)
    {
        return Validator::make($data, static::$rules);
	}

    public function scopeBuilder($query)
    {
        return $query->leftJoin('cms_section', 'cms_category.section_id', '=', 'cms_section.id')
            ->addSelect('cms_section.*', 'cms_category.*', 'cms_section.name as section_name', 'cms_category.name as category_name');
    }

    public function scopeCalculateFoundRows($query)
    {
        return $query->select(DB::raw('SQL_CALC_FOUND_ROWS cms_category.ix'));
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }
}