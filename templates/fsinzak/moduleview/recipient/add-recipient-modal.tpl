{extends "%THEME%/helper/wrapper/dialog/standard.tpl"}

{block "class"}modal-lg{/block}
{block "title"}
    {t}Выбор Получателя{/t}
{/block}
{if $is_auth}
    {block "body"}
        <div class="row">
            <div class="col l6 m12">
                <div class="input-field"><input type="text" placeholder="Фамилия"><label for="">Фамилия</label></div>
            </div>
            <div class="col l6 m12">
                <div class="input-field"><input type="text" placeholder="Имя"><label for="">Имя</label></div>
            </div>
            <div class="col l6 m12">
                <div class="input-field"><input type="text" placeholder="Отчество"><label for="">Отчество</label></div>
            </div>
        </div>
    {/block}
    {block "footer"}
        <div class="modal-footer">
            <a data-id="{$id}"
               data-referer="{$referer}"
               data-url="{$router->getUrl('fsinzak-front-recipient',['Act' => 'add'])}"
               class="btn"
            >Принять</a>
        </div>
    {/block}
{else}
    {block "body"}
        <div class="row">
            <p>Чтобы иметь возможность добавлять/выбирать получателя необходимо Авторизоваться</p>
        </div>
    {/block}
    {block "footer"}
        <div class="modal-footer" id="add-recipient-not-auth">
            <a class="btn btn-flat rs-in-dialog" href="{$router->getUrl('users-front-register', ['referer' => $referer])}">Регистрация</a>
            <a class="btn rs-in-dialog" href="{$router->getUrl('users-front-auth', ['referer' => $referer])}">Авторизация</a>
        </div>
    {/block}
{/if}
