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
    protected $fillable     = ['id', 'name', 'editor_id', 'field_group_id', 'date', 'title', 'slug', 'link', 'categories', 'sort', 'tags', 'article_parent', 'attachments', 'data'];
    public $timestamps      = false;
    protected $casts        = [
        'date' => 'boolean',
        'title' => 'boolean',
        'slug' => 'boolean',
        'link' => 'boolean',
        'categories' => 'boolean',
        'sort' => 'boolean',
        'tags' => 'boolean',
        'article_parent' => 'boolean',
        'attachments' => 'boolean',
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