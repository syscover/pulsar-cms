<?php namespace Syscover\Cms\Services;

use Syscover\Core\Services\Service;
use Syscover\Core\Exceptions\ModelNotChangeException;
use Syscover\Cms\Models\Category;

class CategoryService extends Service
{
    public function store(array $data)
    {
        $this->validate($data, [
            'lang_id'           => 'required|size:2|exists:admin_lang,id',
            'name'              => 'required|between:1,255',
            'slug'              => 'required|between:1,255',
            'section_id'        => 'nullable|between:0,30|exists:cms_section,id',
            'sort'              => 'nullable|min:0|numeric',
        ]);

        if(empty($data['id'])) $data['id'] = next_id(Category::class);

        $data['data_lang'] = Category::getDataLang($data['lang_id'], $data['id']);

        return Category::create($data);
    }

    public function update(array $data, int $ix)
    {
        $this->validate($data, [
            'ix'                => 'required|integer',
            'id'                => 'required|integer',
            'lang_id'           => 'required|size:2|exists:admin_lang,id',
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
