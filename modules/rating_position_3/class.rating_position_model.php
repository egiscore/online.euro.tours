<?php
 class Rating_Position_Model extends Samo { protected $auth_required = array('agency'); public function rating() { $result = array(); $partner = $this->getPartner(); $sql = $this->db->formatExec( '<ONLINEDB>.dbo.up_WEB_3_rating_Position', ['Partner' => $partner] ); if (false !== ($res = $this->db->query($sql))) { while (false !== ($row = $this->db->fetchRow($res))) { if ($_SESSION['samo_auth']['Administrator'] == 1) { $row['Private'] = 0; } $row['Color'] = ($row['Color'] > 0) ? dechex($row['Color']) : 'FFFFFF'; $row['Color'] = (strlen($row['Color']) == 6) ? $row['Color'] : 'FFFFFF'; $row['Color'] = substr($row['Color'],4,2) . substr($row['Color'],2,2) . substr($row['Color'],0,2); if ($row['Position'] > 0) { $row['Position'] = ($row['Position'] > $row['HidePosition']) ? $row['Position'] : 'TOP ' . $row['HidePosition']; } $row['Amount'] = round($row['Amount'], 2); $row['Paid'] = round($row['Paid'], 2); $row['Note'] = trim($row['Note']); $result[] = $row; } } return $result; } } 