<?php

$app->get('/', 'UserFrosting\Sprinkle\Cec\Controller\PageController:pageIndex')->add('authGuard')->setName('index');

// INTAKE FORM
$app->group('/intake', function () {

    $this->get('/staff', 'UserFrosting\Sprinkle\Cec\Controller\IntakeController:pageDetails')->setName('details');
    //post this form
    $this->post('/npie', 'UserFrosting\Sprinkle\Cec\Controller\IntakeController:details');


    $this->get('/npie', 'UserFrosting\Sprinkle\Cec\Controller\IntakeController:pageNPIE')->setName('npie');
    //post this form
    $this->post('/recall', 'UserFrosting\Sprinkle\Cec\Controller\IntakeController:npie');


    $this->get('/recall', 'UserFrosting\Sprinkle\Cec\Controller\IntakeController:pageRecall')->setName('npie');
    //post this form
    $this->post('/additional', 'UserFrosting\Sprinkle\Cec\Controller\IntakeController:recall');

    $this->get('/additional', 'UserFrosting\Sprinkle\Cec\Controller\IntakeController:pageAdditional')->setName('final');
    //post this form
    $this->post('/completed', 'UserFrosting\Sprinkle\Cec\Controller\IntakeController:additional');

    $this->get('/completed', 'UserFrosting\Sprinkle\Cec\Controller\IntakeController:pageComplete')->setName('completed');

});
