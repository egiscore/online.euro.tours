<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<body>
<?= style_css() ?>
<style type="text/css">
    body {
        margin: 0px;
    }
</style>
<FORM name="start" action="" method="post">
    <script>
        function gohome() {
            if (parent.frames['tree'].document.start.LOCK.value == 1) {
                alert("<?= Get_Message_Lang($LNG, 'adm_already_edit_record') ?>");
                return;
            }
            if (confirm('<?= Get_Message_Lang($LNG, 'adm_confirm_exit') ?>')) {
                top.location.href = "<?= $http_site ?>admin/index.php?logout=" + (+new Date);
            }
        }
    </script>
    <table width="100%">
        <tr>
            <td width="1px">
                <img src="<?php echo $http_site ?>public/pict/samo.png" alt="САМО-Софт / SAMO-Soft" style="height: 42px;">
            </td>
            <td class="txt" style="vertical-align: bottom; text-align: left; width: 1px; white-space: nowrap;">
                <?php
 if (file_exists(_ROOT . 'includes/version.php')) { $version = include _ROOT . 'includes/version.php'; $version['path'] = basename($version['path']); if ($version['path'] == 'multiservers') { $version['path'] = 'ver.<span style="color: red;">unstable</span>'; } echo $version['path'] . '.' . $version['rev']; unset($version); } ?>
            </td>
            <td>
                <?php
 try { $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_repl_sysinfo'; $rows = $db->fetchAll($sql); $sqlagent = 0; foreach ($rows as $row) { if ($row['Role'] == 'Office' && $row['Option'] == 'SQLAgent running') { $sqlagent = $row['Value']; } } if ($sqlagent == 0) { echo '<h4 style="color: red">' . Get_Message_Lang($LNG, 'check_sqlserveragent') . '</h4>'; } } catch (Samo_Exception $e) { $e; } ?>
            </td>
            <td width="1px" nowrap>
                <?php get_help_button('onlinest', false) ?>
            </td>
            <td width="1px" nowrap class="capt">
                <a href="javascript: gohome();" class="text_white">
                    &nbsp;<b><?= Get_Message_Lang($LNG, 'adm_quit_botton') ?></b>&nbsp;
                </a>
            </td>
            <td width="1px" nowrap>
                <div class="time">
                    <script type="text/javascript">
                        var date = new Date();
                        var weekdays = <?php echo $LNG == 'eng' ? "['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']" : "['Воскресенье','Понедельник','Вторник','Среда','Четверг','Пятница','Суббота','Воскресенье']"; ?>;
                        var weekDay = weekdays[date.getDay()];
                        var month = date.getMonth() >= 9 ? date.getMonth() + 1 : '0' + (date.getMonth() + 1);
                        document.write("<nobr>" + date.getDate() + "." + month + "." + date.getFullYear() + "<br>" + weekDay + "</nobr>");
                    </script>

                    <span id="Clock">&nbsp;</span>

                    <script language="JavaScript">
                        var tick = function () {
                            var hours, minutes, seconds;
                            var intHours, intMinutes, intSeconds;
                            var today;

                            today = new Date();

                            intHours = today.getHours();
                            intMinutes = today.getMinutes();
                            intSeconds = today.getSeconds();

                            if (intHours < 10) {
                                hours = "0" + intHours;
                            } else {
                                hours = intHours;
                            }

                            if (intMinutes < 10) {
                                minutes = "0" + intMinutes;
                            } else {
                                minutes = intMinutes;
                            }

                            if (intSeconds < 10) {
                                seconds = "0" + intSeconds + " ";
                            } else {
                                seconds = intSeconds + " ";
                            }

                            var timeString = "<b>" + hours + ":" + minutes + ":" + seconds + "</b>";
                            document.getElementById('Clock').innerHTML = timeString;
                        }
                        tick();
                        window.setInterval(tick, 1000);
                    </script>
                </div>
            </td>
        </tr>
    </table>
</form>
</body>
