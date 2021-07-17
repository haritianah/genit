<?php
if (!empty($this->session->flashdata('error'))) :
    ?>
    <div><p class="alert alert-danger"><?= $this->session->flashdata('error') ?></p></div>
<?php
endif;
?>

<div class="login-clean">
    <form method="post" action="<?= base_url('login') ?>">
        <h2 class="sr-only">Login Form</h2>
        <div class="illustration"><i class="ion-university"></i></div>
        <div class="form-group">
            <input class="form-control" type="text" name="user" placeholder="Utilisateur">
        </div>
        <div class="form-group">
            <input class="form-control" type="password" name="pass" placeholder="Mot de passe">
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-block" type="submit" name="btn_sub">Se connecter</button>
        </div>
</div>
<script>
    $('document').ready(function () {
       $('header').remove();
       $('.heads').remove();
    });
</script>
