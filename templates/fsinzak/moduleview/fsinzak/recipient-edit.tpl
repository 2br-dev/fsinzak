{extends "%THEME%/helper/wrapper/dialog/standard.tpl"}

{block "class"}modal-lg{/block}
{block "title"}
    {t}Редактирование данных получателя{/t}
{/block}
{block "body"}
    <form id="recipient-edit-form">
        <div class="row">
            <input type="hidden" name="id" value="{$recipient['id']}">
            <input type="hidden" name="referer" value="/my/recipients/">
            <div class="col l6 m12">
                <div class="input-field">
                    <input type="text" name="surname" placeholder="Фамилия" value="{$recipient['surname']}">
                    <label for="">Фамилия</label>
                </div>
            </div>
            <div class="col l6 m12">
                <div class="input-field">
                    <input type="text" placeholder="Имя" name="name" value="{$recipient['name']}">
                    <label for="">Имя</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col l6 m12">
                <div class="input-field">
                    <input type="text" placeholder="Отчество" name="midname" value="{$recipient['midname']}">
                    <label for="">Отчество</label>
                </div>
            </div>
            <div class="col l6 m12">
                <input type="hidden" class="defaultDatePicker" value="{$birthday_timestamp}">
                <div class="input-field">
                    <input type="text" name="birthday" class="datepicker" placeholder="Дата рождения">
                    <label for="">Дата рождения</label>
                </div>
                <input type="hidden" name="birthday_timestamp" value="{$birthday_timestamp}">
            </div>
        </div>
    </form>
{/block}
{block "footer"}
    <div class="modal-footer">
        <a
           data-referer = "/my/recipients/"
           data-url="{$router->getUrl('fsinzak-front-myrecipients',['Act' => 'edit'])}"
           class="btn recipient-edit"
        >Сохранить</a>
    </div>
{/block}
