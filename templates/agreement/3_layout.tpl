{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="agreement.css"}
{include file="../partial_top.tpl"}
<div id="agreement">
    {note}
    {if $partnerErrors}
        <div id="system-error">{$partnerErrors|nl2br}</div>
        <a href="{Samo_Url::route('edit_agency', ['SOURCE' => 'samo://agreement'])}">{$messages.MODULE_TITLE.edit_agency}</a>
    {else}
    {if $error}<div class="error" style="margin: 30px;" >{$error}</div>{/if}
    <div class="resultset">
        {include file="../controls.tpl" control="SEARCHMODE" SEARCHMODE=$PERSONAL_AREA}
        {if $agreements}
            {include file="resultset.tpl"}
        {else}
             ##NO_DATA##
        {/if}
    </div>
    {/if}
</div>
{include file="../common.tpl"}
{jsload file="agreement.js"}
{if isset($routes.warrant)}
    {jsload file="warrant.js"}
{/if}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}