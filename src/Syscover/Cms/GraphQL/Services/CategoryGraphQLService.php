<?php namespace Syscover\Cms\GraphQL\Services;

use Syscover\Cms\Models\Category;
use Syscover\Cms\Services\CategoryService;
use Syscover\Core\GraphQL\Services\CoreGraphQLService;

class CategoryGraphQLService extends CoreGraphQLService
{
    public function __construct(Category $model, CategoryService $service)
    {
        $this->model = $model;
        $this->service = $service;
    }
}
