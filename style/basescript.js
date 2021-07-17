$(document).ready(function () {
    $('#search_input').keydown(function () {
        $('#matcont').hide();
        var fd = new FormData();
        fd.append('matquery', $('#search_input').val());
        $.ajax({
            url: "ajax/aj_recherche.php",
            method: "POST",
            data: fd,
            contentType:false,
            processData:false,
            success: function (data) {
                $('#matcont').show();
                $('#matcont').html(data);
            }
        });

    });
});
function searchmat(obj) {

    if ($('#result').length==false){
        $(obj).after("<div id='result'></div>");
    }
    var fd = new FormData();
    fd.append('matquery', $(obj).val());
    $.ajax({
        url: "ajax/aj_recherche.php",
        method: "POST",
        data: fd,
        contentType:false,
        processData:false,
        success: function (data) {
            $('#result').html(data);
        }
    });
}
function change () {
    if($('#search_input').val()!= '' && $('#search_input').val().length>5){
        $('#searchs').submit();
    }
}
function recupma(value,obj){
    var vall = value.replace("#","");
    obj= "#"+obj; //idmat
    $(obj).val(value);
    $('#result').hide();
}
function create(value) {
    $.post(
        "ajax/aj_download.php",
    {idmat:value},
        function (data) {

        }

    );
}