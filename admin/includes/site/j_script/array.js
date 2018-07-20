// ****** Функции работы с массивами ********

function is_value_in_Array(thearray, val){
    for (var ii = 0 ; ii < thearray.length; ii++ ){
        if (thearray[ii] == val){
            return true;
        }
    }
    return false;
}

function into_Array(thearray, newval){
    arraysize = stacksize(thearray);
    thearray[arraysize] = newval;
}

function stacksize(thearray){
    for (var ii = 0 ; ii < thearray.length; ii++ ){
        if ( (thearray[ii] == "") || (thearray[ii] == null) || (thearray == 'undefined') ){
            return ii;

        }
    }
    return thearray.length;
}
