{* include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="the_best.css" *}
{cssload file="common.css,popular_hotel.css"}
{cssload file="data/search_tour/icons.css" base="" required=false}
{cssload file="customer.css" required=false}
{include file="../partial_top.tpl"}
<div id="popular_hotel" data-period="{$PERIOD}">
    {note}

    <table class="container std">
        <tbody>
        <tr>                
            <td width="50%"><select name="TOWNFROMINC" class="TOWNFROMINC">{foreach from=$TOWNFROMINC item="town"}<option value="{$town.id}" {if $town.selected}selected="selected"{/if}>{$town.name}</option>{/foreach}</select></td>
            <td width="50%"><select name="STATEINC" class="STATEINC">{foreach from=$STATEINC item="state"}<option value="{$state.id}" {if $state.selected}selected="selected"{/if}>{$state.name}</option>{/foreach}</select></td>
        </tr>
        </tbody>
    </table>

    <div class="resultset">{include file="resultset.tpl"}</div>
</div>
 
{include file="../common.tpl"}
{jsload file="popular_hotel.js"}
{include file="../partial_bottom.tpl"}
{* include file="../footer.tpl" *}