<?php

require_once __DIR__ . '/../connection.php';
require_once __DIR__ . '/MenuItem.php';

printMenu(getMenu());

function getMenu() : array {

    $conn = getConnection();

    $stmt = $conn->prepare('SELECT id, parent_id, name 
                            FROM menu_item ORDER BY id');

    $stmt->execute();
    $dict = []; //seda kasutame meeles parent idega pidamiseks
    $menu = [];
    foreach ($stmt as $row) {
        $id = $row['id'];
        $parent_id = $row['parent_id'];
        $name = $row['name'];

        $new_item = new MenuItem($id, $name);

        $dict[$id] = $new_item;

        if ($parent_id !== null) {
            $dict[$parent_id]->addSubItem($new_item);
        }
        // ilma elsita teeb topelt
        else
            $menu[] = $new_item;
    }

    return $menu;
}












function printMenu($items, $level = 0) : void {
    $padding = str_repeat(' ', $level * 3);
    foreach ($items as $item) {
        printf("%s%s\n", $padding, $item->name);
        if ($item->subItems) {
            printMenu($item->subItems, $level + 1);
        }
    }
}
