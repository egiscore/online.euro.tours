<html>
<head>
{cssload file="common.css,check_confirm.css"}
<title>##PAGE_TITLE##</title>
</head>
<body>
<div class="samo_container" id="check_confirm" style="display: block">
{include file="resultset.tpl"}
</div>
{jsload file="pack.main.js,##LANG##.js,page_callback.js"}
<!--@@AS_JS@@-->
{jsload file="check_confirm.js"}
</body>
</html>