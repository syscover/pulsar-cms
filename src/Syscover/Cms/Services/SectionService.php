<?php namespace Syscover\Cms\Services;

use Syscover\Cms\Models\Section;

class SectionService
{
    /**
     * @param $object   array   contain properties of section
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public static function createService($object)
    {
        return Section::create($object);
    }

    /**
     * @param $object   array   contain properties of section
     * @param $id       int     old id of section
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public static function updateService($object, $id)
    {
        Section::where('id', $id)->update([
            'id'                => $object['id'],
            'name'              => $object['name'],
            'article_family_id' => $object['family_id']
        ]);

        return Section::find($object['id']);
    }
}