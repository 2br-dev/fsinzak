{if !empty($howorder)}
    <section id="howto">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h2>Как заказать?</h2>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <div class="row howto-wrapper">
                        {foreach $howorder as $item}
                            <div class="col center-align l3 m6 s12">
                                <div class="icon lazy" data-src="{$item['__image']->getUrl('100', '100', 'xy')}"></div>
                                <p>{$item['text']}</p>
                            </div>
                        {/foreach}
                        <div class="col s12 center-align btn-wrapper">
                            <a
                                    href="" class="btn large rs-in-dialog"
                                    data-href="{$router->getUrl('affiliate-front-affiliates', ['referer' => '/'])}"
                            >Выбрать учреждение</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
{/if}
