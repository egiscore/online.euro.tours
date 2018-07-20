<?php
 foreach (array('messages_' . $LNG . '.php', 'message_rus.php') as $file) { $file = $dirname.'/'.$file; if (file_exists($file)) { include $file; } } 