<?php

namespace UserFrosting\Sprinkle\Cec\ServicesProvider;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use UserFrosting\Sprinkle\Core\Facades\Debug;

/**
 * Registers services for my site Sprinkle
 */
class ServicesProvider
{
    /**
     * Register my site services.
     *
     * @param Container $container A DI container implementing ArrayAccess and container-interop.
     */
    public function register($container)
    {
        $container->extend('classMapper', function ($classMapper, $c) {
            $classMapper->setClassMapping('office', 'UserFrosting\Sprinkle\Cec\Database\Models\Office');
            $classMapper->setClassMapping('dentist', 'UserFrosting\Sprinkle\Cec\Database\Models\DentistDetails');
            $classMapper->setClassMapping('hygienist', 'UserFrosting\Sprinkle\Cec\Database\Models\HygienistDetails');
            $classMapper->setClassMapping('status', 'UserFrosting\Sprinkle\Cec\Database\Models\Status');
            $classMapper->setClassMapping('anpie', 'UserFrosting\Sprinkle\Cec\Database\Models\AdultNPIE');
            return $classMapper;
        });

        $container['redirect.onLogin'] = function ($c) {
            /**
             * This method is invoked when a user completes the login process.
             *
             * Returns a callback that handles setting the `UF-Redirect` header after a successful login.
             * @param \Psr\Http\Message\ServerRequestInterface $request
             * @param \Psr\Http\Message\ResponseInterface      $response
             * @param array $args
             * @return \Psr\Http\Message\ResponseInterface
             */
            return function (Request $request, Response $response, array $args) use ($c) {
                // Backwards compatibility for the deprecated determineRedirectOnLogin service
                if ($c->has('determineRedirectOnLogin')) {
                    $determineRedirectOnLogin = $c->determineRedirectOnLogin;

                    return $determineRedirectOnLogin($response)->withStatus(200);
                }

                /** @var UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager */
                $authorizer = $c->authorizer;

                $currentUser = $c->authenticator->user();

                if ($authorizer->checkAccess($currentUser, 'uri_dashboard')) {
                    return $response->withHeader('UF-Redirect', $c->router->pathFor('dashboard'));
                } elseif ($authorizer->checkAccess($currentUser, 'uri_account_settings')) {
                    return $response->withHeader('UF-Redirect', $c->router->pathFor('settings'));
                } else {
                    return $response->withHeader('UF-Redirect', $c->router->pathFor('index'));
                }
            };
        };
    }
}
