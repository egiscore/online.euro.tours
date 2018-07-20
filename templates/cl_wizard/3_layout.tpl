{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="cl_wizard.css"}
{include file="../partial_top.tpl"}
<div id="cl_wizard">
{if $step == 1}
    {note}
    <table class="std container panel top_menu">
        <tr>
            <td width="33%" class="bold">##CL_W_STEP1##</td>
            <td width="34%">##CL_W_STEP2##</td>
            <td width="33%">##CL_W_STEP3##</td>
        </tr>
        <tr>
            <td colspan="3"><input type="button" class="button" id="NEWCLAIM" value="##CL_W_NEW_CLAIM##"></td>
        </tr>
    </table>
    <table class="std container who_where">
        <tr>
            <td>
                <table class="panel">
                    <tr class="td_panel">
                        <td width="10%">##CL_W_TOWNFROM##</td>
                        <td width="20%"><select id="TOWNFROM" name="TOWNFROM" class="TOWNFROM">{foreach from=$TOWNFROM item="item"}<option value="{$item.Inc}" {if $item.selected}selected{/if}>{$item.LName}</option>{/foreach}</select></td>
                        <td width="10%">##CL_W_STATE##</td>
                        <td width="20%"><select id="STATE" name="STATE" class="STATEINC">{foreach from=$STATE item="item"}<option value="{$item.Inc}" {if $item.selected}selected{/if}>{$item.LName}</option>{/foreach}</select></td>
                        <td width="10%">##CL_W_TOUR##</td>
                        <td width="30%"><select id="TOURINC" name="TOURINC" class="TOURINC">{foreach from=$TOURINC item="item"}<option value="{$item.Inc}" {if $item.selected}selected{/if}>{$item.LName}</option>{/foreach}</select></td>
                    </tr>
                    <tr class="td_panel">
                        <td colspan="6">
                            <table align="center">
                                <tr>
                                    <td>##CL_W_DATEBEG##</td>
                                    <td><input type="text" class="frm-input date DATE_BEG" id="DATE_BEG" name="DATE_BEG" data-old="{$DATE_BEG}" {datepicker_init direction=true validDates=$DATE_BEG_VALIDDATES value=$DATE_BEG}></td>
                                    <td>##CL_W_DATEEND##</td>
                                    <td><input type="text" class="frm-input date DATE_END" id="DATE_END" name="DATE_END" data-old="{$DATE_END}" {datepicker_init direction=true validDates=$DATE_END_VALIDDATES value=$DATE_END}></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td>
                <div class="title_left">##CL_W_TOURISTS##</div>
                <div class="eraser"></div>
                <table class="res">
                    <thead>
                        <tr>
                            <th width="3%">##CL_W_TOURIST_NUMBER##</th>
                            <th width="7%">##CL_W_TOURIST_HUMAN##</th>
                            <th>##CL_W_TOURIST_NAME##</th>
                            <th>##CL_W_TOURIST_BIRTHDAY##</th>
                            <th>##CL_W_TOURIST_PASSPORT##</th>
                            <th width="10%" class="r"></th>
                        </tr>
                    </thead>
                    <tbody id="ALL_TOURIST">
                    {if $Tourist}
                        {include file="table_tourist.tpl"}
                    {/if}
                    </tbody>
                    <tr><td colspan="8" class="c"><input type="button" class="button" id="ADD_TOURIST_BUTTON" value="##CL_W_ADD_TOURIST_BTN##"></td></tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="c">
                {if $warning_stop}
                    <div id="TOURIST_WARNING">{include file="warning.tpl"}</div>
                {else}
                    <div id="TOURIST_WARNING" style="display: none;">&nbsp;</div>
                {/if}
                <br>
                <input type="button" class="button" id="NEXT" value="##CL_W_NEXT_BTN##">
            </td>
        </tr>
    </table>
{elseif $step == 2}
    <table class="std container panel top_menu">
        <tr>
            <td width="33%">##CL_W_STEP1##</td>
            <td width="34%" class="bold">##CL_W_STEP2##</td>
            <td width="33%">##CL_W_STEP3##</td>
        </tr>
    </table>
    
    <div id="BUTTONS"></div>
    <div>
        <br>
        <div class="title_left">##CL_W_ORDERS##</div>
        <table class="std container orders">
            <tr>
                <td>
                    <div class="eraser"></div>
                    <table class="res">
                        <thead>
                            <tr>
                                <th width="10%">##CL_W_ORDER_NUMBER##</th>
                                <th>##CL_W_ORDER_NAME##</th>
                                <th>##CL_W_ORDER_TOURIST##</th>
                                <th width="10%" class="r"></th>
                            </tr>
                        </thead>
                        <tbody id="ALL_ORDER"></tbody>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div id="CLAIMPRICE" class="d_none">?????</div>
    <div class="c">
        <br>
        <br>
        <input type="button" class="button" id="BACK" value="##CL_W_BACK_BTN##">
        <input type="button" class="button" id="NEXT" value="##CL_W_NEXT_BTN##">
    </div>
{elseif $step == 3}
    <table class="std container">
    <tr>
        <td>
            <table class="std container panel top_menu">
                <tr>
                    <td width="33%">##CL_W_STEP1##</td>
                    <td width="34%">##CL_W_STEP2##</td>
                    <td width="33%" class="bold">##CL_W_STEP3##</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <div id="ORDER_WARNING_STOP" style="display: none;">##CL_W_ORDER_ERROR##</div>
            <fieldset class="panel" id="FIELDSET_NOTE">
                <legend>##CL_W_NOTECLAIM##</legend>
                <textarea id="NOTECLAIM" name="NOTECLAIM">{$NOTECLAIM}</textarea>
            </fieldset>
            <div id="ORDER_WARNING" style="display: none;">##CL_W_ORDER_WARNING##</div>
            <div class="c">
                <br>
                <br>
                <input type="button" class="button" id="BACK" value="##CL_W_BACK_BTN##">
                <input type="button" class="button" id="NEXT" value="##CL_W_NEXT_BTN##">
            </div>
        </td>
    </tr>
    </table>
{else}
    ##NO_DATA##
{/if}
</div>
{include file="../common.tpl"}
{jsload file="cl_wizard.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}