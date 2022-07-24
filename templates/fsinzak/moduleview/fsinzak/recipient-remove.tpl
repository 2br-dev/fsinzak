{extends "%THEME%/helper/wrapper/dialog/standard.tpl"}

{block "class"}modal-lg{/block}
{block "title"}
    {t}Удаление получателя{/t}
{/block}
{block "body"}
    <p>Удалить получателя: {$recipient->getFio()}?</p>
{/block}
{block "footer"}
    <div class="modal-footer">
        <form action="{$router->getUrl('fsinzak-front-myrecipients', ['Act' => 'remove'])}" method="POST">
            <input type="hidden" name="id" value="{$recipient['id']}">
            <input type="hidden" name="/my/recipients/">
            <button type="submit"
               class="btn recipient-remove"
            >Удалить</button>
        </form>
    </div>
{/block}
