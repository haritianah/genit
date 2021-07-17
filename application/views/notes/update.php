<h1>Modifier notes</h1>
<!--Liste niveau-->
<?php empty($niveau)&&!isset($code) ? $this->app->niveau("Notes/update") : false ;?>
<?php
if (!empty($niveau)):
    echo form_open('',array('id'=>'form','style'=>'height:100px'));
    $labelEtd= form_label('ID',"id");
    $inputETD= form_input('id','','id="id" class="form-control" onkeyup="get_idEtudiant(this)"');
    $labelMat= form_label('Matière',"mat");
    $inputMat= form_input('mat','','id="mat" class="form-control" onkeyup="get_idMatiere(this)"');
    $labelAnnee= form_label("Année d'étude","annee");
    $inputAnnee= form_input(array("name"=>"annee","type"=>"number"),$_SESSION['annee_etude'],'id="annee" class="form-control"');
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
        <?= $labelAnnee ?>
        <?= $inputAnnee ?>
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
                param += "&niveau=<?= $this->uri->segment(3) ?>";
                $.ajax({
                    url: "<?= base_url('notes/ajax_update') ?>",
                    method:"POST",
                    data: param,
                    success: function (data) {
                        $('#result').html(data);
                    },
                    error: function () {
                        alert('ERROR');
                    }
                });
            });
            $('#id').on('blur',function () {
                containerEtd.fadeOut();
            });
            $('#mat').on('blur',function () {
                containerMat.fadeOut();
            });

        });
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
<?php
endif;
/// ---------------- ISSET CODE
if (isset($code)):
    ?>
    <div class="container text-center">
        <h4> <b><?= $etudiant->id_etudiant ?></b> <br> <?= $etudiant->nom ?> <?= $etudiant->prenom ?></h4>
        <h5>Matiere : <?= $matiere->nom_matiere ?></h5>
        <h5>Résultat : <?= $resmat->resultat ?></h5>
        <div id="result"></div>
        <div class="alert alert-danger">
            <form action="" id="form">
                <label for="note"><b><u>Note:</u></b><br>Session:<?= ucfirst($note->session)?></label>
                <div class="form-group">
                    <input autofocus id="note" type="number" name="note" value="<?= $note->notes ?>" class="border rounded border-light shadow-sm">
                </div>
                <label for="noteO"><b>Note originale:</b></label>
                <div class="form-group">
                    <input id="noteO" type="number" value="<?= $note->noteO ?>" disabled class="border rounded border-light shadow-sm">
                </div>
                <div style="margin-top: 10px">
                    <button type="button" class="btn btn-success" id="update">Modifier</button>
                    <button type="button" class="btn btn-light" id="delib">Délibérer</button>
                    <button type="button" class="btn btn-danger" id="delete">Supprimer</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function () {
           $('button').click(function () {
               var action = $(this).attr("id");
               var param = $('#form').serialize();
               param += "&action="+action;
               $.ajax({
                   url: "<?= base_url('notes/query_update/').$code ?>",
                   method:'POST',
                   data : param,
                   success: function (data) {
                        $('#result').html(data);
                        $('#result').addClass('alert alert-success');
                   },
                   error: function () {
                       alert("error");
                   }
               })
           })
        });
    </script>
<?php
endif;
