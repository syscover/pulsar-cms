<?php namespace Syscover\Cms\Services;

use Syscover\Cms\Models\Section;

class SectionService
{
    /**
     * @param   array     $object     contain properties of section
     * @return  mixed
     * @throws  \Exception
     */
    public static function create($object)
    {
        SectionService::check($object);
        return Section::create(SectionService::builder($object));
    }

    /**
     * @param   array     $object     contain properties of section
     * @return  \Syscover\Cms\Models\Section
     * @throws  \Exception
     */
    public static function update($object)
    {
        if(! empty($object['attachment_families'])) $object['attachment_families'] = json_encode($object['attachment_families']);

        SectionService::check($object);
        Section::where('ix', $object['ix'])->update(SectionService::builder($object));

        return Section::find($object['ix']);
    }

    private static function builder($object)
    {
        $object = collect($object);
        $data = [];

        if($object->has('id'))                  $data['id'] = $object->get('id');
        if($object->has('name'))                $data['name'] = $object->get('name');
        if($object->has('family_id'))           $data['family_id'] = $object->get('family_id');
        if($object->has('attachment_families')) $data['attachment_families'] = $object->get('attachment_families');

        return $data;
    }

    private static function check($object)
    {
        if(empty($object['id']))     throw new \Exception('You have to define a id field to create a section');
        if(empty($object['name']))   throw new \Exception('You have to define a name field to create a section');
    }
}