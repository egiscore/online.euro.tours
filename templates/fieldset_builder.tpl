{if !isset($print_version)}
    {assign var="print_version" value=false}
{/if}
{if !$panel}
    {if $id}
        {assign var="panel" value=false}
    {else}
        {assign var="panel" value=true}
    {/if}
{/if}
{foreach from=$fields key="fieldset" item="items"}
    {if $fieldset == 'System'}
        {foreach from=$items item="field"}
            <input type="hidden" class="frm-value{if $field.css_classes} {$field.css_classes|@glue:" "}{/if}" name="frm[{$field.Entity}][{$field.EntityInc|default:$id}][{$field.Field}]" value="{$field.Value|escape:'html'}">
        {/foreach}
    {/if}
    {if $fieldset == 'Geo'}
        {foreach from=$items item="field"}
            <input type="hidden" class="frm-value{if $field.css_classes} {$field.css_classes|@glue:" "}{/if}" name="frm[{$field.Entity}][{$field.EntityInc|default:$id}][{$field.Field}]" value="{$field.Value|escape:'html'}">
        {/foreach}
    {/if}
    {assign var="empty_fieldset" value=true}
    {foreach from=$items item="field"}
        {if $field.Visible}
            {assign var="empty_fieldset" value=false}
            {break}
        {/if}
    {/foreach}
    {if !$empty_fieldset}
    <fieldset class="{if $panel}panel{else}subpanel{/if}">
        {if $panel}
            <legend>{$fieldset}</legend>
        {/if}
        <table width="100%">
        {foreach from=$items item="field"}
            {if $field.Visible}
                {assign var="helpalt_exists" value=false}
                {if $field.HelpAlt != ''}
                    {assign var="helpalt_exists" value=true}
                {/if}
                <tr>
                    <td class="left_column"><label {if $field.Required}class="required"{/if}>{if $field.Url}<a href="{$field.Url}" target="_blank">{$field.Title}</a>{else}{$field.Title}{/if}{if $print_version}:{/if}</label></td>

                    <td>{if $field.Type == 'human' }
                        {if $field.Value}
                            {assign var="STATUS" value=$field.Value}
                        {/if}
                        {if $field.Editable && !$print_version}
                        <select {if $field.css_classes}class="{$field.css_classes|@glue:" "}"{/if} name="frm[{$field.Entity}][{$field.EntityInc|default:$id}][{$field.Field}]"  {if $field.attributes}{$field.attributes|@glue:" "}{/if} data-loaded-value="{$STATUS}">
                                {if $ANY_HUMAN}
                                    <option value="MR"{if $STATUS == 'MR'} selected="selected"{/if}>MR</option>
                                    <option value="MRS"{if $STATUS == 'MRS'} selected="selected"{/if}>MRS</option>
                                    <option value="CHD"{if $STATUS == 'CHD'} selected="selected"{/if}>CHD</option>
                                    <option value="INF"{if $STATUS == 'INF'} selected="selected"{/if}>INF</option>
                                {else}
                                    {if $STATUS == 'INF'}
                                        <option value="INF" selected="selected">INF</option>
                                    {else}
                                        <option value="MR"{if $STATUS == 'MR'} selected="selected"{/if}>MR</option>
                                        <option value="MRS"{if $STATUS == 'MRS'} selected="selected"{/if}>MRS</option>
                                        <option value="CHD"{if $STATUS == 'CHD'} selected="selected"{/if}>CHD</option>
                                    {/if}
                                {/if}
                        </select>
                        {else}
                            {if $print_version}
                                <strong class="frm-value">{$STATUS}</strong>
                            {else}
                                <input type="text" class="frm-value" disabled="disabled" value="{$STATUS}" />
                            {/if}
                        {/if}
                    {/if}
                    {if $field.Type == 'sex'}
                        {if $field.Editable && !$print_version}
                            <div class="sex">
                             <span>
                                <input type="radio" name="frm[{$field.Entity}][{$field.EntityInc|default:$id}][{$field.Field}]" id="SEX_M_{$field.EntityInc|default:$id}" value="1" {if $field.Value == 1}checked="checked"{/if} {if $field.css_classes}class="{$field.css_classes|@glue:" "}"{/if} {if $field.attributes}{$field.attributes|@glue:" "}{/if}>
                                <label for="SEX_M_{$field.EntityInc|default:$id}">##TOURIST_MALE##</label>
                             </span>&nbsp;
                             <span>
                                 <input type="radio" name="frm[{$field.Entity}][{$field.EntityInc|default:$id}][{$field.Field}]" id="SEX_F_{$field.EntityInc|default:$id}" value="0" {if $field.Value == 0}checked="checked"{/if} {if $field.css_classes}class="{$field.css_classes|@glue:" "}"{/if} {if $field.attributes}{$field.attributes|@glue:" "}{/if}>
                                 <label for="SEX_F_{$field.EntityInc|default:$id}">##TOURIST_FEMALE##</label>
                             </span>
                            </div>
                        {else}
                            {if $print_version}
                                <strong class="frm-value">{if $field.Value == 1}##TOURIST_MALE##{else}##TOURIST_FEMALE##{/if}</strong>
                            {else}
                                <input type="text" class="frm-value" disabled="disabled" value="{if $field.Value == 1}##TOURIST_MALE##{else}##TOURIST_FEMALE##{/if}" />
                            {/if}
                        {/if}
                    {/if}

                    {if $field.Type == 'string'}
                        {if $field.Editable && !$print_version}
                            <input type="text" class="frm-input{if $helpalt_exists} helpalt{/if}{if $field.css_classes} {$field.css_classes|@glue:" "}{/if}" name="frm[{$field.Entity}][{$field.EntityInc|default:$id}][{$field.Field}]" {if $field.Value}value="{$field.Value}"{/if} {if $field.attributes}{$field.attributes|@glue:" "}{/if} data-field-title="{$field.Title}"{if $helpalt_exists} title="{$field.HelpAlt|escape}"{/if}>
                        {else}
                            {if $print_version}
                                <strong class="frm-value">{$field.Value|default:"&nbsp;"}</strong>
                            {else}
                                <input type="text" class="frm-value" disabled="disabled" value="{$field.Value|default:"&nbsp;"}" />
                            {/if}
                        {/if}
                    {/if}
                    {if $field.Type == 'date'}
                        {if $field.Editable && !$print_version}
                            <input type="text" class="frm-input{if $helpalt_exists} helpalt{/if}{if $field.css_classes} {$field.css_classes|@glue:" "}{/if}" name="frm[{$field.Entity}][{$field.EntityInc|default:$id}][{$field.Field}]" {if $field.Value}value="{$field.Value|date_format}"{/if} {if $field.attributes}{$field.attributes|@glue:" "}{/if}{if $helpalt_exists} title="{$field.HelpAlt|escape}"{/if} {datepicker_init view="years" direction=false}>
                        {else}
                            {if $print_version}
                                <strong class="frm-value">{if $field.Value}{$field.Value|date_format}{else}&nbsp;{/if}</strong>
                            {else}
                                <input type="text" class="frm-value" disabled="disabled" value="{if $field.Value}{$field.Value|date_format}{else}&nbsp;{/if}" />
                            {/if}
                        {/if}
                    {/if}
                    {if $field.Type == 'state'}
                        {if $field.Editable && !$print_version}
                            <select name="frm[{$field.Entity}][{$field.EntityInc|default:$id}][{$field.Field}]" class="{if $helpalt_exists}helpalt{/if}{if $field.css_classes} {$field.css_classes|@glue:" "}{/if}" {if $field.attributes}{$field.attributes|@glue:" "}{/if} {if $field.Value}data-loaded-value="{$field.Value}"{/if}{if $helpalt_exists} title="{$field.HelpAlt|escape}"{/if}>
                                {if !$field.Required}<option value="{$MAXLONGINT}">----</option>{/if}
                                {foreach from=$field.Variants item="state"}
                                    <option value="{$state.id}" {if ($state.selected and $field.Required) or $field.Value == $state.StateInc }selected="selected"{/if}{if $state.attributes} {$state.attributes|@glue:" "}{/if}>{$state.name}</option>
                                {/foreach}
                            </select>
                        {else}
                            {if $print_version}
                                <strong class="frm-value">{foreach from=$field.Variants item="state"}{if $state.StateInc == $field.Value}{$state.StateName}{/if}{/foreach}&nbsp;</strong>
                            {else}
                                <input type="text" class="frm-value" disabled="disabled" value="{foreach from=$field.Variants item="state"}{if $state.StateInc == $field.Value}{$state.StateName}{/if}{/foreach}&nbsp;" />
                            {/if}
                        {/if}
                    {/if}
                    {if $field.Type == 'select'}
                        {if $field.Editable && !$print_version}
                            <select name="frm[{$field.Entity}][{$field.EntityInc|default:$id}][{$field.Field}]" class="{if $helpalt_exists}helpalt{/if}{if $field.css_classes} {$field.css_classes|@glue:" "}{/if}" {if $field.attributes}{$field.attributes|@glue:" "}{/if} {if $field.Value}data-loaded-value="{$field.Value}"{/if}{if $helpalt_exists} title="{$field.HelpAlt|escape}"{/if}>
                                {if !$field.Required}<option value="{$MAXLONGINT}">----</option>{/if}
                                {foreach from=$field.Variants item="item"}
                                    <option value="{$item.Inc}" {if ($item.selected and $field.Required) or ('' === strval($field.Value) and '' === $item.Inc) or ('' !== strval($field.Value) and $field.Value == $item.Inc)}selected="selected"{/if} {if $item.attrs}{$item.attrs}{/if}>{$item.Name}</option>
                                {/foreach}
                            </select>
                        {else}
                            {if $print_version}
                                <strong class="frm-value">{foreach from=$field.Variants item="item"}{if ('' === strval($field.Value) and '' === $item.Inc) or ('' !== strval($field.Value) and $field.Value == $item.Inc)}{$item.Name}{/if}{/foreach}&nbsp;</strong>
                            {else}
                                <input type="text" class="frm-value" disabled="disabled" value="{foreach from=$field.Variants item="item"}{if ('' === strval($field.Value) and '' === $item.Inc) or ('' !== strval($field.Value) and $field.Value == $item.Inc)}{$item.Name}{/if}{/foreach}&nbsp;" />
                            {/if}
                        {/if}
                    {/if}
                    {if $field.Type == 'radio'}
                        {if $field.Editable && !$print_version}
                            {foreach from=$field.Variants item="item"}
                                <label {if $field.css_classes}class="radio {$field.css_classes|@glue:" "}"{/if} ><input type="radio" name="frm[{$field.Entity}][{$field.EntityInc|default:$id}][{$field.Field}]" {if $field.attributes}{$field.attributes|@glue:" "}{/if} value="{$item.Inc}" {if ($item.selected and $field.Required) or $field.Value == $item.Inc }checked="checked"{/if}>{$item.Name}</label>
                            {/foreach}
                        {else}
                            {if $print_version}
                                <strong class="frm-value">{foreach from=$field.Variants item="item"}{if $item.Inc == $field.Value}{$item.Name}{/if}{/foreach}&nbsp;</strong>
                            {else}
                                <input type="text" class="frm-value" disabled="disabled" value="{foreach from=$field.Variants item="item"}{if $item.Inc == $field.Value}{$item.Name}{/if}{/foreach}&nbsp;" />
                            {/if}
                        {/if}
                    {/if}
                    {if $field.Type == 'text'}
                        {if $field.Editable && !$print_version}
                            <textarea {if $field.attributes}{$field.attributes|@glue:" "}{/if} {if $field.css_classes}class="{$field.css_classes|@glue:" "}"{/if} name="frm[{$field.Entity}][{$field.EntityInc|default:$id}][{$field.Field}]">{if $field.Value}{$field.Value|htmlspecialchars}{/if}</textarea>
                        {else}
                            <div class="frm-value">{$field.Value|default:"&nbsp;"}"</div>
                        {/if}
                    {/if}
                    {if $field.Type == 'email'}
                        {if $field.Editable && !$print_version}
                            <input type="email" class="frm-input{if $field.css_classes} {$field.css_classes|@glue:" "}{/if}" name="frm[{$field.Entity}][{$field.EntityInc|default:$id}][{$field.Field}]" {if $field.Value}value="{$field.Value}"{/if} {if $field.attributes}{$field.attributes|@glue:" "}{/if}>
                        {else}
                            {if $print_version}
                                <strong class="frm-value">{$field.Value|default:"&nbsp;"}</strong>
                            {else}
                                <input type="text" class="frm-value" disabled="disabled" value="{$field.Value|default:"&nbsp;"}" />
                            {/if}
                        {/if}
                    {/if}
                    {if $field.Type == 'url'}
                        {if $field.Editable && !$print_version}
                            <input type="url" class="frm-input{if $field.css_classes} {$field.css_classes|@glue:" "}{/if}" name="frm[{$field.Entity}][{$field.EntityInc|default:$id}][{$field.Field}]" {if $field.Value}value="{$field.Value}"{/if} {if $field.attributes}{$field.attributes|@glue:" "}{/if}>
                        {else}
                            {if $print_version}
                                <strong class="frm-value">{$field.Value|default:"&nbsp;"}</strong>
                            {else}
                                <input type="text" class="frm-value" disabled="disabled" value="{$field.Value|default:"&nbsp;"}" />
                            {/if}
                        {/if}
                    {/if}
                    {if $field.Type == 'checkbox'}
                        {if $field.Editable && !$print_version}
                            <input type="hidden" name="frm[{$field.Entity}][{$field.EntityInc|default:$id}][{$field.Field}]" value="0">
                            <input type="checkbox" {if $field.css_classes}class="{$field.css_classes|@glue:" "}"{/if} name="frm[{$field.Entity}][{$field.EntityInc|default:$id}][{$field.Field}]" {if $field.Checked}checked{/if} value="1" {if $field.attributes}{$field.attributes|@glue:" "}{/if}>
                        {else}
                            {if $print_version}
                                <strong class="frm-value">{if $field.Checked}Y{else}N{/if}</strong>
                            {else}
                                <input type="checkbox" {if $field.css_classes}class="{$field.css_classes|@glue:" "}"{/if} disabled="disabled" name="frm[{$field.Entity}][{$field.EntityInc|default:$id}][{$field.Field}]" {if $field.Checked}checked{/if} value="1" {if $field.attributes}{$field.attributes|@glue:" "}{/if}>
                            {/if}
                        {/if}
                    {/if}
                    {if $field.Type == 'checklistbox'}
                        {if $field.Editable && !$print_version}
                            <div data-any=".{$field.Field}_ANY" {if $field.css_classes}class="{$field.css_classes|@glue:" "}"{/if} name="frm[{$field.Entity}][{$field.EntityInc|default:$id}][{$field.Field}]">
                                {include file="../controls.tpl" control="checklistbox_html" elements=$field.Variants}
                            </div>
                        {else}
                        {/if}
                    {/if}
                    {if $field.Type == 'button'}
                        {if $print_version}
                            <span class="frm-value">&nbsp;</span>
                        {else}
                            <button {if $field.css_classes}class="{$field.css_classes|@glue:" "}"{/if}>{$field.Title}</button>
                        {/if}
                    {/if}
                    {if $field.Type == 'bik_bank'}
                        {if $field.Editable && !$print_version}
                            <div class="frm-bik-bank">
                                ##PARTNER_BIK_BANK_SEARCH## <input type="text" class="frm-input PARTNER_BIK" name="PARTNER_BIK">
                                ##PARTNER_BIK_BANK_BANK##
                                <select name="frm[{$field.Entity}][{$field.EntityInc|default:$id}][{$field.Field}]"  {if $field.css_classes}class="{$field.css_classes|@glue:" "}"{/if} {if $field.attributes}{$field.attributes|@glue:" "}{/if} {if $field.Value}data-loaded-value="{$field.Value}"{/if} data-field-title="##PARTNER_BIK_BANK_BANK##">
                                    {if !$field.Required}<option value="{$MAXLONGINT}">----</option>{/if}
                                    {foreach from=$field.Variants item="item"}
                                        <option value="{$item.Inc}" {if ($item.selected and $field.Required) or $field.Value == $item.Inc}selected="selected"{/if} {if $item.attrs}{$item.attrs|@glue:" "}{/if}>{$item.Name}</option>
                                    {/foreach}
                                </select>
                            </div>
                        {else}
                            {foreach from=$field.Variants item="item"}{if $item.Inc == $field.Value}{assign var=bik_bank value=$item}{/if}{/foreach}
                            {if $print_version}
                                <strong class="frm-value">{if $bik_bank}{$bik_bank.Name}{/if}&nbsp;</strong>
                            {else}
                                <input type="text" class="frm-value{if $item.deleted} deleted{/if}" disabled="disabled" value="{if $bik_bank}{$bik_bank.Name|escape:"html"}{/if}{if $bik_bank} {'##PARTNER_BIK_BANK_BIK##: '|cat:$bik_bank.bik|escape:'html'}{/if}">
                            {/if}
                        {/if}
                    {/if}
                    {if $field.Type == 'partner_town_state'}
                        {if $field.Editable && !$print_version}
                            <div class="combobox">
                                <select name="frm[{$field.Entity}][{$field.EntityInc|default:$id}][{$field.Field}]" class="string {if $field.css_classes}{$field.css_classes|@glue:" "}{/if}" autocomplete="off">{strip}
                                    {foreach from=$field.Variants key="key" item="options"}
                                        <optgroup label="{$key}">
                                            {foreach from=$options item="item"}
                                                <option value="{$item.id}" {if $item.selected}selected{/if} {if $item.attrs}{$item.attrs|@glue:" "}{/if}>{$item.name}</option>
                                            {/foreach}
                                        </optgroup>
                                    {/foreach}
                                {/strip}</select>
                            </div>
                        {else}{strip}
                            {foreach from=$field.Variants key="key" item="options"}
                                {foreach from=$options item="item"}
                                    {if $item.id == $field.Value}
                                        {assign var=state_name value=$key}
                                        {assign var=town_name value=$item.name}
                                    {/if}
                                {/foreach}
                            {/foreach}{/strip}
                            {if $print_version}
                                <strong class="frm-value">{$state_name}&nbsp;/&nbsp;{$town_name}&nbsp;</strong>
                            {else}
                                <input type="text" data-frm-name="frm[{$field.Entity}][{$field.EntityInc|default:$id}][{$field.Field}]" class="frm-value" disabled="disabled" value="{$state_name|escape:"html"}&nbsp;/&nbsp;{$town_name|escape:"html"}">
                            {/if}
                        {/if}
                    {/if}
                </td>
            </tr>
            {/if}
        {/foreach}
        </table>
    </fieldset>
    {/if}
{/foreach}
