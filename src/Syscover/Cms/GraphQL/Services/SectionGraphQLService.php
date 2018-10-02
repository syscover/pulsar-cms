<?php namespace Syscover\Cms\GraphQL\Services;

use Syscover\Cms\Models\Section;
use Syscover\Cms\Services\SectionService;
use Syscover\Core\GraphQL\Services\CoreGraphQLService;

class SectionGraphQLService extends CoreGraphQLService
{
    protected $modelClassName = Section::class;
    protected $serviceClassName = SectionService::class;
}