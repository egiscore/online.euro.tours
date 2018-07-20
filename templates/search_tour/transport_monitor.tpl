{if $freights.routes}
    {assign var="colspan" value=1+$freights.classesRoutes.econom+$freights.classesRoutes.busines+$freights.classesRoutes.comfort+$freights.classesRoutes.premium}
    <fieldset class="panel">
        <legend>
            ##TOUR_SEARCH_PRICE_STATS_FREIGHT_MONITOR##
        </legend>
        <div id="freights">
            {foreach from=$freights.routes item="step"}
                <table class="res">
                    <thead>
                        <tr>
                            <th colspan="2">{$step.info.date|date_format:'d.m.Y, D'} {$step.info.sourceTown} {if {$step.info.targetTown}}-> {$step.info.targetTown}{/if}</th>
                            {if $freights.classesRoutes.econom}
                                <th class="c">##FRCLASS_0##</th>
                            {/if}
                            {if $freights.classesRoutes.busines}
                                <th class="c">##FRCLASS_1##</th>
                            {/if}
                            {if $freights.classesRoutes.comfort}
                                <th class="c">##FRCLASS_2##</th>
                            {/if}
                            {if $freights.classesRoutes.premium}
                                <th class="c">##FRCLASS_3##</th>
                            {/if}
                        </tr>
                    </thead>
                    {foreach from=$step.freights item="freight"}
                        <tr>
                            <td rowspan="2" class="c transportCompanyLogo">
                                {if $freight.transportCompanyLogo}<img src="{$freight.transportCompanyLogo}" title="{$freight.transportCompany}">{else}{$freight.transportCompany}{/if}
                            </td>
                            <td width="100%">
                                {imgload file="freight.gif" inline=true attrs="align=absmiddle hspace=3"} {$freight.name}({$freight.transportType})
                            </td>
                            {if $freights.classesRoutes.econom}
                                <td class="st_pl nb c {$freight.places.0.status}">{$lang[$freight.places.0.status]} {if $freight.places.0.placeTotal}({$freight.places.0.placeTotal}){/if}</td>
                            {/if}
                            {if $freights.classesRoutes.busines}
                                <td class="st_pl nb c {$freight.places.1.status}">{$lang[$freight.places.1.status]} {if $freight.places.1.placeTotal}({$freight.places.1.placeTotal}){/if}</td>
                            {/if}
                            {if $freights.classesRoutes.comfort}
                                <td class="st_pl nb c {$freight.places.2.status}">{$lang[$freight.places.2.status]} {if $freight.places.2.placeTotal}({$freight.places.2.placeTotal}){/if}</td>
                            {/if}
                            {if $freights.classesRoutes.premium}
                                <td class="st_pl nb c {$freight.places.3.status}">{$lang[$freight.places.3.status]} {if $freight.places.3.placeTotal}({$freight.places.3.placeTotal}){/if}</td>
                            {/if}
                        </tr>
                        <tr>
                            <td colspan="{$colspan}">
                                <b>{$freight.departure.time}</b> {$freight.departure.portAlias} - <b>{$freight.arrival.time}</b> {$freight.arrival.portAlias}
                            </td>
                        </tr>

                    {/foreach}
                </table>
            {/foreach}
        </div>
    </fieldset>
{/if}
