<div id="edit_order" data-order-type="{$ORDER_TYPE}" data-order="{$ORDER_INC}" data-pcount="1">
    <div class="order">
        <fieldset class="panel">
{if $load == 'H'}
            <legend>##CL_W_ORDER_HOTEL_INFO##</legend>

           <table width="100%">
               <tr>
                   <td width="120" height="30"><label class="required">##CL_W_ORDER_DATEBEG##</label></td>
                   <td><input type="text" class="frm-input date" name="ORDER_DATEBEG" id="ORDER_DATEBEG" data-old="{$ORDER_DATEBEG}" {datepicker_init direction=true validDates=$DATE_BEG_VALIDDATES startDate=$ORDER_STARTDATE value=$ORDER_DATEBEG endDate=$ORDER_ENDDATE}></td>
               </tr>

               <tr>
                   <td><label class="required">##CL_W_ORDER_DATEEND##</label></td>
                   <td><input type="text" class="frm-input date" name="ORDER_DATEEND" id="ORDER_DATEEND" data-old="{$ORDER_DATEEND}" {datepicker_init direction=true validDates=$DATE_END_VALIDDATES startDate=$ORDER_STARTDATE value=$ORDER_DATEEND endDate=$ORDER_ENDDATE}></td>
               </tr>

               <tr>
                   <td height="30"><label class="required">##CL_W_ORDER_HOTEL##</label></td>
                   <td>
                        <select name="ORDER_HOTELINC" id="ORDER_HOTELINC">
                            {foreach from=$OrderInfo.Hotel item="hotel"}
                                <option value="{$hotel.Inc}" {if $hotel.selected}selected{/if} data-townname="{$hotel.TownLName}">{$hotel.LName}{if $hotel.TownLName}({$hotel.TownLName}){/if}</option>
                            {/foreach}
                        </select>
                   </td>
               </tr>

               <tr>
                   <td height="30"> <label class="required">##CL_W_ORDER_ROOM##</label></td>
                   <td>
                       <select name="ORDER_ROOMINC" id="ORDER_ROOMINC">
                           {foreach from=$OrderInfo.Room item="room"}
                               <option value="{$room.Inc}" {if $room.selected}selected{/if}>{$room.LName}</option>
                           {/foreach}
                       </select>
                   </td>
               </tr>

               <tr>
                   <td height="30"><label class="required">##CL_W_ORDER_HTPLACE##</label></td>
                   <td>
                        <select name="ORDER_HTPLACEINC" id="ORDER_HTPLACEINC">
                            {foreach from=$OrderInfo.HtPlace item="htplace"}
                                <option value="{$htplace.Inc}" {if $htplace.selected}selected{/if}>{$htplace.LName}</option>
                            {/foreach}
                        </select>
                   </td>
               </tr>

               <tr>
                   <td height="30"><label class="required">##CL_W_ORDER_MEAL##</label></td>
                   <td>
                       <select name="ORDER_MEALINC" id="ORDER_MEALINC">
                           {foreach from=$OrderInfo.Meal item="meal"}
                               <option value="{$meal.Inc}" {if $meal.selected}selected{/if}>{$meal.LName}</option>
                           {/foreach}
                       </select>
                   </td>
               </tr>

               <tr>
                   <td height="30"><label class="required">##CL_W_ORDER_ROOMCOUNT##</label></td>
                   <td>
                       <select name="ORDER_COUNT" id="ORDER_COUNT" data-old="0">
                           {section start=1 loop=11 name="cnt"}<option  value="{$smarty.section.cnt.index}">{$smarty.section.cnt.index}</option>{/section}
                       </select>
                   </td>
               </tr>

               <tr>
                   <td colspan="2"></td>
               </tr>
           </table>
        </fieldset>
{/if}
{if $load == 'F'}

<legend>##CL_W_ORDER_FREIGHT_INFO##</legend>

