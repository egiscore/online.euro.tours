<?php  ?>
<input type="hidden" name="VARIABLES" value="">
<script type="text/javascript">
var TREE_ITEMS = [
    ['<?= Get_Message_Lang($LNG, 'adm_tree_root') ?>', '', 'center_frame',
<?php
 createMenu(); if (isset($regional_reports)) { foreach ($regional_reports as $ral => $region) { $name = ($LNG == 'rus') ? $region['name'] : $region['lname']; echo "\r\n['$name', '', 'managers_rules'"; foreach ($region['reports'] as $key => $report) { $name = ($LNG == 'rus') ? $modules[$report]['name'] : $modules[$report]['lname']; echo ",\r\n['" . $name . "', '', 'admin_for_regional_$report?region=$ral']"; } echo "],\r\n"; } } ?>
    ]
];
</script>
