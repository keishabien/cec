<?php

$app->get('/', 'UserFrosting\Sprinkle\Site\Controller\PageController:pageIndex')
    ->add('authGuard')
    ->setName('index');

$app->get('/members', 'UserFrosting\Sprinkle\Site\Controller\PageController:pageMembers')
    ->add('authGuard');

$app->get('/offices', 'UserFrosting\Sprinkle\Site\Controller\OfficeController:pageList')
    ->setName('uri_offices')
    ->add('authGuard');

$app->get('/api/offices', 'UserFrosting\Sprinkle\Site\Controller\OfficeController:getList')
    ->add('authGuard');

//$app->get('/search/{location}', function ($request, $response, $args) {
//
//        echo "Hello, " . $args['location'];
//});

$app->get('/office/{page_id}/{office_name}', 'UserFrosting\Sprinkle\Site\Controller\OfficeController:pageOffice')
    ->setName('office')
    ->add('authGuard');
