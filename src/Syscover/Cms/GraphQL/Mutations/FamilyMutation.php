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
            'family' => [
                'name' => 'family',
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
        return Family::create($args['family']);
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
        Family::where('id', $args['family']['id'])
            ->update($args['family']);

        return Family::find($args['family']['id']);
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
                'type' => Type::nonNull(Type::string())
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $object = SQLService::destroyRecord($args['id'], Family::class);

        return $object;
    }
}
