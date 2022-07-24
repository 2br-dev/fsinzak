{block name="content"}
<main id="orders" class="profile">
    <section>
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h1>Поддержка</h1>
                </div>
                <div class="col l2 m12">
                    {include file="%fsinzak%/profile-menu.tpl"}
                </div>
                <div class="col l10 m12">
                    <div class="row">
                        <div class="col s12">
                            <h2>{$topic.title}</h2>
                            <div class="topic-head">
                                <div class="d-inline-block mb-5">
                                    <a class="return-link" href="{$router->getUrl('support-front-support')}">
                                        <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M14.7803 5.72846C15.0732 6.03307 15.0732 6.52693 14.7803 6.83154L9.81066 12L14.7803 17.1685C15.0732 17.4731 15.0732 17.9669 14.7803 18.2715C14.4874 18.5762 14.0126 18.5762 13.7197 18.2715L8.21967 12.5515C7.92678 12.2469 7.92678 11.7531 8.21967 11.4485L13.7197 5.72846C14.0126 5.42385 14.4874 5.42385 14.7803 5.72846Z"/>
                                        </svg>
                                        <span class="ms-2">{t}К списку обращений{/t}</span>
                                    </a>
                                </div>
                            </div>
                            <div class="chat-wrapper">
                                <div class="chat-content">
                                    {foreach $list as $item}
                                        {if $item.is_admin}
                                            {$user = $item->getUser()}
                                            <div class="chat-entry foreign">
                                                <div class="chat-entry-content">
                                                    <div class="chat-header">
                                                        <span class="author">Поддержка</span> – <span class="date-time">{$item.dateof|dateformat:"%e %v %!Y, в %H:%M"}</span>
                                                    </div>
                                                    <div class="message">
                                                        {$item.message}
                                                    </div>
                                                </div>
                                            </div>
                                        {else}
                                            <div class="chat-entry self">
                                                <div class="chat-entry-content">
                                                    <div class="chat-header">
                                                        <span class="author">Вы</span> – <span class="date-time">{$item.dateof|dateformat:"%e %v %!Y, в %H:%M"}</span>
                                                    </div>
                                                    <div class="message">
                                                        {$item.message}
                                                    </div>
                                                </div>
                                            </div>
                                        {/if}
                                    {/foreach}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <form method="POST">
                            {if $supp->getNonFormerrors()}
                                <div class="alert alert-danger">{$supp->getNonFormerrors()|join:", "}</div>
                            {/if}
                            <div class="col l5 m7 s12">
                                <div class="input-field">
                                    {$supp->getPropertyView('message', ['id' => 'textarea1', 'placeholder' => 'Текст сообщения'])}
                                    <label for="textarea1" class="form-label">{t}Текст сообщения{/t}</label>
                                </div>
                            </div>
                            <div class="col l2 m2 s12 align-center-m-down">
                                <button type="submit" class="btn btn-primary col-12 col-sm-auto">{t}Отправить{/t}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
{/block}
