// ****** Функции работы со строками ********

function leftString(fullString, subString){
    if (fullString.indexOf(subString) == -1){
        return "";
    }else{
        return (fullString.substring(0, fullString.indexOf(subString)));
    }
}

function rightString(fullString, subString){
    if (fullString.indexOf(subString) == -1){
        return "";
    }else{
        return (fullString.substring(fullString.indexOf(subString)+subString.length, fullString.length));
    }
}

function CheckStr(string,chars){
    var ch;
    string = string.toUpperCase();
    for (var i=0; i<string.length; i++){
        ch = string.substring(i,i+1);
        if (chars.indexOf(ch) == -1){
            return 1;
        }
    }
    return 0;
} //end CheckStr

function unHtmlSpecialChars(str){
    var _replace = function(match) {
        switch (match) {
            case '&nbsp;': return ' ';
            break;
            case '&quot;': 
            case '&#034;': return '\"';
            break;
            case '&#039;': return '\'';
            break;
            case '&amp;' :
            case '&#038;': return '&';
            break;
            case '&lt;'  :
            case '&#060;': return '<';
            break;
            case '&gt;'  :
            case '&#062;': return '>';
            break;
            default: return match;
        }
    }
    str = str.replace(/(&nbsp;|&quot;|&#034;|&#039;|&amp;|&#038;|&lt;|&#060;|&gt;|&#062;)/gi, _replace);
    return str;
}

String.prototype.unHtmlSpecialChars = function () {return unHtmlSpecialChars(this);};