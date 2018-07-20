<div class="samo_container {$smarty.get.page|escape:'html'}" data-csrf-token="{$csrf_token}">
    {if isset($logged) && ($smarty.get.page != 'bron_person' || !isset($smarty.get.GUEST)) && $smarty.get.contentonly != '1'}
        <div id="div_logout">{include file="`$smarty.const._ROOT`templates/controls.tpl" control="logout"}</div>
    {/if}
<div class="eraser"></div>
