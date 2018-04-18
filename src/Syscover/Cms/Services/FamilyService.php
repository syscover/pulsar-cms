<?php namespace Syscover\Cms\Services;

use Syscover\Cms\Models\Family;

class FamilyService
{
    public static function create($object)
    {
        FamilyService::check($object);
        return Family::create(FamilyService::builder($object));
    }

    public static function update($object)
    {
        FamilyService::check($object);
        Family::where('id', $object['id'])
            ->update(FamilyService::builder($object));

        return Family::find($object['id']);
    }

    private static function builder($object)
    {
        $object = collect($object);
        $data = [];

        if($object->has('name'))                $data['name'] = $object->get('name');
        if($object->has('excerpt_editor_id'))   $data['excerpt_editor_id'] = $object->get('excerpt_editor_id');
        if($object->has('article_editor_id'))   $data['article_editor_id'] = $object->get('article_editor_id');
        if($object->has('field_group_id'))      $data['field_group_id'] = $object->get('field_group_id');
        if($object->has('date'))                $data['date'] = $object->get('date');
        if($object->has('title'))               $data['title'] = $object->get('title');
        if($object->has('slug'))                $data['slug'] = $object->get('slug');
        if($object->has('link'))                $data['link'] = $object->get('link');
        if($object->has('categories'))          $data['categories'] = $object->get('categories');
        if($object->has('sort'))                $data['sort'] = $object->get('sort');
        if($object->has('tags'))                $data['tags'] = $object->get('tags');
        if($object->has('article_parent'))      $data['article_parent'] = $object->get('article_parent');
        if($object->has('attachments'))         $data['attachments'] = $object->get('attachments');

        return $data;
    }

    private static function check($object)
    {
        if(empty($object['name']))      throw new \Exception('You have to define a name field to create a family');
    }
}