<?php namespace Syscover\Cms\Services;

use Syscover\Cms\Models\Family;

class FamilyService
{
    /**
     * @param array     $object     contain properties of family
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public static function create($object)
    {
        return Family::create($object);
    }

    /**
     * @param array     $object     contain properties of family
     * @param int       $id         old id of section
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public static function update($object, $id)
    {
        $object = collect($object);

        Family::where('id', $id)
            ->update([
                'name'                  => $object->get('name'),
                'excerpt_editor_id'     => $object->get('excerpt_editor_id'),
                'article_editor_id'     => $object->get('article_editor_id'),
                'field_group_id'        => $object->get('field_group_id'),
                'date'                  => $object->get('date'),
                'title'                 => $object->get('title'),
                'slug'                  => $object->get('slug'),
                'link'                  => $object->get('link'),
                'categories'            => $object->get('categories'),
                'sort'                  => $object->get('sort'),
                'tags'                  => $object->get('tags'),
                'article_parent'        => $object->get('article_parent'),
                'attachments'           => $object->get('attachments')
            ]);

        return Family::find($id);
    }
}