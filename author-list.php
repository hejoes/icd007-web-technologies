<?php
require_once ("funcs.php");

$authors = add_author();
?>
<!--
kypsis-sessioonile gener random väärtus, kui brauser teeb serverile uue päringu, pannakse kypsis kaasa
Redirect samas kui **include** - trükib faili välja ja n2itab staatilist sisu **header** viib uuele lehele
span - võimaldab spetsiifilisele sektsioonile htmlist kujundust või formateerimist teha. "Inline" element, mis tähendab et seda võib kasutada paragraafi sees, listis või mujal blokk elementides
Location - brauser teeb uue päringu urlile, peale mida toimub ümbersuunamine uuele lehele, url uuendatakse lehel
dto-lahendab probleemi, kuidas liigutada andmeid mitme aplikatsiooni komponendi vahel arusaadavalt ning muutmatult. Pmst nagu kontainer mis hoiab endas infot suhtluse jaoks
-->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Author list</title>

    <link rel="stylesheet" href="css/style.css" />
  </head>

  <body id="author-list-page">
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
          <div class="pealkiri">Eesnimi</div>
          <div class="autorid">Perenimi</div>
          <div class="hinded">Hinne</div>
        </div>
        <div class="breaker"></div>

      <div class="main">
          <?php foreach ($authors as $author): ?>
              <div> <a href="author-form-page.php?id=<?=$author["id"]?>&firstName=<?= urlencode($author["first_name"])?>&lastName=<?= urlencode($author["last_name"]) ?>&grade=<?= urlencode($author["grade"]) ?>"><?= $author["first_name"] ?></a> </div>
              <div> <?= $author["last_name"] ?> </div>
              <div> <?= $author["grade"] ?> </div>
          <?php endforeach; ?>
      </div>

      </section>

      <footer>ICD0007 Projekt</footer>
    </div>
  </body>
</html>
