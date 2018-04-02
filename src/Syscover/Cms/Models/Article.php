<?php namespace Syscover\Cms\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Laravel\Scout\Searchable;
use Syscover\Admin\Models\Attachment;
use Syscover\Admin\Models\User;
use Syscover\Admin\Traits\CustomizableValues;
use Syscover\Core\Models\CoreModel;
use Syscover\Admin\Traits\Translatable;

/**
 * Class Article
 * @package Syscover\Cms\Models
 */

class Article extends CoreModel
{
    use CustomizableValues, Translatable, Searchable;

	protected $table        = 'cms_article';
    protected $primaryKey   = 'ix';
    protected $fillable     = ['ix', 'id', 'lang_id', 'parent_id', 'name', 'author_id', 'section_id', 'family_id', 'status_id', 'publish', 'date', 'title', 'slug', 'link', 'blank', 'tags', 'sort', 'excerpt', 'article', 'data_lang', 'data'];
    protected $casts        = [
        'tags'      => 'array',
        'data_lang' => 'array',
        'data'      => 'array'
    ];
    public $with            = [
        'lang',
        'author',
        'section',
        'family',
        'categories'
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

    // Accessors
    public function getPublishAttribute($value)
    {
        // return (new Carbon($value))->toW3cString();
        return (new Carbon($value))->format('Y-m-d\TH:i:s');
    }

    public function getDateAttribute($value)
    {
        // return (new Carbon($value))->toW3cString();
        return (new Carbon($value))->format('Y-m-d\TH:i:s');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }

    public function family()
    {
        return $this->belongsTo(Family::class, 'family_id');
    }

    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'cms_articles_categories',
            'article_id',
            'category_id',
            'id',
            'id'
        );
    }

    public function attachments()
    {
        return $this->morphMany(
                Attachment::class,
                'object',
                'object_type',
                'object_id',
                'id'
            )
            ->where('admin_attachment.lang_id', $this->lang_id)
            ->orderBy('sort', 'asc');
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'parent_id', 'id')
            ->builder();
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $searchable =  [
            'id'            => $this->id,
            'lang_id'       => $this->lang_id,
            'section_id'    => $this->section_id,
            'status_id'     => $this->status_id,
            'publish'       => $this->publish,
            'date'          => $this->date,
            'title'         => strip_tags($this->title),
            'slug'          => $this->slug,
            'sort'          => $this->sort,
            'excerpt'       => strip_tags($this->excerpt),
            'article'       => strip_tags($this->article),
            'categories'    => $this->categories->where('lang_id', $this->lang_id)->implode('name', ',')
        ];

        if(isset($this->data['customFields']) && is_array($this->data['customFields']))
        {
            foreach ($this->data['customFields'] as $index => $value)
            {
                if(! array_key_exists($index, $searchable)) $searchable[$index] = strip_tags($value);
            }
        }

        return $searchable;
    }
}