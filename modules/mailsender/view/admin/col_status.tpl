{if $cell}{$elem=$cell->getRow()}{/if}
{$elem.__status->textView()}
{if $elem.status == 'idle'}({t}не рассылается{/t}){/if}
{if $elem.send_type == 'manual' && $elem.status == 'readyforsend' && $elem.dateofsend}
    <br><small>{t}запланировано{/t}: {$elem.dateofsend|dateformat:"@date, @time:@sec"}</small>
{/if}