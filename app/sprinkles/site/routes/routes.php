<?php

$app->get('/members', 'UserFrosting\Sprinkle\Site\Controller\PageController:pageMembers')
    ->add('authGuard');

$app->get('/', 'UserFrosting\Sprinkle\Core\Controller\CoreController:pageIndex')
    ->add('checkEnvironment')
    ->add('authGuard')
    ->setName('index');

/**
 * This route overrides the main `/` route, so that users are taken directly to the registration page.
 */
//$app->get('/', 'UserFrosting\Sprinkle\Account\Controller\AccountController:pageSignIn')
//    ->setName('index');
//
//$app->group('/account', function () {
//    // Redirect to login page on index
//    $this->get('/index', function ($request, $response) {
//        $target = $this->router->pathFor('login');
//        return $response->withRedirect($target, 301);
//    })->setName('login');
//});
