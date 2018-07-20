<html>
<head>
    <title>##PAGE_TITLE##</title>
    {cssload file="psbank.css"}
</head>
<body>
<div id="resultset">{$content_for_layout|default:"##NO_DATA##"}</div>
<div id="buttons">
    <button id="print" onclick="window.print();">##PRINT##</button>
</div>
{include file="../common.tpl"}
</body>
</html>
