{if $messages}
    {foreach from=$messages item="message"}
        <div id="msg-{$message.MessageInc}" class="{if isset($newMessage) && $newMessage == $message.MessageInc}message-new {/if}message-item{if $message.MessageUrgent} message-urgent{/if}{if $message.MessageIncoming == 1} message-outgoing{else} message-incoming{/if}{if !$message.MessageRead} message-unread{/if}{if !$message.MessageDelivered} message-unseen{/if}">
            <div class="message-item-from">
                <span class="message-item-author">{$message.MessageAuthor}</span>
                <span class="message-item-date" title="{$message.MessageADate|date_format:'datetime'}">{$message.MessageADate|date_format:'smartdatetime'|mb_convert_encoding:'utf-8'}</span>
            </div>
            {if $message.MessageText}
            <div class="message-item-body">{$message.MessageText|escape:'html'|format_text}</div>
            {/if}
            <div class="controls">
            {if $message.MessageUnread && $message.MessagePartner > 0}
                <span class="link read">##MSG_MARK_AS_READ##</span>
            {/if}
            </div>
        </div>
    {/foreach}
    {if $settings.can_reply}
        <div class="message-reply message-form">
            {if $messageCategory}
                <select name="MESSAGECATEGORY" class="messagecategory">
                    {foreach from=$messageCategory item="item"}
                        <option value="{$item.id}"{if $item.selected} selected="selected"{/if}>{$item.name}</option>
                    {/foreach}
                </select>
            {/if}
            <textarea class="text" data-parent="{$messages.0.MessageInc}" data-claim="{$messages.0.MessageClaim}" placeholder="##MSG_REPLY##"></textarea>
            <button class="message-sent" disabled="disabled">##MSG_SEND_BUTTON##</button>
            {note}
        </div>
    {/if}
{/if}