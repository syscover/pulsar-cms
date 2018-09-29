<?php namespace Syscover\Cms\GraphQL\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use Syscover\Cms\Services\FamilyService;
use Syscover\Core\Services\SQLService;
use Syscover\Cms\Models\Family;

class FamilyMutation extends Mutation
{
    public function type()
    {
        return GraphQL::type('CmsFamily');
    }

    public function args()
    {
        return [
            'object' => [
                'name' => 'object',
                'type' => Type::nonNull(GraphQL::type('CmsFamilyInput'))
            ],
        ];
    }
}

class AddFamilyMutation extends FamilyMutation
{
    protected $attributes = [
        'name'          => 'addFamily',
        'description'   => 'Add new family'
    ];

    public function resolve($root, $args)
    {
        return FamilyService::create($args['object']);
    }
}

class UpdateFamilyMutation extends FamilyMutation
{
    protected $attributes = [
        'name' => 'updateFamily',
        'description' => 'Update family'
    ];

    public function resolve($root, $args)
    {
        return FamilyService::update($args['object']);
    }
}

class DeleteFamilyMutation extends FamilyMutation
{
    protected $attributes = [
        'name' => 'deleteFamily',
        'description' => 'Delete family'
    ];

    public function args()
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::int())
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $object = SQLService::deleteRecord($args['id'], Family::class);

        return $object;
    }
}
