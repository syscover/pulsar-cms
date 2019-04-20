<?php namespace Syscover\Cms\Services;

use Syscover\Cms\Models\Category;
use Syscover\Core\Exceptions\ModelNotChangeException;

class CategoryService
{
    public function store(array $data)
    {
        $this->validate($data, [
            'lang_id'           => 'required|numeric',
            'name'              => 'required|between:1,255',
            'slug'              => 'required|between:1,255',
            'section_id'        => 'nullable|between:0,30|exists:cms_section,id',
            'sort'              => 'nullable|min:0|numeric',
        ]);

        if(empty($data['id'])) $object['id'] = next_id(Category::class);

        $data['data_lang'] = Category::getDataLang($data['lang_id'], $data['id']);

        return Category::create($data);
    }

    public function update(array $data, int $ix)
    {
        $this->validate($data, [
            'ix'                => 'required|integer',
            'id'                => 'required|integer',
            'lang_id'           => 'required|numeric',
            'name'              => 'required|between:1,255',
            'slug'              => 'required|between:1,255',
            'section_id'        => 'nullable|between:0,30|exists:cms_section,id',
            'sort'              => 'nullable|min:0|numeric',
        ]);

        $object = Category::findOrFail($ix);
        $oldId  = $object->id; // retrieve the id for common update

        $object->fill($data);

        // check is model has changed
        if ($object->isClean()) throw new ModelNotChangeException('At least one value must change');

        // save changes
        $object->save();

        // save changes in all object, with the same id
        // this method is exclusive form elements multi language
        $commonData = $object->only('section_id', 'sort');

        Category::where('id', $oldId)->update($commonData);

        return $object;
    }
}
