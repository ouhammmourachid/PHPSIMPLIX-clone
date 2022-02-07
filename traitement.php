<?php
$is_max = filter_var($_GET["is_max"],FILTER_VALIDATE_BOOLEAN);
$les_b = [];
$coef = [];
$contrant = [] ;
$matrix = [] ;
for($i=0;$i<count($_GET["les_b"]);$i++){
    $les_b[] = floatval($_GET["les_b"][$i]);
}
for($i=0;$i<count($_GET["coef"]);$i++){
    $coef[] = floatval($_GET["coef"][$i]);
}
for($i=0;$i<count($_GET["contrant"]);$i++){
    $contrant[] = floatval($_GET["contrant"][$i]);
}
for($i=1;$i<count($_GET)-3;$i++){
    $list = [] ;
    for($j=0;$j<count($_GET["matrix{$i}"]);$j++){
        $list[] = floatval($_GET["matrix{$i}"][$j]);
    }
    $matrix[] = $list ;
}
require_once "simplixe.php";
$simplixe = new Simplixe($matrix,$coef,$contrant,$les_b,$is_max=$is_max);
require_once "partial/header.php";
?>
<p>On transforme le problème sous sa forme canonique, ajoutant des variables d'excès, d'écart, et artificielles, selon qu'il convient .</p>
<br><br>
<div>
    <?php if($is_max) : ?>
        <h3>MIXIMISER:</h3>Z =
    <?php endif ; ?>
    <?php if(!$is_max) : ?>
        <h3>MINIMISER:</h3>Z=
    <?php endif ; ?>
    <?php for($i=0;$i<count($coef);$i++) : ?>
        <?php echo $coef[$i] ;?> X<sub><?php echo $i+1; ?></sub>
        <?php if($i!==count($coef)-1) : ?>
            +
        <?php endif ;?>
    <?php endfor ; ?>
    <br><br>
    sous les contraintes:
    <br><br>
    <?php for($j=0;$j<count($matrix);$j++) : ?>
        <?php for($i=0;$i<count($coef);$i++) : ?>
            <?php echo $matrix[$j][$i] ; ?>
            X<sub><?php echo $i+1 ; ?></sub>
            <?php if($i!==count($coef)-1) : ?>
                +
            <?php endif ;?>
        <?php endfor ; ?>
        <?php if($contrant[$j]==0) :?>
            =
        <?php endif; ?>
        <?php if($contrant[$j]==1) :?>
            &ge;
        <?php endif; ?>
        <?php if($contrant[$j]==-1) :?>
            &le;
        <?php endif; ?>
        <?php echo $les_b[$j] ; ?>
        <br>
    <?php endfor ;?>
</div>
<div>
    <img src="partial/flecha.png" alt="">
</div>
<div>
    <?php if($is_max) : ?>
        <h3>MAXIMISER:</h3>Z =
    <?php endif ; ?>
    <?php if(!$is_max) : ?>
        <h1>MANIMISER:</h1>Z=
    <?php endif ; ?>
    <?php for($i=0;$i<count($simplixe->coef);$i++) : ?>
        <?php echo $simplixe->coef[$i] ;?> X<sub><?php echo $i+1; ?></sub>
        <?php if($i!==count($simplixe->coef)-1) : ?>
            +
        <?php endif ;?>
    <?php endfor ; ?>
    <br><br>
    sous les contraintes:
    <br><br>
    <?php for($j=0;$j<count($simplixe->matrix);$j++) : ?>
        <?php for($i=0;$i<count($simplixe->coef);$i++) : ?>
            <?php echo $simplixe->matrix[$j][$i] ; ?>
            X<sub><?php echo $i+1 ; ?></sub>
            <?php if($i!==count($simplixe->coef)-1) : ?>
                +
            <?php endif ;?>
        <?php endfor ; ?>
            =
        <?php echo $les_b[$j] ; ?>
        <br>
    <?php endfor ;?>
</div>
<?php
while($simplixe->one_step());
?>
<p>Nous avons construit le premier tableau de la méthode du Simplexe.</p>
<form action="result.php" method="get">
    <input type="hidden" name="Z" value="<?php echo $simplixe->Z ;?>">
    <input type="hidden" name="X" value="<?php echo $simplixe->les_x();?>">
    <button type="submit">Solution directe</button>
    <!-- <input type="submit" name="submitForm" value="submit"> -->
</form>

<?php
require_once "partial/footer.php";
?>
