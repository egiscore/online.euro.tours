{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="bron_info.css"}
{cssload file="nouislider.css"  base="public/css/bron_info/nouislider/"}
{include file="../partial_top.tpl"}
<div id="bron_info">
    {note}

    <div class="top_container">
        {if $smarty.get.page == 'bron_person' && isset($routes.bron) && !isset($smarty.get.KEY)}
            <div class="button-wrapper">
                <a class="button" href="{Samo_Url::route('bron', $smarty.get)|escape:'html'|replace:'_person':''}">##SAMO_FOR_AGENT##</a>
            </div>
        {/if}
        <div class="claim_info{if $FREIGHTS} ticket{/if}">

            {if $FREIGHTS}
                <input type="hidden" value="{$TOURINFO.TourInc}" class="tour_info" data-checkin="{$TOURINFO.CheckIn}" data-checkout="{$TOURINFO.CheckOut}" data-peoplecount="{$TOURINFO.PeopleCount}" data-ptype="{$TOURINFO.PtInc}" data-tour="{$TOURINFO.TourInc}">
            {else}
                <fieldset class="tour_container panel">
                    <legend>##BRON_TOUR_INFO##</legend>
                    {note page="bron_info_tour"}
                    <div class="TOURINFO">
                        {include file="controls.tpl" load="TOURINFO" TOURINFO=$TOURINFO}
                    </div>
                </fieldset>
            {/if}

            {if $HOTELSINFO}
                <fieldset class="hotels_container panel">
                    <legend>##BRON_HOTELS_INFO##</legend>
                    {note page="bron_info_hotel"}
                    <div class="HOTELSINFO">
                        {include file="controls.tpl" load="HOTELSINFO" HOTELSINFO=$HOTELSINFO}
                    </div>
                </fieldset>
            {/if}

            {if $FREIGHTSINFO || $EXTERNALFREIGHTS}
                <fieldset class="freights_container panel">
                    <legend>##BRON_FREIGHTS_INFO##</legend>
                    {note page="bron_info_freight"}
                    <div class="FREIGHTSINFO">
                    {include file="controls.tpl" load="FREIGHTSINFO" FREIGHTSINFO=$FREIGHTSINFO EXTERNALFREIGHTS=$EXTERNALFREIGHTS}
                    </div>
                    {if $EXTERNALFREIGHTS}
                        <button class="load-external-freights">##BRON_FREIGHTS_LOAD_EXTERNAL##</button>
                    {/if}
                </fieldset>
            {elseif $FREIGHTS}
                <fieldset class="freights_container panel">
                    <legend>##BRON_FREIGHTS_INFO##</legend>
                    {note page="bron_info_freight"}
                    <div class="FREIGHTSINFO">
                        {include file="controls.tpl" load="FREIGHTSINFO" FREIGHTSINFO=$FREIGHTS}
                    </div>
                </fieldset>
            {/if}

            {if !$FREIGHTS}
                <fieldset class="insures_container panel">
                    <legend>##BRON_INSURES_INFO##</legend>
                    {note page="bron_info_insure"}
                    <div class="INSURESINFO">
                        {include file="controls.tpl" load="INSURESINFO" INSURESINFO=$INSURESINFO}
                    </div>
                    <div align="center"><button class="additional_insures">##BRON_INFO_ADD_INSURES##</button></div>
                </fieldset>
            {/if}
            <fieldset class="services_container panel">
                <legend>##BRON_SERVICES_INFO##</legend>
                {note page="bron_info_service"}
                <div class="ASERVICES">
                    {include file="controls.tpl" load="ASERVICES" ASERVICES=$ASERVICES}
                </div>
                {include file="controls.tpl" load="ASERVICES_JS"}
                <div align="center"><button class="additional_services">##BRON_INFO_ADD_SERVICES##</button></div>
            </fieldset>

        </div>

        <div class="peoples">
            {include file="controls.tpl" load="TOURISTS" TOURISTS=$TOURISTS}
        </div>
        {if $BUYER || $CLAIM_NOTE || $CLAIM_NOTE_TEXT || $LOGGED_BUYER}
            <div class="CLAIMINFO">
                {if $BUYER}
                    <div class="{if $CLAIM_NOTE || $CLAIM_NOTE_TEXT}left_block{else}full_width{/if} BUYERINFO">
                        {include file="../fieldset_builder.tpl" fields=$BUYER id=-1 panel=true}
                    </div>
                {/if}
                {if $CLAIM_NOTE}
                    <div class="{if $BUYER || $CLAIM_NOTE_TEXT}left_block{if $BUYER} no_margin{/if}{else}full_width{/if}">
                        <fieldset class="panel claim_info_note">
                            <legend>##BRON_INFO_CLAIM_NOTE##</legend>
                            <div class="CLAIM_NOTE checklistbox">
                                {include file="controls.tpl" load="CLAIM_NOTE" CLAIM_NOTE=$CLAIM_NOTE}
                            </div>
                        </fieldset>
                    </div>
                {/if}
                {if $CLAIM_NOTE_TEXT}
                    <div class="{if $BUYER || $CLAIM_NOTE}left_block{if $BUYER || $CLAIM_NOTE} no_margin{/if}{else}full_width{/if}">
                        <fieldset class="panel claim_info_note{if $BUYER && $CLAIM_NOTE} small{/if}">
                            <legend>##BRON_INFO_CLAIM_NOTE##</legend>
                            <textarea class="NOTECLAIM"></textarea>
                        </fieldset>
                    </div>
                {/if}
            </div>
        {/if}

        <div class="PRICEINFO">
            <fieldset class="panel">
                <legend>##BRON_PRICE##</legend>
                <table class="price_details">
                    {if $SPOGMESSAGE}
                        <tr><td colspan="2">
                            <div class="SPOGMESSAGE">
                            {include file="controls.tpl" load="SPOGMESSAGE" SPOGMESSAGE=$SPOGMESSAGE}
                            </div>
                        </td></tr>
                    {/if}
                    {if $EXISTSTPROMOACTION}
                        <tr>
                            <td colspan="2" class="buttons">
                                ##BRON_PROMOCODE##: <input type="text" class="PROMOCODE" name="PROMOCODE" title="##BRON_PROMOCODE##" placeholder="##BRON_PROMOCODE##">
                            </td>
                        </tr>
                        <tr class="promoaction_result">
                            <td class="title r">##BRON_PROMOACTION_MONEY##</td>
                            <td class="l value promoaction_money"></td>
                        </tr>
                    {/if}
                    <tr>
                        <td class="CLAIMPRICE" colspan="2">{$CLAIMPRICE}{if $CLAIMCONVERTPRICE}<br><span class="small">{$CLAIMCONVERTPRICE.price} {$CLAIMCONVERTPRICE.date}</span>{/if}</td>
                    </tr>
                    <tr>
                        <td colspan="2"> <div class="PAYMENT_MESSAGE warning"></div></td>
                    </tr>
                    <tr>
                        <td colspan="2"> <div class="PENALTY_SIZE_MESSAGE warning"></div></td>
                    </tr>
                    {if in_array($TOURINFO.FreightExternal, [Bron_Model::FREIGHT_CHARTER_WITH_REGULAR, Bron_Model::FREIGHT_REGULAR_ONLY])}
                        <tr>
                            <td class="EXTERNALFREIGHT" colspan="2"></td>
                        </tr>
                    {/if}
                    <tr>
                        <td class="commission_block" colspan="2">
                            {if !$partpass_mode}
                                <span class="toggle_details link" data-show="##SHOW_DETAILS##" data-hide="##HIDE_DETAILS##">##SHOW_DETAILS##</span>
                                <div class="COMMISSIONS">
                                    {include file="controls.tpl" load="COMMISSION" COMMISSION=$COMMISSION}
                                </div>
                            {/if}
                        </td>
                    </tr>
                    {if !$FREIGHTS}
                        {if $PAYMENTSCHEDULE}
                            <tr>
                                <td class="installment_pay">
                                    <input type="checkbox" id="payment_schedule" value="1">&nbsp;<span class="link" id="search_tour_payment_schedule">##BRON_PAYMENT_SCHEDULE##</span>
                                </td>
                            </tr>
                        {/if}
                    {/if}
                    {if !$BUYER && !$LOGGED_BUYER && $OWNERINFO}
                        {if $OWNER == 2}
                            <tr>
                                <td colspan="2" class="c">
                                    ##BRON_CLAIM_OWNER## {include file="controls.tpl" load="OWNERINFO" OWNERINFO=$OWNERINFO}
                                </td>
                            </tr>
                        {/if}
                    {/if}
                    {if $BUYER || $LOGGED_BUYER}
                        <tr>
                            <td colspan="2" class="agreements">
                                <label class="contract_agree"><input type="checkbox" autocomplete="off" id="CONRACTAGREE">  ##BRON_PERSON_CONTRACT_AGREE## {if $CONTRACT}<a href="{Samo_Url::route('bron_person', ['samo_action' => 'contractPreview', 'TOURINC' => $TOURINFO.TourInc])}" target="_blank" title="##BRON_PERSON_CONTRACT_PREVIEW##" id="contract_url" class="hidden">##BRON_PERSON_CONTRACT_LINK##</a>{/if} </label>
                            </td>
                        </tr>
                        {if $AGREE_PROCESSING_PERSONAL_DATA}
                            <tr>
                                <td colspan="2">
                                    <label class="agree_processing_personal_data">
                                        <table>
                                            <tr>
                                                <td class="agree_processing_personal_data_checkbox"><input type="checkbox" autocomplete="off" id="AGREE_PROCESSING_PERSONAL_DATA"></td>
                                                <td>{$AGREE_PROCESSING_PERSONAL_DATA}</td>
                                            </tr>
                                        </table>
                                    </label>
                                </td>
                            </tr>
                        {/if}
                    {/if}
                    {if $CALCULATED_CLAIM.enable && !$BUYER && !$LOGGED_BUYER}
                        <tr>
                            <td colspan="2" class="calculated">
                                <table>
                                    <tr>
                                        <td>
                                            <input type="checkbox" autocomplete="off" id="CALCULATED_CLAIM">
                                        </td>
                                        <td>
                                            <label class="calculated_label" for="CALCULATED_CLAIM">##BRON_CALCULATED_CLAIM##</label>
                                            {if $CALCULATED_CLAIM.text}
                                                <div class="calculated_note">
                                                    {$CALCULATED_CLAIM.text}
                                                </div>
                                            {/if}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    {/if}
                    {if $CONTACTS || $REKLAMA}
                        <tr>
                            <td colspan="2" class="buttons">
                                <table width="100%">
                                    {if $CONTACTS && !$BUYER && !$LOGGED_BUYER}
                                        <tr>
                                            <td width="35%">
                                                <span {if $CONTACTS == 2}class="bold"{/if}>##BRON_CONTACTS##</span>
                                            </td>
                                            <td width="65%">
                                                <input type="text" class="contacts" name="CONTACTS" maxlength="64" title="##BRON_CONTACTS##" placeholder="##BRON_CONTACTS##">
                                            </td>
                                        </tr>
                                    {/if}
                                    {if $REKLAMA}
                                        <tr>
                                            <td >
                                                <span {if $REKLAMA_CONFIG == 2}class="bold"{/if}>##BRON_REKLAMA##</span>
                                            </td>
                                            <td >
                                                <select name="ORIGIN" class="ORIGIN" autocomplete="off" >
                                                    {foreach from=$REKLAMA item="item"}
                                                        <option value="{$item.id}" data-search-string="{$item.name}" {if $item.selected}selected{/if}>{$item.name}</option>
                                                    {/foreach}
                                                </select>
                                            </td>
                                        </tr>
                                    {/if}
                                </table>
                            </td>
                        <tr>
                    {/if}
                    <tr>
                        <td colspan="2"> <div class="RESULT_MESSAGES"></div></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="buttons"><span class="CLAIMPRICE_NOTICE">##RECALC_NOTICE##</span></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="buttons">
                            <button class="calc">##BRON_INFO_RECALC##</button>
                            <button class="bron">##BRON_INFO_DO_BRON##</button>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
        <div class="resultset"></div>
        {if $smarty.get.page == 'bron_person' && isset($routes.bron) && !isset($smarty.get.KEY)}
            <div class="button-wrapper">
                <a class="button" href="{Samo_Url::route('bron', $smarty.get)|escape:'html'|replace:'_person':''}">##SAMO_FOR_AGENT##</a>
            </div>
        {/if}
    </div>
</div>
{include file="../common.tpl"}
{jsload file="nouislider.js"  base="public/js/bron_info/nouislider/"}
{jsload file="ejs.js" base="public/js/sale/"}
{jsload file="bron_info.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}