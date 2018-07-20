{if $control == "checklistbox_grouped" or $control == "checklistbox"}
   {if is_array($elements)}
        {assign var="prev_group" value=''}
        {foreach from=$elements item="option" name="options"}
            {if $option.GroupInc && $option.GroupInc != $prev_group}
                {if $prev_group != ''}
                        </div>
                        <label class="any"><input type="hidden" value="1" name="PARAMS-{$prev_group}_ANY" class="PARAMS_ANY">##IN_HOTEL_ANY##</label>
                        <div style="clear: both;"></div>
                    </div>
                </div>
                {/if}
                <div class="block panel">
                    <div class="title">
                        <div class="icon {$option.GroupInc}"></div>
                        <span>{if $LANG == 'rus'}{$option.Group}{else}{$option.LGroup}{/if}</span>
                    </div>
                    <div class="container">
                        <div class="checklistbox PARAMS-{$option.GroupInc}" name="PARAMS-{$option.GroupInc}">
                        {assign var="prev_group" value=$option.GroupInc}
            {/if}
            <label {if isset($option.group_selected) && $option.group_selected == false}class="hidden"{else}{if $option.addition}class="has_input"{/if}{/if}>
                <input type="checkbox" value="{$option.Inc}"{if isset($option.selected) && $option.selected == true} checked="checked"{/if}> {if $LANG == 'rus'}{$option.Name}{else}{$option.LName}{/if}
            </label>
        {/foreach}
        {if $prev_group != ''}
                </div>
                <label class="any"><input type="hidden" value="1" name="PARAMS-{$prev_group}_ANY" class="PARAMS_ANY">##IN_HOTEL_ANY##</label>
                <div style="clear: both;"></div>
            </div>
        </div>
        {/if}
   {/if}
{/if}
