<div id="edit_tourist" data-tourist="{$TOURIST_INC}" data-checkout="{$CHECKOUT}">
    <div class="tourist">
        <form method="POST" id="edit_tourist_form">
            {include file="../fieldset_builder.tpl" fields=$TouristInfo id=$TOURIST_INC ANY_HUMAN=true STATUS='MRS' panel=1}
        </form>
    </div>
    <button class="load">##CL_W_BTN_SAVE##</button>
</div>