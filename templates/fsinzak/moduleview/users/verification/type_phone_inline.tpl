{* Для работы во всплывающих окнах, должен подключаться в layout.tpl файл %users%/rscomponent/verification.js *}
{addcss file="%users%/verification.css"}
{* --- *}

{$delay_refresh_code = $verify_session->getRefreshCodeDelay()}
{$state = $verify_session->getState()}
{$error = $verify_session->getErrorsStr()}
{$action = $verify_session->getAction()}

<div class="rs-verify-code-block rs-inline"
     data-token="{$verify_session->getToken()}"
     data-check-code-url="{$router->getUrl('users-front-verify', ["Act" => "checkCode"])}">

    <input data-token type="hidden" name="{$action->getTokenInputName()}" value="{$verify_session->getToken()}">
    <div class="rs-verify-line checkout-phone col m6 s6 l6" style="padding-left: 0;">
        <div class="input-field">
            <input class="form-control tel" data-phone type="text" name="{$action->getPhoneInputName()}"
                   value="{$verify_session['phone']}"
                   {if $state != 'initialized'}readonly{/if} {$action->getPhoneInputAttrLine()}>
            <label for="">Телефон</label>
        </div>
    </div>
    {if $state == 'codeEnter'}
        <div class="col m6 s6 l6" style="padding-right: 0;">
            <div class="input-field">
                <input class=""
                       data-key type="text"
                       placeholder="{$verify_session.code_debug|default:"{t}Код из СМС{/t}"}"
                       data-auto-submit-length="{$verify_session->getCodeLength()}" autocomplete="off">
                <label for="">Код из СМС</label>
            </div>
        </div>

    {elseif $state == 'resolved'}
        <div class="rs-verify-ok"><img src="{$users_resource.mod_img}icon-success.png" alt="ok" title="{t}Номер подтвержден{/t}"></div>
    {/if}

    {if $state != 'resolved'}
        <div style="padding-right: 0; padding-left: 0;" class="rs-verify-timer-line col s12 m12 l12 mt-2 {if $delay_refresh_code > 0}rs-wait{/if}" data-delay-refresh-code-sec="{$delay_refresh_code}">
            {if $delay_refresh_code > 0}
                <span class="rs-verify-timer">
                    <span class="phrase">{t}Отправить новый код можно через{/t} <span class="rs-time">{$verify_session->formatSecond($delay_refresh_code)}</span> {t}сек.{/t}</span>
                </span>
            {/if}
            <a class="rs-verify-refresh-code" data-url="{$router->getUrl('users-front-verify', ["Act" => "sendCode"])}">{t}Получить код подтверждения{/t}</a>
            {if $state == 'codeEnter'}
                <br><a class="rs-verify-reset" data-url="{$router->getUrl('users-front-verify', ["Act" => "reset"])}">Изменить номер телефона</a>
            {/if}
        </div>
    {else}
        <div class="rs-verify-reset-line mt-2 col s12 m12 l12" style="padding-right: 0; padding-left: 0;">
            <a class="rs-verify-reset" data-url="{$router->getUrl('users-front-verify', ["Act" => "reset"])}">{t}Изменить номер телефона{/t}</a>
        </div>
    {/if}
    {* Сюда будет записана ошибка, в случае если не токен истечет *}
    <span class="rs-verify-error invalid-feedback d-block">{$error}</span>
</div>
