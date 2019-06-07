<?php

namespace UserFrosting\Sprinkle\Cec\Controller;

use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\NotFoundException;
use UserFrosting\Sprinkle\Cec\Sprunje\DentistSprunje;
use UserFrosting\Support\Exception\ForbiddenException;
use UserFrosting\Sprinkle\Core\Controller\SimpleController;
use UserFrosting\Sprinkle\Cec\Database\Models\Office;
use UserFrosting\Sprinkle\Cec\Database\Models\DentistDetails;
use UserFrosting\Sprinkle\Cec\Sprunje\OfficeSprunje;
use UserFrosting\Fortress\RequestDataTransformer;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\ServerSideValidator;
use UserFrosting\Support\Exception\BadRequestException;

use UserFrosting\Support\Exception\HttpException;
use UserFrosting\Sprinkle\Core\Facades\Debug;


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


        $office = Office::query()->get();

        Debug::debug("office");
        Debug::debug(print_r($office, true));

//        $doctor = DentistDetails::where('office_id', $office["id"])->get();
//        Debug::debug("doctor");
//        Debug::debug(print_r($doctor, true));

        return $this->ci->view->render($response, 'pages/dashboard/offices.html.twig', [
            'office' => $office
        ]);

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

//        $doctor = DentistDetails::where('office_id', $office["id"])->get();

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
    public function getInfo($request, $response, $params)
    {
//        $office = $this->getUserFromParams($args);

        $office = Office::distinct()->where('vanity_url', $params['office_name'])->get();

        // If the user doesn't exist, return 404
        if (!$office) {
            throw new NotFoundException($request, $response);
        }

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

//        $doctor = DentistDetails::where('office_id', $office[0]["id"])->get();
//
//        $merged = $office->merge($doctor);
//
//        $result = $merged->all();

        // Be careful how you consume this data - it has not been escaped and contains untrusted user-supplied content.
        // For example, if you plan to insert it into an HTML DOM, you must escape it on the client side (or use client-side templating).
        return $response->withJson($office, 200, JSON_PRETTY_PRINT);
    }



    /**
     * Returns info for a single office.
     *
     * This page requires authentication.
     * Request type: GET
     */
    public function getDoctors($request, $response, $args)
    {
        $params = $request->getQueryParams();

        Debug::debug("params");
        Debug::debug(print_r($params, true));

        $office = Office::distinct()->where('vanity_url', $params['office_name'])->get();

        // If the user doesn't exist, return 404
        if (!$office) {
            throw new NotFoundException($request, $response);
        }

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

        $doctor = DentistDetails::where('office_id', $office[0]["id"])->get();

        /** @var UserFrosting\Sprinkle\Core\Util\ClassMapper $classMapper */
        $classMapper = $this->ci->classMapper;

        $sprunje = new DentistSprunje($classMapper, $params);

        // Be careful how you consume this data - it has not been escaped and contains untrusted user-supplied content.
        // For example, if you plan to insert it into an HTML DOM, you must escape it on the client side (or use client-side templating).
//        return $response->withJson($doctor, 200, JSON_PRETTY_PRINT);
        return $sprunje->toResponse($response);
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
    public function officeInfo($request, $response, $params)
    {
        $office = Office::distinct()->where('vanity_url', $params['office_name'])->get();
        Debug::debug("officeInfo: office");
        Debug::debug(print_r($office, true));
        Debug::debug(print_r($office[0]["id"], true));

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
        $fieldNames = ['name', 'locum', 'start_date', 'end_date', 'leave', 'leave_start', 'leave_end'];

        // Generate form
        $fields = [
            // Always hide these
//            'hidden' => ['theme']
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

        $doctor = DentistDetails::where('office_id', $office[0]["id"])->get();
        Debug::debug("officeInfo: doctor");
        Debug::debug(print_r($doctor, true));

        return $this->ci->view->render($response, 'pages/dashboard/office-single.html.twig', [
            'office' => $office,
            'doctor' => $doctor,
            'locales' => $locales,
            'fields' => $fields,
            'tools' => $editButtons,
            'widgets' => $widgets,
            'midwestLogo' => 'https://www.meritdental.com/cecdb/images/midwest-logo.png',
            'mondoviLogo' => 'https://www.meritdental.com/cecdb/images/mondovi-logo.png',
            'meritLogo' => 'https://www.meritdental.com/cecdb/images/merit-logo.png',
            'mountainLogo' => 'https://www.meritdental.com/cecdb/images/mountain-logo.png',
            'page' => [
                'doctor' => $doctor
            ]
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

