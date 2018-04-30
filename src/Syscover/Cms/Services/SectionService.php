<?php namespace Syscover\Cms\Services;

use Syscover\Cms\Models\Section;

class SectionService
{
    public static function create($object)
    {
        SectionService::checkCreate($object);
        return Section::create(SectionService::builder($object));
    }

    public static function update($object)
    {
        if(! empty($object['attachment_families'])) $object['attachment_families'] = json_encode($object['attachment_families']);

        SectionService::checkUpdate($object);
        Section::where('ix', $object['ix'])->update(SectionService::builder($object));

        return Section::find($object['ix']);
    }

    private static function builder($object)
    {
        $object = collect($object);
        return $object->only('id', 'name', 'family_id', 'attachment_families')->toArray();
    }

    private static function checkCreate($object)
    {
        if(empty($object['id']))     throw new \Exception('You have to define a id field to create a section');
        if(empty($object['name']))   throw new \Exception('You have to define a name field to create a section');
    }

    private static function checkUpdate($object)
    {
        if(empty($object['ix']))     throw new \Exception('You have to define a id field to update a section');
    }
}