{addjs file="core6/rsplugins/ajaxpaginator.js" basepath="common"}
{addjs file="%comments%/rscomponent/comments.js"}

{$users_config = ConfigLoader::byModule('users')}
<div id="responses">
    <div class="stats">
        <div class="stars-stats">
            {$matrix = $comment_type->getMarkMatrix()}
            {foreach $matrix as $rate => $count}
                <div class="stars-{$rate}">{$count}</div>
            {/foreach}
        </div>
        <div class="rating-stats">
            <div>{verb item=$total values="{t}оценка,оценки,оценок{/t}"}</div>
            <div class="rating-val">{if $comment_type->getTypeId() == '\Catalog\Model\CommentType\Product'}
                    {$product = $comment_type->getLinkedObject()}
                    {$product->getRatingBall()}
                {else}
                    {$comment_type->getRatingBall()}
                {/if}
            </div>
            <div class="rating-description">Рейтинг</div>
        </div>
    </div>
    <div class="stats-footer">{if $mod_config.need_authorize == 'Y' && $current_user.id <= 0}
            <a data-href="{$users_config->getAuthorizationUrl(['referer' => $referer])}" class="btn rs-in-dialog">{t}Авторизуйтесь,<br><small>чтобы оставить отзыв</small>{/t}</a>
        {else}
            <a data-href="{$router->getUrl('comments-block-comments', ['_block_id' => $_block_id, 'aid' => $aid, 'cmdo' => 'commentFormDialog'])}" class="btn rs-in-dialog">{t}Оставить отзыв{/t}</a>
        {/if}
    </div>
    <div class="responses">
        {if $total}
            {$list_html}
{*            {if $paginator->total_pages > $paginator->page}*}
{*                <div class="mt-5">*}
{*                    <a data-pagination-options='{ "appendElement":".rs-comment-list" }'*}
{*                       data-url="{$router->getUrl('comments-block-comments', ['_block_id' => $_block_id, 'cp' => $paginator->page+1, 'aid' => $aid])}"*}
{*                       class="btn btn-outline-primary col-12 rs-ajax-paginator">{t}еще комментарии...{/t}</a>*}
{*                </div>*}
{*            {/if}*}
        {/if}
    </div>
</div>
