<div id="SERVTYPE">
    {foreach from=$Items item="item"}
        <br>
        <span class="link servtype" data-servtype="{$item.Inc}">{$item.Name}</span>
        <br>
    {/foreach}
</div>