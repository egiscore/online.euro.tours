{if $BONUS}
    <table class="res" id="bonus_manager" data-claim="{$CLAIM}" data-use-confirm="##BONUS_MANAGER_CONFIRM##">
        <thead>
        <tr>
            <th>##BONUS_MANAGER_CLAIM_COST##</th>
            <th>##BONUS_MANAGER_SUM_AVAILABLE##</th>
            <th>##BONUS_MANAGER_USE##</th>
        </tr>
        </thead>
        <tr class="{cycle values="even,odd"}">
            <td>{$BONUS.claim_amount} {$BONUS.cur_alias}</td>
            <td>{$BONUS.bonus_sum} {$BONUS.cur_alias}</td>
            <td><input type="text" class="frm-input MAX_AMOUNT num required" data-min="0" data-max="{$BONUS.MAX_AMOUNT}"
                       value="{$BONUS.MAX_AMOUNT}"> {$BONUS.cur_alias}
                <button class="bonus_use">##BONUS_MANAGER_USE_BTN##</button>
            </td>
        </tr>
    </table>
{/if}