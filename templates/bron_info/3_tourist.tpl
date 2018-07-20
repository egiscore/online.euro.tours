{if !isset($STATUS)}
    {assign var="STATUS" value="MRS"}
{/if}
<fieldset class="panel">
    <legend>{if $STATUS != 'INF'}##BRON_TOURIST_INFO## {$tourist_id|abs}{else}##BRON_TOURIST_INFANT##{/if}</legend>
    {note page="bron_info_tourist"}
    <div class="tourist {if $STATUS == 'INF'}infant{/if}{if $num == "add"} ainfant{/if}" data-peopleinc="{$id}">

        {include file="../fieldset_builder.tpl" fields=$TOURISTS.fields STATUS=$STATUS id=$id}
        {if $TOURISTS.visainfo || ($STATUS != 'INF' && $TOURISTS.insures) || ($num == 'add' && $STATUS == 'INF' && $TOURISTS.frplace_for_infant) || ($BUYER && in_array($STATUS, ['MR', 'MRS']) && $LASTNAME_EXIST == true)}
            <fieldset class="subpanel">
                <table width="100%">
                    {if $TOURISTS.visainfo}
                        <tr>
                            <td class="left_column"><label>##BRON_TOURIST_VISA##</label></td>
                            <td>
                                <select name="VISA[{$id}]" class="visa">
                                    {foreach from=$TOURISTS.visainfo key="visacenter" item="visas"}
                                        {if $visacenter}<optgroup label="##BRON_VISA_TOWN## {$visacenter}">{/if}
                                            {foreach from=$visas item="visa"}
                                                <option value="{$visa.VisaprInc}" {if $visa.Selected}selected="selected"{/if} data-json='{$visa|@data_json:'visa'}'>{$visa.VisaName}{if $visa.Deadline != null && $visa.Deadline->not_null()} {'##BRON_VISA_DEADLINE##'|sprintf:$visa.Deadline}{else}{if $visa.VisaDays} {'##BRON_VISA_DAYS##'|sprintf:$visa.VisaDays}{/if}{/if}{if $visa.Note}
 {$visa.Note}

{/if}</option>
                                            {/foreach}
                                        {if $visacenter}</optgroup>{/if}
                                    {/foreach}
                                </select>
                            </td>
                        </tr>
                    {/if}
                    {if $num == 'add' && $STATUS == 'INF' && $TOURISTS.frplace_for_infant}
                        <tr>
                            <td class="left_column"></td>
                            <td><label><input type="checkbox" class="checkbox INFANT_FREIGHT_PLACE" id="INFANT_FREIGHT_PLACE">&nbsp;##BRON_INFANT_FREIGHT_PLACE##</label></td>
                        </tr>
                    {/if}
                    {if $BUYER && in_array($STATUS, ['MR', 'MRS']) && $LASTNAME_EXIST == true}
                        <tr>
                            <td class="left_column"></td>
                            <td><label><input type="checkbox" tabindex="-1" class="checkbox SAVE_AS_BUYER" value="{$id}">&nbsp;##BRON_SAVE_AS_BUYER##</label></td>
                        </tr>
                    {/if}
                </table>
            </fieldset>
        {/if}
    </div>
</fieldset>
