<?php

function save_book($title, $grade, $is_read, $author1_id) {
    $conn = getConnection();
    $stmt = $conn->prepare ('INSERT INTO books (author_id, book_name, grade, is_read) 
        VALUES(:book_author1, :book_name, :book_grade, :book_is_read)');

    $stmt -> bindParam(':book_name' , $title, PDO::PARAM_STR);
    $stmt -> bindParam(':book_grade' , $grade, PDO::PARAM_INT);
    $stmt -> bindParam(':book_is_read' , $is_read, PDO::PARAM_STR);
    $stmt -> bindParam(':book_author1' , $author1_id, PDO::PARAM_INT);
    $stmt -> execute();
}

function save_author($first_name, $last_name, $grade) {
    $conn = getConnection();
    $stmt = $conn->prepare ('INSERT INTO authors (first_name, last_name, grade) 
        VALUES(:author_first_name, :author_last_name, :author_grade)');

    $stmt -> bindParam(':author_first_name' , $first_name, PDO::PARAM_STR);
    $stmt -> bindParam(':author_last_name' , $last_name, PDO::PARAM_STR);
    $stmt -> bindParam(':author_grade' , $grade, PDO::PARAM_INT);

    $stmt -> execute();
}

function add_author(): array{
    $conn = getConnection();

    $authors = [];

    $stmt = $conn->prepare('select * from authors');
    $stmt -> execute();

    foreach($stmt as $author) {
        $author_id = $author["id"];
        $author_name = $author["first_name"];
        $author_last_name = $author["last_name"];
        $author_grade = $author["grade"];

        //dictionary
        $authors[] = ["id" => $author_id, "first_name" => $author_name,
            "last_name" => $author_last_name, "grade" => $author_grade];
    }

    return $authors;
}


function edit_book($originalTitle, $title, $grade, $isRead, $author1_id) {
    $conn = getConnection();

    $stmt = $conn->prepare('update books set book_name = :book_name,
             grade = :book_grade, is_read = :book_is_read, author_id = :book_author_id where book_name = :book_original_title');
    $stmt->bindParam(param: ':book_name', var: $title);

    $stmt->bindParam(param: ':book_original_title', var: $originalTitle);
    if ($grade == '') $grade = '1';
    $stmt->bindParam(param: ':book_grade', var: $grade);
    $stmt->bindParam(param: ':book_is_read', var: $isRead);
    $stmt->bindParam(param: ':book_author_id', var: $author1_id);

    $stmt->execute();
}

function add_book(): array{
    $conn = getConnection();

    $books = [];

    $stmt = $conn->prepare('select books.book_id, books.book_name, books.author_id, books.grade, books.is_read, authors.first_name, authors.last_name, authors.id
            from books left join authors on books.author_id = authors.id;');
    $stmt -> execute();

    foreach($stmt as $book) {
        $book_id = $book["book_id"]; //prolly not needed
        $author_id = $book["author_id"];
        //$author_table_id = $book["id"];
        $title = $book["book_name"];
        $grade = $book["grade"];
        $is_read = $book["is_read"];
        $author_first_name = $book["first_name"];
        $author_last_name = $book["last_name"];

        //dictionary
        $books[] = ["id" => urldecode($book_id), "author_id" => urldecode($author_id), "title" => urldecode($title), "grade" => urldecode($grade),
            "isRead" => urldecode($is_read), "author_first_name" => urldecode($author_first_name), "author_last_name" => urldecode($author_last_name)];
    }

    return $books;
}

function delete_book($title) {
    $books = add_book();
    $conn = getConnection();

    foreach ($books as $book) {
        if ($book["title"] == $title) {
            $stmt = $conn->prepare ('DELETE FROM books where book_id = :book_id');

            $stmt->bindValue(param: ':book_id', value: $book["id"]);
            $stmt -> execute();
        }

    }
}

function delete_author($firstName) {
    $authors = add_author();
    $conn = getConnection();

    foreach ($authors as $author) {
        if ($author["first_name"] == $firstName) {
            $stmt = $conn->prepare ('DELETE FROM authors where last_name = :last_name');
            $stmt->bindValue(param: ':last_name', value: $author["last_name"]);
            $stmt -> execute();
        }
    }
}

function edit_author($originalName, $firstName, $lastName, $grade) {

    $conn = getConnection();
    $stmt = $conn->prepare('update authors set first_name = :first_name,
             last_name = :last_name, grade = :grade where first_name = :original_name');
    $stmt->bindParam(param: ':first_name', var: $firstName);
    $stmt->bindParam(param: ':original_name', var: $originalName);
    $stmt->bindParam(param: ':last_name', var: $lastName);
    $stmt->bindParam(param: ':grade', var: $grade);
//    $stmt->bindValue(param: ':book_id', value: $book["id"]);

    $stmt->execute();
}

//function getinfo($id) {
//    $conn = getConnection();
//    $info = [];
//
//    $stmt = $conn->prepare('select * from books where book_id = :id');
//
//    $stmt->bindParam(param: ':id', var: $id);
//    $stmt -> execute();
//
//    foreach($stmt as $book) {
//        $book_title = $book["book_name"];
//        $book_grade = $book["grade"];
//        $book_is_read = $book["is_read"];
//    }
//
//    $info[] = ["book_title" => urldecode($book_title), "book_grade" => urldecode($book_grade), "title" => urldecode($book_is_read)];
//    return $info;
//
//}

function getConnection() : PDO {

    $username = "hejoes";
    $password = "6e2c93";
    $host = 'db.mkalmo.eu';

    $address = sprintf('mysql:host=%s;port=3306;dbname=%s',
        $host, $username);

    return new PDO($address, $username, $password);
}


//$authors = add_author();
//var_dump($authors);
