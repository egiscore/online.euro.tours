{if (1 != $price.programTypeKey) || $price.programTypeUrl || $price.programTypeIcon || $price.programTypeNote}
    {if $price.programTypeUrl}
        <a href="{$price.programTypeUrl}" target="_blank">
    {/if}
    <span class="{if $price.programTypeIcon || $price.programTypeNote}helpalt link{/if}"
          title="{$price.programType}">
                        {if $price.programTypeIcon}
                            <span class="prgt icon pt prt_{$price.programTypeKey}">&nbsp;</span>
                        {else}
                            {$price.programType}
                        {/if}
        {if $price.programTypeIcon || $price.programTypeNote}
            <script type="text/html">
                                <p>{if $price.programTypeIcon}<span class="prgt icon pt prt_{$price.programTypeKey}">&nbsp;</span>&nbsp;{/if}{$price.programType}</p>
                                {if $price.programTypeNote}
                                    <p>{$price.programTypeNote|nl2br}</p>
                                {/if}
                                {if $price.programTypeUrl}
                                    <p>{"##TOUR_SEARCH_MORE##"|linkify:$price.programTypeUrl}</p>
                                {/if}
                            </script>
        {/if}
                    </span>
    {if $price.programTypeUrl}
        </a>
    {/if}
{/if}