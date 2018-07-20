<?php
 function smarty_function_fckeditor($params, &$smarty) { $hEdit = new FCKeditor($params['name']); $hEdit->Width = '800'; $hEdit->Height = '600'; $hEdit->ToolbarSet = 'Public'; $hEdit->Config['BodyId'] = 'resultset'; $hEdit->Config['EditorAreaCSS'] = WWWROOT.'public/css/print.css'; $hEdit->Value = $params['content']; return $hEdit->CreateHtml(); } ?>
