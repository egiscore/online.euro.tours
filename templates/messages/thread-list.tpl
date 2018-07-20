{if $byClaim}
    <div class="messages-claim-wrapper">
        <input id="msg-4" name="msg" type="radio" {if !$showForm}checked="checked"{/if} />
        <label for="msg-4">##MESSAGES_CLAIM## {$byClaim.0.MessageClaim}</label>
        <div class="messages-container">
            <table class="messages-table">
                {include file="thread-headers.tpl" messages=$byClaim nextPage=false}
            </table>
        </div>
    </div>
{/if}
{if $unread}
<div class="messages-unread-wrapper">
    <input id="msg-1" name="msg" type="radio" {if !$showForm && !$byClaim}checked="checked"{/if} />
    <label for="msg-1">##MESSAGES_UNREAD##</label>
    <div class="messages-container">
        <table class="messages-table">
            {include file="thread-headers.tpl" messages=$unread nextPage=$unreadNextPage}
        </table>
    </div>
</div>
{/if}
{if $recent}
<div class="messages-recent-wrapper">
    <input id="msg-2" name="msg" type="radio"{if !$unread && !$byClaim && !$showForm} checked="checked"{/if} />
    <label for="msg-2">##MESSAGES_RECENT##</label>
    <div class="messages-container">
        <table class="messages-table">
            {include file="thread-headers.tpl" messages=$recent nextPage=$recentNextPage}
        </table>
    </div>
</div>
{/if}
{if $settings.can_create_new}
<div class="messages-new-wrapper">
    <input id="msg-3" name="msg" type="radio"{if $showForm} checked="checked"{/if}/>
    <label for="msg-3">##MSG_CREATE##</label>
    <div class="messages-container message-new message-form">
        {if $claimList}
            <select name="CLAIM" class="claim" data-placeholder="##MSG_CLAIM##">
                {foreach from=$claimList item="item"}
                    <option value="{$item.id}"{if $item.selected} selected="selected"{/if}>{$item.name}</option>
                {/foreach}
            </select>
        {else}
            <input name="CLAIM" type="text" class="claim" placeholder="##MSG_CLAIM##" maxlength="10" value="{$smarty.get.CLAIM|escape:'html'}">
        {/if}
        {if $messageCategory}
            <select name="MESSAGECATEGORY" class="messagecategory">
                {foreach from=$messageCategory item="item"}
                    <option value="{$item.id}"{if $item.selected} selected="selected"{/if}>{$item.name}</option>
                {/foreach}
            </select>
        {/if}
        <textarea name="TEXT" class="text" placeholder="##MSG_CREATE##"></textarea>
        <button class="message-sent" disabled="disabled">##MSG_SEND_BUTTON##</button>
        {note}
    </div>
</div>
{/if}