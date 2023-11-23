<?php

require_once 'Post.php';
require_once 'ex3.php';

const DATA_FILE = 'data/posts.txt';

savePost(new Post("a", "b"));

print (listToString(getAllPosts()));

function getAllPosts(): array {

    $lines = file(DATA_FILE);
    $result = [];
    foreach ($lines as $line) {
        [$title, $text] = explode(";", $line);
        $result[] = new Post(urldecode($title), trim(urldecode($text)));
    }

    return $result;
}

function savePost(Post $post): void {
    $line = urlencode($post->title) . ";" . urlencode($post->text) . PHP_EOL;

    file_put_contents(DATA_FILE, $line, FILE_APPEND);
}


