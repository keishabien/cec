<?php

use UserFrosting\Sprinkle\Site\Database\Models\Search;

$app->get('/', 'UserFrosting\Sprinkle\Site\Controller\PageController:pageIndex')
    ->add('authGuard')
    ->setName('index');

$app->get('/members', 'UserFrosting\Sprinkle\Site\Controller\PageController:pageMembers')
    ->add('authGuard');

$app->get('/search', 'UserFrosting\Sprinkle\Site\Controller\SearchController:pageSearch')
    ->setName('search')
    ->add('authGuard');

//$app->get('/search/{location}', function ($request, $response, $args) {
//
//        echo "Hello, " . $args['location'];
//});

$app->get('/office/{page_id}/{office_name}', 'UserFrosting\Sprinkle\Site\Controller\OfficeController:pageOffice')
    ->setName('office')
    ->add('authGuard');
