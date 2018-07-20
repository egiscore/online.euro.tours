{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="freight_monitor.css"}
{include file="../partial_top.tpl"}
{include file="../controls.tpl"}
<div id="freight_monitor">
    {note}
    <div class="controls container">
        <table class="std panel">
            <tr>
                <td class="controllers">##FREIGHT_TOWNFROM##</td>
                <td class="controllers"><select name="SOURCE" class="SOURCE string" autocomplete="off">{foreach from=$SOURCE key="key" item="options"}<optgroup label="{$key}">{foreach from=$options item="item"}<option value="{$item.id}" {if $item.selected}selected{/if} data-search-string="{$item.tags|@glue:" "}">{$item.name}</option>{/foreach}</optgroup>{/foreach}</select></td>
                <td class="controllers"><input type="text" name="CHECKIN" class="frm-input date CHECKIN DATEBEG" {datepicker_init data=$CHECKIN} autocomplete="off"/></td>
                <td class="controllers" rowspan="2">##FREIGHT_DELTA## <input name="PLUS_MINUS" type="text" class="frm-input PLUS_MINUS spin-button" min="0" max="30" value="{$PLUS_MINUS}"  autocomplete="off"></td>
            </tr>
            <tr>
                <td class="controllers">##FREIGHT_TOWNTO##</td>
                <td class="controllers"><select name="TARGET" class="TARGET string" autocomplete="off">{foreach from=$TARGET key="key" item="options"}<optgroup label="{$key}">{foreach from=$options item="item"}<option value="{$item.id}" {if $item.selected}selected{/if} data-search-string="{$item.tags|@glue:" "}">{$item.name}</option>{/foreach}</optgroup>{/foreach}</select></td>
                <td class="controllers"><input type="text" name="CHECKOUT" class="frm-input date CHECKOUT DATEEND" {datepicker_init data=$CHECKOUT} autocomplete="off"/></td>
            </tr>
            <tr>
                <td class="controllers">##FREIGHT_AIRLINE##</td>
                <td class="controllers"><select name=AIRLINE class="AIRLINE string" autocomplete="off">{foreach from=$AIRLINE key="key" item="item"}<option value="{$item.id}" {if $item.selected}selected{/if} data-search-string="{$item.tags|@glue:" "}">{$item.name}</option>{/foreach}</select></td>
            </tr>
            <tr>
                <td class="freight_btn" colspan="4"><button class="load" disabled="disabled">##FREIGHT_REFRESH##</button></td>
            </tr>
        </table>
    </div>
    <div class="fr_monitor_lengend">
        <table align="center">
        <tr class="txt_small">
            <td class="yesplace">&nbsp;&nbsp;&nbsp;&nbsp;</td><td>##FREIGHT_YESPLACE##</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td class="yesnoplace">&nbsp;&nbsp;&nbsp;&nbsp;</td><td>##FREIGHT_YESNOPLACE##</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td class="noplace">&nbsp;&nbsp;&nbsp;&nbsp;</td><td>##FREIGHT_NOPLACE##</td>
        </tr>
        </table>
    </div>
    <div class="resultset">{if $freights}{include file="resultset.tpl"}{/if}</div>
</div>
{include file="../common.tpl"}

{jsload file="freight_monitor.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}