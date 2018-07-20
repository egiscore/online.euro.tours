<form id="kkb_kz_form" class="pay_variant" method="POST" action="{$kkb_kz_pay_url}" target="_blank">
    <fieldset class="panel">
        <legend>##KKB_KZ_PAYMENT_INFO##</legend>
        <table width="100%" style="border-collapse: separate; border-spacing: 5px">
            <tr>
                <td class="left_column">##KKB_KZ_PAID##</td>
                <td>{$kkb_kz_paid} {$kkb_kz_currency_public}</td>
            </tr>
            <tr>
                <td class="left_column">##KKB_KZ_INPUT_AMOUNT##:</td>
                <td>
                    <input class="frm-input" type="text" value="{$kkb_kz_amount}" name="amount" data-max="{$kkb_kz_amount}"> {$kkb_kz_currency}
                </td>
            </tr>
            <tr>
                <td class="left_column">##KKB_KZ_INPUT_EMAIL##:</td>
                <td>
                    <input class="frm-input" type="text" value="{$kkb_kz_email}" name="email" data-max="{$kkb_kz_amount}">
                </td>
            </tr>
            <tr>
                <td colspan="2" class="center">
                    <input type="hidden" name="Signed_Order_B64" id="kkb_kz_signed_order_id" value="">
                    <input type="hidden" name="Language" value="rus">
                    <input type="hidden" name="BackLink" value="{$kkb_kz_back_link}">
                    <input type="hidden" name="FailureBackLink" value="{$kkb_kz_failure_back_link}">
                    <input type="hidden" name="PostLink" value="{$kkb_kz_post_link}">
                    <input type="hidden" name="FailurePostLink" value="{$kkb_kz_failure_post_link}">
                    <input type="hidden" name="appendix" id="kkb_kz_appendix" value="">
                    <button id="kkb_kz_submit">##KKB_KZ_SUBMIT##</button>
                    <a target="_blank" id="kkb_kz_link" href="" style="display: none"></a>
                </td>
            </tr>
        </table>
    </fieldset>
</form>