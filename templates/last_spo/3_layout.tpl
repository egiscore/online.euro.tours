{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="last_spo.css"}
{include file="../partial_top.tpl"}
<div id="last_spo">
    <div class="controls">
        <table class="std panel">
            <tr>
                <td width="20%">##SPO_TOWNFROM##</td>
                <td width="30%"><select name="TOWNFROMINC" class="TOWNFROMINC" autocomplete="off" >{foreach from=$TOWNFROMINC item="item"}<option value="{$item.Inc}" {if $item.selected}selected{/if}>{$item.LName}</option>{/foreach}</select></td>
                <td width="10%">##SPO_STATE##</td>
                <td width="30%"><select name="STATEINC"  class="STATEINC" autocomplete="off" >{foreach from=$STATEINC item="item"}<option value="{$item.Inc}" {if $item.selected}selected{/if}>{$item.LName}</option>{/foreach}</select></td>
                <td width="10%">
                    <input type="button" class="load" value="##SPO_REFRESH##" disabled="disabled">
                    {*<div class="LAST_SPO_ALL_SPO"></div>*}
                </td>
            </tr>
        </table>
    </div>
    <div class="resultset">{if $spos}{include file="resultset.tpl"}{/if}</div>
</div>
{include file="../common.tpl"}
{jsload file="last_spo.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}
