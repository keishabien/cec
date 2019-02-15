<?php

$app->get('/', 'UserFrosting\Sprinkle\Cec\Controller\PageController:pageIndex')
    ->add('authGuard')
    ->setName('index');

// INTAKE FORM
$app->group('/intake', function () {
    $this->get('', 'UserFrosting\Sprinkle\Cec\Controller\PageController:pageIntake')
        ->setName('intake');


    $this->get('/npie', 'UserFrosting\Sprinkle\Cec\Controller\PageController:pageNPIE')
        ->setName('npie');

    $this->post('/npie', 'UserFrosting\Sprinkle\Cec\Controller\PageController:intake')
        ->setName('npie');


    $this->get('/recall', 'UserFrosting\Sprinkle\Cec\Controller\PageController:pageRecall')
        ->setName('npie');


    $this->get('/final', 'UserFrosting\Sprinkle\Cec\Controller\PageController:pageFinal')
        ->setName('final');
});
