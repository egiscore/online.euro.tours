<div id="edit_tourist"  data-claiminc="{$model.CLAIM}" data-layout="1" >
    <form method="POST" action="" class="edit_tourist">
        {include file="../fieldset_builder.tpl" fields=$TOURIST print_version=true}
        <a href="{$routes.anketa.url}CLAIM={$model.CLAIM}&PEOPLE={$model.PEOPLE}&accept=1">##BTN_ACCEPT##</a>
        | <a class="modalClose" onclick="samo.edit_tourist_link('{$model.PEOPLE}','{$model.CLAIM}');">##BTN_EDIT##</a>
    </form>
</div>