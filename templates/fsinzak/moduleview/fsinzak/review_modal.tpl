{extends "%THEME%/helper/wrapper/dialog/standard.tpl"}

{block "class"}modal-lg{/block}
{block "title"}
   {t}Оставить отзыв{/t}
{/block}
{block "body"}
    <div class="input-field review-text">
        <textarea class="styled" name="review_text" placeholder="Текст отзыва"></textarea>
        <label>Текст отзыва</label>
    </div>
{/block}
{block "footer"}
    <div class="modal-footer">
        <a data-id="{$user_id}"
           data-referer="{$referer}"
           data-url="{$router->getUrl('fsinzak-front-reviews',['Act' => 'createReview'])}"
           class="btn review-create"
        >Отправить</a>
    </div>
{/block}
