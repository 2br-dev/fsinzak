{*{extends file="%THEME%/helper/wrapper/my-cabinet.tpl"}*}
{block name="content"}
    {addjs file="%support%/rscomponent/support.js"}
    <main id="profile" class="profile">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col s12">
                        {moduleinsert name="\Main\Controller\Block\Breadcrumbs" indexTemplate="%main%/blocks/breadcrumbs/breadcrumbs-catalog.tpl"}
                    </div>
                    <div class="col s12">
                        <h1>Личный кабинет</h1>
                    </div>
                    <div class="col l2 m12 hide-l-down">
                        {include file="%fsinzak%/profile-menu.tpl"}
                    </div>
                    <div class="col l10 m12">
                        <h2>
                            <a href="#sections" class="sidenav-trigger hide-l-up"><i class="mdi mdi-tune"></i></a>
                            Поддержка
                        </h2>
                        <p class="info">
                            Здесь хранятся Ваши обращения в службу технической поддержки
                        </p>
                        <ul class="tabs nav nav-pills tab-pills" id="pills-tab">
                            <li class="tab nav-item">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button">Создать<span class="hide-m-down"> обращение</span></button>
                            </li>
                            <li class="tab nav-item">
                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-profile" type="button">
                                    История<span class="hide-m-down"> обращений</span>
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" >

                                    <form method="POST">
                                        {if $supp->getNonFormerrors()}
                                            <div class="alert alert-danger">{$supp->getNonFormerrors()|join:", "}</div>
                                        {/if}

                                        <div class="row">
                                            <div class="col l6 m6 s8 xs12">
                                                <h3 class="support">Новое обращение</h3>

                                                {if count($list)>0}
                                                    <div class="input-field">
                                                        <select name="topic_id" class="styled rs-support-topic-id">
                                                            {foreach $list as $item}
                                                                <option value="{$item.id}" {if $item.id == $supp.topic_id}selected{/if}>{$item.title}</option>
                                                            {/foreach}
                                                            <option value="0" {if $supp.topic_id == 0}selected{/if}>{t}Новая тема...{/t}</option>
                                                        </select>
                                                        <label for="">Тема сообщения</label>
                                                    </div>
                                                {/if}
                                                <div class="mb-3 input-field {if $supp.topic_id>0}d-none{/if} rs-support-topic-name">
                                                    {$supp->getPropertyView('topic', ['id' => 'input-topic', 'placeholder' => 'Новая тема'])}
                                                    <label for="input-topic" class="form-label">{t}Новая тема{/t}</label>
                                                </div>
                                                <div class="mb-4 input-field">
                                                    {$supp->getPropertyView('message', ['id' => 'textarea1', 'placeholder' => 'Опишите свой вопрос'])}
                                                    <label for="textarea1" class="form-label">{t}Опишите свой вопрос{/t}</label>
                                                </div>
                                                <button type="submit" class="btn btn-primary col-12 col-sm-auto">{t}Отправить{/t}</button>
                                            </div>
                                        </div>
                                    </form>
                            </div>
                            <div class="tab-pane fade" id="pills-profile">
                                <div class="row">
                                    <div class="col s12">
                                        <h3 class="support">История обращений</h3>
                                        {if $list}
                                            <div class="last-child-margin-remove topics">
                                                {foreach $list as $item}
                                                    <div class="topic lk-support-item" data-id="{$item.id}">
                                                        <div class="topic-row">
                                                            <div class="header">
                                                                <a href="{$item->getUrl()}" class="link-dark text-decoration-none">{$item.title}</a>
                                                            </div>
                                                            <div class="action">
                                                                <a class="lk-support-item__delete rs-topic-delete"
                                                                   data-remove-url="{$router->getUrl('support-front-support', ["Act" => "delTopic", "id" => $item.id])}"
                                                                   title="{t}Удалить переписку по этой теме{/t}"><i class="mdi mdi-delete"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="topic-row">
                                                            <div class="date-time">
                                                                <span class="date">{t time="{$item.updated|dateformat:"@date @time"}"}от %time{/t}</span>
                                                                {if $item.newcount>0} <span class="text-danger">({t}новых сообщений{/t}: {$item.newcount})</span>{/if}
{*                                                                    <span class="time">@@time</span>*}
                                                            </div>
                                                            <div class="action right-align"><a href="{$item->getUrl()}">Подробнее</a></div>
                                                        </div>
                                                    </div>
                                                {/foreach}
                                            </div>
                                        {else}
                                            <div>{t}Еще нет ни одного обращения в поддержку{/t}</div>
                                        {/if}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
{/block}
