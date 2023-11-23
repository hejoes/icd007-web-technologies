<?php

require_once __DIR__ . '/../vendor/php-test-framework/public-api.php';

const BASE_URL = 'http://localhost:8080/ex1/';

setBaseUrl(BASE_URL);

function indexToE() {
    navigateTo(BASE_URL);

    clickRelativeLinkWithText('e.html');

    assertCurrentUrl(BASE_URL . 'a/b/c/d/e/e.html');
}

function eToF() {
    navigateTo(BASE_URL . 'a/b/c/d/e/e.html');

    clickRelativeLinkWithText("f.html");

    assertCurrentUrl(BASE_URL . 'a/b/c/d/e/f/f.html');
}

function fToD() {
    navigateTo(BASE_URL . 'a/b/c/d/e/f/f.html');

    clickRelativeLinkWithText("d.html");

    assertCurrentUrl(BASE_URL . "a/b/c/d/d.html");
}

function dToB() {
    navigateTo(BASE_URL . '/a/b/c/d/d.html');

    clickRelativeLinkWithText('b.html');

    assertCurrentUrl(BASE_URL . 'a/b/b.html');
}

function shortestSelf() {

    navigateTo(BASE_URL . 'a/b/c/d/d.html');

    $linkText = "shortest self";

    $href = getHrefFromLinkWithText($linkText);

    clickLinkWithText($linkText);

    assertCurrentUrl(BASE_URL . 'a/b/c/d/d.html');

    assertThat(strlen($href), is(0),
        sprintf("'%s' is not the shortest link possible", $href));
}

function shortestDIndex() {

    navigateTo(BASE_URL . 'a/b/c/d/d.html');

    $linkText = "shortest d/index.html";

    $href = getHrefFromLinkWithText($linkText);

    clickLinkWithText($linkText);

    assertCurrentUrl(BASE_URL . 'a/b/c/d/');

    assertThat(strlen($href), is(1),
        sprintf("'%s' is not the shortest link possible", $href));
}

function logoImageSrcIsCorrect() {

    navigateTo(BASE_URL . 'a/b/c/d/e/f/f.php');

    $src = getAttributeFromElementWithId('logo', 'src');

    resourceExists(getCurrentUrlDir() . $src);
}

#Helpers

function clickRelativeLinkWithText($linkText) {
    $href = getHrefFromLinkWithText($linkText);

    if (preg_match("/:/", $href) || preg_match("/^\//", $href)) {
        throw new RuntimeException("$href is not a relative link");
    }

    clickLinkWithText($linkText);
}

stf\runTests(new stf\PointsReporter([
    3 => 1,
    4 => 2,
    5 => 3,
    6 => 4,
    7 => 6]));
