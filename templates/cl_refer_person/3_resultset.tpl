{if $clr}
    <table class="res cl_refer_result{if $clr.cl_status} cl_{$clr.cl_status}{/if}{if $clr.PayTimeLimit} cl_overdue{/if}{if $clr.AccessPay} cl_accesspay{/if}"
        id="cl_{$clr.Inc}"
        data-claim="{$clr.Inc}"
        data-status="{$clr.Status}"
        data-printdocument="{$clr.CanPrintDocument}"
        data-payment="{if $clr.Status == 1}1{else}0{/if}"
        data-partpayment="{$clr.Partpayment}"
        data-confirmed="{$clr.Confirmed}"
        data-request-cancel-date = "{$clr.RequestCancelDate|date_format:'sql'}"
        data-checkin="{$clr.DateBeg|date_format:'sql'}"
        data-checkout="{$clr.DateEnd|date_format:'sql'}"
        data-phys-byer="{$phys_byer}"
        data-anketa="{$clr.Anketa}"
        data-visast_www="{$clr.Visast_www}"
    >
        <thead>
            <tr>
                <th width="20%"><span class="claim">{$clr.Inc}</span>&nbsp; ##CL_R_FROM## {$clr.CDate}</th>
                <th width="32%">##CL_R_RES_TOUR##<br>##CL_R_RES_SPOG##</th>
                <th width="12%">##CL_R_RES_BEGIN##<br>##CL_R_RES_END##</th>
                <th width="12%">##CL_R_RES_STATUS##</th>
                <th width="12%">##CL_R_RES_PREPAYMENT##<br>##CL_R_RES_FULL_PAYMENT##</th>
                <th width="12%">##CL_R_RES_IDATE##</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="num">
                    <span class="claim-status" {if $clr.cl_status == 'hold'}data-title="{$clr.HoldStatus.hint}: {$clr.HoldStatus.hold_sum} {$clr.HoldStatus.hold_currency}"{/if} >
                    {if $clr.cl_status == 'paid' || $clr.cl_status == 'penaltypaid'}
                        ##CL_R_RES_PAID##
                    {elseif $clr.cl_status == 'partpaid' || $clr.cl_status == 'penaltypart'}
                        ##CL_R_RES_PARTPAID##
                    {elseif $clr.cl_status == 'unpaid'}
                        ##CL_R_RES_UNPAID##
                    {elseif $clr.cl_status == 'cancel'}
                        ##CL_R_RES_CANCELED##
                    {elseif $clr.cl_status == 'penalty'}
                        ##CL_R_RES_PENALTY##
                    {elseif $clr.cl_status == 'calc'}
                        ##CL_R_RES_CALC##
                        {if $clr.CalculatedClaimEnable}
                            <span class="right">
                                    <button class="preorder-btn ClaimConfirmPreOrder">##CLAIM_CONFIRM_PREORDER_CHECK##</button>
                                </span>
                        {/if}
                    {elseif $clr.cl_status == 'hold'}
                        {$clr.HoldStatus.status_name}
                    {/if}
                    </span>
                </td>
                <td>{$clr.TourLName|linkify:$clr.TourUrl}<br>{$clr.SpoFullNumber} {if $clr.SpoRqDateEnd->not_null()}##SPOG_UNTIL## {$clr.SpoRqDateEnd}{/if}</td>
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
                </td>
                <td {if $clr.ICancel == 1}class="line_through"{/if}>{$clr.IDate}<br>{if $clr.InvoiceNumber != ''}¹{$clr.InvoiceNumber}{/if}</td>
            </tr>
            <tr>
                <td class="cl_alink">
                    {if $routes.messages_person && $smarty.session.samo_auth.Person}
                        {if $clr.msg_exists}
                            <span class="link msg{if $clr.msg_unread} msg_unread{/if}">##MSG_SHOW##</span>
                        {else}
                            <span class="link msg-new">##MSG_CREATE##</span>
                        {/if}
                    {/if}
                    {if $clr.Status != 3 && $clr.Status != 5}
                        {if isset($clr.cost)}
                            <fieldset class="cost">
                                <legend>##CL_R_GROUP_COST##</legend>
                                <ul>
                                    {$clrCost = $clr.cost.1}
                                    <table class="res">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>{$clrCost.rate_dateex}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {if $clrCost.Debt_person != 0}
                                            <tr>
                                                <td>##CL_R_COST_AMOUNT##</td>
                                                <td>{$clrCost.Amount_to_pay_person} {$clrCost.CurrencyAlias}</td>
                                            </tr>
                                        {/if}
                                        <tr>
                                            <td>##CL_R_COST_PAID##</td>
                                            <td>{$clrCost.Paid} {$clrCost.CurrencyAlias}</td>
                                        </tr>
                                        {if $clrCost.Debt_person != 0}
                                            <tr>
                                                <td>{if $clrCost.Debt_person >=0}
                                                        <span class="red">##CL_REFER_DEBT##</span>
                                                    {elseif $clrCost.Debt_person <0}
                                                        <span class="green">##CL_REFER_PAYBACK##</span>
                                                    {else}##CL_R_COST_TO_PAY##{/if}</td>
                                                <td>{$clrCost.Debt_person} {$clrCost.CurrencyAlias}</td>
                                            </tr>
                                        {/if}
                                        </tbody>
                                    </table>
                                </ul>
                            </fieldset>
                        {else}
                            <span class="link cost" id="cost_{$clr.Inc}">##CL_R_GROUP_COST##</span>
                        {/if}
                    {/if}
                    {if $clr.AccessPay && $clr.Status != Samo_Claim::STATUS_PAID && $clr.pay_variants}
                        <fieldset class="pay_variants">
                            <legend>##CL_R_GROUP_PAY_VARIANTS##</legend>
                        <ul>
                            {foreach from=$clr.pay_variants item="variant"}
                                {if $variant.link}
                                    <li class="{$variant.name}">{$variant.link_title|default:$variant.title|linkify:$variant.link:'_blank':'custom link'}</li>
                                {else}
                                    {if $variant.name == 'invoice'}
                                        <li><a id="invoice_{$clr.Inc}" class="link invoice{if $invoice.external} external{/if}" href="{$invoice.link}" target="_blank">{$variant.link_title|default:$variant.title}</a></li>
                                    {else}
                                        <li><span id="v_{$variant.name}_{$clr.Inc}" class="link {$variant.name}">{$variant.link_title|default:$variant.title}</span><li>
                                    {/if}
                                {/if}
                            {/foreach}
                        </ul>
                        </fieldset>
                    {/if}
                    <fieldset class="documents">
                        <legend>##CL_R_GROUP_DOCUMENTS##</legend>
                        <ul>
                            <li><span class="link e_doc">##CL_R_E_DOC##</span></li>
                            {if $CONTRACT}
                                <li><a class="link agreement external" href="{Samo_Url::route('cl_refer_person', ['samo_action' => 'contract', 'CLAIM' => $clr.Inc])}" target="_blank">##CL_R_P_AGREEMENT_PRINT##</a></li>
                            {/if}
                        </ul>
                    </fieldset>
                    {if $clr.Status != 3 && $clr.Status != 4 && $clr.Status != 5 && $clr.Status != 7}
                        {if $routes.cancel_claim && $clr.RequestCancelDate->is_null() && $clr.DateBeg->gte()}
                            <fieldset>
                                <ul>
                                    <li><span class="link cancel_claim">{$routes.cancel_claim.title}</span></li>
                                </ul>
                            </fieldset>
                        {/if}
                    {/if}
                </td>
                <td colspan="5" id="orders_{$clr.Inc}" class="orders">
                    {if $clr.PartnerComment}
                        <div class="partnercomment">{$clr.PartnerComment}</div>
                    {/if}
                    {if !$clr.orders}
                        <div class="toggle_orders">##CL_R_RES_A_SHOW_ORDERS##<br></div>
                    {/if}
                    <div class="orders" {if $clr.orders}style="display: block"{/if}>
                        {if $clr.orders}{include file="orders.tpl" hotels=$clr.orders.hotels freights=$clr.orders.freights services=$clr.orders.services insures=$clr.orders.insures visas=$clr.orders.visas peoples=$clr.orders.peoples}{/if}

                        {if $phys_byer}
                            <table class="tbl_phys_byer">
                                <thead>
                                <tr>
                                    <th>##CL_R_P_BUYER_INFO##</th>
                                    <th>##PHONE##</th>
                                    <th>##EMAIL##</th>
                                    <th>&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="fio">{$phys_byer.NAME}</td>
                                    <td class="mobile">{$phys_byer.MOBILE}</td>
                                    <td class="email">{$phys_byer.EMAIL}</td>
                                    <td class="link phys_byer ns">##CL_R_P_EDIT##</td>
                                </tr>
                                </tbody>
                            </table>

                        {/if}

                    </div>
                </td>
            </tr>
        </tbody>
    </table>
{else}
    ##CL_R_P_CLAIM_NOT_FOUND##
{/if}
