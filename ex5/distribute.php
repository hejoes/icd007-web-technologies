<?php

//$sets = distributeToSets([1, 2, 1]);

//var_dump($sets);

function distributeToSets(array $input): array {
    $nrs = [];
    foreach ($input as $each) {
        //kontrollime kas number on olemas nrsis listis, kui on, lisame dictionarisse
        if (isset($nrs[$each])) {
            $nrs[$each][] = $each; //kui on olemas number, appendime
        } else { //kui ei ole olemas numbrit, siis lisame sõnastikku
            $nrs[$each] = [$each];
        }
    }


    return $nrs;
}
