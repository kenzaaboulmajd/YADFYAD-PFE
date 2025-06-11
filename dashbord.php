<?php

    session_start();

        $sdn="mysql:host=localhost;dbname=yadfyad";
        $user="root";
        $pass= "";
        try{
            $db=new PDO($sdn, $user, $pass);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if(!isset($_SESSION['id'])){
                header('location:connexion.php');
                exit;
            }
            $id= $_SESSION['id'];
            $min= $db->prepare("SELECT SUM(durée) as total_minute FROM revisions WHERE utilisateur_id =:id");
            $min->execute([":id"=>$id]);
            $total_min=$min->fetch(PDO::FETCH_ASSOC)["total_minute"]??0;
    
            $moy=$db->prepare("SELECT AVG(note) as moyenne FROM revisions WHERE utilisateur_id =:id ");
            $moy->execute([":id"=>$id]);
            $moyenne=$moy->fetch(PDO::FETCH_ASSOC)["moyenne"] ??0;
    
            $total=$db->prepare("SELECT COUNT(*) as tot FROM revisions WHERE utilisateur_id =:id ");
            $total->execute([":id"=>$id]);
    
            $total_rev=$total->fetch(PDO::FETCH_ASSOC)["tot"]??0 ;
        }catch(Exception $e){
            echo "errorr".$e->getMessage();
        }

        
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Tableau de bord</h2>
<p>Total d’heures cette semaine :<?= round($total_min /60)?>  h</p>
<p>Note moyenne cette semaine :<?= round($moyenne) ?></p>
<p>Séances ce mois-ci :<?= $total_rev ; ?></p>

<a href="ajouter_revision.php">➕ Nouvelle révision</a>
<a href="revisions.php">📋 Voir les révisions</a>
</body>
</html>