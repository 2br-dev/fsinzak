{block name="content"}
    <main id="responses">
        <section>
            <div class="container">
                <div class="row flex">
                    <div class="col s12">
                        <ul class="breadcrumbs">
                            <li><a href="/">Главная</a></li>
                            <li><span>Отзывы</span></li>
                        </ul>
                        <h1>
                            <span>Отзывы</span>
                        </h1>
                    </div>
                    <div class="col s12 review-action">
                        {if $is_auth}
                            {if $can_write_review}
                                <a href="{$router->getUrl('fsinzak-front-reviews', ['Act' => 'getReviewModal', 'user' => $user['id']])}" class="btn rs-in-dialog">Оставить отзыв</a>
                            {else}
                                <p class="cant-write-review info">Вы уже оставляли отзыв о сервисе. Ваше мнение учтено. Спасибо.</p>
                            {/if}
                        {else}
                            <p class="cant-write-review info">Оставлять отзывы могут только авторизованные пользователи</p>
                        {/if}
                    </div>
                    {if $reviews}
                        <div class="col xl12 l12 m12 s12 responses-wrapper">
                            <div class="responses">
                                {foreach $reviews as $review}
                                    {if $review['public']}
                                        <div class="response">
                                            <div class="response-top">{$review['text']}</div>
                                            <div class="response-bottom">
                                                <div class="review-date">{$review['dateof']}</div>
                                                <div class="author">{$user['name']}</div>
                                            </div>
                                            {if $review['answer'] !=''}
                                                <div class="answer">
                                                    <div class="author">
                                                        <span class="name">
                                                            Администратор
                                                        </span>
                                                    </div>
                                                    <div class="body">{$review['answer']}</div>
                                                </div>
                                            {/if}
                                        </div>
                                    {/if}
                                {/foreach}
                            </div>
                        </div>
                    {else}
                        <div class="col s12">
                            <p class="info">Еще ни один покупатель не оставил отзыв</p>
                        </div>
                    {/if}
                </div>
            </div>
        </section>
    </main>
{/block}
