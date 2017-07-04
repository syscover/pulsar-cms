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
        if(! isset($args['object']['id']))
        {
            $id = Category::max('id');
            $id++;

            $args['object']['id'] = $id;
        }

        $args['object']['data_lang'] = Category::addLangDataRecord($args['object']['lang_id'], $args['object']['id']);

        return Category::create($args['object']);
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
        Category::where('id', $args['object']['id'])
            ->where('lang_id', $args['object']['lang_id'])
            ->update($args['object']);

        return Category::find($args['object']['id']);
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
