<?php
 function summa_to_str_semantic($i,$f,& $fem){ static $_1_19 = null; static $_1_2 = null; static $des = null; static $hang = null; $words = ''; if (is_null($_1_19)) { $_1_2[1]="���� "; $_1_2[2]="��� "; $_1_19[1]="���� "; $_1_19[2]="��� "; $_1_19[3]="��� "; $_1_19[4]="������ "; $_1_19[5]="���� "; $_1_19[6]="����� "; $_1_19[7]="���� "; $_1_19[8]="������ "; $_1_19[9]="������ "; $_1_19[10]="������ "; $_1_19[11]="����������� "; $_1_19[12]="���������� "; $_1_19[13]="���������� "; $_1_19[14]="������������ "; $_1_19[15]="���������� "; $_1_19[16]="����������� "; $_1_19[17]="���������� "; $_1_19[18]="������������ "; $_1_19[19]="������������ "; $des[2]="�������� "; $des[3]="�������� "; $des[4]="����� "; $des[5]="��������� "; $des[6]="���������� "; $des[7]="��������� "; $des[8]="����������� "; $des[9]="��������� "; $hang[1]="��� "; $hang[2]="������ "; $hang[3]="������ "; $hang[4]="��������� "; $hang[5]="������� "; $hang[6]="�������� "; $hang[7]="������� "; $hang[8]="��������� "; $hang[9]="��������� "; } if($i >= 100){ $jkl = intval($i / 100); $words .= $hang[$jkl]; $i %= 100; } if($i >= 20){ $jkl = intval($i / 10); $words .= $des[$jkl]; $i %= 10; } switch($i) { case 1: $fem=1; break; case 2: case 3: case 4: $fem=2; break; default: $fem=3; break; } if( $i ){ if( $i < 3 && $f > 0 ){ if ( $f >= 2 ) { $words .= $_1_19[$i]; } else { $words .= $_1_2[$i]; } } else { $words .= $_1_19[$i]; } } return $words; } function smarty_modifier_summa_to_str($L, $_als = 'rub') { static $namerub = null; static $kopeek = null; static $nametho = null; static $namemil = null; static $namemrd = null; $lc_ctype = setlocale(LC_CTYPE,0); setlocale(LC_CTYPE,'ru_RU.cp1251','ru_RU.CP1251','rus_RUS','ru_RU'); $_als = strtolower($_als); if (is_null($namerub)) { $namerub['rub'][1]="����� "; $namerub['rub'][2]="����� "; $namerub['rub'][3]="������ "; $namerub['usd'][1]="������ "; $namerub['usd'][2]="������� "; $namerub['usd'][3]="�������� "; $namerub['eur'][1]="���� "; $namerub['eur'][2]="���� "; $namerub['eur'][3]="���� "; $namerub['grv'][1]="������ "; $namerub['grv'][2]="������ "; $namerub['grv'][3]="������ "; $namerub['kzt'][1]="����� "; $namerub['kzt'][2]="����� "; $namerub['kzt'][3]="����� "; $kopeek['rub'][1]="������� "; $kopeek['rub'][2]="������� "; $kopeek['rub'][3]="������ "; $kopeek['usd'][1]="���� "; $kopeek['usd'][2]="����� "; $kopeek['usd'][3]="������ "; $kopeek['eur'][1]="���� ���� "; $kopeek['eur'][2]="���� ����� "; $kopeek['eur'][3]="���� ������ "; $kopeek['grv'][1]="������� "; $kopeek['grv'][2]="������� "; $kopeek['grv'][3]="������ "; $kopeek['kzt'][1]="���� "; $kopeek['kzt'][2]="���� "; $kopeek['kzt'][3]="���� "; $nametho[1]="������ "; $nametho[2]="������ "; $nametho[3]="����� "; $namemil[1]="������� "; $namemil[2]="�������� "; $namemil[3]="��������� "; $namemrd[1]="�������� "; $namemrd[2]="��������� "; $namemrd[3]="���������� "; } $s = $s1 = ''; $L = floatval(str_replace(',', '.', $L)); $kop=intval( ( round($L*100) - round(intval( $L )*100) )); $L=intval($L); if($L>=1000000000){ $many = 0; $s1 = summa_to_str_semantic(intval($L / 1000000000), 3, $many); $s .= $s1 . $namemrd[$many]; $L %= 1000000000; } if($L >= 1000000){ $many=0; $s1 = summa_to_str_semantic(intval($L / 1000000),2,$many); $s .= $s1 . $namemil[$many]; $L %= 1000000; if($L == 0){ $s .= $namerub[$_als][3]; } } if($L >= 1000){ $many=0; $s1 = summa_to_str_semantic(intval($L / 1000),1,$many); $s .= $s1 . $nametho[$many]; $L %= 1000; if($L == 0){ $s .= $namerub[$_als][3]; } } if($L != 0){ $many = 0; $s1 = summa_to_str_semantic($L,0, $many); $s .= $s1.$namerub[$_als][$many]; } if($kop > 0){ $many = 0; $s1 = summa_to_str_semantic($kop,1,$many); $s .= $s1 . $kopeek[$_als][$many]; } else { $s .= " 00 ".$kopeek[$_als][3]; } setlocale(LC_CTYPE,$lc_ctype); return $s; } ?>
