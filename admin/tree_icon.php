<script>
var root = '';
var tree_tpl = {
	'target'  : 'content',	// name of the frame links will be opened in
							// other possible values are: _blank, _parent, _search, _self and _top

	'icon_e'  : '<?= $http_site ?>admin/imgs/icons/empty.gif', // empty image
	'icon_l'  : '<?= $http_site ?>admin/imgs/icons/line.gif',  // vertical line
	
	'icon_32' : "<?= $http_site ?>admin/imgs/icons/base.gif",   // root icon normal
	'icon_36' : "<?= $http_site ?>admin/imgs/icons/base.gif",   // root icon normal
	'icon_48' : "<?= $http_site ?>admin/imgs/icons/base.gif",   // root icon normal
	'icon_52' : "<?= $http_site ?>admin/imgs/icons/base.gif",   // root icon selected
	'icon_56' : "<?= $http_site ?>admin/imgs/icons/base.gif",   // root icon opened
	'icon_60' : "<?= $http_site ?>admin/imgs/icons/base.gif",   // root icon selected
	
	'icon_16' : '<?= $http_site ?>admin/imgs/icons/folder.gif', // node icon normal
	'icon_20' : '<?= $http_site ?>admin/imgs/icons/folderopen.gif', // node icon selected
	'icon_24' : '<?= $http_site ?>admin/imgs/icons/folder.gif', // node icon opened
	'icon_28' : '<?= $http_site ?>admin/imgs/icons/folderopen.gif', // node icon selected opened

	'icon_0'  : '<?= $http_site ?>admin/imgs/icons/page.gif', // leaf icon normal
	'icon_4'  : '<?= $http_site ?>admin/imgs/icons/page.gif', // leaf icon selected
	'icon_8'  : '<?= $http_site ?>admin/imgs/icons/page.gif', // leaf icon opened
	'icon_12' : '<?= $http_site ?>admin/imgs/icons/page.gif', // leaf icon selected
	
	'icon_2'  : '<?= $http_site ?>admin/imgs/icons/joinbottom.gif', // junction for leaf
	'icon_3'  : '<?= $http_site ?>admin/imgs/icons/join.gif',       // junction for last leaf
	'icon_18' : '<?= $http_site ?>admin/imgs/icons/plusbottom.gif', // junction for closed node
	'icon_19' : '<?= $http_site ?>admin/imgs/icons/plus.gif',       // junction for last closed node
	'icon_26' : '<?= $http_site ?>admin/imgs/icons/minusbottom.gif',// junction for opened node
	'icon_27' : '<?= $http_site ?>admin/imgs/icons/minus.gif'       // junction for last opended node
};
</script>
