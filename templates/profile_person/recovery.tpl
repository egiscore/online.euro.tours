{include file="../header.tpl" page_title="##RECOVERY_PASSWORD_TITLE##" cssfiles="profile_person.css"}
{include file="../partial_top.tpl"}
<div id="profile_person" class="recovery">
    {note}
    {if $message}
        <div class="description">{$message}</div>
    {else}
        <div class="container">
            <div class="description">##RECOVERY_PERSON_PASSWORD_HOWTO##</div>
            <form method="post" id="recovery-frm" action="{Samo_Url::route('profile_person',['samo_action' => 'search_person'])}">
                <label>##RECOVERY_PERSON_PASSWORD_EMAIL## <input type="text" name="search" id="search" value="{$smarty.get.email|escape:'html'|default:''}"></label>
                <button class="load">##RECOVERY_PASSWORD_BUTTON_SEARCH##</button>
            </form>
        </div>
    {/if}
</div>

{include file="../common.tpl"}
{jsload file="profile_person.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}