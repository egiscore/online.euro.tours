{include file="../controls.tpl" control="pager"}
{foreach from=$cl_refer item="clr"}
    <table class="res cl_refer_result{if $clr.cl_status} cl_{$clr.cl_status}{/if}{if $clr.PayTimeLimit} cl_overdue{/if}{if $clr.AccessPay} cl_accesspay{/if}"
           id="cl_{$clr.Inc}"
           data-claim="{$clr.Inc}"
           data-status="{$clr.Status}"
           data-printdocument="{$clr.CanPrintDocument}"
           data-payment="{if $clr.Status == 1}1{else}0{/if}"
           data-partpayment="{$clr.Partpayment}"
           data-confirmed="{$clr.Confirmed}"
           data-request-cancel-date="{$clr.RequestCancelDate|date_format:'sql'}"
           data-checkin="{$clr.DateBeg|date_format:'sql'}"
           data-checkout="{$clr.DateEnd|date_format:'sql'}"
           data-anketa="{$clr.Anketa}"
           data-visast_www="{$clr.Visast_www}"
           data-paymentschedule="{$clr.paymentschedule}"
           data-show_cost_link="{$clr.show_cost_link}"
    >
        <thead>
        <tr>
            <th width="20%"><span class="claim">{$clr.Inc}</span>&nbsp; ##CL_R_FROM## {$clr.CDate}
                <br>{$clr.PartnerName}{if $clr.Login}, {$clr.Login}{/if}</th>
            <th width="30%">##CL_R_RES_TOUR##<br>##CL_R_RES_SPOG##</th>
            <th width="10%">##CL_R_RES_BEGIN##<br>##CL_R_RES_END##</th>
            <th width="10%">##CL_R_RES_STATUS##</th>
            <th width="10%">##CL_R_RES_PREPAYMENT##<br>##CL_R_RES_FULL_PAYMENT##</th>
            <th width="10%">##CL_R_RES_IDATE##</th>
            <th width="10%">##MANAGER_OPERATOR##</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="num">
                    <span class="claim-status">
                        {if $clr.cl_status == 'paid'}
                            {imgload file="paid.gif" inline=true title="##CL_R_RES_PAID##"}##CL_R_RES_PAID##
                        {elseif $clr.cl_status == 'partpaid'}
                            {imgload file="ppaid.gif" inline=true title="##CL_R_RES_PARTPAID##"}##CL_R_RES_PARTPAID##
                        {elseif $clr.cl_status == 'unpaid'}
                            {imgload file="unpaid.gif"  inline=true title="##CL_R_RES_UNPAID##"}##CL_R_RES_UNPAID##
                        {elseif $clr.cl_status == 'cancel'}
                            {imgload file="cancel.gif"  inline=true title="##CL_R_RES_CANCELED##"}##CL_R_RES_CANCELED##
                        {elseif $clr.cl_status == 'penaltypart'}
                            {imgload file="ppenalty.gif"  inline=true title="##CL_R_RES_PARTPAID##"}##CL_R_RES_PARTPAID##
                        {elseif $clr.cl_status == 'penalty'}
                            {imgload file="penalty.gif"  inline=true title="##CL_R_RES_PENALTY##"}##CL_R_RES_PENALTY##
                        {elseif $clr.cl_status == 'penaltypaid'}
                            {imgload file="paidpenalty.gif"  inline=true title="##CL_R_RES_PAID##"}##CL_R_RES_PAID##
                        {elseif $clr.cl_status == 'calc'}
                            <span class="left">{imgload file="calc.gif"  inline=true title="##CL_R_RES_CALC##"}
                                ##CL_R_RES_CALC##</span>




