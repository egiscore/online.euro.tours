<?php
function smarty_modifier_vertical_string($string) { $letters = str_split($string); return '<span class="v">' . implode('</span><br /><span class="v">', $letters) . '</span>'; } 