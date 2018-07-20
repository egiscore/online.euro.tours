function Delete_all_rows_from_table(tbl_id){
    while (true){
        currow = window.document.getElementById(tbl_id).rows.length;
        if (currow == 0){
            break;
        }
        window.document.getElementById(tbl_id).deleteRow(0);
    }
}
