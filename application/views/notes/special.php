
<H1>Insertion notes spécifique</H1>
<div id="result" style="padding: 10px; min-height: 30px; border-radius :5%;">

</div>
    <?php
    echo form_open('',array('id'=>'form','style'=>'height:100px'));
    $labelEtd= form_label('ID',"id");
    $inputETD= form_input('id','','id="id" class="form-control" onkeyup="get_idEtudiant(this)"');
    $labelMat= form_label('Matière',"mat");
    $inputMat= form_input('mat','','id="mat" class="form-control" onkeyup="get_idMatiere(this)"');
    $labelAnnee= form_label("Année d'étude","annee");
    $inputAnnee= form_input(array("name"=>"annee","type"=>"number"),2016,'id="annee" class="form-control"');
    ?>
    <div class="form-group col-md-2">
        <?= $labelEtd ?>
        <?= $inputETD ?>
        <div id="etContainer" class="border border-primary box-search"></div>
    </div>
    <div class="form-group col-md-2">
        <?= $labelMat ?>
        <?= $inputMat ?>
        <div id="matContainer" class="border border-primary box-search"></div>
    </div>
    <div class="form-group col-md-2">
        <select name="session" id="">
            <option value="normale">Session normale</option>
            <option value="rattrapage">Session rattrapage</option>
        </select>
        <br>
        <label for="">Note</label>
        <input type="number" name="note" min=0 max=20 class="form-control" step="0.01">
    </div>
    <div class="form-group col-md-2">
        <?= $labelAnnee ?>
        <?= $inputAnnee ?>
    </div>
    <div class="form-group col-md-2">
        <?= form_button(array('id'=>'button'),'Insérer','class="form-control btn btn-primary"') ?>
    </div>
    <?= form_close() ?>


<script>
    $(document).ready(function () {
       $('#button').click(function () {
           var param  = $('#form').serialize();
           $('#result').fadeOut(500);
           $.ajax({
               url : "<?= base_url('notes/query_spec') ?>",
               method: "POST",
               data : param,
               dataType : "JSON",
               success :  function (data) {
                   $('#result').fadeIn(800);
                   $('#result').html(data.result);
                   $('#result').removeClass();
                   $('#result').addClass("alert-"+data.type);
               },
               error : function () {
                   alert('Error');
               }
           })
       });
    })
    var containerEtd = $('#etContainer');
    var containerMat = $('#matContainer');
    var form = $('#form');
    function get_idEtudiant(obj) {
        containerEtd.fadeIn();
        var input = $(obj).val();
        var param = form.serialize();
        if (input != ''){
            $.ajax({
                url: "<?= base_url('ajax/search_etudiant') ?>",
                method : "POST",
                data :  param,
                success:  function (data) {
                    if (data !=''){
                        containerEtd.html(data);
                    }else {
                        containerEtd.html('Aucun résultat trouvé');
                    }

                },
                error : function () {
                    alert('ERROR');
                }
            });
        }else{
            containerEtd.fadeOut();
        }
    }
    function set_idEtudiant(input) {
        $('#id').val(input.attr('id'))
        containerEtd.fadeOut();
    }
    function get_idMatiere(obj) {
        containerMat.fadeIn();
        var param = form.serialize();
        param = param+"&niveau=<?= $this->uri->segment(3) ?>";
        var input = $(obj).val();
        if (input != ''){
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
            });
        }else {
            containerMat.fadeOut();
        }

    }
    function set_idMatiere(input) {
        $('#mat').val(input.attr('id'))
        containerMat.fadeOut();
    }
</script>
