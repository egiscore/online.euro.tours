<table class="res commissions">
    {foreach from=$result item="option" name="options"}
        <tr class="{cycle values="even,odd"}">
            <td class="caption">
                {$option.title}
            </td>
            <td class="r">
                {$option.value}
            </td>
        </tr>
    {/foreach}
</table>
