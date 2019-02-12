<?php

namespace UserFrosting\Sprinkle\Site\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\NotFoundException;
use UserFrosting\Fortress\RequestDataTransformer;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\ServerSideValidator;
use UserFrosting\Sprinkle\Core\Controller\SimpleController;
use UserFrosting\Support\Exception\BadRequestException;
use UserFrosting\Support\Exception\ForbiddenException;
use UserFrosting\Support\Exception\HttpException;

use UserFrosting\Sprinkle\Site\Database\Models\Search;
use UserFrosting\Sprinkle\Site\Database\Models\CECOffice;
use UserFrosting\Sprinkle\Site\Database\Models\Office;
use UserFrosting\Sprinkle\Site\Sprunje\OfficeSprunje;
use UserFrosting\Sprinkle\Site\Sprunje\SearchSprunje;

use UserFrosting\Sprinkle\Site\Sprunje\CECOfficeSprunje;


class SearchController extends SimpleController
{
    public function pageSearch($request, $response, $args)
    {

        $keyword = $args['keyword'];

        $params = $request->getQueryParams();


        $office = CECOffice::distinct()->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('zip', 'like', '%' . $keyword . '%')
            ->orderBy('name', "ASC")
            ->get();


        return $this->ci->view->render($response, 'pages/search.html.twig', [
            'results' => $results,
            'keyword'   => $keyword,
            'office' => $office,
            'location' => $location,
            'midwestLogo' => 'https://www.meritdental.com/cecdb/images/midwest-logo.png',
            'mondoviLogo' => 'https://www.meritdental.com/cecdb/images/mondovi-logo.png',
            'meritLogo' => 'https://www.meritdental.com/cecdb/images/merit-logo.png',
            'mountainLogo' => 'https://www.meritdental.com/cecdb/images/mountain-logo.png',
            "page" => [
                'keyword'   => $keyword
            ]
        ]);
    }


//    public function pageList($request, $response, $args)
//    {
//        // GET parameters
//        $params = $request->getQueryParams();
//
//        /** @var UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager */
//
//        $authorizer = $this->ci->authorizer;
//
//        /** @var UserFrosting\Sprinkle\Account\Database\Models\User $currentUser */
//        $currentUser = $this->ci->currentUser;
//
//        // Access-controlled page
//
//        if (!$authorizer->checkAccess($currentUser, 'api_offices')) {
//            throw new ForbiddenException();
//        }
//
//        return $this->ci->view->render($response, 'pages/search.html.twig');
//    }

    /**
     * Renders the user listing page.
     *
     * This page renders a table of users, with dropdown menus for admin actions for each user.
     * Actions typically include: edit user details, activate user, enable/disable user, delete user.
     * This page requires authentication.
     * Request type: GET
     */
    public function pageList($request, $response, $args)
    {
        $params = $request->getQueryParams();


        $office = CECOffice::distinct()->where('name', 'like', '%' . $params['keyword'] . '%')
            ->orWhere('zip', 'like', '%' . $params['keyword'] . '%')
            ->orderBy('name', "ASC")
            ->get();


        return $this->ci->view->render($response, 'pages/search.html.twig', [
            'keyword'   => $params['keyword'],
            'office' => $office,
            'midwestLogo' => 'https://www.meritdental.com/cecdb/images/midwest-logo.png',
            'mondoviLogo' => 'https://www.meritdental.com/cecdb/images/mondovi-logo.png',
            'meritLogo' => 'https://www.meritdental.com/cecdb/images/merit-logo.png',
            'mountainLogo' => 'https://www.meritdental.com/cecdb/images/mountain-logo.png',
            "page" => [
                'keyword'   => $keyword
            ]
        ]);
    }

    public function quickInfo($request, $response, $args)
    {

        $keyword = $args['input'];

        $params = $request->getQueryParams();

        $this->getContainer()->db;
//        $result = User::where('name', $keyword)->get();
        $result = Search::where('name', 'like', 'dog')->get();

        if ($params['format'] == 'json') {
            return $response->withJson($result, 200, JSON_PRETTY_PRINT);
        } else {
            return $response->withJson($result, 200, JSON_PRETTY_PRINT);
        }
    }


    /**
     * Returns info for a single office.
     *
     * This page requires authentication.
     * Request type: GET
     */
    public function getInfo($request, $response, $args)
    {
        // Load the request schema
        $schema = new RequestSchema('schema://requests/search.yaml');

        // Whitelist and set parameter defaults
        $transformer = new RequestDataTransformer($schema);
        $data = $transformer->transform($args);

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

        $office = Office::distinct()->where('name', 'like', '%' .  $data['input'] . '%')->get();

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

        $result = $office->toArray();

        if(!$result){
            echo "fail";
        } else {
            // Be careful how you consume this data - it has not been escaped and contains untrusted user-supplied content.
            // For example, if you plan to insert it into an HTML DOM, you must escape it on the client side (or use client-side templating).
            return $response->withJson($result, 200, JSON_PRETTY_PRINT);
        }
    }


    /**
     * Returns info for a single office.
     *
     * This page requires authentication.
     * Request type: GET
     */
    public function getInput($request, $response, $args)
    {
        $params = $request->getQueryParams();
        // Load the request schema


        $office = Office::distinct()->where('name', 'like', '%' .  $params['keyword'] . '%')->first();

        // If the user doesn't exist, return 404
        if (!$office) {
            throw new NotFoundException($request, $response);
        }


        $result = $office->toArray();


            // Be careful how you consume this data - it has not been escaped and contains untrusted user-supplied content.
            // For example, if you plan to insert it into an HTML DOM, you must escape it on the client side (or use client-side templating).
            return $response->withJson($result, 200, JSON_PRETTY_PRINT);

    }

    public function getList($request, $response, $args)
    {
        // GET parameters
        $params = $request->getQueryParams();

        /** @var UserFrosting\Sprinkle\Core\Util\ClassMapper $classMapper */
        $classMapper = $this->ci->classMapper;

        $sprunje = new SearchSprunje($classMapper, $params);

        // Be careful how you consume this data - it has not been escaped and contains untrusted user-supplied content.
        // For example, if you plan to insert it into an HTML DOM, you must escape it on the client side (or use client-side templating).
        return $sprunje->toResponse($response);
    }

    protected function getUserFromParams($params)
    {

        // Load the request schema
        $schema = new RequestSchema('schema://requests/search.yaml');

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
//        $classMapper = $this->ci->classMapper;

        // Get the user to delete
//        $office = $classMapper->staticMethod('CECOffice', 'where', 'name', $data['input'])
//            ->first();


//        $office = Office::distinct()->where('page_title', $data['office_name'])->get();
        $office = Office::distinct()->where('name', 'like', '%' .  $data['input'] . '%')->get();
//        $details = Search::distinct()->where('name', $data['keyword'])->get();

//        $office = $office->merge($details);


        return $office;
    }
}
