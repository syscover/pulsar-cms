<?php namespace Syscover\Cms\GraphQL\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
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
        return Family::create($args['object']);
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
        Family::where('id', $args['object']['id'])
            ->update($args['object']);

        return Family::find($args['object']['id']);
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
        $object = SQLService::destroyRecord($args['id'], Family::class);

        return $object;
    }
}
