{if $field.type == 'text'}
    <input name="{$fieldname}" type="text" class="{$fieldname}  {$field.filter}{if $field.required} required{/if}" value="" maxlength="{$field.length}">
{/if}
{if $field.type == 'select'}
    <select name="{$fieldname}" class="{$fieldname}{if $field.required} required{/if}">
    {foreach from=$field.values item="item"}
        <option value="{$item.value}" {if $item.selected}selected="selected"{/if} {$item.attrs}>{$item.title}</option>
    {/foreach}
    </select>
{/if}