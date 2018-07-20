<table width="100%">
    <tr>
        <td width="25%">
             <a id="invoice_{$CLAIM}" class="link{if $variant.vars.external} external{/if}"{if !$variant.vars.external} target="_blank"{/if} href="{$variant.vars.link}">{$variant.title}</a>
        </td>
        <td>
            {note page="description" section="invoice"}
        </td>
    </tr>
</table>