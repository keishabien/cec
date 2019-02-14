<?php
/**
 * Routes for administrative office management.
 */




$app->group('/offices', function () {
    $this->get('', 'UserFrosting\Sprinkle\Site\Controller\OfficeController:pageList')
        ->setName('uri_offices');

    $this->get('/o/{office_name}', 'UserFrosting\Sprinkle\Site\Controller\OfficeController:pageInfo')
        ->setName('uri_office');
})->add('authGuard');



$app->group('/api/offices', function () {
    $this->get('', 'UserFrosting\Sprinkle\Site\Controller\OfficeController:getList')
        ->setName('api_offices');

    $this->get('/o/{office_name}', 'UserFrosting\Sprinkle\Site\Controller\OfficeController:getInfo')
        ->setName('api_office')
        ->add('authGuard');
});


