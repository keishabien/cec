<?php

namespace UserFrosting\Sprinkle\Site\Controller;

use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\NotFoundException;
use UserFrosting\Support\Exception\ForbiddenException;
use UserFrosting\Sprinkle\Core\Controller\SimpleController;
use UserFrosting\Sprinkle\Site\Database\Models\Search;
use UserFrosting\Sprinkle\Site\Database\Models\Office;
use UserFrosting\Sprinkle\Site\Sprunje\OfficeSprunje;
use UserFrosting\Fortress\RequestDataTransformer;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\ServerSideValidator;
use UserFrosting\Support\Exception\BadRequestException;


class OfficeController extends SimpleController
{
    public function pageList($request, $response, $args)
    {
        /** @var UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager $authorizer */
        $authorizer = $this->ci->authorizer;

        /** @var UserFrosting\Sprinkle\Account\Database\Models\User $currentUser */
        $currentUser = $this->ci->currentUser;

        // Access-controlled page
        if (!$authorizer->checkAccess($currentUser, 'uri_users')) {
            throw new ForbiddenException();
        }

        return $this->ci->view->render($response, 'pages/dashboard/offices.html.twig');
    }

    public function getList($request, $response, $args)
    {
        // GET parameters
        $params = $request->getQueryParams();

        /** @var UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager */
        $authorizer = $this->ci->authorizer;

        /** @var UserFrosting\Sprinkle\Account\Database\Models\User $currentUser */
        $currentUser = $this->ci->currentUser;

        // Access-controlled page
        if (!$authorizer->checkAccess($currentUser, 'api_offices')) {
            throw new ForbiddenException();
        }

        /** @var UserFrosting\Sprinkle\Core\Util\ClassMapper $classMapper */
        $classMapper = $this->ci->classMapper;

        $sprunje = new OfficeSprunje($classMapper, $params);

        // Be careful how you consume this data - it has not been escaped and contains untrusted user-supplied content.
        // For example, if you plan to insert it into an HTML DOM, you must escape it on the client side (or use client-side templating).
        return $sprunje->toResponse($response);
    }

    /**
     * Returns info for a single office.
     *
     * This page requires authentication.
     * Request type: GET
     */
    public function getInfo($request, $response, $args)
    {
        $office = $this->getUserFromParams($args);

        // If the user doesn't exist, return 404
        if (!$office) {
            throw new NotFoundException($request, $response);
        }

        /** @var UserFrosting\Sprinkle\Core\Util\ClassMapper $classMapper */
//        $classMapper = $this->ci->classMapper;

        // Join user's most recent activity
//        $office = $classMapper->createInstance('office')
//            ->where('page_title', $office->page_title)
//            ->first();

        /** @var UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager $authorizer */
        $authorizer = $this->ci->authorizer;

        /** @var UserFrosting\Sprinkle\Account\Database\Models\User $currentUser */
        $currentUser = $this->ci->currentUser;

        // Access-controlled page
        if (!$authorizer->checkAccess($currentUser, 'api_office', [
            'office' => $office
        ])) {
            throw new ForbiddenException();
        }

        $result = $office->toArray();

        // Be careful how you consume this data - it has not been escaped and contains untrusted user-supplied content.
        // For example, if you plan to insert it into an HTML DOM, you must escape it on the client side (or use client-side templating).
        return $response->withJson($result, 200, JSON_PRETTY_PRINT);
    }


