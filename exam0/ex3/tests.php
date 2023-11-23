<?php

require_once __DIR__ . '/../vendor/php-test-framework/public-api.php';

const BASE_URL = 'http://localhost:8081/ex3/';

function defaultPageIsSelectFrom() {
    navigateTo(BASE_URL);

    assertPageContainsSelectWithName('color');
}

function showsConditionsFromAfterColorSelection() {
    navigateTo(BASE_URL);

    selectOptionWithValue('color', 'green');

    clickButton('cmd');

    assertPageContainsCheckboxWithName('conditions');
}

function showsErrorMessageWhenConfirmationNotChecked() {
    navigateTo(BASE_URL);

    selectOptionWithValue('color', 'green');

    clickButton('cmd');

    clickButton('cmd');

    assertPageContainsText('Tingimuste kinnitamine on kohustuslik!');
}

function redirectsToFinalPageWhenConfirmationChecked() {
    navigateTo(BASE_URL);

    selectOptionWithValue('color', 'green');

    clickButton('cmd');

    setCheckboxValue('conditions', '1');

    disableAutomaticRedirects();

    clickButton('cmd');

    assertThat(getResponseCode(), isAnyOf(301, 302, 303));
}

function finalPageShowsTextInSelectedColor() {
    navigateTo(BASE_URL);

    selectOptionWithValue('color', 'green');

    clickButton('cmd');

    setCheckboxValue('conditions', '1');

    clickButton('cmd');

    assertPageContainsFieldWithName('className');

    assertThat(getFieldValue('className'), is('my-green'));
}

#Helpers

setBaseUrl(BASE_URL);
setLogRequests(false);
setLogPostParameters(false);
setPrintPageSourceOnError(false);

stf\runTests(new stf\PointsReporter([
    2 => 3,
    3 => 9,
    4 => 18,
    5 => 24]));
