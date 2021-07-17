<h1><?= $etudiant->nom ?> <?= $etudiant->prenom ?></h1>
<?php
//debug($etudiant);
    echo form_open('settings/etudiant/query_update',array("id"=>'form'));
    //
    $labelNom = form_label('Nom');
    $inputNom = form_input('nom',$etudiant->nom,'class="form-control"');
    $labelPrenom = form_label('Prénoms');
    $inputPrenom = form_input('prenom',$etudiant->prenom,'class="form-control"');
    //
    $sexe = array('masculin'=>'Homme','feminin'=>'Femme');
    $labelSexe = form_label('Sexe');
    $inputSexe = form_dropdown('sexe',$sexe,$etudiant->sexe,'class="form-control"');
    $labelAdresse = form_label('Adresse');
    $inputAdresse = form_input('adresse',$etudiant->adresse,'class="form-control"');
    $labelDate = form_label('Date de naissance');
    $inputDate = form_input(array('name'=>'date','type'=>'date'),$etudiant->naissance,'class="form-control"');
    $labelLieu = form_label('Lieu de naissance');
    $inputLieu = form_input('lieu',$etudiant->lieu,'class="form-control"');
    $labelPhone = form_label('Téléphone');
    $inputPhone = form_input('phone', "0$etudiant->telephone",'class="form-control"');
    //
    $inscrit = array('1'=>'Inscrit','0'=>'Non inscrit');
    $labelInscrit = form_label('Inscrit');
    $inputInscrit = form_dropdown('inscrit',$inscrit,$etudiant->inscrit,'class="form-control"');
?>
<div class="container">
    <input type="hidden" name="id" value="<?= $etudiant->id_etudiant ?>">
    <div class="row">
        <div class="form-group col-sm-4">
            <?= $labelNom ?>
            <?= $inputNom ?>
        </div>
        <div class="form-group col-sm-4">
            <?= $labelPrenom ?>
            <?= $inputPrenom ?>
        </div>
        <div class="form-group col-sm-3">
            <?= $labelSexe ?>
            <?= $inputSexe ?>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-4">
            <?= $labelDate ?>
            <?= $inputDate ?>
        </div>
        <div class="form-group col-sm-4">
            <?= $labelLieu ?>
            <?= $inputLieu ?>
        </div>
        <div class="form-group col-sm-3">
            <?= $labelAdresse ?>
            <?= $inputAdresse ?>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-4">
            <?= $labelPhone ?>
            <?= $inputPhone ?>
        </div>
        <div class="form-group col-sm-4">
            <?= $labelInscrit ?>
            <?= $inputInscrit ?>
        </div>
        <div class="form-group col-sm-3">
            <button type="submit" class="btn btn-success form-control psi-bg" style="margin-top: 25px">Modifier</button>
        </div>
    </div>
</div>

<?= form_close() ?>