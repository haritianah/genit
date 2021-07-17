<h1>Créer compte profésseur</h1>
<?php

$this->app->session_msg();

?>
<div class="container">
    <form action="<?= base_url('settings/prof/q_insert') ?>" method="post">
        <input type="text" name="user" id="user" placeholder="Utilisateur" class="input-block-level">
        <input type="text" name="nom" id="nom" placeholder="Nom">
        <input type="text" name="prenom" id="prenom" placeholder="Prénom">
        <input type="email" name="mail" id="mail" placeholder="Email">
        <input type="password" name="passwd" id="passwd" placeholder="Mot de passe">
        <input type="password" name="Cpasswd" id="Cpasswd" placeholder="Confirmer le mot de passe">
        <select name="matiere" id="matiere">
            <?php foreach ($matieres as $matiere): ?>
            <option value="<?= $matiere->id_matiere ?>"><?= $matiere->nom_matiere ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-primary btn-block">Insérer</button>
    </form>
</div>