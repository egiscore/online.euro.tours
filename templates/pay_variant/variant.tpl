<table width="100%">
    <tr>
        <td width="25%">
            {if $variant.link_title}
                {$variant.title}
                <br/>
            {/if}
            {if $variant.link}
                {$variant.link_title|default:$variant.title|linkify:$variant.link}
            {else}
                <span id="v_{$variant.name}" class="link">{$variant.link_title|default:$variant.title}</span>
            {/if}
        </td>
        <td class="note_container">
            {include file=$variant.resource}
        </td>
    </tr>
</table>