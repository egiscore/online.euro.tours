{foreach from=$Tourist item="tourist" name="tname" key="tourist_inc"}
    <tr data-tourist="{$tourist_inc}" class="{cycle values="even,odd"}">
        <td>{$smarty.foreach.tname.iteration}</td>
        <td>{$tourist.HUMAN}</td>
        <td class="link a_ed_tourist">{$tourist.LASTLNAME|default:$tourist.LASTNAME} {$tourist.FIRSTLNAME|default:$tourist.FIRSTNAME}</td>
        <td>{$tourist.BORN}</td>
        <td>{$tourist.PSERIE}&nbsp;{$tourist.PNUMBER}{if trim($tourist.PVALID)} ##CL_W_TILL## {$tourist.PVALID}{/if} </td>
        <td><input type="button" class="button delete_tourist_botton"  value="##CL_W_DELETE##"></td>
    </tr>
{/foreach}