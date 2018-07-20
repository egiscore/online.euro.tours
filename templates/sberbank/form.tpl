<div id="sberbank_cont">
    <fieldset class="panel">
        <legend>##SBERBANK_PAYMENT_INFO##</legend>
        <form class="pay_variant" id="sberbank_pay_variant_form" method="POST" action=""{if $smarty.session.samo_auth.type == 'agency'} target="_blank"{/if}>
            <table width="100%" style="border-collapse: separate; border-spacing: 5px">
                <tr>
                    <td class="left_column">##SBERBANK_PAID##</td>
                    <td>{$sberbank_paid} {$sberbank_currency_public}</td>
                </tr>
                <tr>
                    <td class="left_column">##SBERBANK_INPUT_AMOUNT##:</td>
                    <td>
                        <input class="frm-input" type="text" value="{$sberbank_amount}" name="amount" data-min="{$sberbank_min_amount}" data-max="{$sberbank_amount}"> {$sberbank_currency}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="center">
                        <button id="sberbank_submit">##SBERBANK_SUBMIT##</button>
                    </td>
                </tr>
            </table>
        </form>
        <form id="sberbank_link" action="" method="GET"{if $smarty.session.samo_auth.type == 'agency'} target="_blank"{/if} style="display: none">
            <button>##SBERBANK_PAY_ON_BANK_SITE##</button>
        </form>
    </fieldset>
</div>