{* include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="the_best.css" *}
{cssload file="common.css,the_best.css"}
{cssload file="data/search_tour/icons.css" base="" required=false}
{cssload file="customer.css" required=false}

{include file="../partial_top.tpl"}
<div id="the_best">
    {note}
    <table class="container std">
        <tbody>
        <tr>
            <td width="25%">
                {include file="../controls.tpl" control="TOWNFROMINC" TOWNFROMINC=$TOWNFROMINC}
            </td>
            <td width="20%"><select name="STATEINC"  class="STATEINC" autocomplete="off" >{foreach from=$STATEINC item="item"}<option value="{$item.id}" {if $item.selected}selected{/if}>{$item.name}</option>{/foreach}</select></td>
            <td width="20%"><select name="TOWNTOINC"  class="TOWNTOINC" autocomplete="off" >{foreach from=$TOWNTOINC item="item"}<option value="{$item.id}" {if $item.selected}selected{/if}>{$item.name}</option>{/foreach}</select></td>
            <td width="20%"><select name="GROUPSTARINC"  class="GROUPSTARINC" autocomplete="off" >{foreach from=$GROUPSTARINC item="item"}<option value="{$item.id}" {if $item.selected}selected{/if}>{$item.name}</option>{/foreach}</select></td>
            <td width="10%"><select class="CURRENCY" name="CURRENCY"  autocomplete="off" >{foreach from=$CURRENCY item="item"}<option value="{$item.id}" {if $item.selected}selected{/if}>{$item.alias}</option>{/foreach}</select></td>
            <td width="5%"><button class="load">##REFRESH##</button></td>
        </tr>
        </tbody>
    </table>

    <div class="resultset">{include file="resultset.tpl"}</div>
</div>
 
{include file="../common.tpl"}
{jsload file="the_best.js"}
{include file="../partial_bottom.tpl"}
{* include file="../footer.tpl" *}