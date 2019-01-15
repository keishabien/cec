<?php

$app->get('/', 'UserFrosting\Sprinkle\Site\Controller\PageController:pageIndex')
    ->add('authGuard')
    ->setName('index');

$app->get('/intake', 'UserFrosting\Sprinkle\Site\Controller\PageController:pageIntake')
    ->setName('intake');
