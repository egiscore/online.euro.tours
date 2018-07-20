{include file="header.tpl" cssfiles="login.css"}
{include file="partial_top.tpl"}
{if isset($flash)}<h1 class="flash_message">{$flash_message|default:"##SAMO_LOGON_ERROR##"}</h1>{/if}
<h1 class="cookie_help">##COOKIES_MUST_BE_ENABLED##</h1>
<div class="container">
    {include file="login_form_person.tpl"}
</div>
{include file="common.tpl"}
{jsload file="login_person.js"}
{include file="partial_bottom.tpl"}
{include file="footer.tpl"}