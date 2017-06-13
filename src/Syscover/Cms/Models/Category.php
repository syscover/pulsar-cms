<?php namespace Syscover\Cms\Models;

use Syscover\Core\Models\CoreModel;
use Illuminate\Support\Facades\Validator;
use Syscover\Admin\Models\Lang;

/**
 * Class Category
 * @package Syscover\Market\Models
 */

class Category extends CoreModel
{
	protected $table        = 'category';
    protected $fillable     = ['id', 'lang_id', 'name', 'slug', 'sort', 'data_lang', 'data'];
    public $timestamps      = false;
    protected $casts        = [
        'data_lang' => 'array',
        'data'      => 'array'
    ];
    public $with            = ['lang'];

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

    public function lang()
    {
        return $this->belongsTo(Lang::class, 'lang_id');
    }
}