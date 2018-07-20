<?php
 function smarty_fileversion($filepath) { static $revision = null; if (is_null($revision)) { $revision = Samo_Utils::assets_revision(); } return '?rev=' . $revision; } ?>
