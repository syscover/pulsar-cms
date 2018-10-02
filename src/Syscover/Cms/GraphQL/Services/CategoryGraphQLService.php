<?php namespace Syscover\Cms\GraphQL\Services;

use Syscover\Cms\Models\Category;
use Syscover\Cms\Services\CategoryService;
use Syscover\Core\GraphQL\Services\CoreGraphQLService;

class CategoryGraphQLService extends CoreGraphQLService
{
    protected $modelClassName = Category::class;
    protected $serviceClassName = CategoryService::class;
}