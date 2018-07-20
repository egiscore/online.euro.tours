{if $prices}
    {if $smarty.get.samo_action != 'embed' && strpos($smarty.get.page, '_person') === false}
        {assign var="show_commission" value=true}
    {else}
        {assign var="show_commission" value=false}
    {/if}
    {if !$groupResult}
        <table class="res">
        <thead>
        <tr>
            {if $groupByPartPrice}
                <th></th>
            {/if}
            <th>##TOUR_SEARCH_CHECKIN##</th>
            <th>##TOUR_SEARCH_RESULT_TOURNAME##</th>
            <th class="c">##TOUR_SEARCH_NIGHTS##</th>
            {if $subfilter != 1}
                <th>##TOUR_SEARCH_RESULT_HOTEL##</th>
                <th>##TOUR_SEARCH_HOTEL_AVAILABILITY##</th>
                <th>##TOUR_SEARCH_RESULT_MEAL##</th>
                <th>##TOUR_SEARCH_ROOM## / ##TOUR_SEARCH_HTPLACE##</th>
                <th></th>
            {/if}
            <th>&nbsp;</th>
            <th>##TOUR_SEARCH_PRICE##</th>
            {if $show_commission}
                <th></th>
            {/if}
            <th>##TOUR_SEARCH_PRICE_TYPE##</th>
            {if $subfilter != 2}
                <th class="transport">##TRANSPORT##</th>
            {/if}
        </tr>
        </thead>
        <tbody>
    {/if}
    {foreach from=$prices.prices item="price"}
        <tr class="{if $groupResult} dark {/if}price_info {cycle values="even,odd"} {$price.color}_row{if $price.stats} stats{/if}{if $price.from_the_best || $price.best} from_the_best{/if}"
            data-townfrom="{$price.townFromKey}" data-state="{$price.stateKey}"
            data-checkin="{$price.checkIn|date_format:'sql'}" data-nights="{$price.nights}"
            data-hnights="{$price.hnights}" data-cat-claim="{$price.id}" data-packet-type="{$price.packetType}"
            data-hotel="{$price.hotelKey}">
            {if $groupByPartPrice or $groupResult}
                <td>
                    {if !$groupResult}
                        <div class="rR">{imgload file="gr.png"  inline=true}</div>
                    {/if}
                </td>
            {/if}
            <td class="sortie {if $groupResult}gR{/if}">
                {$price.checkIn|date_format:'d.m.Y, D'}
                {if $price.listTime}
                    <br/>
                    {if $price.listTime|strlen > 12}
                        <span title="##TOUR_SEARCH_FREIGHT_TIME##: {$price.listTime}"
                              class="link popup-note">{$price.listTime|truncate:15:"...":true}</span>
                    {else}
                        <span class="helpalt" data-helpalt-arrow="hide" title="##TOUR_SEARCH_FREIGHT_TIME##">{$price.listTime}</span>
                    {/if}
                {/if}
            </td>
            <td>
                {$price.tour|linkify:$price.tourUrl}
                {include file="../search_tour/program-type.tpl" price=$price}
            </td>
            <td class="c">
                {if $SEARCH_BY_HOTEL_NIGHTS or $price.hnights != $price.nights}
                    {$price.hnights}{if $price.hnights != $price.nights}<span
                        class="helpalt price-additional-nights"
                        title="##TOUR_SEARCH_NIGHTS_ON_ROAD##">{$price.nights-$price.hnights}</span>{/if}
                {else}
                    {$price.nights}
                {/if}
            </td>
            {if $subfilter != 1}
                <td class="link-hotel">{if $price.id}
                        <span class="helpalt additional" title="##PACKET_CONTENT##"></span>
                        &nbsp;{/if}{$price.hotel|cat:' '|cat:$price.star|linkify:$price.hotelUrl} ({$price.town})
                </td>
                <td class="nw">
                    {hotel_availability value=$price.hotelAvailability}
                </td>
                <td>
                    {if !$price.mealNote}
                        {$price.meal|linkify:$price.mealUrl}
                    {else}
                        <span class="helpalt link">{$price.meal}
                            <script type="text/html">
                                {if $price.mealNote}
                                    {if strpos($price.mealNote, "\n") === false}
                                        {$price.mealNote}
                                    {else}
                                        <p>{$price.mealNote|nl2br}</p>
                                    {/if}
                                {/if}
                                {if $price.mealUrl}<p><a href="{$price.mealUrl}"
                                                         target="_blank">##TOUR_SEARCH_MORE##</a></p>{/if}
                            </script>
                        </span>
                    {/if}
                </td>
                <td>
                    <span class="{if $price.roomNote}helpalt link{/if}">{$price.room} / {$price.htPlace}
                        {if $price.roomNote}
                            <script type="text/html">
                                <p>{$price.roomNote|nl2br}</p>
                            </script>
                        {/if}
                    </span>
                </td>
                <td class="r nw attributes">
                    {foreach from=$price.attributes item="attr"}
                        <span class="icon hp hp_{$attr.id} helpalt" data-helpalt-arrow="hide"
                                             title="{$attr.name}{if $attr.note} - {$attr.note}{/if}">&nbsp;</span>
                    {/foreach}
                    {if $price.paymentschedule}<span class="paymentschedule">&nbsp;</span>{/if}
                    {foreach from=$price.packetAttributes item="attr"}
                        <span class="helpalt icon uf uf_{$attr.id}" data-helpalt-arrow="hide" title="{if $attr.note}{if $attr.url}{$attr.note|escape:'html'|cat:"<br><a target='_blank' href='{$attr.url}'>##TOUR_SEARCH_MORE##</a>"}{else}{$attr.note|escape:'html'}{/if}{else}{if $attr.url}{$attr.name|escape:'html'|cat:"<br><a target='_blank' href='{$attr.url}'>##TOUR_SEARCH_MORE##</a>"}{else}{$attr.name|escape:'html'}{/if}{/if}">&nbsp;</span>
                    {/foreach}
                </td>
            {/if}
            <td class="c nw statistic">{if $price.stats && $price.crossTour == 0}
                    <span class="stats helpalt" data-helpalt-arrow="hide" title="##TOUR_SEARCH_PRICE_STATS##">&nbsp;</span>
                {/if}</td>
            <td class="td_price">
                    <span data-cat-price="{$price.price}" data-cat-price_old="{$price.priceOld}"
                          data-converted_price_old="{$price.convertedPriceOld}" data-cat-currency="{$price.currencyKey}"
                          data-currency="{$price.convertedCurrencyKey}"
                          class="price {if $price.priceOld} price_old{/if} {if $price.bron} bron price_button"{else}{if $price.stopSale || $price.stopSpog}
                          stop" title="{$price.note}"{else}"{/if}{/if}>
                {$price.convertedPrice}
                </span>
            </td>
            {if $show_commission}
                <td>
                    {if $price.bron}<span class="percent helpalt icon-info" title="##TOUR_COMMISSION##"></span>{/if}
                </td>
            {/if}
            <td class="type_price">
                <span{if $routes.all_prices && $price.stats} class="link all_prices"{/if}>{if !$routes.all_prices && $price.spo && $show_link_to_spog && $price.stats}{$price.spo|spo2link:"xls"}{$price.spo|spo2link:"zip"}{$price.spo|spo2link:"rar"}{$price.spo|spo2link:"xml"}&nbsp;{/if}{$price.spo|default:"##CATALOG##"}</span>
            </td>
            {if $subfilter != 2}
                <td class="nw transport">
                    {freight_avail title="##FRCLASS_0##" class="econom"  value=$price condition=$prices.freights.econom  surcharge=$prices.surcharge}
                    {freight_avail title="##FRCLASS_1##" class="busines" value=$price condition=$prices.freights.busines surcharge=$prices.surcharge}
                    {freight_avail title="##FRCLASS_2##" class="comfort" value=$price condition=$prices.freights.comfort surcharge=$prices.surcharge}
                    {freight_avail title="##FRCLASS_3##" class="premium" value=$price condition=$prices.freights.premium surcharge=$prices.surcharge}
                </td>
            {/if}
        </tr>
    {/foreach}
    {if !$groupResult}
        </tbody>
        </table>
        {include file="../controls.tpl" control="pager"}
    {/if}
{else}
    {if !$groupResult} ##NO_DATA## {else}
        <tr class="{if $groupResult} dark {/if}price_info {cycle values="even,odd"} {$price.color}_row{if $price.stats} stats{/if}{if $price.from_the_best || $price.best} from_the_best{/if}">
            <td colspan="14">##NO_DOPDATA##</td>
        </tr>
    {/if}
{/if}