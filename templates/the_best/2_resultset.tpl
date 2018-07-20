{if $prices}
<table class="std res">
    <thead>
        <tr>
            <th>##THE_BEST_HOTEL##</th>
            <th>##THE_BEST_CHECKIN##</th>
            <th>##THE_BEST_TOWNTO##</th>
            <th>##THE_BEST_HTPLACE## / ##THE_BEST_ROOM## / ##THE_BEST_MEAL##</th>
            <th>##THE_BEST_NIGHTS##</th>
            <th>##THE_BEST_PRICE##</th>
            <th>##THE_BEST_SPO##</th>
            <th>##THE_BEST_LIKE##</th>
        </tr>
    </thead>
    <tbody>
    {foreach from=$prices item="best"}
        <tr class="price_info {cycle values="even,odd"}" data-townfrom="{$townFrom}" data-state="{$state}" data-hotel="{$best.hotelKey}" data-checkin="{$best.checkIn|date_format:'sql'}" data-nights="{$best.nights}" data-tour="{$best.tourKey}" data-adult="{$best.adult}" data-child="{$best.child}" data-cat-claim="{$best.id}" data-spog="{$best.spoKey|default:0}" data-packet="{$best.packetType|default:0}">
            <td class="link-hotel">{$best.hotel|cat:' '|cat:$best.star|linkify:$best.hotelUrl}</td>
            <td>{$best.checkIn|date_format:'d.m.Y, D'}</td>
            <td>{$best.town}</td>
            <td>{$best.htPlace}/ {$best.room}/ {$best.meal|linkify:$best.mealUrl}</td>
            <td>
                {if $SEARCH_BY_HOTEL_NIGHTS}
                    {$best.hnights}{if $best.hnights != $best.nights}<span class="helpalt price-additional-nights" title="##TOUR_SEARCH_NIGHTS_ON_ROAD##">{$best.nights-$best.hnights}</span>{/if}
                {else}
                    {$best.nights}
                {/if}
            </td>
            <td class="price bron" data-cat-price="{$best.price}" data-cat-currency="{$best.currencyKey}">{$best.convertedPrice}</td>
            <td>{$best.spo|spo2link:"xls"}{$best.spo|spo2link:"zip"}{$best.spo|spo2link:"rar"}{$best.spo|spo2link:"xml"}&nbsp;{$best.spo}</td>
            <td class="like_price"><a href="{$best.searchUrl}" target="_blank">##THE_BEST_LIKE##</a></td>
        </tr>
    {/foreach}
    </tbody>
</table>
{else}
    ##NO_DATA##
{/if}