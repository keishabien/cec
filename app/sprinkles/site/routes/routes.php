<?php

$app->get('/', 'UserFrosting\Sprinkle\Site\Controller\PageController:pageIndex')
    ->add('authGuard')
    ->setName('index');



$app->group('/search', function () {
    $this->get('', 'UserFrosting\Sprinkle\Site\Controller\SearchController:pageList');

    $this->get('?keyword={keyword}', 'UserFrosting\Sprinkle\Site\Controller\SearchController:pageSearch');

    $this->get('/{keyword}', 'UserFrosting\Sprinkle\Site\Controller\SearchController:pageSearch');
})->add('authGuard');



$app->group('/api/search', function () {
    $this->get('', 'UserFrosting\Sprinkle\Site\Controller\SearchController:getInput');

    $this->get('/{input}', 'UserFrosting\Sprinkle\Site\Controller\SearchController:getInfo');

//    $this->get('?keyword={input}', 'UserFrosting\Sprinkle\Site\Controller\SearchController:getInput');
})->add('authGuard');





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
