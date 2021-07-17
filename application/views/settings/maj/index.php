<h1>Pasage d'année universitaire</h1>

<form action="<?= base_url('settings/maj/action') ?>" id= 'form' method="post">
    <input type="hidden" name="currentAnnee" value="2019">
    <button class="btn btn-danger" type="submit">Mise à jour</button>
</form>

<script>
    $('#form').submit(function(e){
        
        if(confirm('Cette action est irréversible')){
            consoel.log('dd');    
        }else{
            e.preventDefault();
        }
        
    });
</script>