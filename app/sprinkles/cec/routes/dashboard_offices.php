<?php
/**
 * Routes for administrative office management.
 */


$app->group('/dash/offices', function () {
    $this->get('', 'UserFrosting\Sprinkle\Cec\Controller\OfficeController:pageList')
        ->setName('uri_offices');

    $this->get('/o/{office_name}', 'UserFrosting\Sprinkle\Cec\Controller\OfficeController:officeInfo');
})->add('authGuard');



$app->group('/api/dash/offices', function () {
    $this->get('', 'UserFrosting\Sprinkle\Cec\Controller\OfficeController:getList');

    $this->get('/o/{office_name}', 'UserFrosting\Sprinkle\Cec\Controller\OfficeController:getInfo')
        ->add('authGuard');
});


