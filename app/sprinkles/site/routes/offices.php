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
        ->setName('api_office');
})        ->add('authGuard');


$app->group('/api/users', function () {
    $this->delete('/u/{user_name}', 'UserFrosting\Sprinkle\Admin\Controller\UserController:delete');

    $this->get('', 'UserFrosting\Sprinkle\Admin\Controller\UserController:getList');

    $this->get('/u/{user_name}', 'UserFrosting\Sprinkle\Admin\Controller\UserController:getInfo');

    $this->get('/u/{user_name}/activities', 'UserFrosting\Sprinkle\Admin\Controller\UserController:getActivities');

    $this->get('/u/{user_name}/roles', 'UserFrosting\Sprinkle\Admin\Controller\UserController:getRoles');

    $this->get('/u/{user_name}/permissions', 'UserFrosting\Sprinkle\Admin\Controller\UserController:getPermissions');

    $this->post('', 'UserFrosting\Sprinkle\Admin\Controller\UserController:create');

    $this->post('/u/{user_name}/password-reset', 'UserFrosting\Sprinkle\Admin\Controller\UserController:createPasswordReset');

    $this->put('/u/{user_name}', 'UserFrosting\Sprinkle\Admin\Controller\UserController:updateInfo');

    $this->put('/u/{user_name}/{field}', 'UserFrosting\Sprinkle\Admin\Controller\UserController:updateField');
})->add('authGuard');

$app->group('/modals/users', function () {
    $this->get('/confirm-delete', 'UserFrosting\Sprinkle\Admin\Controller\UserController:getModalConfirmDelete');

    $this->get('/create', 'UserFrosting\Sprinkle\Admin\Controller\UserController:getModalCreate');

    $this->get('/edit', 'UserFrosting\Sprinkle\Admin\Controller\UserController:getModalEdit');

    $this->get('/password', 'UserFrosting\Sprinkle\Admin\Controller\UserController:getModalEditPassword');

    $this->get('/roles', 'UserFrosting\Sprinkle\Admin\Controller\UserController:getModalEditRoles');
})->add('authGuard');


