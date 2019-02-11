<?php namespace Syscover\Cms\GraphQL\Services;

use Syscover\Cms\Models\Family;
use Syscover\Cms\Services\FamilyService;
use Syscover\Core\GraphQL\Services\CoreGraphQLService;

class FamilyGraphQLService extends CoreGraphQLService
{
    public function __construct(Family $model, FamilyService $service)
    {
        $this->model = $model;
        $this->service = $service;
    }
}
