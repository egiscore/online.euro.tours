/*
    �������� ��� �������� � ���� <SELECT multiple>
*/
function Select_All_Multiple(s){
    for (i = 0; i < s.options.length; i++){
        s.options[i].selected = true;
    }
}

/*
    ������� ��������� � ��������� � ���� <SELECT multiple>
*/
function Deselect_All_Multiple(s){
    for (i = 0; i < s.options.length; i++){
        s.options[i].selected = false;
    }
}
