{if $dirlist->count()}
    <ul class="catalog-navi">
        {foreach $dirlist as $node}
            {$dir = $node->getObject()}
            <li class="{if $node->getChildsCount()}folder{/if}">
                <a
                    href="{$dir->getUrl()}"
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
{/if}
