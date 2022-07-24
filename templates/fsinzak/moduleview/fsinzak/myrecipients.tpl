{*{extends file="%THEME%/wrapper.tpl"}*}
{block name="content"}
    <main id="profile" class="profile">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col s12">
                        <h1>Управление аккаунтом</h1>
                    </div>
                    <div class="col l2 m12 hide-l-down">
                        {include file="%fsinzak%/profile-menu.tpl"}
                    </div>
                    <div class="col l10 m12">
                        <div class="row">
                            <div class="col s12">
                                <h2>
                                    <a href="#sections" class="sidenav-trigger hide-l-up"><i class="mdi mdi-tune"></i></a>
                                    Получатели
                                </h2>
                                <p class="info">
                                    С помощью этой секции вы можете редактировать получателей Ваших заказов
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <table class="recievers">
                                    <thead>
                                        <th>Фамилия</th>
                                        <th>Имя</th>
                                        <th>Отчество</th>
                                        <th>Дата рождения</th>
                                        <th class="icons">&nbsp;</th>
                                        <th class="icons">&nbsp;</th>
                                    </thead>
                                    <tbody>
                                        {foreach $recipients as $recipient}
                                            <tr>
                                                <td>{$recipient['surname']}</td>
                                                <td>{$recipient['name']}</td>
                                                <td>{$recipient['midname']}</td>
                                                <td>{$recipient->getBirthday('d.m.Y')}г.</td>
                                                <td>
                                                    <a class="rs-in-dialog" href="{$router->getUrl('fsinzak-front-myrecipients', ['Act' => 'edit', 'recipient' => $recipient['id']])}">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="rs-in-dialog" href="{$router->getUrl('fsinzak-front-myrecipients', ['Act' => 'remove', 'recipient' => $recipient['id']])}">
                                                        <i class="mdi mdi-delete"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        {/foreach}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <a href="{$router->getUrl('fsinzak-front-myrecipients', ['Act' => 'create'])}" class="btn right rs-in-dialog">Добавить получателя</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
{/block}
