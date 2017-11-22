<?php namespace Syscover\Cms\Services;

use Syscover\Cms\Models\Section;

class SectionService
{
    /**
     * @param array     $object     contain properties of section
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public static function create($object)
    {
        return Section::create($object);
    }

    /**
     * @param array     $object     contain properties of section
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public static function update($object)
    {
        $object = collect($object);

        Section::where('ix', $object->get('ix'))->update([
            'id'                    => $object->get('id'),
            'name'                  => $object->get('name'),
            'family_id'             => $object->get('family_id'),
            'attachment_families'   => json_encode($object->get('attachment_families'))
        ]);

        return Section::find($object->get('ix'));
    }
}