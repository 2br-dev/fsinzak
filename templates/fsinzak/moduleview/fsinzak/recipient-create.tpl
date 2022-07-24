{extends "%THEME%/helper/wrapper/dialog/standard.tpl"}

{block "class"}modal-lg{/block}
{block "title"}
    {t}Добавить получателя{/t}
{/block}
{block "body"}
    {$current_user = \RS\Application\Auth::getCurrentUser()}
    <form id="recipient-create-form">
        <div class="row">
            <input type="hidden" name="referer" value="/my/recipients/">
            <input type="hidden" name="user" value="{$current_user['id']}">
            <div class="col l6 m12">
                <div class="input-field">
                    <input type="text" name="surname" placeholder="Фамилия">
                    <label for="">Фамилия</label>
                </div>
            </div>
            <div class="col l6 m12">
                <div class="input-field">
                    <input type="text" placeholder="Имя" name="name">
                    <label for="">Имя</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col l6 m12">
                <div class="input-field">
                    <input type="text" placeholder="Отчество" name="midname">
                    <label for="">Отчество</label>
                </div>
            </div>
            <div class="col l6 m12">
                <div class="input-field">
                    <input type="text" name="birthday" class="datepicker" placeholder="Дата рождения">
                    <label for="">Дата рождения</label>
                </div>
                <input type="hidden" name="birthday_timestamp" value="0">
            </div>
        </div>
    </form>
{/block}
{block "footer"}
    <div class="modal-footer">
        <a
           data-referer = "/my/recipients/"
           data-url="{$router->getUrl('fsinzak-front-myrecipients',['Act' => 'create'])}"
           class="btn recipient-create"
        >Добавить</a>
    </div>
{/block}
