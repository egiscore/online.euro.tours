</div>
<div class="footer website">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <a href="//euro.tours"><img src="public/pict/logo-footer.png" /></a>
            </div>
            <div class="col-md-8">
              {foreach from=$routes item="module" name="module"} {if $module.public}<nobr><a href="{$module.url}" rel="bookmark" title="{$module.title}" >{$module.title}</a> |</nobr>{/if}{/foreach}
            </div>
            <div class="col-md-12 footer-bottom">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="footer-links">
                            <div class="footer-global">
                                © 2009 - 2018 &mdash; Все права защищены. 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> 
<a href="tel:+74950551588" id="popup__toggle" class="d-md-none"><div class="circlephone" style="transform-origin: center;"></div><div class="circle-fill" style="transform-origin: center;"></div><div class="img-circle" style="transform-origin: center;"><div class="img-circleblock" style="transform-origin: center;"></div></div></a>
</body>
</html>