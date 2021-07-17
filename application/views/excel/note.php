<table class="table table-bordered">
    <tr>
        <td>ID</td>
        <td>Nom et prénoms</td>
        <td>Note</td>
        <!--<td>SQL</td>-->
    </tr>
<?php
$countError=0;
$data =array();
foreach ($object->getWorksheetIterator()  as $worksheet) {
    $highRow = $worksheet->getHighestRow();
    for ($row= $firstRow; $row<= $highRow ; $row++){
        if (!empty($idCol) && !empty($noteCol)){
            $id = $worksheet->getCell($idCol.$row)->getValue();
            //
            $note = $worksheet->getCell($noteCol.$row)->getValue();
            if (!is_numeric($note)){
                $note= 0;
            }
            //
            $name  = $worksheet->getCell('E'.$row)->getValue();
            //Query
            $this->db->select("id_etudiant, concat(nom,' ',prenom)as fullname");
            $this->db->where('id_etudiant',$id);
            $result = $this->db->get('etudiant')->row();
            $sqlText = $this->db->last_query();
            //TABLE
            if (isset($result->id_etudiant)){
                $fullname = $result->fullname;
            }else{
                $fullname=$name;
                $countError ++;
            }
            echo "<tr>";
                echo "<td>$id</td>";
                echo "<td>{$fullname}</td>";
                echo "<td>{$note}</td>";
               // echo "<td>{$sqlText}</td>";
            echo "</tr>";
            $data[$id]= $note;
            ?>
            <script>
                $("#<?= $id ?>").val("<?= $note ?>");
            </script>
    <?php
        }
    }
}
echo "<p class='alert alert-danger'>Non Trouvé: $countError</p>";
?>

