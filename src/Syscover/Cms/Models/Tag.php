<?php namespace Syscover\Cms\Models;

use Syscover\Core\Models\CoreModel;
use Illuminate\Support\Facades\Validator;
use Syscover\Admin\Traits\Translatable;

/**
 * Class Tag
 * @package Syscover\Market\Models
 */

class Tag extends CoreModel
{
    use Translatable;

	protected $table        = 'tag';
    protected $fillable     = ['id', 'lang_id', 'name'];
    public $timestamps      = false;
    public $with            = ['lang'];
    private static $rules   = [
        'name' => 'required|between:1,255'
    ];

    public static function validate($data)
    {
        return Validator::make($data, static::$rules);
	}

    public function scopeBuilder($query)
    {
        return $query;
    }
}