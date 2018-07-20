{if $smarty.get.SOURCE == 'STA'}
    <!DOCTYPE html>
    <html>
        <head>
            <title>{if isset($page_title)}{$page_title}{else}##DEFAULT_PAGE_TITLE##{/if}</title>
            <meta http-equiv="X-UA-Compatible" content="IE=edge; chrome=1" >
            {cssload file="common.css"}
            {cssload file="data/search_tour/icons.css" base="" required=false}
        {if isset($cssfiles)}{cssload file=$cssfiles}{/if}
        {cssload file="customer.css" required=false}
    </head>
    <body class='STA'>
    {elseif $smarty.get.samo_action != 'embed' && $smarty.get.contentonly != '1'}
        <!DOCTYPE html>
    <html>
        <head>
            <title>{if isset($page_title)}{$page_title}{else}##DEFAULT_PAGE_TITLE##{/if}</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext" rel="stylesheet">
            <link rel="shortcut icon" href="https://euro.tours/wp-content/themes/eurotour/img/favicon.ico">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
            <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
            {* This block MUST be in <head> *}
            {cssload file="common.css"}
            {cssload file="data/search_tour/icons.css" base="" required=false}
        {if isset($cssfiles)}{cssload file=$cssfiles}{/if}
        {* // This block MUST be in </head> *}
        {cssload file="customer.css" required=false}
    </head>
    <body>
        <div class="container-fluid top-line">
            <div class="container top-line-menu">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="//euro.tours">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/cl_refer?">Агентствам</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/cl_refer_person?">Клиентам</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="container main drop-shadow">
            <div id="header">
                <div class="row">
                    <div class="col-sm-3">
                        <a href="//euro.tours" style="float: left;"><img src="public/pict/logo.png" width="210" /></a>
                    </div>
                    <div class="col-sm-4">
                        <div class="row geo-city">
                            <div class="col-xs-1 bg-geo-city">
                                <img src="public/pict/bg-geo-city.png" />
                            </div>
                            <div class="col-xs-4">
                                <div class="text-muted geo-city-text">Ваш город</div>
                                <div class="text-primary geo-city-title"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row contacts justify-content-end">
                            <div class="text-muted contacts-text">Контактная информация</div>
                            <div class="text-default contacts-text-title">для туристов: <span class="text-danger">8 495 055-15-88</span></div>
                            <div class="text-default contacts-text-title">для турагентств: <span class="text-danger">8 495 055-15-48</span></div>                            
                        </div>
                    </div>
                </div>
                <div class="row main-menu">
                    <div class="col-sm-9 nopadding nomargin">
                        <nav class="nav">

                        </nav>
                    </div>
                    <div class="col-sm-3 nopadding nomargin d-none d-sm-block">

                    </div>
                </div>                    
                <div class="row submenu bg-primary nomargin">
                    <div class="justify-content-center align-self-center">
                        <ul class="nav">


                        </ul>
                    </div>
                </div>
                <!--<a href="{$WWWROOT}">{imgload file="data/partner/logo.png" default="public/pict/logo.png" base="" class="logo" inline=true }</a>
                <div class="header_top">
                    <div style="width: 60em; float: right;">
            {foreach from=$routes item="module" name="module"} {if $module.public}<nobr><a href="{$module.url}" rel="bookmark" title="{$module.title}" >{$module.title}</a> |</nobr>{/if}{/foreach}
            {if count($LANGS) > 1}
            <nobr>
                {foreach from=$LANGS key="lang" item="lang_url"}
                    {if $LANG != $lang}
                        <a href="{$lang_url}" class="samo_lang {$lang}">{$lang}</a> |
                    {else}
                        <span class="samo_lang {$lang}">{$lang}</span> |
                    {/if}
                {/foreach}
            </nobr>
            {/if}
        </div>-->
        {else}
            <title>{if isset($page_title)}{$page_title}{else}##DEFAULT_PAGE_TITLE##{/if}</title>
            {cssload file="common.css"}
            {cssload file="data/search_tour/icons.css" base="" required=false}
        {if isset($cssfiles)}{cssload file=$cssfiles}{/if}
        {cssload file="customer.css" required=false}
    {/if}
</div>