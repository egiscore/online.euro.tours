<body>
<?=style_css()?>
<FORM name="start" action="" method="post">

    <style>
        /* Style for tree item text */
        .t0i {
            font-family: Tahoma, Verdana, Geneva, Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #000000;
            background-color: #ffffff;
            text-decoration: none;
        }

        /* Style for tree item image */
        .t0im {
            border: 0px;
            width: 19px;
            height: 16px;
        }
    </style>
    <input type="hidden" name="LNG" value="<?= $LNG ?>">
    <input type="hidden" name="LOCK" value="">

    <?php
 include $folder_site . "admin/tree_items.php"; include $folder_site . "admin/tree.php"; include $folder_site . "admin/tree_icon.php"; ?>
    <script language="JavaScript">
        new tree(TREE_ITEMS, tree_tpl);
    </script>
</form>
</body>
