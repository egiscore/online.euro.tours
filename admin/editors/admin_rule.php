<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<body>
    <?=style_css()?>
    <form name="start" action="" method="post">
    <input type="hidden" name="page" value="<?=$ALIAS?>">
    <input type="hidden" name="LNG" value="<?=$LNG?>">
    <input type=hidden name="ADD" value="">
    <input type=hidden name="EDIT" value="">
    <input type=hidden name="SAVE" value="">
    <input type=hidden name="DELETE" value="">
    <input type=hidden name="UNLOCK" value="">
    <script>
          function Vars(add,edit,save,del,unlock){
                document.start.ADD.value = add;
                document.start.EDIT.value = edit;
                document.start.SAVE.value = save;
                document.start.DELETE.value = del;
                document.start.UNLOCK.value = unlock;
                document.start.submit();
            }
            function Check(){
                Vars('','',1,'','');
            }
    </script>
    <?php
 if (isset($SAVE) && ($SAVE == 1)) { save_module_permition($module_alias); } if ((!isset($EDIT)) || ($EDIT != 1) && isset($ADD) && ($ADD != 1)) { echo Get_Message_Lang($LNG, 'adm_permission_setup') . ' <strong>' . ($LNG == 'rus' ? $module_row['Name'] : $module_row['LName']) . '</strong><br><br>'; ?>
        <table align=left cellpadding = 1 cellspacing = 1>
            <tr>
                <td class="capt border_dark">&nbsp;<?= Get_Message_Lang($LNG, 'adm_manager') ?>&nbsp;</td>
                <td class="capt border_dark">&nbsp;<?= Get_Message_Lang($LNG, 'adm_rule') ?>&nbsp;</td>
            </tr>
            <?php
 $sql = $db->formatExec(OFFICE_SQLSERVER . '.' . OFFICEDB . '.[dbo].[up_WEB_3_ADMIN_ModuleUsers]', ['module' => $module_alias]); $res = $db->fetchAll($sql); foreach ($res as $row) { ?>
                <tr>
                    <td class="txt border_dark">&nbsp;<?= $row['UserName'] ?>&nbsp;</td>
                    <td class="txt border_dark">&nbsp;
                        <?php
 if ($row['User_admin']) { echo Get_Message_Lang($LNG, 'adm_administrator_have_full_permition'); } else { if ($row['Access'] == 0) { $only_view = 1; $full_permition = 0; } else { if ($row['Access'] == 1) { $only_view = 0; $full_permition = 1; } else { $only_view = 0; $full_permition = 0; } } $inc = $row['UserInc']; ?>
                            <label>
                                <input type="checkbox" value="1" name="FULL_PERMITION<?= $inc ?>" <?= ($full_permition == 1) ? 'checked' : '' ?> >
                                <?= Get_Message_Lang($LNG, 'adm_full_permition') ?>
                            </label>
                            <label>
                                <input type="checkbox" value="1" name="ONLY_VIEW<?= $inc ?>" <?= ($only_view == 1) ? 'checked' : '' ?> >
                                <?= Get_Message_Lang($LNG, 'adm_only_view') ?>
                            </label>
                            <?php
 } ?>
                        &nbsp;
                    </td>
                </tr>
                <?php
 } ?>
        </table>
        <br clear="all">
        <br>
        <input type="button" value="<?= Get_Message_Lang($LNG, 'adm_save_botton') ?>" name="BSAVE" class="button" onClick="Check();">
    <?php
 } ?>
    </form>
</body>
