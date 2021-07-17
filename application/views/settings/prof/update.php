<h1>Modifier un Profésseur</h1>
<?php if (isset($_SESSION['flash'])){
    $key = key($_SESSION['flash']);
    echo "<div class='alert alert-$key'>";
    foreach ($_SESSION['flash'] as $flash) {
        if (is_array($flash)):
            foreach ($flash as $flash_s) {
                echo "<p>$flash_s</p>";
            }
        else:
            echo "<p>$flash</p>";
        endif;
    }
    echo '</div>';
    unset($_SESSION['flash']);
}?>
<div class="container">
    <form action="<?= base_url('settings/prof/q_update') ?>" id="form" method="post">
        <input type="text" name="user" id="user" placeholder="Utilisateur" onkeyup="checkUser()">
        <input type="text" name="nom" id="nom" placeholder="Nom">
        <input type="text" name="prenom" id="prenom" placeholder="Prénoms">
        <input type="email" name="mail" id="mail" placeholder="Adresse E-mail">
        <input type="password" name="passwd" id="passwd" placeholder="Mot de passe">
        <input type="password" name="Cpasswd" id="Cpasswd" placeholder="Confirmer mot de passe">
        <select name="matiere" id="matiere">
            <?php foreach ($matieres as $matiere): ?>
                <option value="<?= $matiere->id_matiere ?>"><?= $matiere->nom_matiere ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-primary btn-block">Modifier</button>
    </form>
</div>
<script>
    function checkUser() {
        $.ajax({
            url : "<?= base_url('ajax/update_prof') ?>",
            method : 'POST',
            data : $('#form').serialize(),
            success : function (data) {
                if (data == 'true'){
                    $('#user').css('color','green');
                    fillInput();
                }else{
                    $('#user').css('color','red');
                }
            }
        })
    }
    function fillInput() {

    }
</script>