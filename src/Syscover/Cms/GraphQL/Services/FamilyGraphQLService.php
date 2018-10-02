<?php namespace Syscover\Cms\GraphQL\Services;

use Syscover\Cms\Models\Family;
use Syscover\Cms\Services\FamilyService;
use Syscover\Core\GraphQL\Services\CoreGraphQLService;

class FamilyGraphQLService extends CoreGraphQLService
{
    protected $modelClassName = Family::class;
    protected $serviceClassName = FamilyService::class;
}