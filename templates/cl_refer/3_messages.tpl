<table class="std res" id="messages">
<tbody>
{foreach from=$messages item="message"}
  <tr {if $msg.MessageUnread}class="unread"{/if}>
    <th class="silver">{$message.MessageDate|date_format:"datetime"}</th>
        <th class="silver">
        {$message.MessageAuthor}<br>
        {if $message.email1}##MSG_AUTHOR_EMAIL1## <a href="mailto:{$message.email1}">{$message.email1}</a><br>{/if} {if $message.email2}##MSG_AUTHOR_EMAIL2## <a href="mailto:{$message.email2}">{$message.email2}</a><br>{/if}
        {if $message.icq1}##MSG_AUTHOR_ICQ1## {$message.icq1}<br>{/if} {if $message.icq2}##MSG_AUTHOR_ICQ2## {$message.icq2}<br>{/if}
        {if $message.mobile1}##MSG_AUTHOR_PHONE1## {$message.mobile1}<br>{/if} {if $message.mobile2}##MSG_AUTHOR_PHONE2## {$message.mobile2}<br>{/if}
        </th>
    <th class="silver">[{$message.MessageType}] {$message.MessageSubject}</th>
    <th class="silver">{if $message.MessagePartner}<label><input type="checkbox" {if $message.MessageUnread}value="{$message.MessageInc}"{else}checked disabled{/if}> ##MSG_MARK_AS_READ##</label>{/if}</th>    
  </tr>
  <tr {if $message.MessageUnread}class="unread"{/if}>
    <td colspan="4">{$message.MessageText}</td>    
  </tr>  
{/foreach}
</tbody>
</table>