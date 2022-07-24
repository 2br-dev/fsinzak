<div class="head-bar">
    <div class="container">
        {$wrapped_content}
    </div>
</div>
<div class="custom">
    <a href="{$router->getUrl('fsinzak-front-recipient')}" class="rs-in-dialog">Добавить получателя</a>
</div>
<div class="custom">
    {$current_recipient = \Fsinzak\Model\RecipientsApi::getRecipientFromCookie('fsinzak-selected-recipient')}
    {$config = \RS\Config\Loader::byModule('fsinzak')}
    <p>{$current_recipient['id']}</p>
    <p>{$current_recipient->getAge()}</p>
{*    <pre>{$config->getLimits()|var_dump}</pre>*}
</div>
