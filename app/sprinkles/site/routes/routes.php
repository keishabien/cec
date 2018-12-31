<?php

$app->get('/', 'UserFrosting\Sprinkle\Site\Controller\PageController:pageIndex')
    ->add('authGuard')
    ->setName('index');

$app->get('/members', 'UserFrosting\Sprinkle\Site\Controller\PageController:pageMembers')
    ->add('authGuard');

$app->get('/search', 'UserFrosting\Sprinkle\Site\Controller\SearchController:pageSearch')
    ->setName('search')
    ->add('authGuard');
