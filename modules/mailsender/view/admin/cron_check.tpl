{addjs file="%mailsender%/updater.js"}
{if !$is_cron_work}
<div class="notice-box no-padd" style="margin-top:10px">
    <div class="notice-bg">
        {t}Не запущен планировщик заданий cron. Рассылка сообщений невозможна. Подробнее о настройке планировщика заданий можно узнать в <a href="http://readyscript.ru/manual/cron.html" class="u-link" target="_blank">документации</a>.{/t}
    </div>
</div>
{/if}