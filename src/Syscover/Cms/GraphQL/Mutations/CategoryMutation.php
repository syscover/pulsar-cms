<?php namespace Syscover\Cms\GraphQL\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use Syscover\Cms\Services\CategoryService;
use Syscover\Core\Services\SQLService;
use Syscover\Cms\Models\Category;

class CategoryMutation extends Mutation
{
    public function type()
    {
        return GraphQL::type('CmsCategory');
    }

    public function args()
    {
        return [
            'object' => [
                'name' => 'object',
                'type' => Type::nonNull(GraphQL::type('CmsCategoryInput'))
            ],
        ];
    }
}

class AddCategoryMutation extends CategoryMutation
{
    protected $attributes = [
        'name'          => 'addCategory',
        'description'   => 'Add new category'
    ];

    public function resolve($root, $args)
    {
        return CategoryService::create($args['object']);
    }
}

class UpdateCategoryMutation extends CategoryMutation
{
    protected $attributes = [
        'name' => 'updateCategory',
        'description' => 'Update category'
    ];

    public function resolve($root, $args)
    {
        return CategoryService::update($args['object']);
    }
}

class DeleteCategoryMutation extends CategoryMutation
{
    protected $attributes = [
        'name' => 'deleteCategory',
        'description' => 'Delete category'
    ];

    public function args()
    {
        return [
            'object_id' => [
                'name' => 'object_id',
                'type' => Type::nonNull(Type::int())
            ],
            'lang_id' => [
                'name' => 'lang_id',
                'type' => Type::nonNull(Type::string())
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $object = SQLService::destroyRecord($args['object_id'], Category::class, $args['lang_id']);

        return $object;
    }
}
