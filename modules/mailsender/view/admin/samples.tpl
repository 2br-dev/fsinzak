<div class="titlebox">{t}Выберите оформление{/t}</div>
<ul class="mailsender-samples" data-get-sample-url="{adminUrl do="ajaxGetSampleHtml"}">
    {foreach $samples as $sample}
        <li data-sample-id="{$sample->getId()}">
            <div class="mailsender-sample-image">
                <img src="{$sample->getPreviewUrl()}">
            </div>
            <a class="mailsender-sample-link">{$sample->getTitle()}</a>
        </li>
    {/foreach}
</ul>