<table width="100%">
    <tr>
        <td height="30" width="120"><label class="required">##CL_W_ORDER_DATE##</label></td>
        <td><input type="text" class="frm-input date" name="ORDER_DATEBEG" id="ORDER_DATEBEG" data-old="{$ORDER_DATEBEG}" {datepicker_init startDate=$ORDER_STARTDATE value=$ORDER_DATEBEG endDate=$ORDER_ENDDATE}></td>
    </tr>

    <tr>
        <td height="30"><label class="required">##CL_W_ORDER_TOWNFROM##</label></td>
        <td>
            <select name="ORDER_TOWNFROM" id="ORDER_TOWNFROM">
                {foreach from=$OrderInfo.TownFrom item="townfrom"}
                    <option value="{$townfrom.Inc}" {if $townfrom.selected}selected{/if}>{$townfrom.LName}</option>
                {/foreach}
            </select>
        </td>
    </tr>

    <tr>
        <td height="30"><label class="required">##CL_W_ORDER_TOWNTO##</label></td>
        <td>
            <select name="ORDER_TOWNTO" id="ORDER_TOWNTO">
                {foreach from=$OrderInfo.TownTo item="townto"}
                    <option value="{$townto.Inc}" {if $townto.selected}selected{/if}>{$townto.LName}</option>
                {/foreach}
            </select>
        </td>
    </tr>

    <tr>
        <td height="30"><label class="required">##CL_W_ORDER_CLASS##</label></td>
        <td>
            <select name="ORDER_CLASSINC" id="ORDER_CLASSINC">
                {foreach from=$OrderInfo.Class item="class"}
                    <option value="{$class.Inc}" {if $class.selected}selected{/if}>{$class.LName}</option>
                {/foreach}
            </select>
        </td>
    </tr>

    <tr>
        <td height="30"><label class="required">##CL_W_ORDER_FRPLACE##</label></td>
        <td>
            <select name="ORDER_FRPLACEINC" id="ORDER_FRPLACEINC">
                {foreach from=$OrderInfo.FrPlace item="frplace"}
                    <option value="{$frplace.Inc}" {if $frplace.selected}selected{/if}>{$frplace.LName}</option>
                {/foreach}
            </select>
        </td>
    </tr>

    <tr>
        <td height="30"><label class="required">##CL_W_ORDER_FREIGHT##</label></td>
        <td>
            <select name="ORDER_FREIGHTINC" id="ORDER_FREIGHTINC">
                <option value="0">----</option>
                {foreach from=$OrderInfo.Freight item="freight"}
                    <option value="{$freight.Inc}" {if $freight.selected}selected{/if} data-srcport="{$freight.SrcPort}" data-src_time="{$freight.SrcTime}" data-trg_port="{$freight.TrgPort}" data-trg_time="{$freight.TrgTime}" data-freight_name="{$freight.LName}" data-tpartner_name="{$freight.PartnerLName}" data-days="{$freight.days}">{$freight.LName} {if $freight.Inc > 0}({$freight.SrcPort} {$freight.SrcTime}) --> ({$freight.TrgPort} {$freight.TrgTime}) {$freight.PartnerLName} {$freight.realcount}{/if}</option>
                {/foreach}
            </select>
        </td>
    </tr>

    <tr>
        <td height="30"><label class="required">##CL_W_ORDER_CLASSCOUNT##</label></td>
        <td>
            <select name="ORDER_COUNT" id="ORDER_COUNT">
                {section start=1 loop=21 name="cnt"}<option  value="{$smarty.section.cnt.index}">{$smarty.section.cnt.index}</option>{/section}
            </select>
        </td>
    </tr>
