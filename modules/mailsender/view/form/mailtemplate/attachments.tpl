<ul class="mailsend-attached-files">
    {foreach $elem.attachments as $file}
    <li data-id="{$file.filename}"><a href="{$file.link}" target="_blank">{$file.name}</a> ({$file.size|format_filesize}) <a class="mailsend-attached-remove">&times;</a></li>
    {/foreach}
</ul>

<ul class="mailsend-files-container">
    <li><input type="file" name="uploadfiles[]"> <a class="mailsend-uploadfile-remove" title="{t}удалить{/t}">&times;</a></li>
</ul>
<a class="mailsend-file-attach"><u>{t}Добавить файл{/t}</u></a>