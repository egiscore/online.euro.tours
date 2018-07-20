<?php
function smarty_modifier_class_builder($array, $entity) { switch ($entity) { case 'hotels': $result = buildByHotels($array); break; case 'freights': $result = buildByFreights($array); break; case 'services': $result = buildByServices($array); break; case 'insures': $result = buildByInsures($array); break; case 'visas': $result = buildByVisas($array); break; case 'peoples': $result = buildByPeoples($array); break; default: $result = ''; break; } return $result; } function build($keys, $array) { $result = ''; $postfix = "_"; $prefix = " "; foreach ($keys as $key) { $result .= $prefix . $key . $postfix . $array[$key]; } return $result; } function buildByHotels($array) { $keys = [ 'HotelInc', 'Nights', 'Sent', 'Confirmed', 'RoomInc', 'HtPlaceInc', 'MealInc', 'StarInc', 'TownInc', 'StateInc', 'PCount', 'OrderInc', 'IPartnerInc', 'printtype', 'Status' ]; return build($keys, $array); } function buildByFreights($array) { $keys = [ 'FreightInc', 'IsBack', 'IsLocal', 'Nights', 'Sent', 'Confirmed', 'ClassInc', 'FrPlaceInc', 'PCount', 'SrcPortInc', 'TrgPortInc', 'TownSrcInc', 'TownTrgInc', 'StateSrcInc', 'StateTrgInc', 'source', 'target', 'TranTypeInc', 'TransportCodeInc', 'TransportInc', 'PartnerInc', 'AirlineInc', 'OrderInc', 'RouteIndex', 'index', 'days', 'IPartnerInc', 'delay', 'ftype', 'printtype', 'OnlineClass', 'FrPlacementAvailable', 'MaxSeatCount', 'SeatCount', 'Status', 'IsGDS', 'SrcTimeDelta', 'TrgTimeDelta' ]; return build($keys, $array); } function buildByServices($array) { $keys = [ 'OrderInc', 'ServiceInc', 'RouteIndex', 'ServicePrivate', 'ServiceType', 'ServiceTypeInc', 'ServiceCategoryInc', 'TranTypeInc', 'TransferTypeInc', 'TransportCodeInc', 'TransportInc', 'Nights', 'Sent', 'Confirmed', 'PCount', 'IPartnerInc', 'Status', 'OrderIndex', 'ServType', 'ServTypeInc' ]; return build($keys, $array); } function buildByInsures($array) { $keys = [ 'InsureInc', 'StateInc', 'InsureType', 'Medical', 'Nights', 'Sent', 'Confirmed', 'PCount', 'OrderInc', 'IPartnerInc', 'printtype', 'policytype', 'Status', 'Sum' ]; return build($keys, $array); } function buildByVisas($array) { $keys = [ 'VisaInc', 'VisaprInc', 'StateInc', 'Nights', 'Sent', 'Confirmed', 'PCount', 'OrderInc', 'IPartnerInc', 'printtype', 'Status', ]; return build($keys, $array); } function buildByPeoples($array) { $keys = [ 'Inc', 'StateInc', 'PlaceOfBornInc', 'index', 'givendoc', 'Male', 'VisaDocument', 'fulltakendoc', 'prepareddoc', 'receiveddoc', 'VStatusInc', 'visareceived', 'VisiblePersonalInformation' ]; return build($keys, $array); } 