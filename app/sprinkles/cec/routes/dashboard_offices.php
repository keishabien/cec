<?php
/**
 * Routes for administrative office management.
 */


$app->group('/dash/offices', function () {
    $this->get('', 'UserFrosting\Sprinkle\Cec\Controller\OfficeController:pageList')
        ->setName('uri_offices');

    $this->get('/o/{office_name}', 'UserFrosting\Sprinkle\Cec\Controller\OfficeController:pageInfo')
        ->setName('uri_office');
})->add('authGuard');



$app->group('/api/dash/offices', function () {
    $this->get('', 'UserFrosting\Sprinkle\Cec\Controller\OfficeController:getList')
        ->setName('api_offices');

    $this->get('/o/{office_name}', 'UserFrosting\Sprinkle\Cec\Controller\OfficeController:getInfo')
        ->setName('api_office')
        ->add('authGuard');
});

