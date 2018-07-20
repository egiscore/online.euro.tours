<html>
<head>
    <title>##PAGE_TITLE##</title>
    {cssload file="common.css, aviaticket_cost.css"}
    {cssload file="customer.css" required=false}
</head>
<body>
<div id="resultset">{$content_for_layout|default:"##NO_DATA##"}</div>
<div id="buttons" style="clear: both">
    <button id="print" onclick="window.print();">##PRINT##</button>
</div>
{include file="../common.tpl"}
</body>
</html>
