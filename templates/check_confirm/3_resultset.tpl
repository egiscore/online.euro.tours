{if $confirmation}
<div class="check_c" data-claim="{$confirmation.Claim}">
<table class="res" width="100%">
    <thead>
    <tr>
        <th colspan="2">##CLAIM_NUMBER##&nbsp;<b>{$confirmation.Claim}</b></th>
    </tr>
    </thead>
    <tbody>
    <tr class="{cycle values="even,odd"}">
        <td>##CLAIM_STATUS##</td>
        <td>{include file="../claim_status.tpl" claim=$confirmation}</td>
    </tr>
    {if $confirmation.load_payment && $confirmation.Confirmed}
    <tr class="{cycle values="even,odd"}">
        <td>##CLAIM_STATUS_PAYMENT##</td>
        <td>{include file="../claim_status_payment.tpl" claim=$confirmation}</td>
    </tr>
    {/if}
    {if isset($confirmation.cost)}
        <tr class="{cycle values="even,odd"}">
            <td>##CLAIM_COST##</td>
            <td><b>{$confirmation.cost.Amount}&nbsp;{$confirmation.cost.CurrencyAlias}</b></td>
        </tr>
        {if $confirmation.cost.Debt}
            <tr class="{cycle values="even,odd"}">
                <td>##CLAIM_PAY##</td>
                <td><b>{$confirmation.cost.Debt}&nbsp;{$confirmation.cost.CurrencyAlias}</b></td>
            </tr>
        {/if}
    {/if}
    {if isset($confirmation.documents)}
        <tr class="{cycle values="even,odd"}">
            <td>##DOCUMENT_INFO##</td>
            <td><b>{$confirmation.documents}</b></td>
        </tr>
    {/if}
    </tbody>
