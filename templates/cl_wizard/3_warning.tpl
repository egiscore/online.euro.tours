{if $warning_stop}
    <div class="warning_stop red">
        {foreach from=$warning_stop item="warn"}
            {$warn}<br>
        {/foreach}
    </div>
{/if}
{if $warning}
    <div class="warning blue">
        {foreach from=$warning item="warn"}
            {$warn}<br>
        {/foreach}
    </div>
{/if}