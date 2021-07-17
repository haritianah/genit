<?php
$this->load->model('model_etudiants');
$etudiant = $this->model_etudiants->get_info_etudiant($notes[0]->id_etudiant);
?>
<div class="container text-center">
<h4> <b><?= $etudiant->id_etudiant ?></b> <br> <?= $etudiant->nom ?> <?= $etudiant->prenom ?></h4>
<h5>Matiere : <?= $matiere->nom_matiere ?></h5>
<h5>Résultat : <?= $resmat->resultat ?></h5>
    <div class="alert alert-danger">
        <p>NOTES</p>
        <?php foreach ($notes as $note): ?>
            <p><a href="<?= base_url('notes/update/code/').$note->code_note ?>" target="_blank"><?= ucfirst($note->session) ?>: <?= $note->notes ?>/<?= $note->annee_etude ?></a></p>
        <?php endforeach; ?>
    </div>
</div>