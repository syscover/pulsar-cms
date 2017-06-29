<?php namespace Syscover\Cms\GraphQL\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
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
            'category' => [
                'name' => 'category',
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
        $args['category']['data_lang'] = Category::addLangDataRecord($args['category']['lang_id'], $args['category']['id']);

        return Category::create($args['category']);
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
        Category::where('id', $args['category']['id'])
            ->where('lang_id', $args['category']['lang_id'])
            ->update($args['category']);

        return Category::find($args['category']['id']);
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
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::string())
            ],
            'lang' => [
                'name' => 'lang',
                'type' => Type::nonNull(Type::string())
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $object = SQLService::destroyRecord($args['id'], Category::class, $args['lang']);

        return $object;
    }
}
