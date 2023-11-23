<?php

require_once("funcs.php");

$authors = add_author();
$books = add_book();

$book_error = false;

$title = $_POST["title"];
$grade = isset($_POST['grade']) ? $_POST['grade'] : 0;
$isRead = isset($_POST['isRead']) ? "jah" : "ei";
$author1_id = $_POST["author1"];

    // Ilma request methodita ei saada ära
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

#kui grade on lisatud, las jääda grade, kui pole gradi siis pane hinne 0
    if (isset($_POST["title"])) {
        if (strlen($title) < 3 or strlen($title) > 23) {
            $book_error = true;
        }
    }
// If book length not too short or long, send POST request to index.php with the saved message

    if (!$book_error) {
        if ($_GET['command'] == 'book-list') {
            $originalTitle = $_POST["originalTitle"];
            edit_book($originalTitle, $title, $grade, $isRead, $author1_id);
            header('Location: index.php?message=edited');
        } elseif ($_GET['command'] == 'book-added') {
            save_book($title, $grade, $isRead, $author1_id);
            header('Location: index.php?message=saved', true, 302);
            exit();
        } elseif ($_GET['command'] == 'book-delete') {
            delete_book($title);
            header('Location: index.php?message=deleted');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add a book</title>

    <link rel="stylesheet" href="css/style.css" />
  </head>

  <body id="book-form-page">
    <div class="container">
      <header>
        <nav class="menu">
          <a href="index.php" id="book-list-link">Raamatud</a>
            <a href="index.php?cmd=book-form" id="book-form-link">Lisa raamat</a>
            <a href="index.php?cmd=author-list" id="author-list-link">Autorid</a>
            <a href="index.php?cmd=author-form" id="author-form-link">Lisa autor</a>

        </nav>
      </header>

        <?php if ($book_error): ?>
            <div id="error-block">Pealkiri peab olema 3 kuni 23 tähemärki!</div><br>
        <?php endif ?>
        <?php if (!isset($_GET['id'])): ?>
      <section>
        <form class="form" action="book-form-page.php" method="post">

          <div class="form-cell">
            <label class="label-cell" for="title">Pealkiri:</label>
            <input class="input-cell" name="title" type="text" value="<?= $title ?>" />
          </div>

            <div class="form-cell">
                <label class="label-cell" for="author">Autor:</label>
                <select id="author1" name="author1">
                    <option value="0"></option>
                    <?php foreach($authors as $author): ?>
                        <option value="<?= $author['id'] ?>"><?= urldecode(string: $author["first_name"]) . " " . urldecode(string: $author["last_name"]); ?></option>
                    <?php endforeach; ?>


                </select>
            </div>

            <div class="form-cell">
                <label class="grade">Hinne:</label>
                <?php foreach (range(1, 5) as $i): ?>
                    <label><input type="radio" name="grade"
                            <?= $i === intval(isset($_POST['grade'])) ? 'checked' : ''; ?>
                                  value="<?= $i ?>" /></label>
                    <?= $i ?>
                <?php endforeach; ?>
            </div>

          <div class="form-cell">
            <label class="label-cell" for="read">Loetud:</label>
            <input type="checkbox" name="isRead" <?= ($isRead=="jah") ? 'checked' : '';?>/>
          </div>

          <input
            type="submit"
            name="submitButton"
            value="Salvesta"
            class="submitbtn"
            formaction="book-form-page.php?command=book-added"
          />
        </form>
      </section>
            <?php endif; ?>

        <?php if (isset($_GET['id'])):?>

        <?php
            $conn = getConnection();

            $stmt = $conn->prepare('select * from books where book_id = :id ');

            $stmt->bindParam(param: ':id', var: $_GET["id"]);

            $stmt -> execute();

            foreach($stmt as $book) {
                $book_title = $book["book_name"];
                $book_grade = $book["grade"];
                $book_is_read = $book["is_read"];
            }?>

            <section>
            <form class="form" action="book-form-page.php" method="post">

            <div class="form-cell">
            <label class="label-cell" for="title">Pealkiri:</label>
                        <div class="input-cell">
                            <input class="input-cell" name="title" type="text" value="<?= htmlspecialchars($book_title) ?>">
                            <input type="hidden" name="originalTitle" value="<?= htmlspecialchars($book_title, ENT_QUOTES) ?>"/>
                        </div>
            </div>
                <div class="form-cell">
                    <label class="label-cell" for="author1">Autor:</label>

                    <select name="author1">
                        <option value="0"></option>
                        <?php
                            foreach ($books as $book) {
                                if ($_GET["id"] == $book['id']) {
                                    $real_author_id = $book["author_id"];
                                }
                            }
                        ?>

                        <?php foreach($authors as $author): ?>
                        <?php if ($author["id"] == $real_author_id): ?>
                                <option value="<?= $author['id']?>" selected="selected"><?= urldecode(string: $author["first_name"]) . " " . urldecode(string: $author["last_name"]); ?></option>
                            <?php else: ?>
                                <option value="<?= $author['id'] ?>"><?= urldecode(string: $author["first_name"]) . " " . urldecode(string: $author["last_name"]); ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>


                    </select>
                </div>

                <div class="form-cell">
                    <label class="grade">Hinne:</label>
                    <?php foreach (range(1, 5) as $i): ?>

                        <?php if (intval($book_grade) == $i): ?>
                        <label><input type="radio" name="grade" value="<?=$i?>" checked="checked"><?=$i?></label>
                        <?php else: ?>
                        <label><input type="radio" name="grade" value="<?=$i?>"><?=$i?></label>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>


                <div class="form-cell">
                    <label><input id="isRead" name="isRead" type="checkbox" <?= ($book_is_read=="jah") ? "checked" : ''; ?>></label>
                </div>

                <input type="submit" name="submitButton" value="Salvesta" class="submitbtn" formaction="?command=book-list">
                <input type="submit" name="deleteButton" value="Kustuta" class="deletebutton" formaction="?command=book-delete">
                </form>
                </section>

        <?php endif; ?>

      <footer>ICD0007 Projekt</footer>
    </div>
  </body>
</html>
