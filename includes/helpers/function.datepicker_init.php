<?php
 function smarty_function_datepicker_init($params, &$smarty) { $view = ($smarty instanceof Samo_View) ? $smarty : Samo_Registry::get('view'); $data = array(); $value = ''; foreach (array('startDate', 'endDate', 'value') as $field) { if (isset($params[$field]) && is_string($params[$field])) { $params[$field] = Samo_Datetime::parse($params[$field]); } if (isset($params['data'][$field]) && is_string($params['data'][$field])) { $params['data'][$field] = Samo_Datetime::parse($params['data'][$field]); } } if (isset($params['data']) && is_array($params['data'])) { if (isset($params['data']['validDates'])) { $data['valid'] = $params['data']['validDates']; } if (isset($params['data']['startDate'])) { $data['start'] = $params['data']['startDate']->format('date'); } if (isset($params['data']['endDate'])) { $data['end'] = $params['data']['endDate']->format('date'); } if (isset($params['data']['validFirst'])) { $data['first'] = $params['data']['validFirst']->format('date'); } if (isset($params['data']['direction'])) { $data['direction'] = $params['data']['direction']; } if (isset($params['data']['value'])) { $value = ' value="' . $params['data']['value']->format('date') . '"'; } } if (isset($params['startDate'])) { $data['start'] = $params['startDate']->format('date'); } if (isset($params['endDate'])) { $data['end'] = $params['endDate']->format('date'); } if (isset($data['start']) && isset($data['end']) && !isset($params['direction'])) { $data['direction'] = [$data['start'], $data['end']]; unset($data['end']); $data['start'] = Samo_Datetime::today()->format('date'); } if (isset($params['validDates'])) { $data['valid'] = $params['validDates']; } if (isset($params['validFirst'])) { $data['first'] = $params['validFirst']->format('date'); } if (isset($params['view']) && in_array($params['view'], ['days', 'months', 'years'])) { $data['view'] = $params['view']; } if (isset($params['direction'])) { $data['direction'] = $params['direction']; } if (isset($params['value']) && !$params['value']->is_null()) { $value = ' value="' . $params['value']->format('date') . '"'; } return " data-calendar='" . $view->json_encode($data, '"') . "' " . $value; } 