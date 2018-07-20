{assign var='orders_status_column' value=false}
{if count($hotels) or count($freights) or count($services) or count($insures) or count($visas)}
    <table class="res tbl_orders">
        <thead>
            <tr>
                <th>##CL_R_O_ORDERS##</th><th>##CL_R_O_TOURISTS##</th>{if $orders_status_column}<th>##CL_R_O_STATUS##</th>{/if}{if $orders_print_column}<th>&nbsp;</th>{/if}
            </tr>
        </thead>
        <tbody>
        {foreach from = $hotels item = "hotel" name="hotels"}
            <tr data-peoples="{$hotel.orderPeoples}" class="{cycle name="orders" values="even,odd"} hotel {$hotel|class_builder:'hotels'}" id="order_{$hotel.OrderInc}" data-order="{$hotel.OrderInc}" data-hotel="{$hotel.HotelInc}">
                <td>
                    {imgload file="hotel.gif" inline=true}&nbsp;{$hotel.HotelLName|linkify:$hotel.HotelUrl} {$hotel.DateBeg}&mdash;{$hotel.DateEnd} {if $hotel.HotelInc != 1}{imgload file="room.gif" inline=true} {$hotel.RoomName} / {$hotel.HtPlaceName}, {imgload file="meal.gif" inline=true} {$hotel.MealName}{/if} {if $hotel.TimeLimit->not_null()}<span class="timelimit">##CL_R_ORDER_TIMELIMIT## {$hotel.TimeLimit|datetime_format}</span>{/if}
                        {if $hotel.HotelNote}
                            <div class="hotel_note short_block">
                                {$hotel.HotelNote|format_text}
                            </div>
                        {/if}
                </td>

                <td class="o_pcount link">{$hotel.PCount}</td>
                {if $orders_status_column}<td class="o_status">{$hotel.Confirmed|order_confirmation}</td>{/if}
            </tr>
        {/foreach}
        {foreach from = $freights item = "freight" name="freights"}
            <tr data-peoples="{$freight.orderPeoples}" class="{cycle name="orders" values="even,odd"} freight {$freight|class_builder:'freights'}" id="order_{$freight.OrderInc}" data-order="{$freight.OrderInc}" data-freight='{$freight|data_json:'frplacement'}'{if $freight.FrPlacementAvailable} data-frplacement="1"{/if}>
                <td>
                    {imgload file="freight.gif" inline=true}&nbsp;{if $freight.FreightInc == 1}{$freight.FreightName}{if $freight.IsGDS != 1} {$freight.DateBeg}{/if}{else}{$freight.FreightName} {$freight.PartnerLName} ({$freight.TranTypeName}) {$freight.DateBeg} {$freight.TownSrcName} ({$freight.SrcPortAlias} {$freight.SrcTime}{if $freight.SrcTimeDelta}<span class="delta">+{$freight.SrcTimeDelta}</span>{/if}) -> {$freight.TownTrgName} ({$freight.TrgPortAlias} {$freight.TrgTime}{if $freight.TrgTimeDelta}<span class="delta">+{$freight.TrgTimeDelta}</span>{/if}) <img src="{$WWWROOT}public/pict/class.gif"> {$freight.ClassName|linkify:$freight.ClassUrl}/{$freight.FrPlaceName}{/if} {if $freight.TimeLimit->not_null()}<span class="timelimit">##CL_R_ORDER_TIMELIMIT## {$freight.TimeLimit|datetime_format}</span>{/if}
                    {if $freight.Note}
                        <div class="freight_note short_block">
                            {$freight.Note|format_text}
                        </div>
                    {/if}
                </td>
                <td class="o_pcount link ns">{$freight.PCount}{if $freight.FrPlacementAvailable}<span class="frplacement{if $freight.SeatCount < $freight.MaxSeatCount} pulse{/if}" title="##FRPLACEMENT_CHOOSE_TITLE##"></span>{/if}</td>
                {if $orders_status_column}<td class="o_status">{$freight.Confirmed|order_confirmation}</td>{/if}
            </tr>
        {/foreach}
        {foreach from = $services item = "service" name="services"}
            <tr data-peoples="{$service.orderPeoples}" class="{cycle name="orders" values="even,odd"} service {$service|class_builder:'services'}" id="order_{$service.OrderInc}" data-order="{$service.OrderInc}">
                <td>
                    {imgload file="service.gif" inline=true}&nbsp;{if $service.ServiceInc == 1}{$service.ServiceName}{else}{$service.ServiceTypeName}: {$service.ServiceName|linkify:$service.ServiceUrl}{/if} {$service.DateBeg} - {$service.DateEnd} {if $service.TimeLimit->not_null()}<span class="timelimit">##CL_R_ORDER_TIMELIMIT## {$service.TimeLimit|datetime_format}</span>{/if}
                    {if $service.ServiceNote}
                        <div class="service_note short_block">
                            {$service.ServiceNote|format_text}
                        </div>
                    {/if}
                </td>
                <td class="o_pcount link">{$service.PCount}</td>
                {if $orders_status_column}<td class="o_status">{$service.Confirmed|order_confirmation}</td>{/if}
            </tr>
        {/foreach}
        {foreach from = $insures item = "insure" name="insures"}
            <tr data-peoples="{$insure.orderPeoples}" class="{cycle name="orders" values="even,odd"} insure {$insure|class_builder:'insures'}" id="order_{$insure.OrderInc}" data-order="{$insure.OrderInc}" data-medical="{$insure.Medical}">
                <td>
                    {imgload file="insure.gif" inline=true}&nbsp;{$insure.StateName}: {$insure.InsureName|linkify:$insure.InsureUrl} {if $insure.Medical && {$insure.Sum}}({$insure.Sum}&nbsp;{$insure.CurrencyAliasSum}){/if}&nbsp;{$insure.DateBeg} - {$insure.DateEnd} {if $insure.TimeLimit->not_null()}<span class="timelimit">##CL_R_ORDER_TIMELIMIT## {$insure.TimeLimit|datetime_format}</span>{/if}
                    {if $insure.Note}
                        <div class="insure_note short_block">
                            {$insure.Note|format_text}
                        </div>
                    {/if}
                </td>
                <td class="o_pcount link">{$insure.PCount}</td>
                {if $orders_status_column}<td class="o_status">{$insure.Confirmed|order_confirmation}</td>{/if}
            </tr>
        {/foreach}
        {foreach from = $visas item = "visa" name="visas"}
            <tr data-peoples="{$visa.orderPeoples}" class="{cycle name="orders" values="even,odd"} visa {$visa|class_builder:'visas'}" id="order_{$visa.OrderInc}" data-order="{$visa.OrderInc}" >
                <td class="visa">{imgload file="visa.gif" inline=true}&nbsp;{$visa.StateName}: {$visa.VisaName|linkify:$visa.VisaUrl} {$visa.DateBeg} - {$visa.DateEnd} {if $visa.VisaDeadlineDate->not_null()}&nbsp;&nbsp;<span class="green bold">##CL_R_VISA_TAKEDOC## {if $visa.VisaTakeDocBeginDate->not_null()}##CL_R_VISA_TAKEDOCBEGINDATE##{$visa.VisaTakeDocBeginDate}{/if} ##CL_R_VISA_DEADLINE## {$visa.VisaDeadlineDate|datetime_format}</span>{/if} {if $visa.TimeLimit->not_null()}<span class="timelimit">##CL_R_ORDER_TIMELIMIT## {$visa.TimeLimit|datetime_format}</span>{/if}</td>
                <td class="o_pcount link">{$visa.PCount}</td>
                {if $orders_status_column}<td class="o_status">{$visa.Confirmed|order_confirmation}</td>{/if}
            </tr>
        {/foreach}
    </tbody>
    </table>
{else}
    <p>##CL_R_O_NOORDERS##</p>
{/if}
{if count($peoples)}
    <table class="tbl_peoples">
        <thead>
        <tr>
            <th>##CL_R_P_HUMAN##</th>
            <th>##CL_R_P_FIO##</th>
            {if $peoples.0.VisiblePersonalInformation && isset($routes.edit_tourist)}<th>&nbsp;</th>{/if}
            <th>##CL_R_P_BORN##</th>
            <th>##CL_R_P_PASSPORT##</th>
            {if $peoples.0.VisiblePersonalInformation && (isset($routes.visa_status) || isset($routes.anketa)) && $visas}<th>##CL_R_P_VDOCUM##</th>{/if}
        </tr>
        </thead>
        <tbody>
    {foreach from = $peoples item = "people" name="peoples"}
        <tr class="{cycle name="peoples" values="even,odd"} {$people|class_builder:'peoples'}"  id="people_{$people.Inc}" data-people="{$people.Inc}">
            <td class="human">{$people.Human}</td>
            <td class="fio">{if $people.VisiblePersonalInformation}{$people.LName}{else}##CL_R_P_HIDDEN##{/if}</td>
            {if $people.VisiblePersonalInformation && isset($routes.edit_tourist)}<td class="edit_tourist"></td>{/if}
            <td class="born">{if $people.VisiblePersonalInformation}{$people.Born}{else}##CL_R_P_HIDDEN##{/if}</td>
            <td class="passport">{if $people.VisiblePersonalInformation}{$people.PSerie} {$people.PNumber} ##CL_FOR## {$people.PValid}{else}##CL_R_P_HIDDEN##{/if}</td>
            {if $people.VisiblePersonalInformation && (isset($routes.visa_status) || isset($routes.anketa)) && $visas}<td class="p_v_status">&nbsp;{$people.ANote|icon_popup}&nbsp;</td>{/if}
        </tr>
    {/foreach}
        </tbody>
    </table>
{else}
    <p>##CL_R_P_NOPEOPLES##</p>
{/if}
