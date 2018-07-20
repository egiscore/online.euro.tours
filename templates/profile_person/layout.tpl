{include file="../header.tpl" page_title="##RECOVERY_PASSWORD_TITLE##" cssfiles="profile_person.css"}
{include file="../partial_top.tpl"}
<div id="profile_person" class="resultset">
    {if $flash}
        {foreach from=$flash item="message"}
        <div class="description">{$message}</div>
        {/foreach}
    {elseif $errors}
        {foreach from=$errors item="message"}
            <div class="error">{$message}</div>
        {/foreach}
    {/if}
</div>

{include file="../common.tpl"}
{jsload file="profile_person.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}