<?php
require_once ("funcs.php");

$books = add_book();


$cmd = $_GET['cmd'] ?? 'book-list-hm';

// Prepare variables that might be needed
$books = null;

switch ($cmd) {
    case 'book-form':
        require_once("book-form-page.php");
        exit();  // Terminate the script here
    case 'author-list':
        require_once("author-list.php");
        exit();  // Terminate the script here
    case 'author-form':
        require_once("author-form-page.php");
        exit();  // Terminate the script here
    default:
        $books = add_book();
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Book list</title>

    <link rel="stylesheet" href="css/style.css" />
  </head>

  <body id="book-list-page">
    <div class="container">
      <header>
        <nav class="menu">
            <a href="index.php" id="book-list-link">Raamatud</a>
            <a href="index.php?cmd=book-form" id="book-form-link">Lisa raamat</a>
            <a href="index.php?cmd=author-list" id="author-list-link">Autorid</a>
            <a href="index.php?cmd=author-form" id="author-form-link">Lisa autor</a>
        </nav>
      </header>

      <section>
          <?php if (isset($_GET['message']) && $_GET['message'] == 'saved'):?>

              <div id="message-block">Kirje lisatud!</div>
          <?php endif;?>
          <?php if (isset($_GET['message']) && $_GET['message'] == 'edited'):?>
              <div id="message-block">Kirje muudetud!</div>
          <?php endif;?>
          <?php if (isset($_GET['message']) && $_GET['message'] == 'deleted'):?>
              <div id="error-block">Kirje kustutatud!</div>
          <?php endif;?>
        <div class="author-header">
          <div class="pealkiri">Pealkiri</div>
            <div class="hinded">Autor</div>
          <div class="hinded">Hinne</div>
        </div>
        <div class="breaker"></div>

        <div class="main">

          <?php foreach ($books as $book): ?>
            <div> <a href="book-form-page.php?id=<?=$book["id"]?>"> <?= $book["title"] ?> </a> </div>
            <div> <?= $book["author_first_name"] . " " . $book["author_last_name"] ?> </div>
            <div> <?= $book["grade"] ?> </div>
          <?php endforeach; ?>
        </div>
      </section>

      <footer>ICD0007 Projekt</footer>
    </div>
  </body>
</html>
