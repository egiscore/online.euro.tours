{if $control == "checklistbox_html" or $control == "checklistbox"}
    {if is_array($elements)}
        {assign var="prev_group" value=0}
        {foreach from=$elements item="option" name="options"}
            {if $option.region && $option.regionKey != $prev_group}
                {if $prev_group != 0}
                    </div>
                {/if}
                <div class="groupbox{if $group_expanded} expanded{/if}">
                <label class="groupname"><input type="checkbox" class="group"
                                                {if isset($option.regionSelected) && $option.regionSelected == true}checked="checked"{/if} />{$option.region}
                </label>
                {assign var="prev_group" value=$option.regionKey}
            {/if}
            <label class="{$class}{if isset($option.regionSelected) && $option.regionSelected == false} hidden{else}{if $option.addition} has_input{/if}{/if}{if $option.icon} with_icon"{/if}">
            {if $SHOWICON==true}<span class="c-icon icon {$ICONTYPE} {$ICONTYPE}_{$option.id}">{/if}
                    <input type="checkbox" {if $class}class="{$class}"{/if} {if isset($option.selected) && $option.selected == true}checked="checked"{/if} value="{$option.id}"/>
                    {if $option.url}
                        <a class="help" href="{$option.url}" target="_blank">{$option.name}</a>
                    {else}
                        {$option.name}
                    {/if}
            {if $SHOWICON==true}</span>{/if}
            </label>
            {if $option.addition}
                <input type="text" name="addit_{$option.id}" disabled="disabled" class="addit">
            {/if}
        {/foreach}
        {if $prev_group != 0}
            </div>
        {/if}
    {/if}
{/if}
{if $control == 'options'}
    [
    {if is_array($elements)}
        {foreach from=$elements item="option" name="options"}
            {ldelim}inc: '{$option.id}', title: '{$option.alias|escape:'javascript'|default:$option.name|escape:'javascript'}', selected: {if isset($option.selected) && $option.selected == true}true{else}false{/if}{if $option.attributes}, attrs: {ldelim}{$option.attributes|@glue:",":"json"}{rdelim}{/if}{rdelim}{if $smarty.foreach.options.last ne true},{/if}
        {/foreach}
    {/if}
    ]
{/if}
{if $control == 'hotel_category'}
    {if $STARS}
        {include file="`$smarty.const._ROOT`templates/api_controls.tpl" control="checklistbox" elements=$STARS class="star"}
    {/if}
    {if $HOTELTYPES}
        {if $STARS}<hr>{/if}
        {include file="`$smarty.const._ROOT`templates/api_controls.tpl" control="checklistbox" elements=$HOTELTYPES class="hoteltype"}
    {/if}
{/if}