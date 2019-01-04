<?php

$app->get('/', 'UserFrosting\Sprinkle\Site\Controller\PageController:pageIndex')
    ->add('authGuard')
    ->setName('index');

$app->get('/members', 'UserFrosting\Sprinkle\Site\Controller\PageController:pageMembers')
    ->add('authGuard');

$app->get('/search', 'UserFrosting\Sprinkle\Site\Controller\SearchController:pageSearch')
    ->setName('search')
    ->add('authGuard');

$app->group('/pastries', function () {
    $this->get('', 'UserFrosting\Sprinkle\Pastries\Controller\PastriesController:pageList')
        ->setName('pastries');
})->add('authGuard');
