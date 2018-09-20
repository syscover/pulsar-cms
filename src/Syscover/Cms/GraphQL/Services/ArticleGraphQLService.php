<?php namespace Syscover\Cms\GraphQL\Services;

use Syscover\Cms\Models\Article;
use Syscover\Cms\Services\ArticleService;
use Syscover\Core\GraphQL\Services\CoreGraphQLService;

class ArticleGraphQLService extends CoreGraphQLService
{
    protected $model = Article::class;
    protected $service = ArticleService::class;
}