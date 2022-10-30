<div class="bordered userBlock">
    <h3>{t}Получатель{/t}</h3>
    <div id="userBlockWrapper">
        {$recipient = $elem->getRecipient()}
        <div id="userBlockWrapperContent">
            {if isset($recipient.id) && $recipient.id>0}
                <input type="hidden" name="recipient_id" value="{$recipient.id}"/>
                <table class="otable">
                    <tr>
                        <td class="otitle">
                            {t}Фамилия Имя Отчество:{/t}
                        </td>
                        <td>
                            <a href="{adminUrl mod_controller="fsinzak-recipientsctrl" do="edit" id=$recipient.id}" target="_blank">{$recipient->getFio()} ({$recipient.id})</a>&nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td class="otitle">
                            {t}Дата рождения:{/t}
                        </td>
                        <td>{$recipient->getBirthday('d.m.Y')}</td>
                    </tr>
                    <tr>
                        <td class="otitle">
                            {t}Учреждение:{/t}
                        </td>
                        <td>{$elem->getColonyTitle()}</td>
                    </tr>
                </table>
            {else}
                <p class="emptyOrderBlock">{t}Получатель не указан.{/t}</p>
            {/if}
        </div>
    </div>
</div>
