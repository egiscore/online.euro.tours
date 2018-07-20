{include file="../header.tpl" page_title="##CHECK_PASSPORT##" cssfiles="check_passport.css"}
{include file="../partial_top.tpl"}
<div id="check_passport">
        <div class="searchmodes">
                <div class="panel searchmode searchmode_selected">
                    ##CHECK_PASSPORT##
                </div>
        </div>
        <div class="panel controls">
            <table>
                <tbody>
                <tr>
                    <td>##CHECK_PASSPORT_CITY_DEPARTURE##</td>
                    <td>
                        <select name="TOWNFROMINC" class="TOWNFROMINC">
                            {foreach from=$TOWNFROMINC item=item}
                                <option value="{$item.id}" {if $item.selected}selected{/if}>{$item.name}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>##CHECK_PASSPORT_COUNTRY_DESTINATION##</td>
                    <td>
                        <select name="STATEINC" class="STATEINC">
                            {foreach from=$STATEINC item=item}
                                <option value="{$item.id}" {if $item.selected}selected{/if}>{$item.name}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>##CHECK_PASSPORT_CITIZENSHIP##</td>
                    <td>
                        <select name="CITIZENSHIP" class="CITIZENSHIP">
                            {foreach from=$CITIZENSHIP item=item}
                                <option value="{$item.id}" {if $item.selected}selected{/if}>{$item.name}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>##CHECK_PASSPORT_PLACE_BIRTH##</td>
                    <td>
                        <select name="BORNPLACE" class="BORNPLACE">
                            {foreach from=$BORNPLACE item=item}
                                <option value="{$item.id}" {if $item.selected}selected{/if}>{$item.name}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>##CHECK_PASSPORT_VALID_DATE##</td>
                    <td>
                        <input type="text" name="PVALIDDATE" class="required frm-input date PVALIDDATE" value="{$PVALIDDATE}"
                                {datepicker_init startDate="tomorrow" endDate="+100 year"}/>
                    </td>
                </tr>
                <tr>
                    <td>##CHECK_PASSPORT_DEPARTURE_DATE##</td>
                    <td>
                        <input type="text" name="CHECKIN" class="required frm-input date CHECKIN" value="{$CHECKIN}"
                                {datepicker_init startDate="tomorrow" endDate="+2 year"}/>
                    </td>
                </tr>
                <tr>
                    <td>##CHECK_PASSPORT_DURATION##</td>
                    <td>
                        <select name="NIGHTS" class="NIGHTS">
                            {foreach from=$NIGHTS item=item}
                                <option value="{$item.id}" {if $item.selected}selected{/if}>{$item.name}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="button" class="load">##CHECK_PASSPORT_CHECK##</button>
                    </td>
                    <td class="result"></td>
                </tr>
                </tbody>
            </table>
        </div>
</div>
{include file="../common.tpl"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}
{jsload file="check_passport.js"}