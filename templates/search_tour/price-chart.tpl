{if count($info.prices) > 1}
    <div id="googlePriceChart"><img src="public/pict/preloader.gif" class="preloader"></div>
    <div class="chartBar"></div>
    <div class="chartBarHover"></div>
    <div class="chartBarRed"></div>
    <div class="chartBarGreen"></div>
    <div class="chartBarPink"></div>
    <div class="chartToolType"></div>
    <div class="chartToolTypeGreen"></div>
    <div class="chartToolTypeRed"></div>
    <div class="chartToolTypePink"></div>
    <div id="chart-tip" class="ui-widget ui-widget-content ui-corner-all">
        <span></span>
        <div class="fg-tooltip-pointer-down ui-widget-content">
            <div class="fg-tooltip-pointer-down-inner"></div>
        </div>
    </div>
{/if}