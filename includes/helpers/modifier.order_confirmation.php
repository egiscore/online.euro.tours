<?php
 function smarty_modifier_order_confirmation($status) { switch ($status) { case 4: $confirm = 'ORDER_CANCELED'; break; case 0: $confirm = 'ORDER_NOT_CONFIRMED'; break; case 1: $confirm = 'ORDER_AWAITING'; break; case 2: $confirm = 'ORDER_CONFIRMED'; break; default: $confirm = 'ORDER_NO_ANSWER'; break; } $messages = Samo_Registry::get('messages'); return '<div class="status '.$confirm.'">'.$messages[$confirm].'</div>'; } ?>