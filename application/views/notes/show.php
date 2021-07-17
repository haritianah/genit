<h1>Affichage de notes</h1>
<!--Liste niveau-->
<?php empty($niveau) ? $this->app->niveau("Notes/show") : false ;?>
<?php
if (!empty($niveau)):
//Store liste matiere
$matiere=array();
    foreach ($matieres as $item) {
        $matiere[$item->id_matiere] = $item->nom_matiere;
    }

    echo form_open('',array('class'=>'form-inline','id'=>'form'));
    $listemat= form_dropdown("matiere",$matiere,'','class="form-control"');
    $inputID= form_input('id',"",'id="id" class="form-control" placeholder = "Etudiant" onkeyup="get_idEtudiant()"');
    $inputAnne= form_input(array('name'=>'annee','type'=>'number'),$_SESSION['annee_etude'],'class="form-control"');
    $inputButton= form_button(array('id'=>'affButton'),"Afficher",'class="btn btn-primary"');
?>
<div class="form-group col-md-4">
   <?= $listemat ?>
</div>
<div class="form-group col-md-2">
    <?= $inputID ?>
    <div id="etContainer"></div>
</div>
<div class="form-group col-md-2">
    <?= $inputAnne ?>
</div>
<?= $inputButton ?>
<?= form_close(); ?>

<div id="result"></div>

<script>
    $(document).ready(function () {
       $('#form').submit(function () {
           event.preventDefault();
       })
        $('#affButton').click(function () {
            var param = $('#form').serialize();
            param = param+"&nomat="+$('select option:selected').text();
            $.ajax({
                url: "<?= base_url('notes/ajax_show') ?>",
                method: "POST",
                data :  param,
                success : function (data) {
                    $('#result').html(data);
                }
            });
        })
    });
    var containerEtd = $('#etContainer');
    var form = $('#form');
    function get_idEtudiant() {
        containerEtd.fadeIn();
        var param = form.serialize();
        $.ajax({
            url: "<?= base_url('ajax/search_etudiant') ?>",
            method : "POST",
            data :  param,
            success:  function (data) {
                containerEtd.html(data);
            },
            error : function () {
                alert('ERROR');
            }
        })
    }
    function set_idEtudiant(input) {
        $('#id').val(input.attr('id'))
        containerEtd.fadeOut();
    }

    function updateNote(obj,code) {
        Jobj =  $(obj);
            //
        var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
        if(keyCode==16) {
            var conff = confirm("Confirmer changement ?");
            if (conff==true){
               var note = obj.innerHTML, action = 'updateJson';
               $.ajax({
                   url : "<?= base_url('notes/query_update/')?>"+code,
                   method : 'post',
                   data : {note : note, action : action},
                   dataType : 'JSON',
                   success: function (data) {
                       if (data.color=='green'){
                           Jobj.removeClass('error-bg');
                           Jobj.addClass('success-bg');
                       }else{
                           Jobj.removeClass('success-bg');
                           Jobj.addClass('error-bg');
                       }
                   },
                   error : function () {
                       alert('Error');
                   }
               });
            }
        }
    }
</script>
<?php

endif;