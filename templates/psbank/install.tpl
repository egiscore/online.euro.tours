<table id="KVITOK" bordercolor="#000000" cellspacing="0" bordercolordark="#000000" cellpadding="1" bordercolorlight="#000000" border="1">
    <tbody>
        <tr bgcolor="#ffffff">
            <td width="280" height="302" rowspan="7">
            <table cellpadding="0" width="100%" border="0">
                <tbody>
                    <tr>
                        <td valign="top" width="100%" height="65"><strong>���������</strong><br />
                        �_____________</td>
                    </tr>
                    <tr>
                        <td valign="bottom" width="100%" height="220">�������� ��������</td>
                    </tr>
                </tbody>
            </table>
            </td>
            <td valign="top" colspan="3">
            <table>
                <tbody>
                    <tr>
                        <td colspan="2"><strong>����������: {$owner_info.Partner_partnerofficialname}</strong></td>
                        <td width="10%" nowrap="nowrap">���: {$owner_info.Partner_partnerinn}</td>
                    </tr>
                    <tr>
                        <td colspan="2">�/��. {$owner_info.Partner_partnerrs}</td>
                    </tr>
                    <tr>
                        <td colspan="2">� ����� ??????????? �.������</td>
                    </tr>
                    <tr>
                        <td colspan="2">����. ��. ???????</td>
                        <td nowrap="nowrap">���: ???????</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                        <td nowrap="nowrap">���: {$INVOICESFORBANK.inumber}</td>
                    </tr>
                </tbody>
            </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">����������:</td>
        </tr>
        <tr>
            <td colspan="3">{$payer.PAYER_FIO}, {$payer.PAYER_ADDRESS}, {$payer.PAYER_PSERIE} {$payer.PAYER_PNUMBER}</td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td align="center">���������� �������</td>
            <td align="center">����</td>
            <td align="center">�����</td>
        </tr>
        <tr>
            <td valign="top">������ ������������� ����� �� ����-�������� �{$invoice.number} �� {$invoice.ddate|date_format:'d-m-Y'} �� {$partner_info.partnerofficialname}. ��� �� ����������.</td>
            <td align="center">{$config.datenow|date_format:'d-m-Y'}</td>
            <td align="center">{$payer.TOPAY}</td>
        </tr>
        <tr>
            <td colspan="3">����������</td>
        </tr>
        <tr bgcolor="#ffffff">
            <td width="280" height="302" rowspan="7">
            <table cellpadding="0" width="100%" border="0">
                <tbody>
                    <tr>
                        <td valign="top" width="100%" height="65"><strong>���������</strong><br />
                        �_____________</td>
                    </tr>
                    <tr>
                        <td valign="bottom" width="100%" height="220">�������� ��������</td>
                    </tr>
                </tbody>
            </table>
            </td>
            <td valign="top" colspan="3">
            <table>
                <tbody>
                    <tr>
                        <td colspan="2"><strong>����������: {$owner_info.Partner_partnerofficialname}</strong></td>
                        <td width="10%" nowrap="nowrap">���: {$owner_info.Partner_partnerinn}</td>
                    </tr>
                    <tr>
                        <td colspan="2">�/��. {$owner_info.Partner_partnerrs}</td>
                    </tr>
                    <tr>
                        <td colspan="2">� ����� ??????????? �.������</td>
                    </tr>
                    <tr>
                        <td colspan="2">����. ��. ???????</td>
                        <td nowrap="nowrap">���: ???????</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                        <td nowrap="nowrap">���: {$INVOICESFORBANK.inumber}</td>
                    </tr>
                </tbody>
            </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">����������:</td>
        </tr>
        <tr>
            <td colspan="3">{$payer.PAYER_FIO}, {$payer.PAYER_ADDRESS}, {$payer.PAYER_PSERIE} {$payer.PAYER_PNUMBER}</td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td align="center">���������� �������</td>
            <td align="center">����</td>
            <td align="center">�����</td>
        </tr>
        <tr>
            <td valign="top">������ ������������� ����� �� ����-�������� �{$invoice.number} �� {$invoice.ddate|date_format:'d-m-Y'} �� {$partner_info.partnerofficialname}. ��� �� ����������.</td>
            <td align="center">{$config.datenow|date_format:'d-m-Y'}</td>
            <td align="center">{$payer.TOPAY}</td>
        </tr>
        <tr>
            <td colspan="3">����������</td>
        </tr>
    </tbody>
</table>
