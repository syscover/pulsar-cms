<?php namespace Syscover\Cms\Services;

use Syscover\Core\Services\Service;
use Syscover\Core\Exceptions\ModelNotChangeException;
use Syscover\Admin\Services\AttachmentService;
use Syscover\Cms\Models\Article;
use Syscover\Core\Services\SlugService;

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

        $data['slug'] = SlugService::checkSlug('Syscover\\Cms\\Models\\Article', $data['slug'], null, 'slug', $data['lang_id']);

        // check if has id or can to come from create-lang
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

    public function clone(array $data)
    {
        $this->validate($data, [
            'lang_id'       => 'required|size:2|exists:admin_lang,id',
            'name'          => 'required|between:1,255',
            'author_id'     => 'required|exists:admin_user,id',
            'section_id'    => 'required|exists:cms_section,id',
            'status_id'     => 'required|integer'
        ]);

        $object = null;

        // get articles from other languages
        $articlesToClone    = Article::where('id', $data['id'])->get();
        
        // get new id for article cloned
        $cloneId            = next_id(Article::class);

        foreach($articlesToClone as $articleToClone)
        {
            if ($articleToClone->lang_id === base_lang())
            {
                $cloneData = array_merge($articleToClone->toArray(), $data);

                // get custom fields
                if(isset($cloneData['field_group_id'])) $cloneData['data']['custom_fields'] = $cloneData['custom_fields'];
            } 
            else
            {
                $cloneData = $articleToClone->toArray();
            }
            
            // delete index to avoid error to create other article with the same ix
            unset($cloneData['ix']);

            // set new id
            $cloneData['id'] = $cloneId;

            // check slug
            $cloneData['slug'] = SlugService::checkSlug('Syscover\\Cms\\Models\\Article', $cloneData['slug'], null, 'slug', $cloneData['lang_id']);

            // create article
            $cloneObject = Article::create($cloneData);

            // get object with builder, to get every relations
            $cloneObject = $cloneObject->fresh();

            // we update record if has scout search engine, for register relations
            if (has_scout())
            {
                // status 2 is public
                if($cloneObject->status_id === 2) $cloneObject->searchable(); else $cloneObject->unsearchable();
            }

            // parse html and manage img of wysiwyg
            // $html = AttachmentService::manageWysiwygAttachment($object->article, 'storage/app/public/cms/articles', 'storage/cms/articles', $object->id);
            
            /* 
            if($html != null)
            {
                $object->article = $html;
                $object->save();
            } 
            */

            if ($articleToClone->lang_id === base_lang())
            {
                $cloneObject->categories()->sync($cloneData['categories_id']);

                // set attachments
                if(is_array($cloneData['attachments']))
                {
                    // first save libraries to get id
                    $attachments = AttachmentService::storeAttachmentsLibrary($cloneData['attachments']);

                    // then save attachments
                    AttachmentService::cloneAttachments($attachments, 'storage/app/public/cms/articles', 'storage/cms/articles', Article::class, $cloneObject->id,  $cloneObject->lang_id);
                }

                $object = $cloneObject;
            }
            else
            {
                AttachmentService::cloneAttachments($articleToClone->attachments->where('lang_id', $cloneObject->lang_id)->toArray(), 'storage/app/public/cms/articles', 'storage/cms/articles', Article::class, $cloneObject->id,  $cloneObject->lang_id);
            }
        }

        return $object;
    }
}
