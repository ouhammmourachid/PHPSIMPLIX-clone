<?php require_once "partial/header.php"; ?>
<div class="container">
    <form action="variable.php" method="get" >
    <label for="">Combien de variables de décision a le problème?</label>
    <input type="text" name="number_var" id=""><br><br>
    <label for="">Combien de contraintes?</label>
    <input type="text" name="number_contra" id=""><br><br>
    <button type="submit">Continuer</button>
    </form>
</div>

<?php require_once "partial/footer.php" ; ?>