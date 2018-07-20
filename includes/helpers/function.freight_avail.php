<?php
require_once dirname(__FILE__) . '/function.imgload.php'; function smarty_function_freight_avail($params, &$smarty) { if ($params['condition']) { if (!isset($params['value']['freights'][$params['class']])) { $params['value']['freights'][$params['class']] = array('in' => 'N', 'out' => 'N'); } if (isset($params['value']['freights'][$params['class']]['surcharge'])) { $class = ''; if ($params['value']['freights'][$params['class']]['in'] == 'Y' && $params['value']['freights'][$params['class']]['out'] == 'Y') { $class = 'surcharge'; } elseif ($params['value']['freights'][$params['class']]['in'] == 'Y') { $class = 'surchargeIn'; } elseif ($params['value']['freights'][$params['class']]['out'] == 'Y') { $class = 'surchargeOut'; } $surcharge = '<span class="' . $class . '">&nbsp;+</span><span class="price ' . $class . '" data-cat-price="' . $params['value']['freights'][$params['class']]['surcharge']['total']['price'] . '" data-cat-currency="' . $params['value']['freights'][$params['class']]['surcharge']['total']['currencyKey'] . '">' . $params['value']['freights'][$params['class']]['surcharge']['total']['converted'] . '</span>'; } else { $surcharge = ''; } $messages = Samo_Registry::get('messages'); $flags = [ 'Y' => $messages['TOUR_SEARCH_RES_YES_PLACE'], 'F' => $messages['TOUR_SEARCH_RES_YESNO_PLACE'], 'N' => $messages['TOUR_SEARCH_RES_NO_PLACE'], 'R' => $messages['TOUR_SEARCH_RES_REQUEST_PLACE'], ]; return '<div class="transport"><span class="name">' . $params['title'] . '</span><span class="fr_place_r ' . $params['value']['freights'][$params['class']]['in'] . ' helpalt" data-helpalt-arrow="hide" title="' . $flags[$params['value']['freights'][$params['class']]['in']] . '"></span><span class="fr_place_l ' . $params['value']['freights'][$params['class']]['out'] . ' helpalt"  data-helpalt-arrow="hide" title="' . $flags[$params['value']['freights'][$params['class']]['out']] . '"></span>' . $surcharge . '</div>'; } else { return ''; } } 