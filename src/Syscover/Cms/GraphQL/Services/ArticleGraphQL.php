<?php namespace Syscover\Cms\GraphQL\Services;

use Syscover\Cms\Models\Article;
use Syscover\Cms\Services\ArticleService;
use Syscover\Core\GraphQL\Services\CoreGraphQL;

class ArticleGraphQL extends CoreGraphQL
{
    protected $model = Article::class;
    protected $service = ArticleService::class;
}