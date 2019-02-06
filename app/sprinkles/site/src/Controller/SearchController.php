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
use UserFrosting\Sprinkle\Site\Sprunje\SearchSprunje;

use UserFrosting\Sprinkle\Site\Sprunje\CECOfficeSprunje;


class SearchController extends SimpleController
{
    public function pageSearch($request, $response, $args)
    {
//        $keyword = $request->getParsedBody();

//        $keyword = $args['keyword'];
//
//        // GET parameters
        $keyword = $request->getQueryParams();

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

    public function getOwls($request, $response, $args)
    {
        $location = $args['location'];

        // GET parameters
        $params = $request->getQueryParams();

        $this->ci->db;
        $result = Search::distinct()->where('office_name', 'like', '%' . $location . '%')->get();

        if ($params['format'] == 'json') {
            return $response->withJson($result, 200, JSON_PRETTY_PRINT);
        } else {
            return $response->withJson($result, 200, JSON_PRETTY_PRINT);
        }
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

        $sprunje = new CECOfficeSprunje($classMapper, $params);


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

        $keyword = $args['keyword'];

        $getParams = $request->getQueryParams();

        // Load the request schema
        $schema = new RequestSchema('schema://requests/search.yaml');

        // Whitelist and set parameter defaults
        $transformer = new RequestDataTransformer($schema);
        $data = $transformer->transform($keyword);

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


//        $details = Search::distinct()->where('office_name', $data['office_name'])->get();
//        ->orWhere('zip', 'like', '%' . $data['keyword'] . '%')
        $office = CECOffice::where('name', 'like', '%' . $data['keyword'] . '%')->first();



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

        if (!$authorizer->checkAccess($currentUser, 'api_search', [
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
     * Renders the user listing page.
     *
     * This page renders a table of users, with dropdown menus for admin actions for each user.
     * Actions typically include: edit user details, activate user, enable/disable user, delete user.
     * This page requires authentication.
     * Request type: GET
     */
    public function pageList($request, $response, $args)
    {

        /** @var UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager $authorizer */
        $authorizer = $this->ci->authorizer;

        /** @var UserFrosting\Sprinkle\Account\Database\Models\User $currentUser */
        $currentUser = $this->ci->currentUser;

        // Access-controlled page

        if (!$authorizer->checkAccess($currentUser, 'uri_search')) {
            throw new ForbiddenException();
        }

        $keyword = $request->getQueryParams();

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
            'mountainLogo' => 'https://www.meritdental.com/cecdb/images/mountain-logo.png'
        ]);
    }



    protected function getOfficeFromParams($params)
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
        //$classMapper = $this->ci->classMapper;

        // Get the user to delete
//        $user = $classMapper->staticMethod('office', 'where', 'page_title', $data['office_name'])
//            ->first();


//        $details = Search::distinct()->where('office_name', $data['office_name'])->get();
//        ->orWhere('zip', 'like', '%' . $data['keyword'] . '%')
        $office = CECOffice::where('name', 'like', '%' . $data['keyword'] . '%')->first();


        return $office;
    }
}
