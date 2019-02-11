<?php namespace Syscover\Cms\GraphQL\Services;

use Syscover\Cms\Models\Section;
use Syscover\Cms\Services\SectionService;
use Syscover\Core\GraphQL\Services\CoreGraphQLService;

class SectionGraphQLService extends CoreGraphQLService
{
    public function __construct(Section $model, SectionService $service)
    {
        $this->model = $model;
        $this->service = $service;
    }
}
