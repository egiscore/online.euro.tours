{if $control == 'options'}
    [
      {if is_array($elements)}
        {foreach from=$elements key="key" item="group" name="groups"}
          {ldelim}title: '{$key|escape:'javascript'}', children: [
            {foreach from=$group item="option" name="options"}
              {ldelim}inc: '{$option.id}', title: '{$option.name|escape:'javascript'}', selected: {if isset($option.selected) && $option.selected == true}true{else}false{/if}, attrs: {ldelim}"data-search-string": "'{$option.tags|@glue:' '|escape:'javascript'}'"{rdelim}{rdelim}{if $smarty.foreach.options.last ne true},{/if}
            {/foreach}]
          {rdelim}{if $smarty.foreach.groups.last ne true},{/if}
        {/foreach}
      {/if}
    ]
{elseif $control == 'form'}
    <div class="block panel opened no_title container">
        <table class="location">
            <tr>
                <td colspan="2">
                    <span class="port_revert"></span>
                    <div class="combobox"><select name="TOWNFROMINC" class="TOWNFROMINC string" autocomplete="off">{foreach from=$TOWNFROMINC key="key" item="options"}<optgroup label="{$key}">{foreach from=$options item="item"}<option value="{$item.id}" {if $item.selected}selected{/if} data-search-string="{$item.tags|@glue:" "}">{$item.name}</option>{/foreach}</optgroup>{/foreach}</select></div>
                    <div class="combobox"><select name="TOWNTOINC" class="TOWNTOINC string" autocomplete="off"    >{foreach from=$TOWNTOINC   key="key" item="options"}<optgroup label="{$key}">{foreach from=$options item="item"}<option value="{$item.id}" {if $item.selected}selected{/if} data-search-string="{$item.tags|@glue:" "}">{$item.name}</option>{/foreach}</optgroup>{/foreach}</select></div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <select class="AIRLINE" name="AIRLINE" autocomplete="off">{foreach from=$AIRLINES item="item"}<option value="{$item.id}" {if $item.selected}selected{/if}>{$item.name}</option>{/foreach}</select>
                </td>
            </tr>
            <tr>
                <td class="ow_container">
                    {if $ONLY_ROUNDTRIP}
                        ##TICKETS_DEPARTURE##
                        <input type="hidden" value="0" name="FREIGHTBACK" class="FREIGHTBACK">
                    {else}
                        <label><input type="radio" value="0" name="FREIGHTBACK" class="FREIGHTBACK"{if $CHECKOUT.value->is_null()} checked="checked"{/if}> ##TICKETS_ONEWAY##</label>
                    {/if}
                </td>
                <td class="calendar_container"><input type="type" name="CHECKIN" class="frm-input date CHECKIN"  autocomplete="off" {datepicker_init data=$CHECKIN}/><select class="period CHECKIN_DELTA" name="CHECKIN_DELTA">{foreach from=$CHECKIN_DELTA item="item"}<option value="{$item.id}" {if $item.selected}selected{/if}>±{if $item.id > 0}{$item.name}{/if}</option>{/foreach}</select></td>
            </tr>
            <tr>
                <td>
                    {if $ONLY_ROUNDTRIP}
                        ##TICKETS_ARRIVAL##
                        <input type="hidden" value="1" name="FREIGHTBACK" class="FREIGHTBACK">
                    {else}
                        <label><input type="radio" value="1" name="FREIGHTBACK" class="FREIGHTBACK"{if $CHECKOUT.value->not_null()} checked="checked"{/if}> ##TICKETS_ROUNDTRIP##</label>
                    {/if}
                </td>
                <td class="calendar_container"><input type="type" name="CHECKOUT" class="frm-input date CHECKOUT"  autocomplete="off" {datepicker_init data=$CHECKOUT}/><select class="period CHECKOUT_DELTA" name="CHECKOUT_DELTA">{foreach from=$CHECKOUT_DELTA item="item"}<option value="{$item.id}" {if $item.selected}selected{/if}>±{if $item.id > 0}{$item.name}{/if}</option>{/foreach}</select></td>
            </tr>
            <tr>
                <td><span>##TICKETS_ADULTS##</span>&nbsp;<span style="float: right;">##TICKETS_CHILDS##&nbsp;</span></td>
                <td class="pcount_label">##TICKETS_CHILDS_AGE##</td>
            </tr>
            <tr class="no_padding">
                <td>
                    <span class="pcount_wrapper"><select name="ADULT" class="ADULT spin" autocomplete="off">{foreach from=$ADULT item="item"}<option value="{$item.id}" {if $item.selected}selected{/if}>{$item.name}</option>{/foreach}</select></span>
                    <span class="pcount_wrapper"><select name="CHILD" class="CHILD spin" autocomplete="off">{foreach from=$CHILD item="item"}<option value="{$item.id}" {if $item.selected}selected{/if}>{$item.name}</option>{/foreach}</select></span>
                </td>
                <td class="ages">
                    <span class="age_wrapper"><select name="AGE1" class="age age1" autocomplete="off">
                        {section start=0 loop=$MAX_CHILD_AGE + 1 name="age"}<option value="{$smarty.section.age.index}" {if $smarty.section.age.index == $AGE1}selected="selected"{/if}>{$smarty.section.age.index}</option>{/section}
                    </select></span>
                    <span class="age_wrapper"><select name="AGE2" class="age age2" autocomplete="off">
                        {section start=0 loop=$MAX_CHILD_AGE + 1 name="age"}<option value="{$smarty.section.age.index}" {if $smarty.section.age.index == $AGE2}selected="selected"{/if}>{$smarty.section.age.index}</option>{/section}
                    </select></span>
                    <span class="age_wrapper"><select name="AGE3" class="age age3" autocomplete="off">
                        {section start=0 loop=$MAX_CHILD_AGE + 1 name="age"}<option value="{$smarty.section.age.index}" {if $smarty.section.age.index == $AGE3}selected="selected"{/if}>{$smarty.section.age.index}</option>{/section}
                    </select></span>

                </td>
            </tr>
            <tr>
                <td><span class="currency_label">##TICKETS_CLASS##</span></td>
                <td><span class="currency_label">##TICKETS_CURRENCY##</span></td>
            </tr>
            <tr class="no_padding">
                <td><select class="CLASS" name="CLASS" autocomplete="off">{foreach from=$CLASS item="item"}<option value="{$item.id}" {if $item.selected}selected{/if}>{$item.name}</option>{/foreach}</select></td>
                <td><select class="CURRENCYINC" name="CURRENCYINC" autocomplete="off">{foreach from=$CURRENCY item="item"}<option value="{$item.id}" {if $item.selected}selected{/if}>{$item.name}</option>{/foreach}</select></td>
            </tr>
            <tr>
                <td ><label class="ns"><input type="checkbox" name="YESPLACES" class="YESPLACES" {if $YESPLACES}checked="checked"{/if}> ##TICKETS_YESPLACES##</label></td>
                <td><input type="submit" class="load" disabled="disabled" value="##TICKETS_REFRESH##" /></td>
            </tr>
        </table>
</div>
{/if}