<?php namespace Syscover\Cms\Models;

use Carbon\Carbon;
use Syscover\Admin\Models\Attachment;
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
    protected $fillable     = ['id', 'lang_id', 'parent_article_id', 'name', 'author_id', 'section_id', 'family_id', 'status_id', 'publish', 'date', 'title', 'slug', 'link', 'blank', 'sort', 'article', 'data_lang', 'data'];
    public $incrementing    = false;
    public $timestamps      = false;
    protected $casts        = [
        'data_lang' => 'array',
        'data'      => 'array'
    ];
    public $with            = [
        'lang',
        'author',
        'family',
        'categories',
        'tags'
    ];
    public $lazyRelations       = ['attachments'];

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

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'articles_categories', 'article_id', 'category_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'object')
            ->where('attachment.lang_id', $this->lang_id)
            ->orderBy('sort', 'asc');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'articles_tags', 'article_id', 'tag_id');
    }

    public function getPublishAttribute($value)
    {
        return (new Carbon($value))->toW3cString();
    }
}