</table>
        </fieldset>
{/if}
{if $load == 'S'}
            <legend>##CL_W_ORDER_SERVICE_INFO##</legend>

    <table width="100%">
        <tr>
            <td height="30"><label class="required">##CL_W_ORDER_S_DATEBEG##</label></td>
            <td><input type="text" class="frm-input date" name="ORDER_DATEBEG" id="ORDER_DATEBEG" data-old="{$ORDER_DATEBEG}" {datepicker_init direction=true validDates=$DATE_BEG_VALIDDATES startDate=$ORDER_STARTDATE value=$ORDER_DATEBEG endDate=$ORDER_ENDDATE}></td>
        </tr>

        <tr>
            <td height="30"><label class="required">##CL_W_ORDER_SERVICE##</label></td>
            <td>
                <select name="ORDER_SERVICEINC" id="ORDER_SERVICEINC">
                    <option value="0">----</option>
                    {foreach from=$OrderInfo.Service item="service"}
                        <option value="{$service.Inc}" {if $service.selected}selected{/if}  data-trantype-name="{$service.TrantypeLName}" data-service-name="{$service.LName}" data-servtype-name="{$service.ServTypeLName}" data-servtype="{$service.ServTypeInc}" data-servcategory="{$service.ServCategoryInc}" data-routeindex="{$service.RouteIndex}">{if $service.Inc > 0}{$service.ServTypeLName}: {/if}{$service.LName}{if $service.Inc > 0} {if $service.TrantypeLName != ''} {$service.TrantypeLName}{/if}{/if}</option>
                    {/foreach}
                </select>
            </td>
        </tr>

        <tr>
            <td height="30"><label class="required">##CL_W_ORDER_TOWNFROM_SERVICE##</label></td>
            <td>
                <select class="string" name="ORDER_TOWNS_SERVICE" id="ORDER_TOWNS_SERVICE">
                {include file="3_controls.tpl" OrderInfo=$OrderInfo load='ORDER_TOWNS_SERVICE_OPTION'}
                </select>
            </td>
        </tr>

        <tr>
            <td height="30"><label class="required">##CL_W_ORDER_HOTEL_SERVICE##</label></td>
            <td>
                <select name="ORDER_HOTEL_SERVICE" id="ORDER_HOTEL_SERVICE">
                {include file="3_controls.tpl" OrderInfo=$OrderInfo load='ORDER_HOTEL_SERVICE_OPTION'}
                </select>
            </td>
        </tr>

        <tr>
            <td height="30"> <label class="required">##CL_W_ORDER_SERVICECOUNT##</label></td>
            <td>
                <select name="ORDER_COUNT" id="ORDER_COUNT">
                    {section start=1 loop=21 name="cnt"}<option  value="{$smarty.section.cnt.index}">{$smarty.section.cnt.index}</option>{/section}
                </select>
            </td>
        </tr>
    </table>
        </fieldset>
{/if}
{if $load == 'I'}

