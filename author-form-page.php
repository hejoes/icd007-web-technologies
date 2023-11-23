<?php
require_once("funcs.php");

#ctrlalts
foreach (file('data/authors.txt') as $line) {
    $book_data = explode(";", $line);
    $book_id = $book_data[0];
    $book_ids[] = $book_id;
}

if (count($book_ids) != 0) {
    $max_id = intval(max($book_ids));
    $id = strval($max_id +1);
}
else {
    $id = 1;
}

$first_name = $_POST["firstName"];
$last_name = $_POST["lastName"];
$grade = isset($_POST['grade']) ? $_POST['grade'] : 0;

    //Ilmaa if request methodita=postita viiks mind kohe headeri poolt suunatud lingile ja mitte autori formile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $first_name_error = false;
    $last_name_error = false;

    if (isset($_POST["firstName"])) {
        if (strlen($first_name) < 1) {
            $first_name_error = true;
        }
    }

    if (isset($_POST["lastName"])) {
        if (strlen($last_name) < 2) {
            $last_name_error = true;
        }
    }
    # front kontrollerit kasutame, kuna centralized p2ringute haldus
    #kood organiseeritud ja vähendab päringute duplitseerimist, navigatsiooni lahendamine sarnase loogiga alusel
    if (!$first_name_error && !$last_name_error) {
        if ($_GET['command'] == 'author-save') {
            $originalName = $_POST["originalName"];
            edit_author($originalName, $first_name, $last_name, $grade);
            header('Location: index.php?cmd=author-list&message=edited');
        } elseif ($_GET['command'] == 'author-added') {
            save_author($first_name, $last_name, $grade);;
            header('Location: index.php?cmd=author-list&message=saved');
        } elseif ($_GET['command'] == 'author-delete') {
            delete_author($first_name);
            header('Location: index.php?cmd=author-list&message=deleted');
        }
    }
}

?>

<!--mall aitab eraldada muud koodi htmlist, lihtsustab koodist arusaamist kuna võimaldab panna
sarnased koodi osad omavahel kokku-->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add a author</title>

    <link rel="stylesheet" href="css/style.css" />
  </head>

  <body id="author-form-page">
    <div class="container">
      <header>
        <nav class="menu">
            <a href="index.php" id="book-list-link">Raamatud</a>
            <a href="index.php?cmd=book-form" id="book-form-link">Lisa raamat</a>
            <a href="index.php?cmd=author-list" id="author-list-link">Autorid</a>
            <a href="index.php?cmd=author-form" id="author-form-link">Lisa autor</a>
        </nav>
      </header>

        <?php if ($first_name_error && $last_name_error):?>
            <div id="error-block">
                Eesnimi peab olema 1 kuni 21 märki! <br>
                Perekonnanimi peab olema 2 kuni 22 märki!
            </div>
        <?php elseif($first_name_error):?>
            <div id="error-block">Eesnimi peab olema 1 kuni 21 märki!</div>
        <?php elseif ($last_name_error):?>
            <div id="error-block">Perekonnanimi peab olema 2 kuni 22 märki!</div>
        <?php endif;?>

        <?php if (!isset($_GET['id'])): ?>
      <section>
        <form class="form" method="post">
          <div class="form-cell">
            <label class="label-cell" for="firstName">Eesnimi:</label>
            <input class="input-cell" name="firstName" type="text" value="<?= $first_name ?>" />
          </div>

          <div class="form-cell">
            <label class="label-cell" for="lastName">Perekonnanimi:</label>
            <input class="input-cell" name="lastName" type="text" value="<?= $last_name ?>" />
          </div>

          <div class="form-cell">
              <?php foreach (range(1, 5) as $i): ?>
                  <label><input type="radio" name="grade"
                          <?= $i === intval(isset($_POST['grade'])) ? 'checked' : ''; ?>
                                value="<?= $i ?>" /></label>
                  <?= $i ?>
              <?php endforeach; ?>
          </div>

          <input
            type="submit"
            name="submitButton"
            value="Salvesta"
            class="submitbtn"
            formaction="author-form-page.php?command=author-added"
          />
        </form>
      </section>
        <?php endif; ?>

        <?php if (isset($_GET['id'])): ?>
            <section>
                <form class="form" method="post">
                    <div class="form-cell">
                        <label class="label-cell" for="firstName">Eesnimi:</label>
                        <input class="input-cell" name="firstName" type="text" value="<?= $_GET["firstName"]?>" />
                        <input class="input-cell" name="originalName" type="hidden" value="<?= $_GET["firstName"]?>" />
                    </div>

                    <div class="form-cell">
                        <label class="label-cell" for="lastName">Perekonnanimi:</label>
                        <input class="input-cell" name="lastName" type="text" value="<?= $_GET["lastName"]?>" />
                    </div>

                    <div class="form-cell">
                        <label class="label-cell" for="grade">Hinne:</label>
                        <?php foreach (range(1, 5) as $i): ?>

                            <?php if (intval($_GET['grade']) == $i): ?>
                                <label><input type="radio" name="grade" value="<?=$i?>" checked="checked"><?=$i?></label>
                            <?php else: ?>
                                <label><input type="radio" name="grade" value="<?=$i?>"><?=$i?></label>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <input type="submit" name="submitButton" value="Salvesta" class="submitbtn" formaction="?command=author-save">
                    <input type="submit" name="deleteButton" value="Kustuta" class="deletebutton" formaction="?command=author-delete">
                </form>
            </section>
        <?php endif; ?>

      <footer>ICD0007 Projekt</footer>
    </div>
  </body>
</html>
