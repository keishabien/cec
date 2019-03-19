<?php

$app->get('/', 'UserFrosting\Sprinkle\Cec\Controller\PageController:pageIndex')
    ->add('authGuard')
    ->setName('index');

// INTAKE FORM
$app->group('/intake', function () {
    $this->get('/1', 'UserFrosting\Sprinkle\Cec\Controller\IntakeController:pageDetails')
        ->setName('details');

    $this->post('/2', 'UserFrosting\Sprinkle\Cec\Controller\IntakeController:details');
    $this->get('/2', 'UserFrosting\Sprinkle\Cec\Controller\IntakeController:pageNPIE')
        ->setName('npie');

    $this->post('/3', 'UserFrosting\Sprinkle\Cec\Controller\IntakeController:npie');
    $this->get('/3', 'UserFrosting\Sprinkle\Cec\Controller\IntakeController:pageRecall')
        ->setName('npie');

    $this->get('/4', 'UserFrosting\Sprinkle\Cec\Controller\IntakeController:pageFinal')
        ->setName('final');
});
