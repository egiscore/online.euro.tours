{if $freights.direct || $freights.back}
    <table width="100%">
        <tr>
            <td width="49%" style="vertical-align: top">
                <table class="res">
                    <thead>
                    <tr>
                        <th>##FREIGHT_DATE_RESULT##</th>
                        <th>##FREIGHT_TIME_TO##</th>
                        <th colspan="2">##FREIGHT_NAME_IN##</th>
                        {if $freights.classesDirect.econom}<th>##FRCLASS_0##</th>{/if}
                        {if $freights.classesDirect.busines}<th>##FRCLASS_1##</th>{/if}
                        {if $freights.classesDirect.comfort}<th>##FRCLASS_2##</th>{/if}
                        {if $freights.classesDirect.premium}<th>##FRCLASS_3##</th>{/if}
                    </tr>
                    </thead>
                    <tbody>
                    {foreach from=$freights.direct item="freight"}
                        <tr class="{cycle values="even,odd"}">
                            <td class="{$freight.TdClass}">
                                {if $freight.aflew}<span class="flew" title="##FREIGHT_FLEW##"></span>{/if}
                                {$freight.date|date_format:'d.m.Y, D'}
                            </td>
                            <td class="{$freight.TdClass}{if $freight.aflew} flew{/if}">
                                <b>{$freight.departure.time}</b> {$freight.departure.portAlias}<br>
                                <b>{$freight.arrival.time}</b> {$freight.arrival.portAlias}
                            </td>
                            <td class="{$freight.TdClass}{if $freight.aflew} flew{/if}">
                                {$freight.name}
                            </td>
                            <td class="{$freight.TdClass}{if $freight.aflew} flew{/if}">
                                {$freight.transportCompany}<br>
                                {$freight.transportType}
                            </td>
                            {if $freights.classesDirect.econom}
                                <td class="{$freight.places.0.status}{if $freight.aflew} flew{/if}">
                                    {$lang[$freight.places.0.status]} {if $freight.places.0.placeTotal}({$freight.places.0.placeTotal}){/if}
                                </td>
                            {/if}
                            {if $freights.classesDirect.busines}
                                <td class="{$freight.places.1.status}{if $freight.aflew} flew{/if}">
                                    {$lang[$freight.places.1.status]} {if $freight.places.1.placeTotal}({$freight.places.1.placeTotal}){/if}
                                </td>
                            {/if}
                            {if $freights.classesDirect.comfort}
                                <td class="{$freight.places.2.status}{if $freight.aflew} flew{/if}">
                                    {$lang[$freight.places.2.status]} {if $freight.places.2.placeTotal}({$freight.places.2.placeTotal}){/if}
                                </td>
                            {/if}
                            {if $freights.classesDirect.premium}
                                <td class="{$freight.places.3.status}{if $freight.aflew} flew{/if}">
                                    {$lang[$freight.places.3.status]} {if $freight.places.3.placeTotal}({$freight.places.3.placeTotal}){/if}
                                </td>
                            {/if}
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </td>
            <td width="2%" class="splitter">&nbsp;</td>
            <td width="49%" style="vertical-align: top">
                <table class="res">
                    <thead>
                    <tr>
                        <th>##FREIGHT_DATE_RESULT##</th>
                        <th>##FREIGHT_TIME_TO##</th>
                        <th colspan="2">##FREIGHT_NAME_OUT##</th>
                        {if $freights.classesBack.econom}<th>##FRCLASS_0##</th>{/if}
                        {if $freights.classesBack.busines}<th>##FRCLASS_1##</th>{/if}
                        {if $freights.classesBack.comfort}<th>##FRCLASS_2##</th>{/if}
                        {if $freights.classesBack.premium}<th>##FRCLASS_3##</th>{/if}
                    </tr>
                    </thead>
                    <tbody>
                    {foreach from=$freights.back item="freight"}
                        <tr class="{cycle values="even,odd"}">
                            <td class="{$freight.TdClass}">
                                {$freight.date|date_format:'d.m.Y, D'}
                            </td>
                            <td class="{$freight.TdClass}">
                                <b>{$freight.departure.time}</b> {$freight.departure.portAlias}<br>
                                <b>{$freight.arrival.time}</b> {$freight.arrival.portAlias}
                            </td>
                            <td class="{$freight.TdClass}">
                                {$freight.name}
                            </td>
                            <td class="{$freight.TdClass}">
                                {$freight.transportCompany}<br>
                                {$freight.transportType}
                            </td>
                            {if $freights.classesBack.econom}
                                <td class="{$freight.places.0.status}">
                                    {$lang[$freight.places.0.status]} {if $freight.places.0.placeTotal}({$freight.places.0.placeTotal}){/if}
                                </td>
                            {/if}
                            {if $freights.classesBack.busines}
                                <td class="{$freight.places.1.status}">
                                    {$lang[$freight.places.1.status]} {if $freight.places.1.placeTotal}({$freight.places.1.placeTotal}){/if}
                                </td>
                            {/if}
                            {if $freights.classesBack.comfort}
                                <td class="{$freight.places.2.status}">
                                    {$lang[$freight.places.2.status]} {if $freight.places.2.placeTotal}({$freight.places.2.placeTotal}){/if}
                                </td>
                            {/if}
                            {if $freights.classesBack.premium}
                                <td class="{$freight.places.3.status}">
                                    {$lang[$freight.places.3.status]} {if $freight.places.3.placeTotal}({$freight.places.3.placeTotal}){/if}
                                </td>
                            {/if}
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
{else}
    ##NO_DATA##
{/if}
