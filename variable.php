<?php require_once "partial/header.php"; ?>
<form action="traitement.php" method="get">
    <label for="">Quel est le but de la fonction?</label>
    <select name="is_max" id="">
        <option value="TRUE">Maximiser</option>
        <option value="FALSE">Minimiser</option>
    </select><br><br>
    Function:
    <?php for($i=0;$i<$_GET["number_var"];$i++) : ?>
        <input type="text" name="coef[]" id="">
        X<sub><?php echo $i+1 ; ?></sub>
        <?php if($i!==$_GET["number_var"]-1) : ?>
            +
        <?php endif ;?>
    <?php endfor ; ?>
    <br><br> Contraintes <br><br>
    <?php for($j=0;$j<$_GET["number_contra"];$j++) : ?>
        <?php for($i=0;$i<$_GET["number_var"];$i++) : ?>
        <input type="text" name="matrix<?php echo $j+1; ?>[]" id="">
        X<sub><?php echo $i+1 ; ?></sub>
        <?php if($i!==$_GET["number_var"]-1) : ?>
            +
        <?php endif ;?>
        <?php endfor ; ?>
        <select name="contrant[]" id="">
            <option value="-1">&le;</option>
            <option value="0">=</option>
            <option value="1">&ge;</option>
        </select>
        <input type="text" name="les_b[]" id="">
        <br><br>
    <?php endfor ;?>
    <?php for($i=0;$i<$_GET["number_var"];$i++) : ?>
        X<sub><?php echo $i+1 ; ?></sub>
        <?php if($i!==$_GET["number_var"]-1) : ?>
            ,
        <?php endif ;?>
    <?php endfor ; ?>&ge;0
    <br><br>
    <button type="submit">Continuer</button>

</form>
<p>On transforme le problème sous sa forme canonique, ajoutant des variables d'excès, d'écart, et artificielles, selon qu'il convient .</p>

<?php require_once "partial/footer.php"; ?>
