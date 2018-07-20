{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="cl_refer_person.css,psbank.css"}
{include file="../partial_top.tpl"}
<div id="cl_refer" class="cl_refer_person">
    {if $payment_wait}
        {note page="cl_refer_person_payment_wait"}
    {elseif $payment_error}
        {note page="cl_refer_person_payment_error"}
    {else}
        {note page="cl_refer_person"}
        {if $BONIS_INFO && count($BONIS_INFO) > 0}
            <br>
            <div class="bonus_info">
                {foreach from=$BONIS_INFO item="manager"}
                    <br>
                    <fieldset class="panel">
                        <legend>##CL_R_P_BONUS##</legend>
                        <br>
                        <table class="res" id="bonus_manager_currency">
                            <thead>
                            <tr>
                                <th>##CL_R_P_BONUS_MANAGER_CURRENCY##</th>
                                <th>##CL_R_P_BONUS_MANAGER_ADD##</th>
                                <th>##CL_R_P_BONUS_MANAGER_DELETE##</th>
                                <th>##CL_R_P_BONUS_MANAGER_TOTAL##</th>
                            </tr>
                            </thead>
                            {cycle values="even,odd" reset=true print=false advance=false}
                            {foreach from=$manager.currency item="currency"}
                                <tr class="{cycle values="even,odd"}">
                                    <td>{$currency.total.alias}</td>
                                    <td>{$currency.add.value}</td>
                                    <td>{$currency.delete.value}</td>
                                    <td>{$currency.total.value}</td>
                                </tr>
                            {/foreach}
                        </table>
                        <br>
                        <table class="res" id="bonus_manager_detail">
                            <thead>
                            <tr>
                                <th>##CL_R_P_BONUS_MANAGER_DATE##</th>
                                <th>##CL_R_P_BONUS_MANAGER_TYPE##</th>
                                <th>##CL_R_P_BONUS_MANAGER_CLAIM##</th>
                                <th>##CL_R_P_BONUS_MANAGER_BONUS##</th>
                            </tr>
                            </thead>
                            {cycle values="even,odd" reset=true print=false advance=false}
                            {foreach from=$manager.detail item="item"}
                                <tr class="{cycle values="even,odd"}">
                                    <td>{$item.issue|date_format:"datetime"}</td>
                                    <td>{if $item.type == 1}##CL_R_P_BONUS_MANAGER_IN##{elseif $item.type == 2}##CL_R_P_BONUS_MANAGER_OUT##{else}##CL_R_P_BONUS_MANAGER_UNKNOWN##{/if}</td>
                                    <td>
                                        {if $item.allow_show}
                                            <a href="{$routes.cl_refer_person.url}CLAIM={$item.claim}" data-claim="{$item.claim}" class="claiminfo">{$item.claim}</a>
                                        {else}
                                            {$item.claim}
                                        {/if}
                                    </td>
                                    <td>{$item.value}&nbsp;{$row.currency_alias}</td>
                                </tr>
                            {/foreach}
                        </table>
                    </fieldset>
                    <br>
                {/foreach}
            </div>
        {/if}
        {if $claimList && count($claimList) > 1}
            <div class="controls panel">
                <table class="std n1">
                    <tr>
                        <th>##CLAIM_NUMBER##</th>
                        <td>
                            <form method="GET">
                                {if !$smarty.const.FRIENDLY_URLS}
                                    <input type="hidden" name="page" value="cl_refer_person">
                                {/if}
                                <select name="CLAIM" class="CLAIM" data-placeholder="##MSG_CLAIM##" onchange="submit()">
                                    {foreach from=$claimList item="item"}
                                        <option value="{$item.id}" {if $item.selected}selected="selected"{/if}>{$item.name}</option>
                                    {/foreach}
                                </select>
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
        {/if}
        <div class="resultset" id="cl_refer_person">
            {include file="resultset.tpl" clr=$result}
        </div>
    {/if}
</div>
{include file="../common.tpl"}
{jsload file="cl_refer_person.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}