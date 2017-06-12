<?php namespace Syscover\Cms\Models;

use Illuminate\Support\Facades\Validator;
use Syscover\Core\Models\CoreModel;
use Syscover\Admin\Traits\CustomizableFields;

/**
 * Class Family
 * @package Syscover\Pulsar\Models
 */

class Family extends CoreModel
{
    use CustomizableFields;

	protected $table        = 'article_family';
    protected $fillable     = ['id', 'name', 'editor_id', 'field_group_id', 'data'];
    public $timestamps      = false;
    protected $casts        = [
        'data' => 'array'
    ];
    public $with = [
        'fieldGroup'
    ];

    private static $rules   = [];

    public static function validate($data, $specialRules = [])
    {
        return Validator::make($data, static::$rules);
	}

    public function scopeBuilder($query)
    {
        return $query;
    }
}