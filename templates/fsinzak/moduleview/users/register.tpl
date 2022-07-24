{* Регистрация пользователя *}
{extends "%THEME%/helper/wrapper/dialog/standard.tpl"}
{addcss file="%users%/verification.css"}

{block "title"}{t}Регистрация{/t}{/block}
{block "body"}
    {$user_config = $this_controller->getModuleConfig()}
    {$is_dialog_wrap = $url->request('dialogWrap', $smarty.const.TYPE_INTEGER)}
    <form method="POST" action="{$router->getUrl('users-front-register')}">
        {csrf}
        {$this_controller->myBlockIdInput()}
        <input type="hidden" name="referer" value="{$referer}">
        <input type="hidden" name="is_company" value="0">
        <div class="row">
            {if $conf_userfields->notEmpty()}
                {foreach $conf_userfields->getStructure() as $fld}
                    {if $fld.alias == 'citizen'}
                        <div class="col l12 m12">
                            <div class="input-field mt-20">
                                {$conf_userfields->getForm($fld.alias, '%THEME%/helper/forms/userfields_forms_custom.tpl')}
                                <label>{$fld.title}</label>
                                {$errname = $conf_userfields->getErrorForm($fld.alias)}
                                {$error = $user->getErrorsByForm($errname, ', ')}
                                {if !empty($error)}
                                    <span class="invalid-feedback">{$error}</span>
                                {/if}
                            </div>
                        </div>
                    {/if}
                {/foreach}
            {/if}

            {if $user_config.user_one_fio_field}
                <div class="col l12 m12">
                    <div class="input-field">
                        {$user->getPropertyView('fio', ['placeholder' => "{t}Ф.И.О.{/t}"])}
                        <label class="form-label">{t}Ф.И.О.{/t}</label>
                    </div>
                </div>
            {else}
                {if $user_config->canShowField('name')}
                    <div class="col l12 m12">
                        <div class="input-field">
                            {$user->getPropertyView('name', ['placeholder' => "{t}Имя{/t}"])}
                            <label class="form-label">{t}Имя{/t}</label>
                        </div>
                    </div>
                {/if}
                {if $user_config->canShowField('surname')}
                    <div class="col l12 m12">
                        <div class="input-field">
                            {$user->getPropertyView('surname', ['placeholder' => "{t}Фамилия{/t}"])}
                            <label class="form-label">{t}Фамилия{/t}</label>
                        </div>
                    </div>
                {/if}
                {if $user_config->canShowField('midname')}
                    <div class="col l12 m12">
                        <div class="input-field">
                            {$user->getPropertyView('midname', ['placeholder' => "{t}Отчество{/t}"])}
                            <label class="form-label">{t}Отчество{/t}</label>
                        </div>
                    </div>
                {/if}
            {/if}

            {if $user_config->canShowField('phone')}
                <div class="col l12 m12 register-phone-block {if $user['data']['citizen'] == 'Не гражданин РФ'}no-rf{/if}">
                    {$user->getPropertyView('phone', ['placeholder' => "{t}Например, +7(XXX)-XXX-XX-XX{/t}"])}
                </div>
            {/if}

            {if $user_config->canShowField('login')}
                <div class="col l12 m12">
                    <div class="input-field">
                        <label class="form-label">{t}Логин{/t}</label>
                        {$user->getPropertyView('login', ['placeholder' => "{t}Придумайте логин для входа{/t}"])}
                    </div>
                </div>
            {/if}

            {if $user_config->canShowField('e_mail')}
                <div class="col l12 m12">
                    <div class="input-field">
                        {$user->getPropertyView('e_mail', ['placeholder' => "{t}Например, demo@example.com{/t}"])}
                        <label class="form-label">{t}E-mail{/t}</label>
                    </div>
                </div>
            {/if}

            {if $conf_userfields->notEmpty()}
                {foreach $conf_userfields->getStructure() as $fld}
                    {if $fld.alias != 'citizen'}
                        <div class="col l12 m12">
                            <div class="input-field">
                                {$conf_userfields->getForm($fld.alias, '%THEME%/helper/forms/userfields_forms_custom.tpl')}
                                <label class="form-label">{$fld.title}</label>
                                {$errname = $conf_userfields->getErrorForm($fld.alias)}
                                {$error = $user->getErrorsByForm($errname, ', ')}
                                {if !empty($error)}
                                    <span class="invalid-feedback">{$error}</span>
                                {/if}
                            </div>
                        </div>
                    {/if}
                {/foreach}
            {/if}

            {if $user->__captcha->isEnabled()}
                <div>
                    <label class="form-label">{$user->__captcha->getTypeObject()->getFieldTitle()}</label>
                    {$user->getPropertyView('captcha')}
                </div>
            {/if}

            <div class="col l12 m12">
                <div class="input-field">
                    {$user->getPropertyView('openpass', ['placeholder' => 'Пароль'])}
                    <label class="form-label">{t}Пароль{/t}</label>
                </div>
            </div>
            <div class="col l12 m12">
                <div class="input-field">
                    {$user->getPropertyView('openpass_confirm', ['placeholder' => 'Повтор пароля'])}
                    <label class="form-label">{t}Повтор пароля{/t}</label>
                </div>
            </div>

            {if $CONFIG.enable_agreement_personal_data}
                {include file="%site%/policy/agreement_phrase.tpl" button_title="{t}Зарегистрироваться{/t}"}
            {/if}
            <div>
                <button type="submit" class="btn btn-primary w-100">{t}Зарегистрироваться{/t}</button>
            </div>

        </div>
    </form>
{/block}

