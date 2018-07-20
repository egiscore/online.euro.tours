<br>
{foreach from=$result_messages item="row"}
    <div class="message {$row.type}">{$row.message}</div>
{/foreach}
