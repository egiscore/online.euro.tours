<fieldset class="panel">
    <legend>##PAGE_TITLE##</legend>
    <form onmousemove="samo.formatINNNumber()" method="get" action="{Samo_Url::route('register_agency')}" class="register_agency_by_inn_form">
        <div class="error">{$error}</div>
        <table width="100%">
            {if $states|count > 1}
                <tr>
                    <td class="left_column register_by_inn">##REGISTER_AGENCY_STATEFROM##</td>
                    <td>
                        <select name="STATEFROM" class="STATEFROM">
                            {foreach from=$states item="item"}
                                <option{if $item.attrs} {$item.attrs|@glue:' '}{/if}
                                        value="{$item.id}"{if $item.selected} selected="selected"{/if}>{$item.name}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
            {/if}
            <tr class="innBlock">
                <td class="left_column register_by_inn">##INN##</td>
                <td><input type="text" name="INN" id="innf" class="INN frm-value"
                           data-validation-engine="validate[required,custom[integer], minSize[10], maxSize[12]"
                           data-errormessage-value-missing="##REGISTER_AGENCY_ERROR_INN_REQUIRED##"
                           data-errormessage-custom-error="##REGISTER_AGENCY_ERROR_INN_NODIGITS##"
                           data-errormessage-range-underflow="##REGISTER_AGENCY_ERROR_INN_UNDERFLOW##"
                           data-errormessage-range-overflow="##REGISTER_AGENCY_ERROR_INN_OVERFLOW##"
                           data-prompt-position="topLeft"
                           value="{$smarty.get.INN|trim|escape:"html"}"
                           onkeyup="samo.formatINNNumber();" onchange="samo.formatINNNumber();"
                    >
                </td>
            </tr>
        </table>
        {if !$smarty.const.FRIENDLY_URLS}
            <input type="hidden" name="page" value="register_agency"/>
        {/if}
        <input type="submit" onclick="samo.formatINNNumber()"
               value="##REGISTER_AGENCY_NEXTSTEP##">
    </form>
</fieldset>