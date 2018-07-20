{if $h_stop_sale}
    <table class="res">
        <thead>
        <tr>
            <th>##H_STOPSALE_STOP##</th>
            <th>##H_STOPSALE_ROOM##</th>
            <th>##H_STOPSALE_HTPLACE##</th>
            <th>##H_STOPSALE_MEAL##</th>
            <th>##H_STOPSALE_TYPE##</th>
            <th>##H_STOPSALE_INCOMING_PARTNER##</th>
            <th>##H_STOPSALE_NOTE##</th>
        </tr>
        </thead>
        <tbody>

        <tr class="even" data-hotel="{$h_stop_sale.0.hotelKey}">
            <td colspan="7"><span class="link{if $h_stop_sale.0.enable} enabled{/if}"
                                  data-hotel="{$h_stop_sale.0.hotelKey}">{$h_stop_sale.0.hotel}</span>{if $h_stop_sale.0.town} ({$h_stop_sale.0.town}){/if}{if $h_stop_sale.0.starAlt} {$h_stop_sale.0.starAlt}{/if}
            </td>
        </tr>

        {foreach from=$h_stop_sale item="hsts"}
            <tr class="odd" data-hotel="{$hsts.hotelKey}">
                <td nowrap>
                    {$hsts.dateBeg} - {$hsts.dateEnd}
                </td>
                <td>{$hsts.roomAlt|default:"##H_STOPSALE_ALL##"}</td>
                <td>{$hsts.htPlaceAlt|default:"##H_STOPSALE_ALL##"}</td>
                <td>{$hsts.mealAlt|default:"##H_STOPSALE_ALL##"}</td>
                <td>{$hsts.type}</td>
                <td>{$hsts.partner|default:"##H_STOPSALE_ALL##"}</td>
                <td>
                    {$hsts.note}
                    {if $hsts.rdatebeg->not_null()}
                        {if $hsts.note}
                            <br>
                        {/if}
                        ##H_STOPSALE_PERIOD_RDATE##
                        <span class="nw">{if $hsts.rdatebeg->not_null()} {if $hsts.rdatebeg->eq($hsts.rdateend)}{$hsts.rdatebeg}{else}{$hsts.rdatebeg} - {$hsts.rdateend}{/if}{/if}</span>
                    {/if}
                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>
{else}
    {if $HOTELINC}
        <table class="res">
            <thead>
            <tr>
                <th>##H_STOPSALE_STOP##</th>
                <th>##H_STOPSALE_ROOM##</th>
                <th>##H_STOPSALE_HTPLACE##</th>
                <th>##H_STOPSALE_MEAL##</th>
                <th>##H_STOPSALE_TYPE##</th>
                <th>##H_STOPSALE_INCOMING_PARTNER##</th>
                <th>##H_STOPSALE_NOTE##</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$HOTELINC item="hotel"}
                <tr class="even" data-hotel="{$hotel.hotelKey}">
                    <td colspan="7"><span class="link{if $hotel.enable} enabled{/if}"
                                          data-hotel="{$hotel.id}">{$hotel.name}</span>{if $hotel.town} ({$hotel.town}){/if}{if $hotel.starAlt} {$hotel.starAlt}{/if}
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    {else}
        ##NO_DATA##
    {/if}
{/if}