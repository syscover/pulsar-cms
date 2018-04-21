<?php namespace Syscover\Cms\Services;

use Syscover\Cms\Models\Category;

class CategoryService
{
    public static function create($object)
    {
        CategoryService::check($object);

        if(empty($object['id'])) $object['id'] = next_id(Category::class);

        $object['data_lang'] = Category::addDataLang($object['lang_id'], $object['id']);

        return Category::create(CategoryService::builder($object));
    }

    public static function update($object)
    {
        CategoryService::check($object);
        Category::where('ix', $object['ix'])->update(CategoryService::builder($object));
        Category::where('id', $object['id'])->update(CategoryService::builder($object, ['section_id', 'sort']));

        return Category::find($object['ix']);
    }

    private static function builder($object, $filterKeys = null)
    {
        $object = collect($object);
        if($filterKeys) $object = $object->only($filterKeys);

        $data = [];

        if($object->has('id'))          $data['id'] = $object->get('id');
        if($object->has('lang_id'))     $data['lang_id'] = $object->get('lang_id');
        if($object->has('name'))        $data['name'] = $object->get('name');
        if($object->has('slug'))        $data['slug'] = $object->get('slug');
        if($object->has('section_id'))  $data['section_id'] = $object->get('section_id');
        if($object->has('sort'))        $data['sort'] = $object->get('sort');
        if($object->has('data_lang'))   $data['data_lang'] = $object->get('data_lang');
        if($object->has('data'))        $data['data'] = $object->get('data');

        return $data;
    }

    private static function check($object)
    {
        if(empty($object['lang_id']))   throw new \Exception('You have to define a lang_id field to create a category');
        if(empty($object['name']))      throw new \Exception('You have to define a name field to create a category');
    }
}