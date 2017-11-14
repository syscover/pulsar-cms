<?php namespace Syscover\Cms\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Laravel\Scout\Searchable;
use Syscover\Admin\Models\Attachment;
use Syscover\Admin\Models\User;
use Syscover\Admin\Traits\CustomizableValues;
use Syscover\Admin\Traits\Slugable;
use Syscover\Core\Models\CoreModel;
use Syscover\Admin\Traits\Translatable;

/**
 * Class Article
 * @package Syscover\Cms\Models
 */

class Article extends CoreModel
{
    use CustomizableValues, Translatable, Slugable, Searchable;

	protected $table        = 'cms_article';
    protected $fillable     = ['id', 'lang_id', 'parent_id', 'name', 'author_id', 'section_id', 'family_id', 'status_id', 'publish', 'date', 'title', 'slug', 'link', 'blank', 'sort', 'excerpt', 'article', 'data_lang', 'data'];
    public $incrementing    = false;
    protected $casts        = [
        'data_lang' => 'array',
        'data'      => 'array'
    ];
    public $with            = [
        'lang',
        'author',
        'section',
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
        return $query->leftJoin('cms_section', 'cms_article.section_id', '=', 'cms_section.id')
            ->select('cms_section.*', 'cms_article.*', 'cms_section.name as section_name', 'cms_article.name as article_name');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function family()
    {
        return $this->belongsTo(Family::class, 'family_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'cms_articles_categories', 'article_id', 'category_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'object')
            ->where('admin_attachment.lang_id', $this->lang_id)
            ->orderBy('sort', 'asc');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'cms_articles_tags', 'article_id', 'tag_id');
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'parent_id', 'id')
            ->builder();
    }

    public function getPublishAttribute($value)
    {
        return (new Carbon($value))->toW3cString();
    }
}