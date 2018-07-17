function dtgLoadButton(){

    $('#dtg_dialog').dialog({
        autoOpen: false,
        width: 250,
        buttons: {
            "Cancel": function() {
                $(this).dialog("close");
            }
        }
    });


}

function dtgOpenExportdata(){
    $('#dtg_dialog').dialog('open');
    return false;

}
function dtgExport(format, querystring){

    var url = document.URL;
    if (querystring == 'true') {
        url += '&_exportto=' + format;
    } else {
        url += '/_exportto/' + format;
    }
    window.open(url, '_Blank');
}


