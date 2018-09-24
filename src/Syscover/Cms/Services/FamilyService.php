<?php namespace Syscover\Cms\Services;

use Syscover\Cms\Models\Family;

class FamilyService
{
    public static function create($object)
    {
        self::checkCreate($object);
        return Family::create(self::builder($object));
    }

    public static function update($object)
    {
        self::checkUpdate($object);
        Family::where('id', $object['id'])->update(self::builder($object));

        return Family::find($object['id']);
    }

    private static function builder($object)
    {
        $object = collect($object);
        return $object->only(['name', 'excerpt_editor_id', 'article_editor_id', 'field_group_id', 'date', 'title', 'slug', 'link', 'categories', 'sort', 'tags', 'article_parent', 'attachments'])->toArray();
    }

    private static function checkCreate($object)
    {
        if(empty($object['name'])) throw new \Exception('You have to define a name field to create a family');
    }

    private static function checkUpdate($object)
    {
        if(empty($object['id'])) throw new \Exception('You have to define a id field to update a family');
    }
}