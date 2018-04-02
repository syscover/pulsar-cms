<?php namespace Syscover\Cms\Services;

use Syscover\Cms\Models\Category;

class CategoryService
{
    /**
     * @param array     $object     contain properties of category
     * @return \Syscover\Cms\Models\Category
     */
    public static function create($object)
    {
        if(empty($object['id']))
        {
            $id = Category::max('id');
            $id++;

            $object['id'] = $id;
        }

        $object['data_lang'] = Category::addDataLang($object['lang_id'], $object['id']);

        return Category::create($object);
    }

    /**
     * @param array     $object     contain properties of category
     * @return \Syscover\Cms\Models\Category
     */
    public static function update($object)
    {
        $object = collect($object);

        Category::where('ix', $object->get('ix'))
            ->update([
                'name'  => $object->get('name'),
                'slug'  => $object->get('slug'),
            ]);

        Category::where('id', $object->get('id'))
            ->update([
                'section_id'    => $object->get('section_id'),
                'sort'          => $object->get('sort')
            ]);

        return Category::find($object->get('ix'));
    }
}