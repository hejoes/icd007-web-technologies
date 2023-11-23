<div id="error-message">
    <?= $errorMessage ?>
</div>

<br>
<br>

<form method="post">
    <input type="hidden" name="color" value="<?= $color ?>" />

    <label>
        <input type="checkbox" name="conditions" value="1" />
        Nõusutun tingimustega
    </label>

    <br><br>

    <button type="submit"
            name="cmd"
            value="forward">Edasi</button>
</form>
