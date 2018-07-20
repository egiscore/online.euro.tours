<html>
<head>
    <title>##SBERBANK_RESULT_TITLE##</title>
    <meta content="text/html; charset=windows-1251" http-equiv="Content-Type">
    {cssload file="sberbank.css"}
</head>
<body>
    <table width="100%" height="100%">
        <tr>
            <td class="sberbank_header">##SBERBANK_POPUP_TITLE##</td>
        </tr>
        <tr>
            <td class="sberbank_line">&nbsp;</td>
        </tr>
        <tr>
            <td class="sberbank_content">
                <span class="{if $sberbank_result.error}sberbank_error_result{else}sberbank_ok_result{/if}">{$sberbank_result.result}</span>
            </td>
        </tr>
    </table>
</body>
</html>