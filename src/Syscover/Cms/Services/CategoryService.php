<?php namespace Syscover\Cms\Services;

use Syscover\Cms\Models\Category;

class CategoryService
{
    /**
     * @param array     $object     contain properties of family
     * @return \Syscover\Cms\Models\Category
     */
    public static function create($object)
    {
        if(empty($object['object_id']))
        {
            $objectId = Category::max('object_id');
            $objectId++;

            $object['object_id'] = $objectId;
        }

        $object['data_lang'] = Category::addDataLang($object['lang_id'], $object['object_id']);

        return Category::create($object);
    }

    /**
     * @param array     $object     contain properties of family
     * @return \Syscover\Cms\Models\Category
     */
    public static function update($object)
    {
        $object = collect($object);

        Category::where('id', $object->get('id'))
            ->update([
                'name'  => $object->get('name'),
                'slug'  => $object->get('slug'),
            ]);

        Category::where('object_id', $object->get('object_id'))
            ->update([
                'section_id' => $object->get('section_id'),
            ]);

        return Category::find($object->get('id'));
    }
}