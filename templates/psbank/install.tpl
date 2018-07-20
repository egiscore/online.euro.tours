<table id="KVITOK" bordercolor="#000000" cellspacing="0" bordercolordark="#000000" cellpadding="1" bordercolorlight="#000000" border="1">
    <tbody>
        <tr bgcolor="#ffffff">
            <td width="280" height="302" rowspan="7">
            <table cellpadding="0" width="100%" border="0">
                <tbody>
                    <tr>
                        <td valign="top" width="100%" height="65"><strong>ИЗВЕЩЕНИЕ</strong><br />
                        №_____________</td>
                    </tr>
                    <tr>
                        <td valign="bottom" width="100%" height="220">Кассовый работник</td>
                    </tr>
                </tbody>
            </table>
            </td>
            <td valign="top" colspan="3">
            <table>
                <tbody>
                    <tr>
                        <td colspan="2"><strong>Получатель: {$owner_info.Partner_partnerofficialname}</strong></td>
                        <td width="10%" nowrap="nowrap">ИНН: {$owner_info.Partner_partnerinn}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Р/сч. {$owner_info.Partner_partnerrs}</td>
                    </tr>
                    <tr>
                        <td colspan="2">В банке ??????????? г.Москва</td>
                    </tr>
                    <tr>
                        <td colspan="2">Корр. сч. ???????</td>
                        <td nowrap="nowrap">БИК: ???????</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                        <td nowrap="nowrap">КОД: {$INVOICESFORBANK.inumber}</td>
                    </tr>
                </tbody>
            </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">Плательщик:</td>
        </tr>
        <tr>
            <td colspan="3">{$payer.PAYER_FIO}, {$payer.PAYER_ADDRESS}, {$payer.PAYER_PSERIE} {$payer.PAYER_PNUMBER}</td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td align="center">Назначение платежа</td>
            <td align="center">Дата</td>
            <td align="center">Сумма</td>
        </tr>
        <tr>
            <td valign="top">Оплата туристических услуг по счет-договору №{$invoice.number} от {$invoice.ddate|date_format:'d-m-Y'} за {$partner_info.partnerofficialname}. НДС не облагается.</td>
            <td align="center">{$config.datenow|date_format:'d-m-Y'}</td>
            <td align="center">{$payer.TOPAY}</td>
        </tr>
        <tr>
            <td colspan="3">Плательщик</td>
        </tr>
        <tr bgcolor="#ffffff">
            <td width="280" height="302" rowspan="7">
            <table cellpadding="0" width="100%" border="0">
                <tbody>
                    <tr>
                        <td valign="top" width="100%" height="65"><strong>КВИТАНЦИЯ</strong><br />
                        №_____________</td>
                    </tr>
                    <tr>
                        <td valign="bottom" width="100%" height="220">Кассовый работник</td>
                    </tr>
                </tbody>
            </table>
            </td>
            <td valign="top" colspan="3">
            <table>
                <tbody>
                    <tr>
                        <td colspan="2"><strong>Получатель: {$owner_info.Partner_partnerofficialname}</strong></td>
                        <td width="10%" nowrap="nowrap">ИНН: {$owner_info.Partner_partnerinn}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Р/сч. {$owner_info.Partner_partnerrs}</td>
                    </tr>
                    <tr>
                        <td colspan="2">В банке ??????????? г.Москва</td>
                    </tr>
                    <tr>
                        <td colspan="2">Корр. сч. ???????</td>
                        <td nowrap="nowrap">БИК: ???????</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                        <td nowrap="nowrap">КОД: {$INVOICESFORBANK.inumber}</td>
                    </tr>
                </tbody>
            </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">Плательщик:</td>
        </tr>
        <tr>
            <td colspan="3">{$payer.PAYER_FIO}, {$payer.PAYER_ADDRESS}, {$payer.PAYER_PSERIE} {$payer.PAYER_PNUMBER}</td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td align="center">Назначение платежа</td>
            <td align="center">Дата</td>
            <td align="center">Сумма</td>
        </tr>
        <tr>
            <td valign="top">Оплата туристических услуг по счет-договору №{$invoice.number} от {$invoice.ddate|date_format:'d-m-Y'} за {$partner_info.partnerofficialname}. НДС не облагается.</td>
            <td align="center">{$config.datenow|date_format:'d-m-Y'}</td>
            <td align="center">{$payer.TOPAY}</td>
        </tr>
        <tr>
            <td colspan="3">Плательщик</td>
        </tr>
    </tbody>
</table>
