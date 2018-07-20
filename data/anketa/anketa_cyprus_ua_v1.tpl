<div class="anketa_hide">КИПРСКАЯ АНКЕТА УКРАИНА {if $model.instruction_url}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{$model.instruction_url}" target="_blank">инструкция по заполнению анкеты</a>{/if}</div>
{if $model.photo}
    {include file="td_photo.tpl" elements=$model.photo}
{/if}
<form id="ANKETA_FORM" name="ANKETA_FORM" action="{$routes.anketa.url}samo_action=SAVE&CLAIM={$model.CLAIM}&PEOPLE={$model.PEOPLE}" method="post">
    <div class="anketa_hide">
        <div class="red">Все данные заполняются латинскими буквами</div>
        <br>
        {include file="../fieldset_builder.tpl"}
        <br>
        <input type="checkbox" name="VISA_INPUTED" id="VISA_INPUTED" value=1> Я уверен(а), что анкета заполнена правильно, вся предоставленная информация достоверна и готова к передаче в консульство <span class="red">(после внесения данной отметки редактирование анкеты невозможно)</span>.
        <br>
        <input type="submit" value="##BTN_SAVE##">
    </div>
</form>
<iframe name="iframe_anketa_photo" width="0px" height="0px" src="about:blank" style="visibility: hidden;"></iframe>
