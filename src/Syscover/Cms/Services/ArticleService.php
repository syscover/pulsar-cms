<?php namespace Syscover\Cms\Services;

use Syscover\Core\Services\Service;
use Syscover\Core\Exceptions\ModelNotChangeException;
use Syscover\Admin\Services\AttachmentService;
use Syscover\Cms\Models\Article;

class ArticleService extends Service
{
    public function store(array $data)
    {
        $this->validate($data, [
            'lang_id'       => 'required|size:2|exists:admin_lang,id',
            'name'          => 'required|between:1,255',
            'author_id'     => 'required|exists:admin_user,id',
            'section_id'    => 'required|exists:cms_section,id',
            'status_id'     => 'required|integer'
        ]);

        if(empty($data['id'])) $data['id'] = next_id(Article::class);

        $data['data_lang'] = Article::getDataLang($data['lang_id'], $data['id']);

        // get custom fields
        if(isset($data['field_group_id'])) $data['data']['custom_fields'] = $data['custom_fields'];

        $object = Article::create($data);

        // get object with builder, to get every relations
        $object = $object->fresh();

        // we update record if has scout search engine, for register relations
        if (has_scout())
        {
            // status 2 is public
            if($object->status_id === 2) $object->searchable(); else $object->unsearchable();
        }

        // parse html and manage img of wysiwyg
        $html = AttachmentService::manageWysiwygAttachment($object->article, 'storage/app/public/cms/articles', 'storage/cms/articles', $object->id);

        if($html != null)
        {
            $object->article = $html;
            $object->save();
        }

        $object->categories()->sync($data['categories_id']);

        // set attachments
        if(is_array($data['attachments']))
        {
            // first save libraries to get id
            $attachments = AttachmentService::storeAttachmentsLibrary($data['attachments']);

            // then save attachments
            AttachmentService::storeAttachments($attachments, 'storage/app/public/cms/articles', 'storage/cms/articles', Article::class, $object->id,  $object->lang_id);
        }

        return $object;
    }

    public function update(array $data, int $ix)
    {
        $this->validate($data, [
            'ix'            => 'required|integer',
            'id'            => 'required|integer',
            'lang_id'       => 'required|size:2|exists:admin_lang,id',
            'name'          => 'required|between:1,255',
            'author_id'     => 'required|exists:admin_user,id',
            'section_id'    => 'required|exists:cms_section,id',
            'status_id'     => 'required|integer'
        ]);

        $object = Article::findOrFail($ix);

        // get custom fields
        if (isset($data['field_group_id'])) $data['data']['custom_fields'] = $data['custom_fields'];

        $object->fill($data);

        // check is model has changed
        if ($object->isClean()) throw new ModelNotChangeException('At least one value must change');

        // save changes
        $object->save();

        // we update record if has scout search engine, for register relations
        if (has_scout())
        {
            // status 2 is public
            if($object->status_id === 2) $object->searchable(); else $object->unsearchable();
        }

        // parse html and manage img of wysiwyg
        $html = AttachmentService::manageWysiwygAttachment($object->article, 'storage/app/public/cms/articles', 'storage/cms/articles', $object->id);

        if($html != null)
        {
            $object->article = $html;
            $object->save();
        }

        $object->categories()->sync($data['categories_id']);

        // set attachments
        if (is_array($data['attachments']))
        {
            // first save libraries to get id
            $attachments = AttachmentService::storeAttachmentsLibrary($data['attachments']);

            // then save attachments
            AttachmentService::updateAttachments($attachments, 'storage/app/public/cms/articles', 'storage/cms/articles', Article::class, $object->id,  $object->lang_id);
        }

        return $object;
    }
}
