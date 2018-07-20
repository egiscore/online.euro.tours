<html>
<head>
    <title>##PAGE_TITLE##</title>
    {cssload file="confirmation.css"}
    {cssload file="customer.css" required=false}
</head>
<body>
<div id="resultset">{$content_for_layout|default:"##NO_DATA##"}</div>
<div id="buttons">
    <button id="print" onclick="window.print();">##CONFIRMATION_PRINT##</button>
</div>
{include file="../common.tpl"}
</body>
</html>
