<div id="login" data-partpass_inc="{$login.inc}" data-partpass_delete_confirm="##LOGIN_CONFIRM_DELETE##">
    <fieldset><legend>##LOGIN_INFO##</legend>
        <div class="row">
            <label class="required">##LOGIN_FULLNAME##</label>
            <input type="text" class="fio text required" name="PARTPASS_FULLNAME" id="PARTPASS_FULLNAME" value="{$login.fullname}">
        </div>
        <div class="row">
            <label class="required">##LOGIN_BORN##</label>
            <input type="text" class="date required" name="PARTPASS_BORN" id="PARTPASS_BORN" value="{$login.born|date_format}">
        </div>
        <div class="row">
            <label class="required">##LOGIN_MALE##</label>
            <div class="sex"><span><input type="radio" {if $login.male == 1}checked="checked"{/if} name="PARTPASS_MALE" id="SEX_M" value="1"><label for="SEX_M">##MALE##</label></span>&nbsp;<span><input type="radio" name="PARTPASS_MALE" id="SEX_F" {if $login.male == 0}checked="checked"{/if} value="0"><label for="SEX_F">##FEMALE##</label></span></div>
        </div>
        <div class="row">
            <label class="required">##LOGIN_OCCUPATION##</label>
            <input type="text" class="string required" name="PARTPASS_OCCUPATION" id="PARTPASS_OCCUPATION" value="{$login.occupation}">
        </div>
        <div class="row">
            <label class="required">##LOGIN_PHONES##</label>
            <input type="text" class="string required" name="PARTPASS_PHONES" id="PARTPASS_PHONES" value="{$login.phones}">
        </div>
        <div class="row">
            <label class="required">##LOGIN_FAXES##</label>
            <input type="text" class="string required" name="PARTPASS_FAXES" id="PARTPASS_FAXES" value="{$login.faxes}">
        </div>
        <div class="row">
            <label class="required">##LOGIN_EMAIL##</label>
            <input type="text" class="string required" name="PARTPASS_EMAIL" id="PARTPASS_EMAIL" value="{$login.email}">
        </div>
        <div class="row">
            <label class="required">##LOGIN_ALIAS##</label>
            <input type="text" class="string required" name="PARTPASS_ALIAS" id="PARTPASS_ALIAS" value="{$login.alias}">
        </div>
        {if $login.inc > 0}
            <div class="row">
                <label>##LOGIN_ONLINE_ACCESS##</label>
                <div class="sex">
                    <input type="checkbox" {if $login.online_access == 1 || !isset($login.inc)}checked="checked"{/if} name="PARTPASS_ONLINE_ACCESS" id="PARTPASS_ONLINE_ACCESS" value="1">
                </div>
            </div>
            <div class="row">
                <label><span class="red">##LOGIN_ONLINE_DELETED##</span></label>
                <div class="sex">
                    <button class="login_delete">##LOGIN_ONLINE_DELETED##</button>
                </div>
            </div>
        {/if}
    </fieldset>
    <div>##REQUIRE_BOLD##</div>
    {if $show_save_partpass_btn}
        <br>
        <button class="login_load">##BTN_SAVE##</button>
    {/if}
</div>
