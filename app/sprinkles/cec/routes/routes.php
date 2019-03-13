<?php

$app->get('/', 'UserFrosting\Sprinkle\Cec\Controller\PageController:pageIndex')
    ->add('authGuard')
    ->setName('index');

// INTAKE FORM
$app->group('/intake', function () {
    $this->get('/1', 'UserFrosting\Sprinkle\Cec\Controller\PageController:pageIntake')
        ->setName('intake');


    $this->get('/2', 'UserFrosting\Sprinkle\Cec\Controller\PageController:pageNPIE')
        ->setName('npie');

    $this->post('/2', 'UserFrosting\Sprinkle\Cec\Controller\PageController:intake')
        ->setName('npie');


    $this->get('/3', 'UserFrosting\Sprinkle\Cec\Controller\PageController:pageRecall')
        ->setName('npie');


    $this->get('/4', 'UserFrosting\Sprinkle\Cec\Controller\PageController:pageFinal')
        ->setName('final');
});
