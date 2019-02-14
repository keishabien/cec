<?php


// ALL OFFICES
$app->group('/offices', function () {
    $this->get('', 'UserFrosting\Sprinkle\Site\Controller\SearchController:pageList');

    $this->get('?keyword={keyword}', 'UserFrosting\Sprinkle\Site\Controller\SearchController:pageSearch');

//    $this->get('/{keyword}', 'UserFrosting\Sprinkle\Site\Controller\SearchController:pageSearch');
})->add('authGuard');



$app->group('/api/offices', function () {
    $this->get('', 'UserFrosting\Sprinkle\Site\Controller\SearchController:getInput');

    $this->get('/{input}', 'UserFrosting\Sprinkle\Site\Controller\SearchController:getInfo');

//    $this->get('?keyword={input}', 'UserFrosting\Sprinkle\Site\Controller\SearchController:getInput');
})->add('authGuard');


// SINGLE OFFICE

$app->group('/office', function () {
    $this->get('', 'UserFrosting\Sprinkle\Site\Controller\SearchController:pageList');

    $this->get('?keyword={keyword}', 'UserFrosting\Sprinkle\Site\Controller\SearchController:pageSearch');

//    $this->get('/{keyword}', 'UserFrosting\Sprinkle\Site\Controller\SearchController:pageSearch');
})->add('authGuard');



$app->group('/api/offices', function () {
    $this->get('', 'UserFrosting\Sprinkle\Site\Controller\SearchController:getInput');

    $this->get('/{input}', 'UserFrosting\Sprinkle\Site\Controller\SearchController:getInfo');

//    $this->get('?keyword={input}', 'UserFrosting\Sprinkle\Site\Controller\SearchController:getInput');
})->add('authGuard');
