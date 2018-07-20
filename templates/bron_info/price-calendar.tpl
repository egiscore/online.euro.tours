<div id="calendarPrice">
    <table>
        <thead>
        <tr>
            <th rowspan="2" class="relative head vHead">
                ##BRON_NIGHTS##
            </th>
            <th colspan="7" class="relative head hHead">
                ##BRON_PRICE_CALENDAR_ORDER_DATE##
                <div class="roll left"></div>
                <div class="roll right"></div>
            </th>
        </tr>
        <tr class="colDates">
            {foreach from=$PRICECALENDAR.datesIn key=index item=priceDate}
                <th class="relative dates" data-index="{$index}">{$priceDate}</th>
            {/foreach}
        </tr>
        </thead>
        <tbody class="tbody">
        {for $night=$PRICECALENDAR.nightsFrom to $PRICECALENDAR.nightsTill}
            <tr class="rows">
                <th class="relative dates">{$night}</th>
                {foreach from=$PRICECALENDAR.datesIn key=k item=priceDate}
                    <td class="cells {if $PRICECALENDAR.prices[$k]['color'][$night] && $PRICECALENDAR.prices[$k]['color'][$night] == 'green'} bgreen {/if}{if $k == $PRICECALENDAR.checkIn && $night == $PRICECALENDAR.nights} selected {/if}{if $PRICECALENDAR.prices[$k][$night]} price {/if}">
                        {if $PRICECALENDAR.prices[$k][$night]}
                            <div class="flexContainer"
                                 title="<div class='text-center'>
                                    <b>{$PRICECALENDAR.prices[$k].datestr} | ##BRON_NIGHTS## {$night}</b>
                                    <br>{$PRICECALENDAR.prices[$k][$night]}
                                    {if $PRICECALENDAR.prices[$k]['diff'][$night] && $PRICECALENDAR.prices[$k]['diff'][$night] > 0}
                                    <span class='red'><b> {$PRICECALENDAR.prices[$k]['diff'][$night]}  {$PRICECALENDAR.currency}</b></span> <div class='arrowUp'></div>
                                    {elseif $PRICECALENDAR.prices[$k]['diff'][$night] < 0}
                                    <span class='green'><b> {$PRICECALENDAR.prices[$k]['diff'][$night]|substr:1} {$PRICECALENDAR.currency}</b></span> <div class='arrowDown'></div>
                                    {/if}
                                    {if $PRICECALENDAR.prices[$k].color[$night] != 'white'}<br>
                                        <b>
                                        {if $PRICECALENDAR.prices[$k].color[$night] == 'green'}
                                        ##TOUR_SEARCH_MOMENT_CONFIRM##
                                        {/if}
                                        {if $PRICECALENDAR.prices[$k].color[$night] == 'red'}
                                        ##TOUR_SEARCH_PRICE_LEGEND_STOP_SALE##
                                        {/if}
                                        {if $PRICECALENDAR.prices[$k].color[$night] == 'pink'}
                                        ##NO_FREIGHTS##
                                        {/if}
                                        </b>
                                    {/if}
                                 </div>"
                                 data-catclaim="{$PRICECALENDAR.prices[$k].catclaim[$night]}"
                                 data-type="{$PRICECALENDAR.prices[$k].color[$night]}">
                                <div class="fcontent">
                                    {if $PRICECALENDAR.prices[$k]['diff'][$night] && $PRICECALENDAR.prices[$k]['diff'][$night] > 0}
                                    <div class="content cloudred">+{$PRICECALENDAR.prices[$k]['diff'][$night]} {$PRICECALENDAR.currency}<span class="arrowUp"></span></div>
                                    {elseif $PRICECALENDAR.prices[$k]['diff'][$night] && $PRICECALENDAR.prices[$k]['diff'][$night] < 0}
                                    <div class="content cloud">{$PRICECALENDAR.prices[$k]['diff'][$night]} {$PRICECALENDAR.currency}<span class="arrowDown"></span></div>
                                    {else}
                                        <div class="content">{$PRICECALENDAR.prices[$k].priceNumber[$night]} {$PRICECALENDAR.currency}</div>
                                    {/if}
                                </div>
                            </div>
                        {/if}
                    </td>
                {/foreach}
            </tr>
        {/for}
        <tr>
            <th colspan="8" class="relative currency">{$PRICECALENDAR.currency}</th>
        </tr>
        </tbody>
    </table>
</div>