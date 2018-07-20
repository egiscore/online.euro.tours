{if $load == 'TOURINFO'}
    <table class="tour_info res" data-checkin="{$TOURINFO.CheckIn}" data-checkout="{$TOURINFO.CheckOut}"
           data-peoplecount="{$TOURINFO.PeopleCount}" data-ptype="{$TOURINFO.PtInc}" data-tour="{$TOURINFO.TourInc}">
        <thead>
        <tr>
            <th>##BRON_TOUR_DESCRIPTION##</th>
            {if $TOURINFO.Spog > 0}
                <th>##BRON_TOUR_SPO##</th>
            {/if}
            <th>##BRON_STATE##</th>
            <th>##BRON_DATES##</th>
            <th>##BRON_NIGHTS##</th>
            <th>##BRON_SPO_NOTE##</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{$TOURINFO.TourLName|linkify:$TOURINFO.TourUrl}</td>
            {if $TOURINFO.Spog > 0}
                <td>{$TOURINFO.SpogFullNumber}</td>{/if}
            <td>{$TOURINFO.StateLName|linkify:$TOURINFO.StateUrl}</td>
            <td>{$TOURINFO.CheckIn}&mdash;{$TOURINFO.CheckOut}</td>
            <td>{if $TOURINFO.tour_change_nights_enable == 1}
                    <select name="NIGHTS" class="nights">{section start=1 max=29 loop=30 name="night"}
                            <option value="{$smarty.section.night.index}"
                                    {if $smarty.section.night.index == $TOURINFO.Nights}selected{/if}>{$smarty.section.night.index}</option>{/section}
                    </select>
                {else}
                    {$TOURINFO.Nights}
                {/if}
            </td>
            <td>{$TOURINFO.Note}</td>
        </tr>
        {if isset($TOURINFO.ExtNote) && !isset($TOURNOTE)}
            <tr>
                <td colspan="{if $TOURINFO.Spog > 0}6{else}5{/if}" class="note_container">
                    {$TOURINFO.ExtNote}
                </td>
            </tr>
        {/if}
        </tbody>
    </table>
    {if $PRICECALENDAR}
        <table class="res pricestats">
            <thead>
            <tr class="header">
                <th>
                    ##BRON_PRICE_STATS##
                </th>
            </tr>
            </thead>
        </table>
        {include file="price-calendar.tpl" info=$PRICECALENDAR}
    {/if}
{/if}
{if $load == 'TOURNOTE'}
    <fieldset style="width: 92%">
        <legend>##BRON_TOUR_DESCRIPTION##</legend>
        <div>{$TOURNOTE}</div>
    </fieldset>
{/if}
{if $load == 'TOURISTS'}
    <div class="usual tourists-tabs">
        {counter assign="tourist_id" start="-1" direction="down"}
        {section loop=$TOURISTS.Adults name="tourists"}
            {include file="tourist.tpl" STATUS="MRS" num=$smarty.section.tourists.iteration id=$tourist_id}
            {counter}
        {/section}
        {section loop=$TOURISTS.Childs name="tourists"}
            {include file="tourist.tpl" STATUS="CHD" num=$smarty.section.tourists.iteration id=$tourist_id}
            {counter}
        {/section}
        {section loop=$TOURISTS.Infant name="tourists"}
            {include file="tourist.tpl" STATUS="INF" num=$smarty.section.tourists.iteration id=$tourist_id}
            {counter}
        {/section}
        <div class="add_inf"><label><input type="checkbox" class="addinfant_cb" value="1"
                                           {if $freeinfant_checked}checked="true"{/if}>
                ##BRON_TOURIST_ADD_INFANT##</label></div>
        <div class="addinfant" id="infant_add"><p>
                &nbsp;</p>{include file="tourist.tpl" STATUS="INF" num="add" id=$tourist_id}</div>
    </div>
{/if}
{if $load == 'ADDITIONAL_SERVICES'}
    <div id="ADDITIONAL_SERVICES">
        {if $ADDITIONAL_SERVICES}
            <div id="additional_services">
                <table class="res">
                    {cycle values="even,odd" print=false reset=true}
                    {foreach from=$ADDITIONAL_SERVICES item="service" name="main_service"}
                        {if $service.Complete}
                            <tr class="{cycle values="even,odd"}{if $service.error} unavailable_order{/if}"
                                data-mainserviceinc="{$service.Inc}"
                                data-json='{$service|@data_json:'service'}'
                            >
                                <td width="10%">{$service.ServiceTypeLName}</td>
                                <td width="80%">
                                    <label>
                                        <input type="checkbox" class="mainservice"
                                               value="1" {if $service.selected || (isset($service.required) && $service.required == true)} checked="checked"{/if} {if isset($service.required) && $service.required == true} disabled="disabled"{/if}
                                               data-complete="{$service.Complete}">
                                        {$service.LName|linkify:$service.Url}
                                    </label>
                                </td>
                                <td width="10%">
                                    {if $service.price}+<span
                                            class="service_price">{$service.price} {$CURRENCYPRICE_ALIAS}</span>{/if}
                                </td>
                            </tr>
                            {if $service.ServiceNote}
                                <tr class="note note-{$service.Inc}">
                                    <td colspan="3" class="service_note">{$service.ServiceNote|format_text}</td>
                                </tr>
                            {/if}
                        {/if}
                    {/foreach}
                </table>
                <br>
                <table class="res">
                    {foreach from=$ADDITIONAL_SERVICES item="service" name="main_service"}
                        {if !$service.Complete}
                            <tr class="odd"
                                data-mainserviceinc="{$service.Inc}"
                                data-json='{$service|@data_json:'service'}'
                            >
                                <td width="10%">{$service.ServiceTypeLName}</td>
                                <td width="80%">{$service.LName|linkify:$service.Url}</td>
                                <td width="10%">
                                    {if $service.price}+<span
                                            class="service_price">{$service.price} {$CURRENCYPRICE_ALIAS}</span>{/if}
                                </td>
                            </tr>
                            {if $service.ServiceNote}
                                <tr class="note note-{$service.Inc}">
                                    <td colspan="3" class="service_note">{$service.ServiceNote|format_text}</td>
                                </tr>
                            {/if}
                            {counter assign="tourist_id" start="1"}
                            {foreach from=$service.clients item="client"}
                                <tr>
                                    <td colspan="3" class="srv_select_tourist">
                                        <label>
                                            <input type="checkbox" class="tourist_service" value="1"
                                                   data-mainserviceinc="{$service.Inc}"
                                                   data-people="{$client.peopleKey}" {if $client.selected} checked="checked"{/if}>
                                            {$client.human} {if trim($client.lname) != trim($smarty.const.FIO_DELIMETER)}{$client.lname}{else}##BRON_TOURIST## {$tourist_id}{/if} {counter}
                                        </label>
                                    </td>
                                </tr>
                            {/foreach}
                        {/if}
                    {/foreach}
                </table>
                <br>
            </div>
        {/if}
    </div>
    <br>
    <button id="ADD_ADDITIONAL_SERVICES">##BRON_ADDITIONAL_SERVICES_ADD_BUTTON##</button>
{/if}
{if $load == 'ASERVICES'}
    <table class="res">
        <thead>
        <tr>
            <th>##BRON_SERVICE_NAME##</th>
            <th>##BRON_SERVICE_DATES##</th>
            <th class="c">##BRON_SERVICE_COUNT##</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        {if $ASERVICES}
            {foreach from=$ASERVICES item="service"}
                <tr data-json='{$service|@data_json:'service'}' data-inc="{$service.Inc}" data-uid="{$service.uid}"
                    data-selected="{$service.selected}" data-offered="{$service.offered}">
                    <td>{$service.ServiceTypeLName}: {$service.LName|linkify:$service.Url}</td>
                    <td>{if $service.DateBeg->not_null()} {if $service.DateBeg->eq($service.DateEnd)}{$service.DateBeg}{else}{$service.DateBeg} - {$service.DateEnd}{/if}{/if}</td>
                    <td class="service_count c">{$service.count}</td>
                    <td>
                        {if $service.price}
                            {$service.price}&nbsp;{$CURRENCYPRICE_ALIAS}
                        {/if}
                    </td>
                    <td align="center">
                        {if $service.required}
                            &nbsp;
                        {elseif $service.offered}
                            <button class="offered_additional_service">##BTN_ADD##</button>
                        {else}
                            <button class="delete_additional_service">##BTN_DELETE##</button>
                        {/if}
                    </td>
                </tr>
                {if $service.ServiceNote}
                    <tr class="note note-{$service.Inc}">
                        <td colspan="5" class="service_note">{$service.ServiceNote|format_text}</td>
                    </tr>
                {/if}
            {/foreach}
        {/if}
        </tbody>
    </table>
    <div class="eraser"></div>
{/if}
{if $load == 'ASERVICES_JS'}
    <script type="text/html" id="services-tpl">
        {literal}
            <table class="res">
                <thead>
                <tr>
                    <th>##BRON_SERVICE_NAME##</th>
                    <th>##BRON_SERVICE_DATES##</th>
                    <th>##BRON_SERVICE_COUNT##</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <% if (services.length){ %>
                <% for(i in services){ %>
                <% info = services[i] %>
                <% service = info.service %>
                <% serviceNote = info.serviceNote %>

                <tr data-json='<%= JSON.stringify(service) %>' data-inc="<%= service.key %>"
                    data-uid="<%= service.uid %>" data-selected="1">
                    <td><%= service.stlname %>: <% if (service.url) { %><a href="<%= service.url %>" target="_blank"><%=
                            service.name %></a><% } else {%><%= service.name %><% }%>
                    </td>
                    <td>
                        <% if (service.datebeg) { %>
                        <% if (service.datebeg == service.dateend) { %>
                        <%= service.datebeg%>
                        <%} else {%>
                        <%= service.datebeg %> - <%= service.dateend %>
                        <%}%>
                        <%}%>
                    </td>
                    <td class="service_count"><%= service.count %></td>
                    <td>
                        <% if (info.service_price) { %>
                        <%= info.service_price %>
                        <%}%>
                    </td>
                    <td>
                    </td>
                </tr>
                <% if (serviceNote) { %>
                <tr class="note note-<%= service.key %>">
                    <td colspan="5" class="service_note"><%= serviceNote%></td>
                </tr>
                <% }%>
                <% } %>
                <% } %>
                </tbody>
            </table>
            <div class="eraser"></div>
        {/literal}
    </script>
{/if}

