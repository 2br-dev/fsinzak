{* Шаблон выпадающего списка категорий *}
{*{nocache}*}
{*{addjs file="%catalog%/rscomponent/category.js"}*}
{*{/nocache}*}
{if $dirlist->count()}
    <div class="container">
        <div class="levels">
            <ul class="mega-menu" id="l1">
                {foreach $dirlist as $node}
                    {$dir = $node->getObject()}
                    <li class="{if $node->getChildsCount()}folder{/if}">
                        <a
                            href="{$dir->getUrl()}"
                            class="lazy"
                            {if $dir.image}
                                data-src="{$dir.__image->getUrl(100, 100, 'cxy')}"
                            {else}
                                data-src="{$THEME_IMG}/icons/availability.svg"
                            {/if}
                        >{$dir.name}</a>
                        {if $node->getChildsCount()}
                            <ul>
                                {foreach $node->getChilds() as $sub_node}
                                    {$sub_dir = $sub_node->getObject()}
                                    <li><a href="{$sub_dir->getUrl()}">{$sub_dir.name}</a></li>
                                {/foreach}
                            </ul>
                        {/if}
                    </li>
                {/foreach}
            </ul>
            <ul id="l2"></ul>
        </div>
    </div>
{*    <div class="row g-3">*}
{*        <div class="col-auto">*}
{*            <div class="head-dropdown-catalog__categories py-xl-6 py-4">*}
{*                {foreach $dirlist as $node}*}
{*                    {$dir = $node->getObject()}*}
{*                    <a href="{$dir->getUrl()}" class="head-dropdown-catalog__category" data-target="dropdown-subcat-{$node@iteration}" {$dir->getDebugAttributes()}>*}
{*                        {if $THEME_SETTINGS.catalog_with_images}*}
{*                            {if $dir.image}*}
{*                                <img src="{$dir.__image->getUrl(24, 24, 'cxy')}" alt="" width="24" height="24">*}
{*                            {else}*}
{*                                <img src="{$THEME_IMG}/icons/availability.svg" alt="" width="24" height="24">*}
{*                            {/if}*}
{*                        {/if}*}
{*                        <span class="ms-3">{$dir.name}</span>*}
{*                    </a>*}
{*                {/foreach}*}
{*            </div>*}
{*        </div>*}
{*        <div class="col">*}
{*            <div class="py-xl-6 py-4">*}
{*                {if $THEME_SETTINGS.catalog_nesting_type == 'variant1'}*}
{*                    {include file="blocks/category/category_sub_variant1.tpl"}*}
{*                {else}*}
{*                    {include file="blocks/category/category_sub_variant2.tpl"}*}
{*                {/if}*}
{*            </div>*}
{*        </div>*}
{*        {if $THEME_SETTINGS.catalog_enable_designer_column}*}
{*            <div class="col-3">*}
{*                <div class="py-xl-5 py-4">*}
{*                    {moduleinsert name="Designer\Controller\Block\Designer"}*}
{*                </div>*}
{*            </div>*}
{*        {/if}*}
{*    </div>*}
{else}
    {include "%THEME%/helper/usertemplate/include/block_dashed_stub.tpl"
    name = "{t}Список категорий{/t}"
    do = [
        [
            'title' => "{t}Добавить категории товаров{/t}",
            'href' => "{adminUrl do=false mod_controller="catalog-ctrl"}"
        ],
        [
            'title' => "{t}Настроить блок{/t}",
            'href' => {$this_controller->getSettingUrl()},
            'class' => 'crud-add'
        ]
    ]}
{/if}
