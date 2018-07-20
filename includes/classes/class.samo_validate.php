<?php
 class Samo_Validate extends Validate { public static function domain($domain, $options = null) { $whitelist = ['localhost', '127.0.0.1']; if (in_array($domain, $whitelist)) { return true; } if (!strpos($domain, '.')) { return false; } $domain_check = true; if (is_array($options)) { extract($options); } if (function_exists('checkdnsrr')) { if ($domain_check) { return checkdnsrr($domain, 'A'); } } if (preg_match('/^([a-z0-9]([-a-z0-9]*[a-z0-9])?\\.)+((a[cdefgilmnoqrstuwxz]|aero|arpa)|(b[abdefghijmnorstvwyz]|biz)|(c[acdfghiklmnorsuvxyz]|cat|com|coop)|d[ejkmoz]|(e[ceghrstu]|edu)|f[ijkmor]|(g[abdefghilmnpqrstuwy]|gov)|h[kmnrtu]|(i[delmnoqrst]|info|int)|(j[emop]|jobs)|k[eghimnprwyz]|l[abcikrstuvy]|(m[acdghklmnopqrstuvwxyz]|mil|mobi|museum)|(n[acefgilopruz]|name|net)|(om|org)|(p[aefghklmnrstwy]|pro)|qa|r[eouw]|s[abcdeghijklmnortvyz]|(t[cdfghjklmnoprtvwz]|travel)|u[agkmsyz]|v[aceginu]|w[fs]|y[etu]|z[amw])$/i', $domain)) { return true; } return false; } public static function Partner_inn($inn, $options = null) { $inn = (string)$inn; if (!intval($inn) || preg_match('/\D/', $inn)) { return false; } $len = strlen($inn); if ($len === 9) { return $inn[8] === (string)(( 29 * $inn[0] + 23 * $inn[1] + 19 * $inn[2] + 17 * $inn[3] + 13 * $inn[4] + 7 * $inn[5] + 5 * $inn[6] + 3 * $inn[7]) % 11); } if ($len === 10) { return $inn[9] === (string)((( 2 * $inn[0] + 4 * $inn[1] + 10 * $inn[2] + 3 * $inn[3] + 5 * $inn[4] + 9 * $inn[5] + 4 * $inn[6] + 6 * $inn[7] + 8 * $inn[8] ) % 11) % 10); } elseif ($len === 12) { $num10 = (string)((( 7 * $inn[0] + 2 * $inn[1] + 4 * $inn[2] + 10 * $inn[3] + 3 * $inn[4] + 5 * $inn[5] + 9 * $inn[6] + 4 * $inn[7] + 6 * $inn[8] + 8 * $inn[9] ) % 11) % 10); $num11 = (string)((( 3 * $inn[0] + 7 * $inn[1] + 2 * $inn[2] + 4 * $inn[3] + 10 * $inn[4] + 3 * $inn[5] + 5 * $inn[6] + 9 * $inn[7] + 4 * $inn[8] + 6 * $inn[9] + 8 * $inn[10] ) % 11) % 10); if ($inn[11] === $num11 && $inn[10] === $num10) { return true; } else { $kaz_bin = (string)(( $inn[0] + 2 * $inn[1] + 3 * $inn[2] + 4 * $inn[3] + 5 * $inn[4] + 6 * $inn[5] + 7 * $inn[6] + 8 * $inn[7] + 9 * $inn[8] + 10 * $inn[9] + 11 * $inn[10] ) % 11); if ($inn[11] === $kaz_bin) { return true; } $kaz_iin = (string)(( 3 * $inn[0] + 4 * $inn[1] + 5 * $inn[2] + 6 * $inn[3] + 7 * $inn[4] + 8 * $inn[5] + 9 * $inn[6] + 10 * $inn[7] + 11 * $inn[8] + 1 * $inn[9] + 2 * $inn[10] ) % 11); if ($inn[11] === $kaz_iin) { return true; } } } else { if ($len === 9) { $num9 = (string)( (29 * $inn[0] + 23 * $inn[1] + 19 * $inn[2] + 17 * $inn[3] + 13 * $inn[4] + 7 * $inn[5] + 5 * $inn[6] + 3 * $inn[7]) % 11 ); return $inn[8] == $num9; } } return false; } public static function Partner_ogrn($ogrn, $options = null) { $ogrn = (string)$ogrn; if (!intval($ogrn) || preg_match('/\D/', $ogrn)) { return false; } $len = strlen($ogrn); if ($len === 13 || $len == 15) { $ost = bcsub( substr($ogrn, 0, -1), bcmul( bcdiv( substr($ogrn, 0, -1), $len - 2 ), $len - 2 ) ); return substr($ogrn, -1) === substr($ost, -1); } return false; } public static function Partner_email($value, $options = null) { return self::CheckEmails($value, $options); } public static function Partner_email1($value, $options = null) { return self::CheckEmails($value, $options); } public static function Partner_accountemail($value, $options = null) { return self::CheckEmails($value, $options); } public static function Partpass_email($value, $options = null) { return self::CheckEmails($value, $options); } public static function anketa_india_mow_Email($value, $options = null) { return self::CheckEmails($value, $options); } public static function anketa_spain_mow_v1_Email($value, $options = null) { return self::CheckEmails($value, $options); } public static function CheckEmails($value, $options = null) { $error = 0; $res = preg_split('[,|;]', $value); foreach ($res as $row) { $error = $error + ((self::email(trim($row), $options)) ? 0 : 1); } return ($error == 0); } } 