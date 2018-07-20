{foreach from=$messages item="message"}
    <tr class="message-item{if !$message.MessageRead} message-unread{/if}{if $message.MessageUrgent} message-urgent{/if}{if $smarty.get.samo_action == 'NEXT_PAGE'} blink{/if}" data-message="{$message.MessageRoot}">
        <td class="message-item-type">{if $message.MessageType}{$message.MessageType}{/if}</td>
        <td class="message-item-author">{$message.MessageAuthor}</td>
        <td class="message-item-subject">{if $message.MessageClaim} <span class="message-item-claim" data-claim="{$message.MessageClaim}">##MSG_CLAIM## {$message.MessageClaim}</span>{else}{$message.MessageSubject|default:'##MSG_NO_SUBJECT##'}{/if}</td>
        <td class="message-item-date" title="{$message.MessageEDate|date_format:'datetime'}">{$message.MessageEDate|date_format:'smartdatetime'|mb_convert_encoding:'utf-8'}</td>
    </tr>
{/foreach}
{if $nextPage}
    <tr><td colspan="4"><div class="message-next-page" data-params='{$nextPage|json_encode}'>next</td></tr>
{/if}