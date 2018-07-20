{if $load == "EXTERNALFREIGHT"}
    <div class="external_freight_note note">
        {$ExternalFreightMessage}
        {if $ExternalFreightNote}
            <h4 class="fare-note-caption">##BRON_EXTERNALFREIGHT_RULES##</h4>
            {$ExternalFreightNote}
        {/if}
    </div>
{/if}