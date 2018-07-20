<?php
  $routes = array(
    'menu' => array('path' => '/', 'public' => false, ),
    'passport' => array('path' => '/', 'public' => false, ),
    'profile' => array('public' => false, ),

    'search_tour' => array('path' => 'modules/search_tour_3/', 'public' => true, ),

    'search_hotel' => array('path' => 'modules/search_hotel/', 'public' => false, 'uses' => array('fast_search'), ),

    'hotel_stopsale' => array('path' => 'modules/hotel_stopsale_3/', 'public' => true, ),
    'freight_monitor' => array('path' => 'modules/freight_monitor_3/', 'public' => true, ),
    'freight_time' => array('path' => 'modules/freight_time_3/', 'public' => true, ),
    'check_confirm' => array('path' => 'modules/check_confirm_3/', 'public' => true, ),
    'all_prices' => array('path' => 'modules/all_prices_3/', 'public' => false, 'uses' => array('search_tour', 'search_hotel'), ),
    'fast_search' => array('path' => 'modules/fast_search_3/', 'public' => true, ),

    'cl_refer' => array('path' => 'modules/cl_refer_3/', 'public' => true, 'uses' => array('cl_refer_person'), ),
    'messages' => array('path' => 'modules/messages_3/', 'public' => false, 'uses' => '*', ),
    'cancel_claim' => array('path' => 'modules/cancel_claim_3/', 'public' => false, 'uses' => array('cl_refer', 'cl_refer_person'), ),
    'visa_status' => array('path' => 'modules/visa_status_3/', 'public' => false, 'uses' => array('cl_refer', 'cl_refer_person'), ),
    'edit_tourist' => array('path' => 'modules/edit_tourist_3/', 'public' => false, 'uses' => array('cl_refer', 'anketa', 'cl_refer_person'), ),
    'registration' => array('path' => 'modules/registration_3/', 'public' => true, ),
    'edit_agency' => array('path' => 'modules/edit_agency_3/', 'public' => true, ),
    'rating_position' => array('path' => 'modules/rating_position_3/', 'public' => true, ),
    'bron' => array('path' => 'modules/bron_info_3/', 'public' => false, 'uses' => array('search_tour', 'search_hotel', 'best_spo', 'all_prices', 'the_best', 'bron_person', 'hotels', 'tickets'), ),
    'bron_person' => array('path' => 'modules/bron_info_3/', 'public' => false, 'uses' => array('bron', 'search_tour_person', 'search_hotel_person'), 'antibot' => '1', ),
    'booklet' => array('path' => 'modules/booklet_3/', 'public' => false, 'uses' => array('cl_refer', 'cl_refer_person'), ),
    'invoice' => array('path' => 'modules/invoice_3/', 'public' => false, 'uses' => array('cl_refer', 'cl_refer_person', 'claim_unpaid', 'pay_variant'), ),
    'hotels' => array('path' => 'modules/hotels_3/', 'public' => true, ),
    'schedule_doc' => array('path' => 'modules/schedule_doc_3/', 'public' => true, ),
    'confirmation' => array('path' => 'modules/confirmation_3/', 'public' => false, 'uses' => array('cl_refer', 'cl_refer_person'), ),

    'cl_wizard' => array('path' => 'modules/cl_wizard_3/', 'public' => true, ),
    'voucher' => array('path' => 'modules/voucher_3/', 'public' => false, 'uses' => array('cl_refer', 'cl_refer_person'), ),
    'popular_hotel' => array('path' => 'modules/popular_hotel_3/', 'public' => true, ),
    'sale' => array('path' => 'modules/sale_3/', 'public' => true, ),
    'register_agency' => array('path' => 'modules/register_agency_3/', 'public' => true, ),
    'warrant' => array('path' => 'modules/warrant_3/', 'public' => true, ),
    'currency' => array('path' => 'modules/currency_3/', 'public' => false, ),
    'agreement' => array('path' => 'modules/agreement_3/', 'public' => true, ),
    'claim_unpaid' => array('path' => 'modules/claim_unpaid_3/', 'uses' => array('cl_refer'), 'public' => true, ),
    'the_best' => array('path' => 'modules/the_best_2/', 'public' => true, ),
    'aviaticket' => array('path' => 'modules/aviaticket_3/', 'public' => false, 'uses' => array('cl_refer', 'cl_refer_person'), ),
    'aviaticket_cost' => array('path' => 'modules/aviaticket_cost_3/', 'public' => false, 'uses' => array('cl_refer', 'cl_refer_person'), ),
    'insurance' => array('path' => 'modules/insurance_3/', 'public' => false, 'uses' => array('cl_refer', 'cl_refer_person'), ),
















    'cl_refer_person' => array('path' => 'modules/cl_refer_person_3/', 'public' => true, ),

    'anketa' => array('path' => 'modules/anketa_3/', 'public' => false, 'uses' => array('cl_refer', 'cl_refer_person'), ),
    'claim_act' => array('path' => 'modules/claim_act_3/', 'public' => true, ),
    'pay_variant' => array('path' => 'modules/pay_variant_3/', 'public' => false, 'uses' => array('cl_refer', 'claim_unpaid'), ),

    'd_flights_monitor' => array('path' => 'admin/modules/d_flights_monitor/', 'public' => false, ),
    'd_daily_report' => array('path' => 'admin/modules/d_daily_report/', 'public' => false, ),
    'd_available_hotels' => array('path' => 'admin/modules/d_available_hotels/', 'public' => false, ),
    'd_freight_situation' => array('path' => 'admin/modules/d_freight_situation/', 'public' => false, ),
    'andromeda' => array('path' => 'modules/andromeda_3/', 'public' => false, ),
    'visa' => array('path' => 'modules/visa_3/', 'public' => false, 'uses' => array('cl_refer', 'cl_refer_person'), ),
    'freight_changes' => array('path' => 'modules/freight_changes_3/', 'public' => true, ),

    'anketa_samo' => array('path' => 'modules/anketa_3/', 'public' => false, ),






















    'bonus_manager' => array('path' => 'modules/bonus_manager_3/', 'public' => true, 'uses' => array('pay_variant'), ),





);
