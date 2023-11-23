<?php
require_once '../vendor/tpl.php';
require_once 'Book.php';
require_once 'Author.php';

$books = [['Head First HTML and CSS', [['Elisabeth', 'Robson'], ['Eric', 'Freeman']], 5],
          ['Learning Web Design', [['Jennifer', 'Robbins']], 4],
          ['Head First Learn to Code', [['Eric', 'Freeman']], 4]];


$book = new Book('Head First HTML and CSS', 3, false);
$author = new Author('Elisabeth', 'Robson');

$book->addAuthor($author);

$data = [
    'books' => [$book],

];


print renderTemplate('tpl/list.html', $data);
?>

