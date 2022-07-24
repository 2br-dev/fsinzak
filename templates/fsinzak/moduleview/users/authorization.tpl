{* Диалог авторизации пользователя *}
{extends "%THEME%/helper/wrapper/dialog/standard.tpl"}

{block "title"}{t}Вход{/t}{/block}
{block "body"}
    {$is_dialog_wrap=$url->request('dialogWrap', $smarty.const.TYPE_INTEGER)}
    {if !empty($status_message)}<div class="alert alert-danger" role="alert">{$status_message}</div>{/if}

    <form action="{$router->getUrl('users-front-auth')}" method="POST">
        {hook name="users-authorization:form" title="{t}Авторизация:форма{/t}"}
            {if $error}<div class="invalid-feedback">{$error}</div>{/if}
            {$this_controller->myBlockIdInput()}
            <input type="hidden" name="referer" value="{$data.referer}">
            <input type="hidden" name="remember" value="1">
            <div class="row">
                <div class="col s12">
                    <div class="input-field">
                        <input type="text" placeholder="{$login_placeholder}" name="login"
                               value="{$data.login|default:$Setup.DEFAULT_DEMO_LOGIN}"
                               class="form-control {if !empty($error)}is-invalid{/if}"
                               autocomplete="off"
                               id="input-auth1"
                        >
                        <label for="input-auth1" class="form-label">{$login_placeholder}</label>
                    </div>
                </div>
                <div class="col s12">
                    <div class="input-field">
                        <input type="password" name="pass" value="{$Setup.DEFAULT_DEMO_PASS}"
                               class="form-control {if !empty($error)}is-invalid{/if}"
                               autocomplete="off" id="input-auth2">
                        <label for="input-auth2" class="form-label">Пароль</label>
                    </div>
                </div>
                <div class="col s12 right-align">
                    <button type="submit" class="btn">{t}Войти{/t}</button>
                </div>
            </div>
            <div class="row d-flex align-items-center justify-content-between fs-5">
                <a href="{$router->getUrl('users-front-auth', ["Act" => "recover"])}" {if $is_dialog_wrap}class="rs-in-dialog"{/if}>{t}Забыли пароль?{/t}</a>
                <a href="{$router->getUrl('users-front-auth', ["Act" => "byPhone"])}" {if $is_dialog_wrap}class="rs-in-dialog"{/if}>{t}Войти с помощью телефона{/t}</a>
                <a href="{$router->getUrl('users-front-register')}" {if $is_dialog_wrap}class="rs-in-dialog"{/if}>{t}У меня нет аккаунта{/t}</a>
            </div>
        {/hook}
    </form>
{/block}