<legend>##CL_W_ORDER_INSURE_INFO##</legend>
    <table width="100%">
        <tr>
            <td height="30"><label class="required">##CL_W_ORDER_I_DATEBEG##</label></td>
            <td><input type="text" class="frm-input date" name="ORDER_DATEBEG" id="ORDER_DATEBEG" data-old="{$ORDER_DATEBEG}" {datepicker_init startDate=$ORDER_STARTDATE value=$ORDER_DATEBEG endDate=$ORDER_ENDDATE}></td>
        </tr>

        <tr>
            <td height="30"><label class="required">##CL_W_ORDER_I_DATEEND##</label></td>
            <td><input type="text" class="frm-input date" name="ORDER_DATEEND" id="ORDER_DATEEND" data-old="{$ORDER_DATEEND}" {datepicker_init startDate=$ORDER_STARTDATE value=$ORDER_DATEEND endDate=$ORDER_ENDDATE}></td>
        </tr>

        <tr>
            <td height="30"> <label class="required">##CL_W_ORDER_INSURE##</label></td>
            <td>
                <select name="ORDER_INSUREINC" id="ORDER_INSUREINC">
                    <option value="0">----</option>
                    {foreach from=$OrderInfo.Insure item="insure"}
                        <option value="{$insure.Inc}" {if $insure.selected}selected{/if} data-insure-name="{$insure.LName}" data-partner-name="{$insure.PartnerLName}" data-state-name="{$insure.StateLName}" data-state="{$insure.StateInc}">{$insure.StateLName}: {$insure.LName} ({$insure.PartnerLName})</option>
                    {/foreach}
                </select>
            </td>
        </tr>

        <tr>
            <td height="30"><label class="required">##CL_W_ORDER_INSURECOUNT##</label></td>
            <td>
                <select name="ORDER_COUNT" id="ORDER_COUNT">
                    {section start=1 loop=21 name="cnt"}<option  value="{$smarty.section.cnt.index}">{$smarty.section.cnt.index}</option>{/section}
                </select>
            </td>
        </tr>
    </table>



            <div class="row">


            </div>
            <div class="row">


            </div>
            <div class="row">


            </div>
            <div class="row">


            </div>
        </fieldset>
{/if}
{if $load == 'V'}
<legend>##CL_W_ORDER_VISA_INFO##</legend>
    <table width="100%">
        <tr>
            <td height="30"><label class="required">##CL_W_ORDER_V_DATEBEG##</label></td>
            <td><input type="text" class="frm-input date" name="ORDER_DATEBEG" id="ORDER_DATEBEG" data-old="{$ORDER_DATEBEG}" {datepicker_init startDate=$ORDER_STARTDATE value=$ORDER_DATEBEG endDate=$ORDER_ENDDATE}></td>
        </tr>

        <tr>
            <td height="30"><label class="required">##CL_W_ORDER_V_DATEEND##</label></td>
            <td><input type="text" class="frm-input date" name="ORDER_DATEEND" id="ORDER_DATEEND" data-old="{$ORDER_DATEEND}" {datepicker_init startDate=$ORDER_STARTDATE value=$ORDER_DATEEND endDate=$ORDER_ENDDATE}></td>
        </tr>

        <tr>
            <td height="30"><label class="required">##CL_W_ORDER_VISA##</label></td>
            <td>
                <select name="ORDER_VISAINC" id="ORDER_VISAINC">
                    <option value="0">----</option>
                    {foreach from=$OrderInfo.Visa item="visa"}
                        <option value="{$visa.Inc}" {if $visa.selected}selected{/if} data-days="{$visa.Days}" data-state-name="{$visa.StateLName}" data-visa-name="{$visa.LName}">{$visa.StateLName}: {$visa.LName} ({$visa.Days})</option>
                    {/foreach}
                </select>
            </td>
        </tr>

        <tr>
            <td height="30"><label class="required">##CL_W_ORDER_VISACOUNT##</label></td>
            <td>
                <select name="ORDER_COUNT" id="ORDER_COUNT">
                    {section start=1 loop=21 name="cnt"}<option  value="{$smarty.section.cnt.index}">{$smarty.section.cnt.index}</option>{/section}
                </select>
            </td>
        </tr>
    </table>
</fieldset>
{/if}
        <div id="FIELDSET_OPEOPLE" style="display: none;">
            <fieldset class="panel">
                <legend>##CL_W_ORDER_OPEOPLE_INFO##</legend>
                {if $load == 'H' || $load == 'S' || $load == 'F'}
                    <div class="row">
                        <label class="addinfant">##CL_W_ORDER_ADD_INFANT##</label>
                        <input type="checkbox" name="ORDER_ADD_INFANT" id="ORDER_ADD_INFANT">
                    </div>
                    <div class="eraser"/>
                {/if}
                <div id="OPEOPLES">
                    <div id="ALL_PEOPLE_DIV"><select size="6" id="ORDER_ALL_TOURIST" /></div>
                    <div id="OPEOPLE" />
                </div>
            </fieldset>
        </div>
    </div>
    <button class="load">##CL_W_BTN_SAVE##</button>
</div>