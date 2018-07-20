<div class="samo_container">
    <table class="res">
        <tbody>
            <tr class="even">
                <td class="dark">##AGENCIES_NAME##:</td>
                <td>{$data.officialName}&nbsp;</td>
            </tr>
            <tr class="odd">
                <td class="dark">##AGENCIES_TITLE##:</td>
                <td>{$data.name}&nbsp;</td>
            </tr>
            <tr class="even">
                <td class="dark">##AGENCIES_ADDRESS##:</td>
                <td>{$data.address}&nbsp;</td>
            </tr>
            <tr class="odd">
                <td class="dark">##AGENCIES_OGRN##:</td>
                <td>{$data.ogrn}&nbsp;</td>
            </tr>
            <tr class="even">
                <td class="dark">##AGENCIES_INN##:</td>
                <td>{$data.inn}&nbsp;</td>
            </tr>
            <tr class="odd">
                <td class="dark">##AGENCIES_KPP##:</td>
                <td>{$data.kpp}&nbsp;</td>
            </tr>
            <tr class="even">
                <td class="dark">##AGENCIES_DATE_REGISTER##:</td>
                <td>{$data.registrationDate}&nbsp;</td>
            </tr>
            {if !$data.status}
                <tr class="odd">
                    <td class="dark">##AGENCIES_DATE_CLOSE##:</td>
                    <td class="red">{$data.stopDate}&nbsp;</td>
                </tr>
            {/if}
            <tr class="even">
                <td class="dark">##AGENCIES_STATUS##:</td>
                {if $data.status}<td>##AGENCIES_STATUS_YES##</td>{else}<td class="red">##AGENCIES_STATUS_NO##</td>{/if}
            </tr>
            <tr class="odd">
                <td class="dark">##AGENCIES_OWNER##:</td>
                <td>{$data.boss}&nbsp;</td>
            </tr>
            <tr class="even">
                <td class="dark">##AGENCIES_ACTIVITIE##:</td>
                <td>{$data.activity}&nbsp;</td>
            </tr>
            <tr class="odd">
                <td class="dark">##AGENCIES_OKVED##:</td>
                <td>{$data.okved}&nbsp;</td>
            </tr>
            <tr class="even">
                <td class="dark">##AGENCIES_DOG##:</td>
                <td>{$data.contractNumber}&nbsp;</td>
            </tr>
            <tr class="odd">
                <td class="dark">##AGENCIES_AVAILABLE##:</td>
                <td>{if $data.contractAvailable == 2}##AGENCIES_AVAILABLE_YES##{elseif $data.contractAvailable == 1}&nbsp;{else}##AGENCIES_AVAILABLE_NO##{/if}</td>
            </tr>
            {if $data['verificationDate']->not_null()}
                <tr class="even">
                    <td class="dark">##AGENCIES_DATE##:</td>
                    <td>{$data.verificationDate|datetime_format}</td>
                </tr>
            {/if}
        </tbody>
    </table>
</div>