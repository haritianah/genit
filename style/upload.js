$(document).ready(function () {
  $('#myform').on("submit",function (e) {
      e.preventDefault();
      var Pligne= prompt("Premiere ligne");
      var fd = new FormData(this);
      fd.append('pligne',Pligne);
      fd.append('niv1',niv1);
      fd.append('niv2',niv2);
      $.ajax({
          url:"ajax/aj_excel.php",
          method:"POST",
          data:fd,
          contentType:false,
          processData:false,
          success:function (data) {
              $('#preview').html(data);
          }

      });
  });
    $('#rmbtn').click(function () {
        $('#preview').html("");
    });


});
