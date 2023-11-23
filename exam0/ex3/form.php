<form method="post">

    Palun valige värv<br><br>

    <select name="color">
        <option></option>
        <?php foreach ($colors as $color): ?>
            <option value="<?= $color->id ?>"><?= $color->label ?></option>
        <?php endforeach; ?>
    </select>

    <br>
    <br>

    <button type="submit" name="cmd" value="select">Edasi</button>

</form>