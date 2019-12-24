<?php namespace Syscover\Cms\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Scout\Searchable;
use Carbon\Carbon;
use Syscover\Admin\Models\Attachment;
use Syscover\Admin\Models\User;
use Syscover\Admin\Traits\CustomizableValues;
use Syscover\Core\Models\CoreModel;
use Syscover\Admin\Traits\Langable;

/**
 * Class Article
 * @package Syscover\Cms\Models
 */

class Article extends CoreModel
{
    use CustomizableValues, Langable, Searchable;

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
        'categories',
        'attachments'
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
        return $query
            ->leftJoin('cms_section', 'cms_article.section_id', '=', 'cms_section.id')
            ->addSelect('cms_section.*', 'cms_article.*', 'cms_section.name as cms_section_name', 'cms_article.name as cms_article_name');
    }

    public function scopeCalculateFoundRows($query)
    {
        return $query->select(DB::raw('SQL_CALC_FOUND_ROWS cms_article.ix'));
    }

    // Accessors
    public function getPublishAttribute($value)
    {
        // https://es.wikipedia.org/wiki/ISO_8601
        // return (new Carbon($value))->toW3cString();
        return $value ? (new Carbon($value))->format('Y-m-d\TH:i:s') : null;
    }

    public function getDateAttribute($value)
    {
        // https://es.wikipedia.org/wiki/ISO_8601
        // return (new Carbon($value))->toW3cString();
        return $value ? (new Carbon($value))->format('Y-m-d\TH:i:s') : null;
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
            'ix'            => $this->ix,
            'id'            => $this->id,
            'lang_id'       => $this->lang_id,
            'section_id'    => $this->section_id,
            'status_id'     => $this->status_id,
            'publish'       => $this->publish,
            'date'          => $this->date,
            'title'         => strip_tags($this->title),
            'slug'          => $this->slug,
            'sort'          => $this->sort,
            'tags'          => $this->tags,
            'excerpt'       => strip_tags($this->excerpt),
            'article'       => strip_tags($this->article),
            'categories'    => $this->categories->where('lang_id', $this->lang_id)->implode('name', ',')
        ];

        if(isset($this->data['custom_fields']) && is_array($this->data['custom_fields']))
        {
            foreach ($this->data['custom_fields'] as $index => $value)
            {
                if(! array_key_exists($index, $searchable)) $searchable[$index] = strip_tags($value);
            }
        }

        return $searchable;
    }
}
