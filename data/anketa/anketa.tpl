<br>
<div class="anketa_hide">{$anketa_title} {if $model.instruction_url}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{$model.instruction_url}" target="_blank">инструкция по заполнению анкеты</a>{/if}</div>
{if $visaforminputed && $print_anketa}
    <br>
    <div class="print-container"><a target="_blank" id="anketa_print_btn" href="{$routes.anketa.url}samo_action=ANKETA_SAMOTOUR&CLAIM={$model.CLAIM}&PEOPLE={$model.PEOPLE}&EXTERNAL={$external}">##PRINT##</a></div>
    <br>
{/if}
<br>
{if $model.photo}
    {include file="td_photo.tpl" elements=$model.photo}
{/if}
<form id="ANKETA_FORM" name="ANKETA_FORM" action="{$routes.anketa.url}{if strpos($routes.anketa.url,'?')}&{else}?{/if}samo_action=SAVE&CLAIM={$model.CLAIM}&PEOPLE={$model.PEOPLE}" method="post">
    <div class="anketa_hide">
        <div class="red">{$anketa_lng_rule}</div>
        <br>
        {include file="`$smarty.const._ROOT`templates/fieldset_builder.tpl"}
        {if $enable_save}
            <br>
            <input type="checkbox" name="VISA_INPUTED" id="VISA_INPUTED" value="1" {if $visaforminputed}checked disabled{/if}> Я уверен(а), что анкета заполнена правильно, вся предоставленная информация достоверна и готова к передаче в консульство {if $warn_about_visaforminputed}<span class="red">(после внесения данной отметки редактирование анкеты невозможно)</span>{/if}.
            <br>
            <input type="submit" value="##BTN_SAVE##">
        {/if}
    </div>
</form>
<iframe name="iframe_anketa_photo" width="0px" height="0px" src="about:blank" style="visibility: hidden;"></iframe>
