<?php namespace Syscover\Cms\Services;

use Syscover\Cms\Models\Category;

class CategoryService
{
    /**
     * @param array     $object     contain properties of family
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public static function create($object)
    {
        if(! isset($object['obj_id']))
        {
            $objId = Category::max('obj_id');
            $objId++;

            $object['obj_id'] = $objId;
        }

        $object['data_lang'] = Category::addDataLang($object['lang_id'], $object['obj_id']);

        return Category::create($object);
    }

    /**
     * @param array     $object     contain properties of family
     * @param int       $id         old id of section
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public static function update($object, $id, $lang)
    {
        $object = collect($object);

        Category::where('id', $id)
            ->where('lang_id', $lang)
            ->update([
                'name'  => $object->get('name'),
                'slug'  => $object->get('slug'),
            ]);

        Category::where('obj_id', $object->get('obj_id'))
            ->update([
                'section_id' => $object->get('section_id'),
            ]);

        return Category::find($id);
    }
}