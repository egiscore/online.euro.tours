{include file="../header.tpl" page_title="##PARTNER_INFO_DISCOUNT##" cssfiles="profile.css"}
{include file="../partial_top.tpl"}
<div id="partner_discount">
    {include file="../controls.tpl" control="SEARCHMODE" SEARCHMODE=$PERSONAL_AREA}
    <fieldset class="panel">
        <legend>##PARTNER_INFO_DISCOUNT##</legend>
        <table>
            {if count($TOURINC) > 1}
                <tr>
                    <td class="left_column label">##PARTNER_INFO_DISCOUNT_TOUR##</td>
                    <td>
                        <div class="chosenDown">
                            <select name="TOURINC" class="TOURINC"
                                    autocomplete="off">{foreach from=$TOURINC item="item"}
                                    <option value="{$item.id}"
                                            {if $item.selected}selected="selected"{/if} {if $item.searchTerms}data-search-string="{$item.searchTerms|escape:'html'}"{/if}>{$item.name}</option>{/foreach}
                            </select>
                        </div>
                    </td>
                </tr>
            {/if}
            <tr>
                <td class="left_column label">##PARTNER_INFO_DISCOUNT##</td>
                <td>
                    <strong class="frm-value" id="discount">{$PARTNER_DISCOUNT|default:''}</strong>
                </td>
            </tr>
        </table>
    </fieldset>
    <div class="eraser"></div>
</div>

{include file="../common.tpl"}
{jsload file="profile.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}