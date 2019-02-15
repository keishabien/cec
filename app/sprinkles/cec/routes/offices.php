<?php


// ALL OFFICES
$app->group('/offices', function () {
    $this->get('', 'UserFrosting\Sprinkle\Cec\Controller\SearchController:pageList');

    $this->get('/o/{keyword}', 'UserFrosting\Sprinkle\Cec\Controller\SearchController:pageInfo');

    $this->get('?keyword={keyword}', 'UserFrosting\Sprinkle\Cec\Controller\SearchController:pageSearch');

})->add('authGuard');



$app->group('/api/offices', function () {
    $this->get('', 'UserFrosting\Sprinkle\Cec\Controller\SearchController:getInput');

    $this->get('/{input}', 'UserFrosting\Sprinkle\Cec\Controller\SearchController:getInfo');

//    $this->get('?keyword={input}', 'UserFrosting\Sprinkle\Cec\Controller\SearchController:getInput');
})->add('authGuard');
