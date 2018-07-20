{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="anketa.css,edit_tourist.css"}
{include file="../partial_top.tpl"}
{if !$complete}
    <div id="anketa" class="container" data-people="{$model.PEOPLE}" data-claim="{$model.CLAIM}">
        {$content_for_layout}
        <div class="anketa_hide">
            {if $model.anketa == 'spain_mow' || $model.anketa == 'greece_mow' || $model.anketa == 'uae_mow' || $model.anketa == 'finland_labirint' || $model.anketa == 'cyprus_labirint' || $model.anketa == 'greece_pegas_com_ua'}
                {if $enable_save}
                    <br>
                    <input type="checkbox" name="VISA_INPUTED" id="VISA_INPUTED" value=1 {if $visaforminputed}checked disabled{/if}> Я уверен(а), что анкета заполнена правильно, вся предоставленная информация достоверна и готова к передаче в консульство {if $warn_about_visaforminputed}<span class="red">(после внесения данной отметки редактирование анкеты невозможно)</span>{/if}.
                    <br>
                    <button class="load">##BTN_SAVE##</button>
                {/if}
            {/if}
        </div>
    </div>
{else}
    Анкета выводится на экран
{/if}
{include file="../common.tpl"}
{jsload file="anketa.js"}
{jsload file="anketa/anketa_custom.js"}
{jsload file="anketa/jquery.imgareaselect.min.js"}
{jsload file="anketa/jquery.rotate.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}