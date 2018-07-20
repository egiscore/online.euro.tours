##PENALTY_TEXT##<br>
{foreach from=$penalty_size item="row"}
    ##PENALTY_FROM## {$row.penalty_day} ##PENALTY_TOTAL## {$row.penalty_percent}%<br>
{/foreach}
