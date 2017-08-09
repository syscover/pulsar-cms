<?php namespace Syscover\Cms\Models;

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
    protected $fillable     = ['id', 'lang_id', 'name', 'slug', 'section_id', 'sort', 'data_lang', 'data'];
    public $incrementing    = false;
    public $timestamps      = false;
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
        return $query;
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}