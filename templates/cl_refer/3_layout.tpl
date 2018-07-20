{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="cl_refer.css,edit_tourist.css"}
{include file="../partial_top.tpl"}
<div id="cl_refer">
    {note}
{*
    <div class="PARTNER">{if $PartnerInfo}{include file="partner_info.tpl"}{else}<span class="link partner_toggle">##PARTNER_INFO_TITLE##</span>{/if}
    </div>
    <br>
*}



    <div class="controls">
        {include file="../controls.tpl" control="SEARCHMODE" SEARCHMODE=$PERSONAL_AREA}
        <table class="std panel">
            <tr>
                <td class="left_side">
                    <table>
                        <tr>
                            <td>
                                <select name="CLAIMTYPE" class="CLAIMTYPE controllers">
                                    <option value="1" {if $smarty.get.CLAIM}selected="selected"{/if}>
                                        ##CL_R_FILTER_ALL##
                                    </option>
                                    <option value="2" {if !isset($smarty.get.CLAIM)}selected="selected"{/if}>
                                        ##CL_R_FILTER_ACTUAL##
                                    </option>
                                    <option value="3">##CL_R_FILTER_NOT_CONFIRMED##</option>
                                    <option value="4">##CL_R__SHOW_CALC_RES##</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label_filter">##CL_R_PAYTYPE##</td>
                        </tr>
                        <tr>
                            <td>
                                <select name="PAYTYPE" class="PAYTYPE controllers">
                                    <option value="0" {if $smarty.get.CLAIM}selected="selected"{/if}>---</option>
                                    <option value="1">##CL_R_RES_PAYMENT##</option>
                                    <option value="2">##CL_R_RES_PARTPAYMENT##</option>
                                    <option value="3">##CL_R_RES_NOPAYMENT##</option>
                                    <option value="4">##CL_R_FILTER_PAY_TIME_LIMIT##</option>
                                </select>
                            </td>
                        </tr>
                        {if $PARTNERCLAIM}
                            <tr>
                                <td class="label_filter">##CL_R_PARTNERCLAIM##</td>
                            </tr>
                            <tr>
                                <td>
                                    <select name="PARTNERCLAIM" class="PARTNERCLAIM string controllers"
                                            autocomplete="off">
                                        {foreach from=$PARTNERCLAIM item="partner"}
                                            <option value="{$partner.inc}"
                                                    data-search-string="{$partner.tags|@glue:" "}">{$partner.name}</option>{/foreach}
                                    </select>
                                </td>
                            </tr>
                        {/if}
                        {if $STATECLAIM}
                            <tr>
                                <td class="label_filter">##CL_R_STATECLAIM##</td>
                            </tr>
                            <tr>
                                <td>
                                    <select name="STATECLAIM" class="STATECLAIM string controllers"
                                            autocomplete="off">
                                        {foreach from=$STATECLAIM item="element"}
                                            <option value="{$element.inc}"
                                                    data-search-string="{$element.tags|@glue:" "}">{$element.name}</option>{/foreach}
                                    </select>
                                </td>
                            </tr>
                        {/if}
                        {if $MANAGERCLAIM}
                            <tr>
                                <td class="label_filter">##CL_R_P_MANAGER_AGENCY##</td>
                            </tr>
                            <tr>
                                <td>
                                    <select name="MANAGERCLAIM" class="MANAGERCLAIM string controllers"
                                            autocomplete="off">
                                        {foreach from=$MANAGERCLAIM item="element"}
                                            <option value="{$element.inc}"
                                                    data-search-string="{$element.tags|@glue:" "}">{$element.name}</option>{/foreach}
                                    </select>
                                </td>
                            </tr>
                        {/if}
                    </table>
                </td>

                <td class="right_side">
                    <table>
                        <tr>
                            <td class="r">##CL_R_FILTER_CLAIM_NUMBER##</td>
                            <td><input type="text" class="frm-input element CLAIMBEGIN cl" name="CLAIMBEGIN" size="10"
                                       maxlength="9" value="{$smarty.get.CLAIM|escape:'html'|default:''}"></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td class="r">##CL_R_FILTER_CHECKIN##&nbsp;##CL_R_FILTER_CHECKIN_FROM##</td>
                            <td class="cl"><input type="text" name="CHECKINBEG" class="frm-input date CHECKINBEG"
                                                  size="12" {datepicker_init startDate="-2 month" endDate="+2 year"}>
                            </td>
                            <td>##CL_R_FILTER_CHECKIN_TILL##</td>
                            <td class="cl"><input type="text" name="CHECKINEND" class="frm-input date CHECKINEND"
                                                  size="12" {datepicker_init startDate="-2 month" endDate="+2 year"}>
                            </td>
                        </tr>


                        <tr>
                            <td class="r">##CL_R_FILTER_CDATE##&nbsp;##CL_R_FILTER_CDATE_FROM##</td>
                            <td class="cl"><input type="text" name="CDATEBEG" class="frm-input date CDATEBEG"
                                                  size="12" {datepicker_init startDate="-2 year" endDate='today'} ></td>
                            <td>##CL_R_FILTER_CDATE_TILL##</td>
                            <td class="cl"><input type="text" name="CDATEEND" class="frm-input date CDATEEND"
                                                  size="12" {datepicker_init startDate="-2 year" endDate='today'}></td>
                        </tr>

                        <tr>
                            <td class="r">##CL_R_FILTER_FIO_TOURIST##</td>
                            <td colspan="3"><input type="text" class="frm-input string FIO" name="FIO" size="29"
                                                   maxlength="29" value=""></td>
                        </tr>

                        <tr>
                            <td colspan="4" class="cl_refer_btn">
                                <button class="load" disabled="disabled">##CL_R_FILTER_BTN_SHOW##</button>
                            </td>
                        </tr>


                    </table>
                </td>
            </tr>


        </table>

    </div>
    <div class="resultset">{if $cl_refer}{include file="resultset.tpl"}{/if}</div>
</div>
{include file="../common.tpl"}

{jsload file="cl_refer.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}