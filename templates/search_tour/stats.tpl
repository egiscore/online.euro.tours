<div id="search_stat">
    <div id="chart-info" class="price_info"
         data-townfrom="{$info.townFromKey}"
         data-state="{$info.stateKey}"
         data-cat-claim="{$info.id}"
         data-currency="{$info.currencyKey}"
    >
        <table class="res resultset">
            <thead>
            <tr>
                <th>##TOUR_SEARCH_CHECKIN##</th>
                <th>##TOUR_SEARCH_RESULT_TOURNAME##</th>
                <th class="c">##TOUR_SEARCH_NIGHTS##</th>
                {if $info.packet != 1}
                    <th>##TOUR_SEARCH_RESULT_HOTEL##</th>
                    <th>##TOUR_SEARCH_RESULT_MEAL##</th>
                    <th>##TOUR_SEARCH_ROOM##/##TOUR_SEARCH_HTPLACE##</th>
                {/if}
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{$info.datebeg|date_format:'d.m.Y, D'}</td>
                <td>
                    {$info.tour|linkify:$info.tourUrl}
                    {include file="`$smarty.const.ROOT`templates/search_tour/program-type.tpl" price=$info}
                </td>
                <td class="c">
                    {if $SEARCH_BY_HOTEL_NIGHTS}
                        {$info.hnights}{if $info.hnights != $info.nights}<span class="helpalt price-additional-nights"
                                                                               title="##TOUR_SEARCH_NIGHTS_ON_ROAD##">{$info.nights-$info.hnights}</span>{/if}
                    {else}
                        {$info.nights}
                    {/if}
                </td>
                {if $info.packet != 1}
                    <td>{$info.hotel|cat:' '|cat:$info.star|linkify:$info.hotelUrl}</td>
                    <td><span class="helpalt icon-info"
                              title="{$info.mealNote}"></span> {$info.meal|linkify:$info.mealUrl}</td>
                    <td>{$info.roomAlt}/{$info.htPlace}</td>
                {/if}
                <td class="td_price">
                        <span class="price {if $info.bron} bron price_button"{else}{if $info.stopSale || $info.stopSpog}
                              stop helpalt" title="{$info.note}"{else}"{/if}{/if} data-currency="{$info.currencyKey}
                    ">{$info.convertedPrice}</span>
                </td>
            </tr>
            {if $info.hotelNote}
                <tr class="note">
                    <td colspan="7" class="hotel_note short_block">
                        {$info.hotelNote|format_text}
                    </td>
                </tr>
            {/if}
            </tbody>
        </table>
        {include file="`$smarty.const.ROOT`templates/search_tour/price-chart.tpl" info=$info}
        <br>
    </div>
    {if $info.hotel_monitor}
        <fieldset class="panel">
            <legend>
                ##TOUR_SEARCH_PRICE_STATS_HOTEL_MONITOR##
                <span class="yesplace">&nbsp;&nbsp;&nbsp;</span> - ##TOUR_SEARCH_PRICE_STATS_HOTEL_MONITOR_Y##
                <span class="noplace">&nbsp;&nbsp;&nbsp;</span> - ##TOUR_SEARCH_PRICE_STATS_HOTEL_MONITOR_N##
                <span class="yesnoplace">&nbsp;&nbsp;&nbsp;</span> - ##TOUR_SEARCH_PRICE_STATS_HOTEL_MONITOR_F##
                <span class="requestplace">&nbsp;&nbsp;&nbsp;</span> - ##TOUR_SEARCH_PRICE_STATS_HOTEL_MONITOR_R##
            </legend>
            <div id="hotel_monitor">
                <table class="res hotel_monitor">
                    <thead>
                    <tr>
                        {foreach from=$info.hotel_monitor item="h_monitor" name="h_monitor"}
                            <th class="h_monitor_day_tick"></th>
                            <th class="h_monitor_day_tick"></th>
                        {/foreach}
                    </tr>
                    <tr>
                        {foreach from=$info.hotel_monitor item="h_monitor" name="h_monitor"}
                            <th class="h_monitor_day_title {if $h_monitor.outerDay} h_monitor_inactive_day{/if}"
                                colspan="2">{$h_monitor.date|date_format:'d D'}</th>
                        {/foreach}
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        {foreach from=$info.hotel_monitor item="h_monitor" name="h_monitor"}
                            {if $smarty.foreach.h_monitor.first}
                                <td class="h_monitor_day {$h_monitor.statusAlias} {if $h_monitor.outerNight} h_monitor_inactive_day{/if}"
                                    title="{$h_monitor.statusName}"></td>
                            {/if}
                            <td class="h_monitor_day {$h_monitor.statusAlias} {if $h_monitor.outerNight} h_monitor_inactive_day{/if}"
                                title="{$h_monitor.statusName}"
                                colspan="{if $smarty.foreach.h_monitor.last}1{else}2{/if}"></td>
                        {/foreach}
                    </tr>
                    </tbody>
                </table>
            </div>
        </fieldset>
    {/if}
    {if !$info.gdsUse}
        {include file="`$smarty.const.ROOT`templates/search_tour/transport_monitor.tpl"}
    {/if}
</div>