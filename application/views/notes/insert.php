<h1>Insertion notes <?= $niveau ?></h1>
<!--Liste niveau-->
<?php empty($niveau) ? $this->app->niveau("Notes/insert") : false ;?>
<!--Liste unites niveau-->
<?php if(!empty($niveau) && empty($idunit)): ?>
<div id='horz'>
    <ul>
        <?php foreach ($unites as $unite): ?>
            <li><a href="<?= base_url("Notes/insert/$niveau/$unite->id_unite") ?>"><?= $unite->num_unite ?>:<?= $unite->nom_unite ?> <?= $unite->semestre ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>
<!--Formulaire-->
<?php if(!empty($niveau) && !empty($idunit)): ?>
<h3 class="text-center"><?= $unite->nom_unite ?></h3>
<div class="form_note">
    <form method="POST" action="" id="formnote">

        <div class="left-box box-3">
            <label for="matt" >Matière</label>
            <div class="styled-select blue rounded formnote-little">
                <select name="matiere" id="matt" onchange="retrieveEtudiant()">
                    <option value=0>Sélectionner Une Matiere</option>
                    <?php
                    foreach($matieres as $matiere){
                        ?>
                        <option value=<?= $matiere->id_matiere ?>><?= $matiere->nom_matiere ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="left-box box-3">
            <label for="sess">Session</label>
            <div class="styled-select black rounded formnote-little">
                <select name="session" id="sess" onchange="retrieveEtudiant()">
                    <option value="sel">Sélectionner la Session</option>
                    <option value="normale">Normale</option>
                    <option value="rattrapage">Rattrapage</option>
                </select>
            </div>
        </div>
        <div class="left-box box-3 form-group">
            <label for="annee_et" style="padding-right:9px">Année d'etude</label>
            <input type="number" style="margin-top:10px; height:25px; z-index:1" name="annee_etude"  id="annee_et" onkeydown="doNothing()" class="form-control formnote-little" value="<?= $_SESSION['annee_etude'] ?>"  min=2000 >
        </div>
        <div id="listetd" style="margin-top: 10px">
        </div>
        <button type="submhit" name="btn_sub" id="butt" class="btn btn-lg btn-success" >Insérer</button>
    </form>
        <div class="alert alert-info" id="resultInsert"></div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#resultInsert').hide();
            $('#formnote').submit(function () {
                var form = $('#formnote');
                var containeList= $('#listetd');
                param = form.serialize();
                param = param+"&unit="+<?= $idunit ?>;
                event.preventDefault();
                if($('#matt').val()!=0 && $('#sess').val()!='sel') {
                    $.ajax({
                        url: "<?= base_url('notes/query_insert') ?>",
                        method: "POST",
                        data: param,
                        beforeSend: function () {
                            $('#resultInsert').html("<p class='alert-info text-center'>CHARGEMENT...</p>");
                        },
                        success: function (data) {
                            /*form.slideUp(800);
                            $('#butt').remove();*/
                            $('#sess').val('sel');
                            $('#listetd').html('');
                            $('#resultInsert').html(data);
                            $('#resultInsert').slideDown();
                        },
                        error: function () {
                            alert("ERROR");
                        }
                    })
                }
            });
            $('#formExcel').submit(function (e) {
                e.preventDefault();
                var premierLigne = prompt('Entrer la première ligne');
                var fd = new FormData(this);
                fd.append('firstRow',premierLigne);
               $.ajax({
                  url : "<?= base_url('ajax/excel_note') ?>",
                   method :"POST",
                   contentType:false,
                   processData:false,
                   data : fd,
                   beforeSend : function () {
                       $('#preview').fadeOut();
                   } ,
                   success : function (data) {
                        $('#preview').html(data);
                       $('#preview').fadeIn();
                   },
                   error: function () {
                       alert('Error');
                   }
               });
            });
            $('#rmbtn').click(function () {
                $('#resultInsert').hide();
                $('#preview').fadeOut();
                $('#preview').html('');
            })
        });
        //
        function retrieveEtudiant() {
            var form = $('#formnote');
            var containerList= $('#listetd');
            containerList.html('');
            param = form.serialize();
            param = param+"&unit="+<?= $idunit ?>;
            if($('#matt').val()!=0 && $('#sess').val()!='sel'){
                $.ajax({
                    url : "<?= base_url('notes/ajax_insert') ?>",
                    method : "POST",
                    data : param,
                    beforeSend: function () {
                        containerList.html("<p class='alert-info text-center'>CHARGEMENT...</p>");
                    },
                    success : function (data) {
                        containerList.html(data);
                    },
                    error :  function () {
                        alert('ERREUR');
                    }
                });
            }
        }
        function doNothing() {
            var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
            if( keyCode == 13 ) {
                if(!e) var e = window.event;

                e.cancelBubble = true;
                e.returnValue = false;
                if (e.stopPropagation) {
                    e.stopPropagation();
                    e.preventDefault();
                }
            }
        }
    </script>
<!--Excel-->
    <form method="POST" action="" id="formExcel" enctype="multipart/form-data">
        <input type="text" name="notecol" placeholder="Colonne Note" class="exc">
<!--        <input type="text" name="idcol" placeholder="Id col" class="exc">-->
        <input type="file" name="excelnote" id="fileExcel" class="input-file">
        <input type="submit" name="subxl" id="insbtn" value="Inserer" class="button18">
        <input type="button" id="rmbtn" value="remove" class="button18">
    </form>
    <div id="preview">
    </div>
</div>
<?php endif;  ?>