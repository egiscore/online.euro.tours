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
{/if}