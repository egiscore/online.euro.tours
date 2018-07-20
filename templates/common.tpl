{strip}
{jsload file="pack.main.js,##LANG##.js,page_callback.js" required=false}
<!--@@AS_JS@@-->
{/strip}
{if 'dev' == $smarty.const.APPMODE && Samo_Request::is_developer()}
    <div class="debug-warning" style="margin: 50px auto;width: 240px;padding:  10px; border: solid 2px red; background-color: pink; color: brown">
        You must change the APPMODE to 'test' !
    </div>
{/if}