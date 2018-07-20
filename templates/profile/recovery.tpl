{include file="../header.tpl" page_title="##RECOVERY_PASSWORD_TITLE##" cssfiles="profile.css"}
{include file="../partial_top.tpl"}
<div id="recovery">
    {note}
    {if $message}
        <div class="description">{$message}</div>
    {else}
        <div class="container">
            <div class="description">##RECOVERY_PASSWORD_HOWTO##</div>
            <form method="post" id="recovery-frm" action="{Samo_Url::route('profile',['samo_action' => 'search_partpass'])}">
                <label>##RECOVERY_PASSWORD_EMAIL## <input type="text" name="search" id="search"></label>
                <button class="load">##RECOVERY_PASSWORD_BUTTON_SEARCH##</button>
            </form>

            {if isset($routes.registration) && $routes.registration.public}
                <div class="registration-link">
                    <a href="{Samo_Url::route('registration')}">##RECOVERY_PASSWORD_REGISTRATION##</a>
                </div>
            {/if}
        </div>
    {/if}
</div>

{include file="../common.tpl"}
{jsload file="profile.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}