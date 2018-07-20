<table width="100%">
    <tr>
        <td width="25%">
            {if $variant.link}
                {$variant.link_title|default:$variant.title|linkify:$variant.link}
            {else}
                <span id="v_{$variant.name}">{$variant.link_title|default:$variant.title}</span>
            {/if}
        </td>
        <td>
            {note page="description" section="bonus_manager"}
            {if $variant.vars.future_bonus}
                <br>
                {include file="../bonus_manager/future_bonus.tpl" future_bonus=$variant.vars.future_bonus}
            {/if}
            {if $variant.vars.bonus_sum}
                <br>
                {include file="../bonus_manager/use_bonus.tpl" rules=$print BONUS=$variant.vars}
            {/if}
        </td>
    </tr>
</table>