</table>
{if !isset($confirmation.no_data)} 
{if count($confirmation.peoples)}
    <br>
    <table class="res tbl_peoples">
        <thead>
        <tr>
            <th>##CL_R_P_HUMAN##</th><th>##CL_R_P_FIO##</th><th>##CL_R_P_BORN##</th><th>##CL_R_P_PASSPORT##</th>{*<th>##CL_R_VSTATUS##</th>*}
        </tr>
        </thead>
        <tbody>
            {cycle values="even,odd" print=false reset=true advance=false}
            {foreach from = $confirmation.peoples item = "people" name="peoples"}
                <tr data-people="{$people.Inc}" class="{cycle values="even,odd"}">
                    <td class="human">{$people.Human}</td>
                    <td class="fio">{$people.Name}</td>
                    <td class="born">{$people.Born}</td>
                    <td class="passport">{$people.PSerie} {$people.PNumber} ##CL_INFO_VALID_TILL## {$people.PValid}</td>
{*
                    <td>
                        <table>
                            <tr>
                                <td class="label">##VISA_STATUS_DOC_FULL_TAKEN##</td>
                                <td>
                                {if $people.fulltakendoc}
                                    {imgload file="paid.gif" title="##YES##"}
                                {else}
                                    {imgload file="cancel.gif" title="##NO##"}
                                {/if}
                                </td>
                            </tr>
                            <tr>
                                <td>##VISA_STATUS_DOC_PREPARED_TO_EMBASSY##</td>
                                <td>
                                {if $people.prepareddoc}
                                    {imgload file="paid.gif" title="##YES##"}
                                {else}
                                    {imgload file="cancel.gif" title="##NO##"}
                                {/if}        
                                </td>
                            </tr>
                            <tr>
                                <td>##VISA_STATUS_DOC_GIVEN_INTO_EMBASSY##</td>
                                <td>
                                {if $people.givendoc}
                                    {imgload file="paid.gif" title="##YES##"}
                                {else}
                                    {imgload file="cancel.gif" title="##NO##"}
                                {/if}        
                                </td>
                            </tr>
                            <tr>
                                <td>##VISA_STATUS_DOC_APPROXIMATE_RECEIVING_DATE##</td>
                                <td>
                                {if $people.receiveddate}
                                    {$people.receiveddate}
                                {/if}        
                                </td>
                            </tr>
                            <tr>
                                <td>##VISA_STATUS_DOC_RECEIVED_FROM_EMBASSY##</td>
                                <td>
                                {if $people.receiveddoc}
                                    {imgload file="paid.gif" title="##YES##"}
                                {/if}
                                </td>                    
                            </tr>
                            <tr>
                                <td>##VISA_STATUS_VISA_DOCUMENTS_STATUS##</td>
                                <td align="center">
                                    {$people.VStatusName}&nbsp;
                                </td>
                            </tr>
                        </table>
                    </td>
*}
                </tr>
{*
                <tr>
                    <td colspan="2" class="r">##TOURIST_PHONE##</td>
                    <td colspan="3"><input type="text" class="string" name="PHONES[{$people.Inc}]" value="{$people.Faxes}" data-mask="999-9999999"></td>
                </tr>
*}
            {/foreach}
        </tbody>
    </table>
{/if}
{if count($confirmation.hotels) or count($confirmation.freights) or count($confirmation.services) or count($confirmation.insures) or count($confirmation.visas)}
    <br>
    <table class="res tbl_orders">
        <thead>
            <tr>
                <th>##CL_R_O_ORDERS##</th>
            </tr>
        </thead>
        <tbody>
        {cycle values="even,odd" print=false reset=true advance=false}
        {foreach from = $confirmation.hotels item = "hotel" name="hotels"}
            <tr data-order="{$hotel.OrderInc}" class="{cycle values="even,odd"}">
                <td>{imgload file="hotel.gif" inline=true}&nbsp;{if $hotel.HotelUrl}<a href="{$hotel.HotelUrl}" target="_blank">{$hotel.HotelLName}</a>{else}{$hotel.HotelLName}{/if} {$hotel.DateBeg}&mdash;{$hotel.DateEnd} {imgload file="room.gif" inline=true} {$hotel.RoomName} / {$hotel.HtPlaceName}, {imgload file="meal.gif" inline=true} {$hotel.MealName}</td>
            </tr>
        {/foreach}
        {foreach from = $confirmation.freights item = "freight" name="freights"}
            <tr data-order="{$freight.OrderInc}" class="{cycle values="even,odd"}">
                <td>{imgload file="freight.gif" inline=true}&nbsp;{$freight.FreightName} ({$freight.TranTypeName}) {$freight.DateBeg} {$freight.TownSrcName} ({$freight.SrcPortAlias} {$freight.SrcTime}{if $freight.SrcTimeDelta}<span class="delta">+{$freight.SrcTimeDelta}</span>{/if}) -> {$freight.TownTrgName} ({$freight.TrgPortAlias} {$freight.TrgTime}{if $freight.TrgTimeDelta}<span class="delta">+{$freight.TrgTimeDelta}</span>{/if}) {imgload file="class.gif" inline=true} {$freight.ClassName}/{$freight.FrPlaceName}</td>
            </tr>
        {/foreach}
        {foreach from = $confirmation.services item = "service" name="services"}
            <tr data-order="{$service.OrderInc}" class="{cycle values="even,odd"}">
                <td>{imgload file="service.gif" inline=true}&nbsp;{$service.ServiceTypeName}: {if $service.ServiceUrl}<a href="{$service.ServiceUrl}" target="_blank">{$service.ServiceName}</a>{else}{$service.ServiceName}{/if} {$service.DateBeg} - {$service.DateEnd}</td>
            </tr>
        {/foreach}
        {foreach from = $confirmation.insures item = "insure" name="insures"}
            <tr data-order="{$insure.OrderInc}" class="{cycle values="even,odd"}">
                <td>{imgload file="insure.gif" inline=true}&nbsp;{$insure.StateName}: {if $insure.InsureUrl}<a href="{$insure.InsureUrl}" target="_blank">{$insure.InsureName}</a>{else}{$insure.InsureName}{/if} {$insure.DateBeg} - {$insure.DateEnd}</td>
            </tr>
        {/foreach}
        {foreach from = $confirmation.visas item = "visa" name="visas"}
            <tr data-order="{$visa.OrderInc}" class="{cycle values="even,odd"}">
                <td>{imgload file="visa.gif" inline=true}&nbsp;{$visa.StateName}: {$visa.VisaName} {$visa.DateBeg} - {$visa.DateEnd}</td>
            </tr>
        {/foreach}
    </tbody>
    </table>
{/if}
{else}
    <p>{$confirmation.no_data}</p>
{/if}
<br>
{assign var="cl_refer_link" value=$cl_refer_link|default:true}
{if $cl_refer_link}<a href="{$confirmation.cl_refer_url}" {if $smarty.get.samo_action eq 'check_popup'}target="_blank"{/if}>##CL_REFER_INFO##</a>{/if}
{*
<br><br>
<button class="save">##SAVE_CONFIRM##</button>
*}
</div>
{elseif $is_error}
    {$is_error}
{else}
##CLAIM_NOT_FOUND##
{/if}