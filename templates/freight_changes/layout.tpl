{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="freight_changes.css"}
{include file="../partial_top.tpl"}
<div id="freight_changes">
    {note}
    <div class="container">
        <table class="panel std">
            <tr>
                <td class="td_panel n1">
                    <table>
                        <tbody>
                        <tr>
                            <td width=5% align="right">##FRCHANGES_TOWNFROM##</td>
                            <td width=10%>
                                {include file="../controls.tpl" control="TOWNFROMINC" TOWNFROMINC=$TOWNFROMINC}
                            </td>
                            <td width=6%>##FRCHANGES_TOURNAME##</td>
                            <td width=30% colspan="2"><select name="TOURINC" class="TOURINC"
                                                              autocomplete="off">{foreach from=$TOURINC item="item"}
                                        <option data-search-string="{$item.searchTerms|escape:'html'}" value="{$item.id}"
                                                {if $item.selected}selected{/if}>{$item.name}</option>{/foreach}
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td width=5% align="right">##FRCHANGES_STATE##</td>
                            <td width=10%>
                                <select name="STATEINC" class="STATEINC"
                                        autocomplete="off">{foreach from=$STATEINC item="item"}
                                        <option
                                        data-search-string="{$item.searchTerms|escape:'html'}" value="{$item.id}"
                                        {if $item.selected}selected{/if}>{$item.name}</option>{/foreach}</select>
                            </td>
                            <td>##FRCHANGES_DATE##</td>
                            <td width=15% class="l" nowrap><input type="text" name="CHECKIN"
                                                                  class="frm-input date CHECKIN" {datepicker_init direction=true value=$CHECKIN.value}
                                                                  autocomplete="off"/></td>
                            <td width=15% align="right">
                                <button class="load">##FRCHANGES_REFRESH##</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="resultset">{if $RESULT}{include file="resultset.tpl"}{/if}</div>
</div>
{include file="../common.tpl"}
{jsload file="freight_changes.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}