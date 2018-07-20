<div id="claiminfo" data-claim="{$claim_info.Claim}">
<table class="res" width="100%">
    <thead>
    <tr>
        <th colspan="2">##CLAIM_NUMBER##&nbsp;<b>{$claim_info.Inc}</b></th>
    </tr>
    </thead>
    <tbody>
    <tr class="{cycle values="even,odd"}">
        <td>##CLAIM_STATUS##</td>
        <td>{include file="`$smarty.const._ROOT`templates/claim_status.tpl" claim=$claim_info}</td>
    </tr>
    <tr class="{cycle values="even,odd"}">
        <td>##CLAIM_STATUS_PAYMENT##</td>
        <td>{include file="`$smarty.const._ROOT`templates/claim_status_payment.tpl" claim=$claim_info}</td>
    </tr>
    {if isset($cost)}
        <tr class="{cycle values="even,odd"}">
            <td>##CLAIM_COST##</td>
            <td><b>{$cost.Amount}&nbsp;{$cost.CurrencyAlias}</b></td>
        </tr>
        {if $cost.Debt}
            <tr class="{cycle values="even,odd"}">
                <td>##CLAIM_PAY##</td>
                <td><b>{$cost.Debt}&nbsp;{$cost.CurrencyAlias}</b></td>
            </tr>
        {/if}
    {/if}
    </tbody>
</table>
{if !isset($no_data)} 
{if count($peoples)}
    <br>
    <table class="res tbl_peoples">
        <thead>
        <tr>
            <th>##CL_R_P_HUMAN##</th><th>##CL_R_P_FIO##</th><th>##CL_R_P_BORN##</th><th>##CL_R_P_PASSPORT##</th>{*<th>##CL_R_VSTATUS##</th>*}
        </tr>
        </thead>
        <tbody>
            {foreach from = $peoples item = "people" name="peoples"}
                <tr class="{cycle name="peoples" values="even,odd"}" data-people="{$people.Inc}">
                    <td class="human">{$people.Human}</td>
                    <td class="fio">{$people.Name}</td>
                    <td class="born">{$people.Born|date_format}</td>
                    <td class="passport">{$people.PSerie} {$people.PNumber} ##CL_INFO_VALID_TILL## {$people.PValid|date_format}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>
{/if}
{if count($hotels) or count($freights) or count($services) or count($insures) or count($visas)}
    <br>
    <table class="res tbl_orders">
        <thead>
            <tr>
                <th>##CL_R_O_ORDERS##</th>
            </tr>
        </thead>
        <tbody>
        {foreach from = $hotels item = "hotel" name="hotels"}
            <tr class="{cycle name="orders" values="even,odd"}" data-order="{$hotel.OrderInc}">
                <td>{imgload file="hotel.gif" inline=true}&nbsp;{if $hotel.HotelUrl}<a href="{$hotel.HotelUrl}" target="_blank">{$hotel.HotelLName}</a>{else}{$hotel.HotelLName}{/if} {$hotel.DateBeg|date_format}&mdash;{$hotel.DateEnd|date_format} {imgload file="room.gif" inline=true} {$hotel.RoomName} / {$hotel.HtPlaceName}, {imgload file="meal.gif" inline=true} {$hotel.MealName}</td>
            </tr>
        {/foreach}
        {foreach from = $freights item = "freight" name="freights"}
            <tr class="{cycle name="orders" values="even,odd"}" data-order="{$freight.OrderInc}">
                <td>{imgload file="freight.gif" inline=true}&nbsp;{$freight.FreightName} ({$freight.TranTypeName}) {$freight.DateBeg|date_format} {$freight.TownSrcName} ({$freight.SrcPortAlias} {$freight.SrcTime}{if $freight.SrcTimeDelta}<span class="delta">+{$freight.SrcTimeDelta}</span>{/if}) -> {$freight.TownTrgName} ({$freight.TrgPortAlias} {$freight.TrgTime}{if $freight.TrgTimeDelta}<span class="delta">+{$freight.TrgTimeDelta}</span>{/if}) <img src="{$WWWROOT}public/pict/class.gif"> {$freight.ClassName}/{$freight.FrPlaceName}</td>
            </tr>
        {/foreach}
        {foreach from = $services item = "service" name="services"}
            <tr class="{cycle name="orders" values="even,odd"}" data-order="{$service.OrderInc}">
                <td>{imgload file="service.gif" inline=true}&nbsp;{$service.ServTypeName}: {if $service.ServiceUrl}<a href="{$service.ServiceUrl}" target="_blank">{$service.ServiceName}</a>{else}{$service.ServiceName}{/if} {$service.DateBeg|date_format} - {$service.DateEnd|date_format}</td>
            </tr>
        {/foreach}
        {foreach from = $insures item = "insure" name="insures"}
            <tr class="{cycle name="orders" values="even,odd"}" data-order="{$insure.OrderInc}">
                <td>{imgload file="insure.gif" inline=true}&nbsp;{$insure.StateName}: {if $insure.InsureUrl}<a href="{$insure.InsureUrl}" target="_blank">{$insure.InsureName}</a>{else}{$insure.InsureName}{/if} {$insure.DateBeg|date_format} - {$insure.DateEnd|date_format}</td>
            </tr>
        {/foreach}
        {foreach from = $visas item = "visa" name="visas"}
            <tr class="{cycle name="orders" values="even,odd"}" data-order="{$visa.OrderInc}">
                <td>{imgload file="visa.gif" inline=true}&nbsp;{$visa.StateName}: {$visa.VisaName} {$visa.DateBeg|date_format} - {$visa.DateEnd|date_format}</td>
            </tr>
        {/foreach}
    </tbody>
    </table>
{/if}
{else}
    <p>{$no_data}</p>
{/if}
{if $cl_refer_url}<a href="{$cl_refer_url}" target="_blank" >##CL_REFER_INFO##</a>{/if}
</div>