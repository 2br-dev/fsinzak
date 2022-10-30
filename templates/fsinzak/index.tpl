{extends file="%THEME%/wrapper.tpl"}
{block name="content"}
    <main id="main">
        <section id="hero">
            <div class="row no-margin">
                <div class="col m6 s12 no-padding">
                    <div class="lazy" id="hero-left" data-src="{$THEME_IMG}/hero_left.svg"></div>
                </div>
                <div class="col m6 s12 no-padding">
                    <div class="lazy" id="hero-right" data-src="{$THEME_IMG}/hero_right.jpg"></div>
                </div>
            </div>
        </section>
        {moduleinsert name="\Catalog\Controller\Block\TopProducts" dirs="rekomenduemye-tovary" pageSize="50" indexTemplate="%catalog%/blocks/topproducts/recomended_products.tpl"}
        {moduleinsert name="\Fsinzak\Controller\Block\HowOrderBlock"}
        <section id="news">
            {moduleinsert name="\Article\Controller\Block\LastNews" category='1' pageSize=3 indexTemplate="%article%/blocks/lastnews/main_page.tpl"}
        </section>
        {moduleinsert name="\Fsinzak\Controller\Block\Faq"}
{*        {$fsinzak_config = \RS\Config\Loader::ByModule('fsinzak')}*}
{*        {foreach $fsinzak_config['dirs_to_main_page'] as $dir_id}*}
{*            {moduleinsert name="\Catalog\Controller\Block\TopProducts" dirs=$dir_id}*}
{*        {/foreach}*}
    </main>
{/block}
