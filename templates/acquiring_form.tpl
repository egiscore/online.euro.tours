<div id="acquiring_{$moduleName}_container">
    <fieldset class="panel">
        <legend>##ACQUIRING_PAYMENT_INFO##</legend>
        <form class="pay_variant"  method="POST" action="{$formAction}" {if $smarty.session.samo_auth.type == 'agency'} target="_blank"{/if}>
            <table width="100%" style="border-collapse: separate; border-spacing: 5px">
                <tr>
                    <td class="left_column">##ACQUIRING_PAID##:</td>
                    <td>{$paid} {$currency}</td>
                </tr>
                <tr>
                    <td class="left_column">##ACQUIRING_INPUT_AMOUNT##:</td>
                    <td>
                        <input id="pv_amount" class="frm-input" type="text" value="{if $maxAmount && $maxAmount < $amount}{$maxAmount}{else}{$amount}{/if}" name="amount" data-min="{$minAmount}" data-max="{if $maxAmount && $maxAmount < $amount}{$maxAmount}{else}{$amount}{/if}"> {$currency}
                    </td>
                </tr>

                {if $visibleFields}
                    {foreach from=$visibleFields item="vft" key="vfn"}
                        <tr>
                            <td class="left_column">{$vft}:</td>
                            <td class="left_column"><input name="{$vfn|escape}" class="frm-input acf-visible-field"></td>
                        </tr>
                    {/foreach}
                {/if}
                {if $maxAmount || $minAmount}
                    <tr>
                        <td class="acquiring-amount-comment" colspan="2">
                            {if $maxAmount && $minAmount}
                                ##ACQUIRING_RANGE_AMOUNT_FROM## {$minAmount|number_format:0:' ':' '} ##ACQUIRING_RANGE_AMOUNT_TO## {$maxAmount|number_format:0:' ':' '}
                            {else}
                                {if $maxAmount}
                                    ##ACQUIRING_MAX_AMOUNT## {$maxAmount|number_format:0:' ':' '}
                                {else}
                                    ##ACQUIRING_MIN_AMOUNT## {$minAmount|number_format:0:' ':' '}
                                {/if}
                            {/if}
                            {$currency}
                        </td>
                    </tr>
                {/if}
                <tr>
                    <td colspan="2" class="center">
                        {if $hiddenFields}
                            {foreach from=$hiddenFields item="e" key="i"}
                                <input type="hidden" name="{$i}" value="{$e}" id="acqf_{$i}">
                            {/foreach}
                        {/if}
                        <button class="acquiring_submit">##ACQUIRING_SUBMIT##</button>
                        <span class="acquiring-loading-text" style="display: none;">##LOADING_DATA##</span>
                        <button class="acquiring_submit_manual" style="display: none">##ACQUIRING_SUBMIT_MANUAL##</button>
                    </td>
                </tr>
            </table>
        </form>
    </fieldset>
</div>
