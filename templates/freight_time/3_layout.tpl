{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="freight_time.css"}
{include file="../partial_top.tpl"}
<div id="freight_time">
    <div class="container">
        <table class="panel std">
            <tr>
                <td class="td_panel n1">
                    <table>
                        <tr>
                            <td width="10%">##FREIGHT_TIME_TOWNFROM##</td>
                            <td width="20%">
                                {include file="../controls.tpl" control="TOWNFROMINC" TOWNFROMINC=$TOWNFROMINC}
                            </td>
                            <td width="8%">##FREIGHT_TIME_STATE##</td>
                            <td width="19%"><select name="STATEINC"  class="STATEINC" autocomplete="off" >{foreach from=$STATEINC item="item"}<option data-search-string="{$item.StateName} {$item.StateLName}" value="{$item.Inc}" {if $item.selected}selected{/if}>{$item.LName}</option>{/foreach}</select></td>
                            <td width="2%"></td>
                            <td width="10%">##FREIGHT_TIME_TOWNTO##</td>
                            <td width="19%"><select name="TOWNTOINC"  class="TOWNTOINC" autocomplete="off" >{foreach from=$TOWNTOINC item="item"}<option data-search-string="{$item.Name} {$item.altName}" value="{$item.Inc}" {if $item.selected}selected{/if}>{$item.LName}</option>{/foreach}</select></td>
                            <td width="2%"></td>
                            <td width="10%"><button class="load" disabled="disabled">##FREIGHT_TIME_REFRESH##</button></td>                            
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    {note}
    <div class="resultset"></div>
</div>
{include file="../common.tpl"}
{jsload file="freight_time.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}