{if $load == 'HOTELSINFO' && count($HOTELSINFO)}
    <div class="hotels">
        <table class="res">
            <thead>
            <tr>
                <th>##BRON_HOTEL_NAME##</th>
                <th>##BRON_HOTEL_TOWN##</th>
                <th>##BRON_HOTEL_ROOM##</th>
                <th>##BRON_HOTEL_PLACE##</th>
                <th>##BRON_HOTEL_MEAL##</th>
                <th>##BRON_HOTEL_DATES##</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$HOTELSINFO item="hotel" name="hotels"}
                {if $hotel.alt_hotel_list}
                    <tr class="{cycle name="hotels" values="even,odd"}" data-json='{$hotel|@data_json:'hotel'}'>
                        <td colspan="5">
                            <select class="alternate_hotels">
                                {foreach from=$hotel.alt_hotel_list item="item"}
                                    <option value="{$item.HotelInc}" {if $item.selected}selected="selected"{/if}
                                            data-json='{$item|@data_json:'hotel'}'>{$item.HotelLName}({$item.TownName}
                                        ) {$item.RoomName} / {$item.HtPlaceName} {$item.MealName}</option>
                                {/foreach}
                            </select>
                        </td>
                        <td>{$hotel.DateBeg}&mdash;{$hotel.DateEnd}</td>
                    </tr>
                {else}
                    <tr class="{cycle name="hotels" values="even,odd"}" data-json='{$hotel|@data_json:'hotel'}'
                        data-hotel="{$hotel.HotelInc}">
                        <td{if $hotel.Enable} class="link-hotel"{/if}>{$hotel.HotelLName|cat:' '|cat:$hotel.StarLName|linkify:$hotel.WWW}</td>
                        <td> {$hotel.TownLName}</td>
                        <td>{$hotel.RoomLName}</td>
                        <td>{$hotel.HtPlaceLName}</td>
                        <td>{$hotel.MealLName}</td>
                        <td>{$hotel.DateBeg}&mdash;{$hotel.DateEnd}</td>
                    </tr>
                    {if $hotel.Note}
                        <tr class="note">
                            <td colspan="6" class="hotel_note">
                                {$hotel.Note|format_text}
                            </td>
                        </tr>
                    {/if}
                    {if count($hotel.Banner)}
                        {foreach from=$hotel.Banner item="banner"}
                            <tr>
                                <td colspan="6" class="claim_banner">
                                    {if $banner.MessageCaption}<span class="bold">{$banner.MessageCaption}
                                        :</span>&nbsp;{/if}{$banner.MessageText|format_text}
                                </td>
                            </tr>
                        {/foreach}
                        <br>
                    {/if}
                {/if}
            {/foreach}
            </tbody>
        </table>
    </div>
{/if}
{if $load == 'INSURESINFO' and $INSURESINFO}
    <table class="res">
        <thead>
        <tr>
            <th>##BRON_INSURE_NAME##</th>
            <th>##BRON_SERVICE_DATES##</th>
            <th></th>
            <th class="c">##BRON_INSURE_COUNT##</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        {foreach from=$INSURESINFO item="insure"}
            <tr class="insure_{$insure.Inc} Packet_{$insure.Packet} Partner_{$insure.Partner} required_{$insure.required|intval} Remove_{$insure.Remove} Medical_{$insure.Medical}"
                data-json='{$insure|@data_json:'insure'}' data-inc="{$insure.Inc}" data-uid="{$insure.uid} "
                data-medical="{$insure.Medical} ">
                <td>{$insure.LName|linkify:$insure.Url} {if $insure.Medical && {$insure.Sum}}({$insure.Sum}&nbsp;{$insure.CurrencyAliasSum}){/if}</td>
                <td>{$insure.DateBeg} - {$insure.DateEnd}</td>
                <td>{if !$insure.Packet && $insure.SumPrice}+{$insure.SumPrice}&nbsp;{$insure.CurrencyAlias}{/if}</td>
                <td class="insure_count c">{$insure.count}</td>
                <td align="center">{if $insure.required}&nbsp;{else}
                        <button class="delete_additional_insure">##BTN_DELETE##</button>
                    {/if}</td>
            </tr>
            {if $insure.inscusts}
                {foreach from=$insure.inscusts item="inscust"}
                    <tr data-json='{$inscust|@data_json:'insure'}' data-inc="{$inscust.Inc}" data-uid="{$inscust.uid}"
                        data-medical="{$inscust.Medical}">
                        <td>{$inscust.Name}</td>
                        <td>{$inscust.DateBeg} - {$inscust.DateEnd}</td>
                        <td>{if $inscust.SumPrice}+{$inscust.SumPrice}&nbsp;{$inscust.CurrencyAlias}{/if}</td>
                        <td class="insure_count c">{$inscust.count}</td>
                        <td>&nbsp;</td>
                    </tr>
                {/foreach}
            {/if}
            {if $insure.Note}
                <tr data-json='{$insure|@data_json:'insure'}' class="note note-{$insure.Inc} insure_{$insure.Inc} Packet_{$insure.Packet} Partner_{$insure.Partner} required_{$insure.required|intval} Remove_{$insure.Remove} Medical_{$insure.Medical}">
                    <td colspan="5" class="insure_note">{$insure.Note}</td>
                </tr>
            {/if}
        {/foreach}
        </tbody>
    </table>
    <div class="eraser"></div>
{/if}
{if $load == 'ADDITIONAL_INSURES'}
    <div id="ADDITIONAL_INSURES">
        {if $ADDITIONAL_INSURES}
            <div id="additional_insures">
                <table class="res">
                    {counter assign="tourist_id" start="1"}
                    {foreach from=$ADDITIONAL_INSURES item="client" name="main_insure"}
                        {assign var="insuretype" value=""}
                        <thead>
                        <tr>
                            <th colspan="2">{$client.human} {if trim($client.lname) != trim($smarty.const.FIO_DELIMETER)}{$client.lname}{else}##BRON_TOURIST## {$tourist_id}{/if} {counter}</th>
                            {if $max_inscusts}
                                <th colspan="{$max_inscusts}">&nbsp;</th>
                            {/if}
                        </tr>
                        </thead>
                        <tbody>
                        {cycle values="even,odd" print=false reset=true}

                        {foreach from=$client.insure item="insure" name="insure_client"}
                            <tr class="insure_{$insure.Inc} Packet_{$insure.Packet} Partner_{$insure.Partner} required_{$insure.required|intval} Remove_{$insure.Remove} Medical_{$insure.Medical}
                                {if $insuretype!=$insure.Type}
                                    {assign var="insuretype" value=$insure.Type}{assign var="first" value=1}{cycle values="even,odd" print=false}
                                {else}
                                    {assign var="first" value=0}
                                {/if}{cycle values="even,odd" advance=false}"
                                data-maininsureinc="{$insure.Inc}" data-people="{$client.key}"
                                data-datebeg="{$insure.DateBeg}" data-dateend="{$insure.DateEnd}"
                                data-insuretype="{$insure.Type}">
                                {assign var="csp" value="2"}
                                <td>{if $first}{$insure.TypeName}{/if}&nbsp;</td>
                                <td><label><input type="checkbox" class="maininsure"
                                                  value="1" {if $insure.selected} checked="checked"{/if} {if $insure.required == true && $insure.remove == false} disabled="disabled"{/if}
                                                  data-complete="{$insure.Complete}">{$insure.LName|linkify:$insure.Url} {if $insure.Medical && {$insure.Sum}}({$insure.Sum}&nbsp;{$insure.CurrencyAliasSum}){/if}{if !$insure.Packet && $insure.Price}&nbsp;+{$insure.Price}&nbsp;{$insure.CurrencyAlias}{/if}
                                    </label></td>
                                {foreach from=$insure.inscusts item="inscust" name="insure_inscust"}
                                    <td><label><input type="checkbox" class="inscust"
                                                      value="{$inscust.Inscust}" {if $inscust.required || (isset($inscust.clients[$client.key]))} checked="checked"{/if} {if isset($inscust.required) && $inscust.required==true} disabled="disabled"{/if}>{$inscust.Name}{if $inscust.Price}&nbsp;+{$inscust.Price}&nbsp;{$inscust.CurrencyAlias}{/if}
                                            {$csp = $csp+1}
                                        </label></td>
                                {/foreach}
                                {if $insure.colspan > 0}
                                    {$csp = $csp+$insure.colspan}
                                    <td colspan="{$insure.colspan}">&nbsp;</td>
                                {/if}
                            </tr>
                            {if $insure.Note}
                                <tr  data-json='{$insure|@data_json:'insure'}' class="note note-{$insure.Inc} insure_{$insure.Inc} Packet_{$insure.Packet} Partner_{$insure.Partner} required_{$insure.required|intval} Remove_{$insure.Remove} Medical_{$insure.Medical}">
                                    <td colspan="{$csp}" class="insure_note">{$insure.Note}</td>
                                </tr>
                            {/if}
                        {/foreach}
                        {assign var="colspan" value="2"}
                        {if $max_inscusts}
                            {assign var="colspan" value=$colspan+$max_inscusts}
                        {/if}
                        <tr class="eraser">
                            <td colspan="{$colspan}">&nbsp;</td>
                        </tr>
                        </tbody>
                    {/foreach}
                </table>
                <br>
            </div>
        {/if}
    </div>
    <br>
    <button id="ADD_ADDITIONAL_INSURES">##BRON_ADDITIONAL_INSURES_ADD_BUTTON##</button>
{/if}
{if $load == 'FREIGHTSTABLE'}
    {if $EXTERNALFREIGHTS eq 2}
        {*filter block start*}
        <div class="freightsFilter"></div>
        {*filter block end*}
        <div class="freightsRes">
            <a name="extfr"></a>
            <table class="res" id="gdsGrid">
                <thead>
                <tr>
                    <th rowspan="2"></th>
                    <th rowspan="2"></th>
                    <th rowspan="2" nowrap="" class="text-center">##BRON_FREIGHTS_4_TABLE_FLIGHT_AIR##</th>
                    <th rowspan="2" nowrap="" class="text-center">
                        <a href="#" class="sortbyduration sortbutton">
                            <input type="checkbox" class="sortInput">
                            <label for="stateInput" class="arrows">##BRON_FREIGHTS_4_TABLE_FLY_DURATION##</label>
                        </a>
                    </th>
                    <th colspan="2" nowrap="" class="text-center">##BRON_FREIGHTS_4_TABLE_TIME##</th>
                    <th colspan="2" nowrap="" class="text-center">##BRON_FREIGHTS_4_TABLE_AIRPORT##</th>
                    <th rowspan="2" nowrap="" class="text-center">##BRON_FREIGHTS_4_TABLE_CLASS##</th>
                    <th rowspan="2" nowrap="" class="text-center">
                        <a href="#" class="sortbysurcharge sortbutton">
                            <input type="checkbox" class="sortInput">
                            <label for="stateInput" class="arrows">##BRON_FREIGHTS_4_TABLE_SURCHARGE##</label>
                        </a>
                    </th>
                    <th rowspan="2" nowrap="" class="text-center">##BRON_FREIGHTS_4_TABLE_BAGGAGE##</th>
                </tr>
                <tr class="smalltitle">
                    <th nowrap="">##BRON_FREIGHTS_4_TABLE_DEPARTURE##</th>
                    <th nowrap="">##BRON_FREIGHTS_4_TABLE_ARRIVAL##</th>
                    <th nowrap="">##BRON_FREIGHTS_4_TABLE_DEPARTURE##</th>
                    <th nowrap="">##BRON_FREIGHTS_4_TABLE_ARRIVAL##</th>
                </tr>
                </thead>
                {include file="controls.tpl" load="FREIGHTS" FREIGHTS = [] peoplecount=$route.num}
            </table>
            <div class="messages text-center"></div>
        </div>
        <div class="external_freight_note"></div>
    {else}
        <table class="res">
            <thead>
            <tr>
                <th>##BRON_FREIGHT_NAME##</th>
                <th>##BRON_FREIGHT_CHECKIN##</th>
                <th>##BRON_FREIGHT_NUMBER##</th>
                <th class="frplacement"></th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$FREIGHTSINFO item="route" name="freights"}
                <tr class="{cycle name="freights" values="even,odd"}">
                    <td {if $smarty.foreach.freights.last}class="BACKFREIGHTS"{/if}>
                        {if $route.freights}
                            {include file="controls.tpl" load="FREIGHTS" FREIGHTS = $route.freights peoplecount=$route.num}
                        {elseif $EXTERNALFREIGHTS > 0}
                            {include file="controls.tpl" load="FREIGHTS" FREIGHTS = [] peoplecount=$route.num}
                        {else}
                            ##NO_FREIGHTS##
                        {/if}
                    </td>
                    <td>
                        {$route.DateBeg}
                    </td>
                    <td class="fr_peoplecount" data-peoplecount="{$route.num}">
                        {$route.num}
                    </td>
                    <td class="frplacement"></td>
                </tr>
                <tr class="note{if !$route.Note} hidden{/if}">
                    <td colspan="4" class="freight_note">{$route.Note|format_text}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    {/if}
{/if}
{if $load == 'FREIGHTSINFO'}
    {$dClass = 'freights'}
    {if $EXTERNALFREIGHTS eq 2}
        {$dClass = 'freightsTableBlock'}
    {/if}
    <div class="{$dClass}">
        {include file="controls.tpl" load="FREIGHTSTABLE"}
    </div>
{/if}
{if $load == 'BACKFREIGHTS'}
    {if $BACKFREIGHTS.freights}
        {include file="controls.tpl" load="FREIGHTS" FREIGHTS=$BACKFREIGHTS.freights peoplecount=$BACKFREIGHTS.num}
    {else}
        ##NO_FREIGHTS##
    {/if}
{/if}
{if $load == 'FREIGHTS'}
    {if $EXTERNALFREIGHTS == 2}
        <tbody class="freightTable"></tbody>
    {else}
        <select class="freight">
            {if $EXTERNALFREIGHTS && $FREIGHTS}
            <optgroup label="##BRON_SAMOTOUR_FREIGHTS##">
                {/if}
                {foreach from=$FREIGHTS item="freight"}
                    <option value="{$freight.Inc}"
                            {if $freight.Inc > 0}
                                data-json='{$freight|@data_json:'freight'}'
                            {/if}
                            data-note="{$freight.Note|format_text|escape}"
                            {if $freight.selected}selected="selected"{/if}
                            data-frplacement="{$freight.FrPlacementAvailable}">
                        {if $freight.Inc > 0}
                            [{if $freight.OnlineClassName}{$freight.OnlineClassName}{else}{$freight.ClassName}{/if}] (##FREIGHT_PLACES## {if $freight.place_status == 1}##BRON_INFO_FRPLACE_AVAIL##{else}##BRON_INFO_FRPLACE_REQUEST##{/if}) {$freight.Name} ({$freight.SrcTownName} {$freight.SrcPortAlias} {$freight.SrcTime}{if $freight.ddelay} +{$freight.ddelay}{/if} &mdash; {$freight.TrgTownName} {$freight.TrgPortAlias} {$freight.TrgTime}{if $freight.bdelay} +{$freight.bdelay}{/if}){if $freight.surcharge > 0}&nbsp; +{$freight.surcharge*$peoplecount}&nbsp;{$freight.surcharge_currency}{/if}
                        {else}
                            {$freight.Name}
                        {/if}
                    </option>
                {/foreach}
                {if $EXTERNALFREIGHTS && $FREIGHTS}
            </optgroup>
            {/if}
        </select>
    {/if}
{/if}
{if $load == 'EXTERNAL_BACKFREIGHTS'}
    {if $BACKFREIGHTS}
        <select class="freight">
            <optgroup label="##BRON_EXTERNAL_FREIGHTS##">
                {foreach $BACKFREIGHTS as $freight}
                    <option value="{$freight.Inc}" data-note="{$freight.Note|nl2br|escape}"
                            data-json='{$freight|@data_json:'freight'}'
                            {if $freight.selected}selected="selected"{/if}>
                        {$freight.Title|escape}
                    </option>
                {/foreach}
            </optgroup>
        </select>
    {else}
        ##NO_FREIGHTS##
    {/if}
{/if}

{if $load == "EXTERNAL_FREIGHTS"}
    {if $freights}
        <optgroup label="##BRON_EXTERNAL_FREIGHTS##">
            {foreach $freights as $freight}
                <option value="{$freight.Inc}" data-note="{$freight.Note|nl2br|escape}"
                        data-json='{$freight|@data_json:'freight'}' {if $freight.selected}selected="selected"{/if}>
                    {$freight.Title|escape}
                </option>
            {/foreach}
        </optgroup>
    {/if}
{/if}

{if $load == "EXTERNAL_FREIGHTS_4_TABLE_FILTERS"}
    <table class="res">
        <thead>
        <tr>
            <th>##BRON_FREIGHTS_4_TABLE_FILTER##</th>
            <th></th>
            <th class="text-right hideLink" data-hide-target=".filterOptions">
                <a href="#" class="filterOptions">##BRON_FREIGHTS_4_TABLE_HIDE_FILTER##</a>
                <a href="#" class="filterOptions">##BRON_FREIGHTS_4_TABLE_SHOW_FILTER##</a>
            </th>
        </tr>
        </thead>
        <tbody class="filterOptions">
        {$filterLang=[
        'full_airline' => ['name'=>'##BRON_FREIGHTS_4_TABLE_FILTERS_AIRLINES##'],
        'flight_types' => ['name'=>'##BRON_FREIGHTS_4_TABLE_FILTERS_FLIGHT_TYPES##','values'=>[1=>'##BRON_FREIGHTS_4_TABLE_FILTERS_FLIGHT_TYPES_1##',2=>'##BRON_FREIGHTS_4_TABLE_FILTERS_FLIGHT_TYPES_2##']]
        ]}
        <tr>
            <td>##BRON_FREIGHTS_4_TABLE_FILTERS_CLASS##</td>
            <td colspan="2">
                <select name='class'>
                    <option value="1">##BRON_FREIGHTS_4_TABLE_FILTERS_CLASS_ECONOM##</option>
                    <option value="2">##BRON_FREIGHTS_4_TABLE_FILTERS_CLASS_BUSINESS##</option>
                </select>
            </td>
        </tr>
        {foreach $filter as $name => $values}
            {if $filterLang[$name]|count > 0 and $values|count > 1}
                {if $values|@sort eq 1}{/if}
                <tr>
                    <td>{$filterLang.$name.name}</td>
                    <td colspan="2">
                        <select name={$name}>
                            <option value="0">##BRON_FREIGHTS_4_TABLE_FILTERS_ALL##</option>
                            {foreach $values as $value}
                                <option value="{$value}">
                                    {if $filterLang.$name.values}
                                        {$filterLang.$name.values.$value}
                                    {else}
                                        {$value}
                                    {/if}
                                </option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
            {/if}
        {/foreach}
        <tr>
            <td>##BRON_FREIGHTS_4_TABLE_FLY_DURATION##</td>
            <td colspan="2">
                <div id="flyDurationSlider" class="timesSlider"></div>
                <div class="rangeLabel">
                    ##BRON_FREIGHTS_4_TABLE_FILTERS_FROM## <span id="fly-duration-value-lower"></span>
                    ##BRON_FREIGHTS_4_TABLE_FILTERS_TO## <span id="fly-duration-value-upper"></span>
                </div>
            </td>
        </tr>
        <tr>
            <td>##BRON_FREIGHTS_4_TABLE_DEPART_TIME_ON##</td>
            <td colspan="2">
                <div id="departTimeOnSlider" class="timesSlider"></div>
                <div class="rangeLabel">
                    ##BRON_FREIGHTS_4_TABLE_FILTERS_FROM## <span id="depart-time-on-value-lower"></span>
                    ##BRON_FREIGHTS_4_TABLE_FILTERS_TO## <span id="depart-time-on-value-upper"></span>
                </div>
            </td>
        </tr>
        <tr>
            <td>##BRON_FREIGHTS_4_TABLE_DEPART_TIME_OFF##</td>
            <td colspan="2">
                <div id="departTimeOffSlider" class="timesSlider"></div>
                <div class="rangeLabel">
                    ##BRON_FREIGHTS_4_TABLE_FILTERS_FROM## <span id="depart-time-off-value-lower"></span>
                    ##BRON_FREIGHTS_4_TABLE_FILTERS_TO## <span id="depart-time-off-value-upper"></span>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
{/if}
{if $load == "EXTERNAL_FREIGHTS_4_TABLE"}
    {if $freights}
        {foreach from=$freights key=id item=freight name=f}
            {$zClass = ''}
            {if ($smarty.foreach.f.iteration % 2 == 0)}
                {$zClass = 'odd'}
            {/if}
            {for $index=0 to 1}
                {include file="freight_table_row.tpl" freight=$freight id=$id filterData=$filterData zClass=$zClass index=$index}
            {/for}
        {/foreach}
    {/if}
{/if}

{if $load == 'COMMISSION'}
    <table class="res">
        {cycle values="even,odd" print=false reset=true advance=false}
        <tr class="{cycle values="even,odd"}">
            <td class="title">##AMOUNT_MONEY##</td>
            <td class="value amount_money">???</td>
        </tr>
        <tr class="{cycle values="even,odd"} COMMISSION">
            <td class="title">##COMMISSION_COMMON##</td>
            <td class="value">{$COMMISSION.common}%</td>
        </tr>
        {if $COMMISSION.Early > 0}
            <tr class="{cycle values="even,odd"} COMMISSION">
                <td class="title">##COMMISSION_EARLY##</td>
                <td class="value">{$COMMISSION.Early}%</td>
            </tr>
        {/if}
        {if $COMMISSION.Internet > 0}
            <tr class="{cycle values="even,odd"} COMMISSION">
                <td class="title">##COMMISSION_INTERNET##</td>
                <td class="value">{$COMMISSION.Internet}%</td>
            </tr>
        {/if}
        {if $COMMISSION.Mediator > 0}
            <tr class="{cycle values="even,odd"} COMMISSION">
                <td class="title">##COMMISSION_MEDIATOR##</td>
                <td class="value">{$COMMISSION.Mediator}%</td>
            </tr>
        {/if}
        <tr class="{cycle values="even,odd"}">
            <td class="title">##COMMISSION_MONEY##</td>
            <td class="value commission_money">???</td>
        </tr>
        <tr class="{cycle values="even,odd"} BONUS">
            <td class="title">##BONUS_VALUE##&nbsp;<span class="bonus_for_agency">##BONUS_FOR_AGENCY##</span><span
                        class="bonus_for_manager">##BONUS_FOR_MANAGER##</span></td>
            <td class="value BONUS_VALUE">???</td>
        </tr>
    </table>
{/if}
{if $load == 'CLAIM_NOTE'}
    {include file="../controls.tpl" control="checklistbox_html" elements=$CLAIM_NOTE}
{/if}
{if $load == 'SPOGMESSAGE' && $SPOGMESSAGE}
    <div class="spog_message">
        {$SPOGMESSAGE}
    </div>
{/if}
{if $load == 'OWNERINFO' && $OWNERINFO|@count > 1}
    <select id="CLAIM_OWNER" name="CLAIM_OWNER">
        <option value="0">##BRON_DASH##</option>
        {foreach from=$OWNERINFO item="owner"}
            <option value="{$owner.Partner_partnerinc}"
                    {if $owner.selected}selected="selected"{/if}>{$owner.Partner_partnerlname}</option>
        {/foreach}
    </select>
{/if}
