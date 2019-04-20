<?php namespace Syscover\Cms\Controllers;

use Syscover\Core\Controllers\CoreController;
use Syscover\Cms\Services\CategoryService;
use Syscover\Cms\Models\Category;

class CategoryController extends CoreController
{
    public function __construct(Category $model, CategoryService $service)
    {
        $this->model = $model;
        $this->service = $service;
    }
}
