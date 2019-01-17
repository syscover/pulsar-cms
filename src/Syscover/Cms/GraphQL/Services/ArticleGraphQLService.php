<?php namespace Syscover\Cms\GraphQL\Services;

use Syscover\Admin\Services\AttachmentService;
use Syscover\Cms\Models\Article;
use Syscover\Cms\Services\ArticleService;
use Syscover\Core\GraphQL\Services\CoreGraphQLService;
use Syscover\Core\Services\SQLService;

class ArticleGraphQLService extends CoreGraphQLService
{
    protected $modelClassName = Article::class;
    protected $serviceClassName = ArticleService::class;

    public function delete($root, array $args)
    {
        $object = SQLService::deleteRecord($args['id'], $this->modelClassName, $args['lang_id']);

        if (
            config('scout.driver') === 'algolia' ||
            config('scout.driver') === 'pulsar-search'
        ) $object->unsearchable();

        // detach categories only if delete base land object
        if(base_lang() === $object->lang_id) $object->categories()->detach();

        // delete attachments
        AttachmentService::deleteAttachments($args['id'], $this->modelClassName, $args['lang_id']);

        return $object;
    }
}