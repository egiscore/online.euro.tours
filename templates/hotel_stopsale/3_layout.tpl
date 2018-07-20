{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="hotel_stopsale.css"}
{include file="../partial_top.tpl"}
<div id="hotel_stopsale" class="container">
    {note}
    <div class="controls">
        <table class="std panel">
            <tr>
                <td class="td_panel n1">
                    <table>
                        <tr>
                            <td width="5%">##H_STOPSALE_TOWNFROM##</td>
                            <td width="23%">
                                {include file="../controls.tpl" control="TOWNFROMINC" TOWNFROMINC=$TOWNFROMINC}
                            </td>

                            <td width="5%">##H_STOPSALE_STATE##</td>

                            <td width="23%"><select  name="STATEINC" class="STATEINC"
                                                    autocomplete="off">{foreach from=$STATEINC item="item"}
                                        <option value="{$item.id}"
                                                {if $item.selected}selected{/if}>{$item.name}</option>{/foreach}
                                </select></td>
                            <td width="5%"></td>
                        </tr>
                        <tr>
                            <td width="5%">##H_STOPSALE_TOWN##</td>
                            <td width="23%"><select name="TOWNTO" class="TOWNTO"
                                                    autocomplete="off">{foreach from=$TOWNTO item="item"}
                                        <option value="{$item.id}"
                                                {if $item.selected}selected{/if}>{$item.name}</option>{/foreach}
                                </select>
                            </td>
                            <td width="5%">##H_STOPSALE_HOTEL##</td>
                            <td width="23%"><select name="HOTELINC" class="HOTELINC"
                                                    autocomplete="off">{foreach from=$HOTELINC item="item"}
                                        <option value="{$item.id}"
                                                {if $item.selected}selected{/if}>{$item.name}</option>{/foreach}
                                </select>
                            </td>
                            <td width="5%" style="padding-bottom: 6px;">
                                <button class="load" disabled="disabled">##H_STOPSALE_REFRESH##</button>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div class="resultset">{if $DOLOAD}{include file="resultset.tpl"}{/if}</div>
</div>
{include file="../common.tpl"}
{jsload file="hotel_stopsale.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}
