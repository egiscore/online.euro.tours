{if $RESULT}

{foreach from=$RESULT item="rating"}
{cycle values="even,odd" reset=true print=false advance=false}
<fieldset class="panel">
    <legend style="background-color: #{$rating.Color};">{$rating.RatingLName}</legend>
        <div class="eraser"></div>
        {if $rating.Private == 0}
            <table class="res">
                <tr class="{cycle values="even,odd"}">
                    <td width="50%">##RATING_POSITION##</td>
                    <td width="50%" class="l b red">{$rating.Position}</td>
                </tr>
                <tr class="{cycle values="even,odd"}">
                    <td width="50%">##RATING_CREATE_DATETIME##</td>
                    <td width="50%" class="l b">{$rating.RatingCreateDate|date_format:'datetime'}</td>
                </tr>
                {if $rating.ShowPax}
                <tr class="{cycle values="even,odd"}">
                    <td>##RATING_PAX##</td>
                    <td class="l b">{$rating.Pax}</td>
                </tr>
                {/if}
                {if $rating.ShowRCount}
                    <tr class="{cycle values="even,odd"}">
                        <td>##RATING_RCOUNT##</td>
                        <td class="l b">{$rating.RCount}</td>
                    </tr>
                {/if}
                {if $rating.ShowAmount}
                <tr class="{cycle values="even,odd"}">
                    <td>##RATING_AMOUNT##</td>
                    <td class="l b">{$rating.Amount}</td>
                </tr>
                {/if}
                {if $rating.ShowPaid}
                <tr class="{cycle values="even,odd"}">
                    <td>##RATING_PAID##</td>
                    <td class="l b">{$rating.Paid}</td>
                </tr>
                {/if}
                {if $rating.ShowIClaims}
                <tr class="{cycle values="even,odd"}">
                    <td>##RATING_INTERNET_CLAIMS_COUNT##</td>
                    <td class="l b">{$rating.IClaims}</td>
                </tr>
                {/if}
                {if $rating.ShowIClaimsPercent}
                <tr class="{cycle values="even,odd"}">
                    <td>##RATING_INTERNET_CLAIMS_PERCENT##</td>
                    <td class="l b">{$rating.IClaimsPercent|ceil} %</td>
                </tr>
                {/if}
                {if $rating.ShowDepth}
                <tr class="{cycle values="even,odd"}">
                    <td>##RATING_DEPTH##</td>
                    <td class="l b">{$rating.Depth}</td>
                </tr>
                {/if}
                {if $rating.Note}
                <tr class="{cycle values="even,odd"}">
                    <td class="c" colspan="2" style="background-color:#{$rating.Color};">{$rating.Note}</td>
                </tr>
                {/if}
            </table>
        {else}
            <div>##RATING_NO_ACCESS##<div>
        {/if}
</fieldset>
{/foreach}
{else}
    ##NO_DATA##
{/if}