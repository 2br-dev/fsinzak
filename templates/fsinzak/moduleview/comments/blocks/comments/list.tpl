{foreach $commentlist as $comment}
    <div class="response" {$comment->getDebugAttributes()}>
        <div class="response-top">{$comment.message|nl2br}</div>
        <div class="response-bottom">
            <div class="stars stars-{$comment.rate}"></div>
            <div class="author">{$comment.user_name}</div>
        </div>
        {if $comment['admin_ask']}
            <div class="answer">
                <div class="author">
				<span class="name">
					Админ
				</span>,
                    <i class="date">
                        {$comment['dateof']|dateformat:"%d %v %Y"}
                    </i>
                </div>
                <div class="body">{$comment['admin_ask']}</div>
            </div>
        {/if}
    </div>

{*    <div class="product-review-item" {$comment->getDebugAttributes()}>*}
{*        <div class="row g-3">*}
{*            <div class="col">*}
{*                <div class="product-review-item__title">{$comment.user_name}</div>*}
{*                <div class="fs-5 text-gray">{$comment.dateof|dateformat:"@date @time"}</div>*}
{*            </div>*}
{*            <div class="col-auto">*}
{*                <div class="rating-stars">*}
{*                    <div class="rating-stars__act" style="width: {$comment.rate*20}%;"></div>*}
{*                </div>*}
{*            </div>*}
{*        </div>*}
{*        <div class="mt-3">*}
{*            {$comment.message|nl2br}*}
{*        </div>*}
{*    </div>*}
{/foreach}
