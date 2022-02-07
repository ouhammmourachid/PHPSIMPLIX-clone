<?php require_once "partial/header.php" ;?>
<br><br>
<p></p>
<?php  echo "La solution optimale est Z = {$_GET["Z"]}"; ?>
<?php 
$les_x = explode("-",$_GET["X"]);
?>
<?php for($i=0;$i<count($les_x);$i++):?>
    <p>X<sub><?php echo $i+1 ;?></sub> = <?php echo $les_x[$i]; ?></p>
<?php  endfor ; ?>
<?php require_once "partial/footer.php"; ?>