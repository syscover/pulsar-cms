<?php namespace Syscover\Cms\Models;

use Syscover\Admin\Models\User;
use Syscover\Core\Models\CoreModel;
use Illuminate\Support\Facades\Validator;
use Syscover\Admin\Traits\Translatable;

/**
 * Class Article
 * @package Syscover\Cms\Models
 */

class Article extends CoreModel
{
    use Translatable;

	protected $table        = 'article';
    protected $fillable     = ['id', 'lang_id', 'parent_article_id', 'author_id', 'section_id', 'family_id', 'status_id', 'publish', 'publish_text', 'date', 'title', 'slug', 'link', 'blank', 'sort', 'article', 'data_lang', 'data'];
    public $timestamps      = false;
    protected $casts        = [
        'data_lang' => 'array',
        'data'      => 'array'
    ];
    public $with            = ['lang', 'author', 'family'];

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

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function family()
    {
        return $this->belongsTo(Family::class, 'family_id');
    }
}