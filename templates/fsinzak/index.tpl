{extends file="%THEME%/wrapper.tpl"}
{block name="content"}
    <main id="main">
        <section id="news">
            {moduleinsert name="\Article\Controller\Block\LastNews" category='1' pageSize=3 indexTemplate="%article%/blocks/lastnews/main_page.tpl"}
        </section>
        {$fsinzak_config = \RS\Config\Loader::ByModule('fsinzak')}
        {foreach $fsinzak_config['dirs_to_main_page'] as $dir_id}
            {moduleinsert name="\Catalog\Controller\Block\TopProducts" dirs=$dir_id}
        {/foreach}
    </main>
{/block}
