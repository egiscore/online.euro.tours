function Load_js(href) {
    href +=  '&RANDOMIZE=' + parseInt(Math.random()*100000000000);
    with (document) {
        var span = null;
        var span = createElement('SPAN');
        span.style.display = 'none';
        body.appendChild(span);
        span.innerHTML = 'Text for stupid IE.<s'+'cript></' + 'script>';
        setTimeout(function() {
            var s = span.getElementsByTagName('script')[0];
            s.language = 'JavaScript';
            if (s.setAttribute){
                s.setAttribute('src', href);
            } else {
                s.src = href;
            }
        }, 10);
    }
}