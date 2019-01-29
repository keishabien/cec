<?php

$app->get('/', 'UserFrosting\Sprinkle\Site\Controller\PageController:pageIndex')
    ->add('authGuard')
    ->setName('index');

$app->post('/search?keyword={keyword}', 'UserFrosting\Sprinkle\Site\Controller\SearchController:pageSearch')
    ->add('authGuard');

$app->group('/intake', function () {
    $this->get('', 'UserFrosting\Sprinkle\Site\Controller\PageController:pageIntake')
        ->setName('intake');

    $this->get('/npie', 'UserFrosting\Sprinkle\Site\Controller\PageController:pageNPIE')
        ->setName('npie');
    $this->post('/npie', 'UserFrosting\Sprinkle\Site\Controller\PageController:intake')
        ->setName('npie');

    $this->get('/recall', 'UserFrosting\Sprinkle\Site\Controller\PageController:pageRecall')
        ->setName('npie');

    $this->get('/final', 'UserFrosting\Sprinkle\Site\Controller\PageController:pageFinal')
        ->setName('final');
});
