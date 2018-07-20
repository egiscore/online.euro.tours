{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="all_prices.css"}
{include file="../partial_top.tpl"}
<div id="all_prices">
    {note}
    <div class="info">
    <br>
        ##TOUR_SEARCH_RESULT_TOURNAME##: {$prices_info.TourLName}<br>
        ##TOUR_SEARCH_RESULT_HOTEL##: {$prices_info.HotelLName} {$prices_info.StarLName}<br>
        ##TOUR_SEARCH_PROGRAMTYPE##: {$prices_info.PtypeLName}
    </div>
    <div class="controls">
        <table class="std panel">
            <tr>
                <td class="n1">
                    <table>
                        <tbody>
                            <tr>
                                <td width="30%">##CHECKIN##</td>            
                                <td width="35%"><input type="text" class="frm-input date CHECKIN" name="CHECKIN" {datepicker_init data=$checkin} /></td>
                                <td width="35%"><button class="load" disabled="disabled">##TOUR_SEARCH_REFRESH##</button></td>
                            </tr>
                        </tbody>
                    </table>
                <td class="n2">
                    <table>
                        <tbody>
                            <tr>
                                <td width="50%">##CURRENCY##</td>
                                <td width="50%">
                                    <select class="CURRENCY string" name="CURRENCY">
                                        {foreach from=$CURRENCY item="currency"}
                                            <option value="{$currency.id}" {if $currency.selected}selected="selected"{/if}>{$currency.alias}</option>
                                        {/foreach}
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div class="resultset">
        {include file="resultset.tpl"}
    </div>
</div>
{include file="../common.tpl"}
{jsload file="all_prices.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}