    /**
     * Renders a page displaying a user's information, in read-only mode.
     *
     * This checks that the currently logged-in user has permission to view the requested user's info.
     * It checks each field individually, showing only those that you have permission to view.
     * This will also try to show buttons for activating, disabling/enabling, deleting, and editing the user.
     * This page requires authentication.
     * Request type: GET
     */
    public function pageInfo($request, $response, $args)
    {
        $office = $this->getUserFromParams($args);

        // If the user no longer exists, forward to main user listing page
        if (!$office) {
            $usersPage = $this->ci->router->pathFor('uri_office');
            return $response->withRedirect($usersPage, 404);
        }

        /** @var UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager $authorizer */
        $authorizer = $this->ci->authorizer;

        /** @var UserFrosting\Sprinkle\Account\Database\Models\User $currentUser */
        $currentUser = $this->ci->currentUser;

        // Access-controlled page
        if (!$authorizer->checkAccess($currentUser, 'uri_office', [
            'office' => $office
        ])) {
            throw new ForbiddenException();
        }

        /** @var UserFrosting\Config\Config $config */
        $config = $this->ci->config;

        // Get a list of all locales
        $locales = $config->getDefined('site.locales.available');

        // Determine fields that currentUser is authorized to view
        $fieldNames = ['page_title', 'page_id', 'phone', 'address', 'city', 'state', 'zip'];

        // Generate form
        $fields = [
            // Always hide these
            'hidden' => ['theme']
        ];

        // Determine which fields should be hidden
        foreach ($fieldNames as $field) {
            if (!$authorizer->checkAccess($currentUser, 'view_user_field', [
                'office' => $office,
                'property' => $field
            ])) {
                $fields['hidden'][] = $field;
            }
        }

        // Determine buttons to display
        $editButtons = [
            'hidden' => []
        ];

//        if (!$authorizer->checkAccess($currentUser, 'update_user_field', [
//            'office' => $office,
//            'fields' => ['name', 'email', 'locale']
//        ])) {
//            $editButtons['hidden'][] = 'edit';
//        }
//
//        if (!$authorizer->checkAccess($currentUser, 'update_user_field', [
//            'user' => $user,
//            'fields' => ['flag_enabled']
//        ])) {
//            $editButtons['hidden'][] = 'enable';
//        }
//
//        if (!$authorizer->checkAccess($currentUser, 'update_user_field', [
//            'user' => $user,
//            'fields' => ['flag_verified']
//        ])) {
//            $editButtons['hidden'][] = 'activate';
//        }
//
//        if (!$authorizer->checkAccess($currentUser, 'update_user_field', [
//            'user' => $user,
//            'fields' => ['password']
//        ])) {
//            $editButtons['hidden'][] = 'password';
//        }
//
//        if (!$authorizer->checkAccess($currentUser, 'update_user_field', [
//            'user' => $user,
//            'fields' => ['roles']
//        ])) {
//            $editButtons['hidden'][] = 'roles';
//        }
//
//        if (!$authorizer->checkAccess($currentUser, 'delete_user', [
//            'user' => $user
//        ])) {
//            $editButtons['hidden'][] = 'delete';
//        }
//
        // Determine widgets to display
        $widgets = [
            'hidden' => [
            ]
        ];
//
//        if (!$authorizer->checkAccess($currentUser, 'view_user_field', [
//            'user' => $user,
//            'property' => 'permissions'
//        ])) {
//            $widgets['hidden'][] = 'permissions';
//        }
//
//        if (!$authorizer->checkAccess($currentUser, 'view_user_field', [
//            'user' => $user,
//            'property' => 'activities'
//        ])) {
//            $widgets['hidden'][] = 'activities';
//        }

        return $this->ci->view->render($response, 'pages/dashboard/office.html.twig', [
            'office' => $office,
            'locales' => $locales,
            'fields' => $fields,
            'tools' => $editButtons,
            'widgets' => $widgets,
            'midwestLogo' => 'https://www.meritdental.com/cecdb/images/midwest-logo.png',
            'mondoviLogo' => 'https://www.meritdental.com/cecdb/images/mondovi-logo.png',
            'meritLogo' => 'https://www.meritdental.com/cecdb/images/merit-logo.png',
            'mountainLogo' => 'https://www.meritdental.com/cecdb/images/mountain-logo.png'
        ]);
    }

    protected function getUserFromParams($params)
    {
        // Load the request schema
        $schema = new RequestSchema('schema://requests/get-office-name.yaml');

        // Whitelist and set parameter defaults
        $transformer = new RequestDataTransformer($schema);
        $data = $transformer->transform($params);

        // Validate, and throw exception on validation errors.
        $validator = new ServerSideValidator($schema, $this->ci->translator);
        if (!$validator->validate($data)) {
            // TODO: encapsulate the communication of error messages from ServerSideValidator to the BadRequestException
            $e = new BadRequestException();
            foreach ($validator->errors() as $idx => $field) {
                foreach ($field as $eidx => $error) {
                    $e->addUserMessage($error);
                }
            }
            throw $e;
        }

        /** @var UserFrosting\Sprinkle\Core\Util\ClassMapper $classMapper */
        //$classMapper = $this->ci->classMapper;

        // Get the user to delete
//        $user = $classMapper->staticMethod('office', 'where', 'page_title', $data['office_name'])
//            ->first();

        $office = Office::distinct()->where('name', $data['office_name'])->get();
//        $details = Search::distinct()->where('office_name', $data['office_name'])->get();

//        $office = $office->merge($details);

        return $office;
    }

}

