{*{extends file="%THEME%/wrapper.tpl"}*}
{block name="content"}
    <main id="profile" class="profile">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col s12">
                        <h1>Личный кабинет</h1>
                    </div>
                    <div class="col l2 m12">
                        {include file="%fsinzak%/profile-menu.tpl"}
                    </div>
                    <form class="col l10 m12" method="POST">
                        <h2>Мои данные</h2>
                        <p class="info">
                            Здесь вы можете изменить свои персональные или контактные данные.
                        </p>
                        {if $result}
                            <div class="alert alert-success">{$result}</div>
                        {/if}
                        <div class="row">
                            {csrf}
                            {$this_controller->myBlockIdInput()}
                            <input type="hidden" name="referer" value="{$referer}">
                            <input name="is_company" value="0" type="hidden">
                            <div class="col l4 m6 s12">
                                <div class="input-field">
                                    {$user->getPropertyView('surname', ['placeholder' => "Фамилия"])}
                                    <label for="">Фамилия</label>
                                </div>
                            </div>
                            <div class="col l4 m6 s12">
                                <div class="input-field">
                                    {$user->getPropertyView('name', ['placeholder' => "Имя"])}
                                    <label for="">Имя</label>
                                </div>
                            </div>
                            <div class="col l4 m6 s12">
                                <div class="input-field">
                                    {$user->getPropertyView('midname', ['placeholder' => "Отчество"])}
                                    <label for="">Отчество</label>
                                </div>
                            </div>
                            {if $conf_userfields->notEmpty()}
                                {foreach $conf_userfields->getStructure() as $fld}
                                    <div class="col l4 m6 s12">
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
                                {/foreach}
                            {/if}
                            <div class="col l4 m6 s12">
                                <div class="input-field">
                                    {$user->getPropertyView('e_mail', ['placeholder' => "Email"])}
                                    <label for="">E-mail</label>
                                </div>
                            </div>
                            <div class="col l8 m12 s12 register-phone-block {if $user->getCitizen() != 'Гражданин РФ'}no-rf{/if}" data-old="{$user['phone']}">
                                {$user->getPropertyView('phone', ['placeholder' => "Телефон", 'readonly' => false])}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <h3>Безопасность</h3>
                            </div>
                            <div class="col s12">
                                <div class="check-field">
                                    <input type="checkbox" id="change-password" class="toggle-password" name="changepass" value="1" {if $user.changepass}checked{/if}>
                                    <label for="change-password">Изменить пароль</label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="password">
                            <div class="col l4 m6 s12">
                                <div class="input-field">
                                    {$user->getPropertyView('current_pass', ['placeholder' => 'Старый пароль'])}
                                    <label for="">Старый пароль</label>
                                </div>
                            </div>
                            <div class="col l4 s12">
                                <div class="input-field">
                                    {$user->getPropertyView('openpass', ['placeholder' => 'Новый пароль'])}
                                    <label for="">Новый пароль</label>
                                </div>
                            </div>
                            <div class="col l4 s12">
                                <div class="input-field">
                                    {$user->getPropertyView('openpass_confirm', ['placeholder' => 'Повторите пароль'])}
                                    <label for="">Повторите пароль</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 right-align">
                                <button class="btn" type="submit">{t}Сохранить изменения{/t}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
{/block}
