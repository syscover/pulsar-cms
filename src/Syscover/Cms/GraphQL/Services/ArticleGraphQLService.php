<?php namespace Syscover\Cms\GraphQL\Services;

use Syscover\Admin\Services\AttachmentService;
use Syscover\Cms\Models\Article;
use Syscover\Cms\Services\ArticleService;
use Syscover\Core\GraphQL\Services\CoreGraphQLService;
use Syscover\Core\Services\SQLService;

class ArticleGraphQLService extends CoreGraphQLService
{
    public function __construct(Article $model, ArticleService $service)
    {
        $this->model = $model;
        $this->service = $service;
    }

    public function delete($root, array $args)
    {
        $object = SQLService::deleteRecord($args['id'], get_class($this->model), $args['lang_id']);

        if (has_scout()) $object->unsearchable();

        // detach categories only if delete base land object
        if(base_lang() === $object->lang_id) $object->categories()->detach();

        // delete attachments
        AttachmentService::deleteAttachments($args['id'], get_class($this->model), $args['lang_id']);

        return $object;
    }
}