{if $clr.CalculatedClaimEnable}
                            <span class="right">
                                    <button class="preorder-btn ClaimConfirmPreOrder">##CLAIM_CONFIRM_PREORDER_CHECK##</button>
                                </span>
                        {/if}
                        {/if}
                    </span>
                {if $clr.PayTimeLimit}<span class="claim-payment-overdue">##CL_PAYMENT_OVERDUE##</span>{/if}
            </td>
            <td>{$clr.TourLName|linkify:$clr.TourUrl}{if $clr.SpoFullNumber}
                    <br>
                    {$clr.SpoFullNumber} {if $clr.SpoRqDateEnd->not_null()}##SPOG_UNTIL## {$clr.SpoRqDateEnd}{/if}{/if}
                {if $clr.SpoMessage}
                    <br>
                    <div class="spomessage ui-state-highlight">
                    <span class="ui-icon ui-icon-alert"></span>
                    {$clr.SpoMessage}</div>{/if}
            </td>
            <td>{$clr.DateBeg}<br>{$clr.DateEnd}</td>
            <td class="status">
                {include file="../claim_status.tpl" claim=$clr}
            </td>
            <td>
                {if $clr.paymentschedule}
                    <span class="link cl_price" style="margin-bottom: 0px;">##CL_R_RES_A_COST_DEADLINE##</span>
                {else}
                    {if $clr.PPDate->not_null()}##CL_R_RES_TILL## {$clr.PPDate|date_format:'datetime'}{else}- - - -{/if}
                {/if}
                <br>
                {if $clr.PDate->not_null()}##CL_R_RES_TILL## {$clr.PDate|date_format:'datetime'}{else}- - - -{/if}
                <br>
                {if $clr.BonusList|count}
                    {$clr.BonusList.bonus_value} {$clr.BonusList.alias} ##CL_BONUSES_WHEN_PAYING_TODAY## {if $clr.BonusList.foragency}(##FOR_AGENCY##){else}(##FOR_MANAGER##){/if}
                {/if}
            </td>
            <td {if $clr.ICancel == 1}class="line_through"{/if}>{$clr.IDate}
                <br>{if $clr.InvoiceNumber != ''}¹{$clr.InvoiceNumber}{/if}</td>
            <td>{$clr.UsName}</td>
        </tr>
        <tr>
            <td class="cl_alink">
                {if $routes.messages}
                    {if $clr.msg_exists}
                        <span class="link msg{if $clr.msg_unread} msg_unread{/if}">##MSG_SHOW##</span>
                    {else}
                        <span class="link msg-new">##MSG_CREATE##</span>
                    {/if}
                {/if}
                {if $clr.show_cost_link}
                    <span class="link cl_price {if $clr.paymentschedule}paymentschedule{/if}" id="cost_{$clr.Inc}">##CL_R_RES_A_COST##</span>
                {/if}
                {if $clr.AccessPay && $routes.pay_variant}
                    <a class="link pay_variant" href="{Samo_Url::route('pay_variant', ['CLAIM' => $clr.Inc])}"
                       target="_blank">{$routes.pay_variant.title}</a>
                {/if}
                <span class="link e_doc">##CL_R_E_DOC##</span>
                {if (($clr.Status == 1 && $clr.Confirmed == 1) || $clr.Status == 5) && $routes.buh_doc}
                    <a class="link buh_doc" href="{$routes.buh_doc.url}CLAIM={$clr.Inc}"
                       target="_blank">{$routes.buh_doc.title}</a>
                {/if}
            </td>
            <td colspan="6" rowspan="2" id="orders_{$clr.Inc}" class="orders">
                {if $clr.Banner}
                    {foreach from=$clr.Banner item="banner"}
                        <div class="claim_banner">
                            {if $banner.MessageCaption || $banner.HotelName}
                                <span class="bold">{$banner.MessageCaption}{if $banner.HotelName} ({$banner.HotelName}){/if}:</span>&nbsp;
                            {/if}
                            {$banner.MessageText|format_text}
                        </div>
                    {/foreach}
                {/if}
                {if $clr.PartnerComment}
                    <div class="partnercomment">{$clr.PartnerComment}</div>
                {/if}
                {if !$clr.orders}
                    <div class="toggle_orders link">##CL_R_RES_A_SHOW_ORDERS##<br></div>
                {/if}
                <div class="orders"
                     {if $clr.orders}style="display: block"{/if}>{if $clr.orders}{include file="orders.tpl" hotels=$clr.orders.hotels freights=$clr.orders.freights services=$clr.orders.services insures=$clr.orders.insures visas=$clr.orders.visas peoples=$clr.orders.peoples}{/if}</div>
            </td>
        </tr>
        <tr>
            <td class="block_cancel_claim">{if $clr.Status != 3 && $clr.Status != 4 && $clr.Status != 5}
                    {if $routes.cancel_claim && $clr.RequestCancelDate->is_null() && $clr.DateBeg->gte()}
                        <span class="link cancel_claim">{$routes.cancel_claim.title}</span>
                    {/if}
                {/if}</td>
        </tr>
        </tbody>
    </table>
    {foreachelse}
    ##NO_DATA##
{/foreach}
{include file="../controls.tpl" control="pager"}