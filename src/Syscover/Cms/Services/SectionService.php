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
     * @param int       $id         old id of section
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public static function update($object, $id)
    {
        $object = collect($object);

        Section::where('id', $id)->update([
            'id'                => $object->get('id'),
            'name'              => $object->get('name'),
            'family_id'         => $object->get('family_id')
        ]);

        return Section::find($object->get('id'));
    }
}