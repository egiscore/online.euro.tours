{include file="../header.tpl" page_title="##PARTNER_INFO_CURATOR##" cssfiles="profile.css"}
{include file="../partial_top.tpl"}
<div id="partner_curator">
    {include file="../controls.tpl" control="SEARCHMODE" SEARCHMODE=$PERSONAL_AREA}
    <fieldset class="panel">
        {if count($CURATOR)}
            <table class="res">
        {foreach from=$CURATOR item="row" name="curators"}
            {if $row.email1 || $row.business}
                <tr class="{cycle values="odd,even"}">
                        <td>{$row.name|linkify:$row.www}</td>
                        <td>
                            {if $row.business}<span class="ui-icon-volume-on ui-icon" title="##PHONE##">&nbsp;</span>##CURATOR_PHONE_BUSINESS## {$row.business}{/if}
                            {if $row.local} (##CURATOR_PHONE_LOCAL## {$row.local}){/if}
                        </td>
                        <td>
                            {if $row.mobile1 || $row.mobile2}<span class="ui-icon-volume-on ui-icon" title="##PHONE##">&nbsp;</span>##CURATOR_PHONE_MOBILE## {$row.mobile1}{if $row.mobile1 && $row.mobile2},{/if}{$row.mobile2} {/if}
                        </td>
                        <td>
                            {if $row.email1}<span class="ui-icon-mail-open ui-icon" title="##PHONE##">&nbsp;</span><a href="mailto:{$row.email1}">{$row.email1}</a>{/if}
                        </td>
                </tr>
            {/if}
        {/foreach}
            </table>
        {/if}
    </fieldset>
    <div class="eraser"></div>
</div>

{include file="../common.tpl"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}