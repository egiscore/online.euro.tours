<html>
<head>
    <title>##PAGE_TITLE##</title>
    {cssload file="common.css"}
    {cssload file="aviaticket_cost.css"}
</head>
<body>
<div class="samo_container">
<div id="resultset" claim="{$CLAIM}">
    <div>##AC_CLAIM_NUMBER##{$CLAIM}</div>
    <div>##AC_TOUR_ROUTE## {$info.routename}</div>
    <div>##AC_CLASS## {$info.classname}</div>
    <br>
    {if count($info.adults)}
        <table class="res">
            <thead>
            <tr>
                <th>&nbsp;</th><th>##AC_PEOPLE_LNAME##</th><th>##AC_PEOPLE_NAME##</th>
            </tr>
            </thead>
            <tbody>
                {foreach from = $info.adults item = "people" name="peoples"}
                    <tr id="people_{$people.Inc}" peopleinfo="{$people.Inc}">
                        <td><input type="checkbox" checked="true" class="adult" name="ch_people[{$smarty.foreach.peoples.iteration}]" id="ch_people[{$smarty.foreach.peoples.iteration}]"></td>
                        <td class="fio">{$people.LName}</td>
                        <td><input type="text" class="tourist" value="" name="people[{$smarty.foreach.peoples.iteration}]" id="people[{$smarty.foreach.peoples.iteration}]"></td>
                    </tr>
                {/foreach}
                {foreach from = $info.infants item = "people" name="peoples"}
                    <tr id="people_{$people.Inc}" peopleinfo="{$people.Inc}">
                        <td><input type="checkbox" checked="true" class="infant" name="ch_ipeople[{$smarty.foreach.peoples.iteration}]" id="ch_ipeople[{$smarty.foreach.peoples.iteration}]"></td>
                        <td class="fio">{$people.LName}</td>
                        <td><input type="text" class="tourist" value="" name="ipeople[{$smarty.foreach.peoples.iteration}]" id="ipeople[{$smarty.foreach.peoples.iteration}]"></td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    {else}
        <p>##AC_NO_PEOPLES##</p>
    {/if}
    <div id="buttons" style="clear: both">
        <button id="loadBtn">##AC_PRINT_BTN##</button>
    </div>
</div>
{include file="../common.tpl"}
{jsload file="aviaticket_cost.js"}
</div>
<noscript><h1 class="error">##JAVASCRIPT_MUST_BE_ENABLED##</h1></noscript>
</body>
</html>
