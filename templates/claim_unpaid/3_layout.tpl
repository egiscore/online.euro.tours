{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="claim_unpaid.css,psbank.css"}
{include file="../partial_top.tpl"}
{note}
<div id="claim_unpaid">
    <div class="controls container">
        {include file="../controls.tpl" control="SEARCHMODE" SEARCHMODE=$PERSONAL_AREA}
        <form method="get">
            {if !$smarty.const.FRIENDLY_URLS}
                <input type="hidden" name="page" value="claim_unpaid" />
            {/if}
            <table class="std panel">
                <tr>
                    <td class="left_side">
                        <table>
                            <tr>
                                <td>
                                    <table>
                                        <tr>
                                            <td class="label_filter">##CLAIM_COMISSION##</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select name="EARLYCOMISSION" class="EARLYCOMISSION">
                                                    <option value="0">
                                                        ---
                                                    </option>
                                                    <option value="1" {if $EARLYCOMISSION} selected{/if}>
                                                        ##CLAIM_EARLY##
                                                    </option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <table>
                                        <tr>
                                            <td class="label_filter">##CLAIM_PAYMENT##</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select name="NEARFUTURE" class="NEARFUTURE">
                                                    <option value="0">
                                                        ---
                                                    </option>
                                                    <option value="1"{if $NEARFUTURE} selected{/if}>
                                                        ##CLAIM_NEARFUTURE##
                                                    </option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="cl_refer_btn">
                                    <button type="submit" class="load" disabled="disabled">##CL_R_FILTER_BTN_SHOW##</button>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </div>
{if $claims && $SHOW_RESULT}
    <table class="std res">
        <thead>
        <tr>
            <th>##CLAIM_UNPAID_CLAIM_NUMBER##</th>
            <th>##CLAIM_UNPAID_CLAIM_STATUS##</th>
            <th>##CLAIM_UNPAID_CHECKIN##</th>
            <th>##CLAIM_UNPAID_COST##</th>
            <th>##CLAIM_UNPAID_DEBT##</th>
            <th>##CLAIM_UNPAID_PARTPAY##<br>##CLAIM_UNPAID_FULLPAY##</th>
            <th>##CLAIM_EARLYCOMISSION##</th>
            <th>##CLAIM_LAST_MTYPE##</th>
            <th>##CLAIM_NEXT_PDATE##</th>
            <th>##CLAIM_NEXT_PSUM##</th>
            <th class="invoice">##CLAIM_UNPAID_PAYMENT_CAPTION##</th>
        </tr>
        </thead>
        <tbody id="claims">
        {foreach from=$claims item="claim" name="claims"}
            <tr class="{cycle values="even,odd"}"
                data-claim="{$claim.Claim}"
                data-tour-amount="{$claim.Amount}"
                data-tour-debt="{$claim.Debt}"
                data-tour-currency="{$claim.CurrencyAlias}"
                data-invoice-amount="{$claim.InvoiceAmount}"
                data-invoice-currency="{$claim.InvoiceCurrencyAlias}"
                data-invoice-debt="{$claim.InvoiceDebt}"
                data-invoice-debt-now="{$claim.InvoiceDebt_now}"
            >
                <td><a href="{$routes.cl_refer.url}CLAIM={$claim.Claim}" data-claim="{$claim.Claim}"
                       class="claiminfo">{$claim.Claim}</a></td>
                <td>{include file="../claim_status.tpl" claim=$claim}</td>
                <td>{$claim.DateBeg}</td>
                <td>
                    {if $claim.Amount_now}{$claim.Amount_now} {$claim.CurrencyAlias}<br>{/if}
                    {$claim.InvoiceAmount_now} {$claim.InvoiceCurrencyAlias}
                    (##CLAIM_UNPAID_ON_DATE## {$claim.rate_dateex_now})<br>
                    {if $claim.rate_dateex->not_null()}{$claim.InvoiceAmount} {$claim.InvoiceCurrencyAlias} (##CLAIM_UNPAID_ON_DATE## {$claim.rate_dateex}){/if}
                </td>
                <td class="debt">
                    {if $claim.Debt_now}{$claim.Debt_now} {$claim.CurrencyAlias}<br>{/if}
                    {$claim.InvoiceDebt_now} {$claim.InvoiceCurrencyAlias}
                    (##CLAIM_UNPAID_ON_DATE## {$claim.rate_dateex_now})<br>
                    {if $claim.rate_dateex->not_null()}{$claim.InvoiceDebt} {$claim.InvoiceCurrencyAlias} (##CLAIM_UNPAID_ON_DATE## {$claim.rate_dateex}){/if}
                </td>
                <td class="c">{if $claim.PPDate->not_null()}##CLAIM_UNPAID_UNTIL## {$claim.PPDate}{else}- - - -{/if}
                    <br>{if $claim.PDate->not_null()}##CLAIM_UNPAID_UNTIL## {$claim.PDate}{else}- - - -{/if}</td>
                <td>{$claim.earlycomission}</td>
                <td>{$claim.last_mtype}</td>
                <td>{$claim.next_pdate}</td>
                <td>{if $claim.next_psum}{$claim.next_psum} {$claim.CurrencyAlias}{/if}</td>
                <td>
                    {if $claim.enable_pay && $claim.Owner > 0}
                        <a class="link" href="{$claim.pay_variant_link}" target="_blank">##CLAIM_UNPAID_PAY_ACTION##</a>
                    {else}
                        &nbsp;
                    {/if}
                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>
{elseif $SHOW_RESULT}
    ##NO_DATA##
{/if}
</div>
{include file="../common.tpl"}
{jsload file="claim_unpaid.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}