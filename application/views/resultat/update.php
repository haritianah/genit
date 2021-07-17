<h1>Modifer Résultat</h1>

<?php
    echo form_open('',array('id'=>'form'));
    $labelEtd= form_label('ID',"id");
    $inputETD= form_input('id','','id="id" class="form-control" onkeyup="get_idEtudiant()"');
    $labelMat= form_label('Matière',"mat");
    $inputMat= form_input('mat','','id="mat" class="form-control" onkeyup="get_idMatiere()"');
?>
<div class="form-group col-md-2">
    <?= $labelEtd ?>
    <?= $inputETD ?>
    <div id="etContainer" class="border border-primary"></div>
</div>
<div class="form-group col-md-2">
    <?= $labelMat ?>
    <?= $inputMat ?>
    <div id="matContainer" class="border border-primary"></div>
</div>
<div class="form-group col-md-2">
    <?= form_button(array('id'=>'button'),'Afficher','class="form-control btn btn-primary"') ?>
</div>
<?= form_close() ?>
<div id="result"></div>
<script>
    $(document).ready(function () {
        $('#button').click(function () {
           param = $('#form').serialize();
           $.ajax({
               url : "<?= base_url('ajax/resultat_update') ?>",
               method : "POST",
               data : param,
               success : function (data) {
                   $('#result').html(data);
               },
               error : function () {
                   alert('ERROR');
               }
           })
        });
        $('body').click(function () {
            containerMat.fadeOut();
            containerEtd.fadeOut();
        })
    });
    var containerEtd = $('#etContainer');
    var containerMat = $('#matContainer');
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
    function get_idMatiere() {
        containerMat.fadeIn();
        var param = form.serialize();
        param = param+"&niveau=<?= $this->uri->segment(3) ?>";
        $.ajax({
            url: "<?= base_url('ajax/search_matiere') ?>",
            method : "POST",
            data :  param,
            success:  function (data) {
                containerMat.html(data);
            },
            error : function () {
                alert('ERROR');
            }
        })
    }
    function set_idMatiere(input) {
        $('#mat').val(input.attr('id'))
        containerMat.fadeOut();
    }
</script>
