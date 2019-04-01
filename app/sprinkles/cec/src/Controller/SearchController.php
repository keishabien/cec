<?php

namespace UserFrosting\Sprinkle\Cec\Controller;

use Illuminate\Database\Capsule\Manager as Capsule;

use UserFrosting\Sprinkle\Core\Controller\SimpleController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\NotFoundException;
use UserFrosting\Fortress\RequestDataTransformer;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\ServerSideValidator;
use UserFrosting\Support\Exception\BadRequestException;
use UserFrosting\Support\Exception\ForbiddenException;
use UserFrosting\Support\Exception\HttpException;
use UserFrosting\Sprinkle\Core\Facades\Debug;

use UserFrosting\Sprinkle\Cec\Database\Models\Search;
use UserFrosting\Sprinkle\Cec\Database\Models\Office;
use UserFrosting\Sprinkle\Cec\Database\Models\ZipCodes;
use UserFrosting\Sprinkle\Cec\Database\Models\DentistDetails;
use UserFrosting\Sprinkle\Cec\Database\Models\HygienistDetails;
use UserFrosting\Sprinkle\Cec\Database\Models\AddDetails;
use UserFrosting\Sprinkle\Cec\Database\Models\AdultNPIE;
use UserFrosting\Sprinkle\Cec\Database\Models\AdultRecall;
use UserFrosting\Sprinkle\Cec\Database\Models\ChildNPIE;
use UserFrosting\Sprinkle\Cec\Database\Models\ChildRecall;

use UserFrosting\Sprinkle\Cec\Sprunje\OfficeSprunje;
use UserFrosting\Sprinkle\Cec\Sprunje\SearchSprunje;
use UserFrosting\Sprinkle\Cec\Sprunje\CECOfficeSprunje;


class SearchController extends SimpleController
{


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
        $keyword = $params['keyword'];
        Debug::debug("pageList");

        $allOffices = Office::query()->get();
        $allzips = ZipCodes::query()->get();

        if (preg_match('/\d{5}/', $keyword, $matches)) {
            $keyword = $matches[0];
            $office = Office::query()
                ->leftJoin('zipcodes', 'zipcodes.zip', '=', 'office_details.zip')
                ->orWhere('office_details.zip', 'like', '%' . $keyword . '%')
                ->distinct()->get();

            $zipLength = count($allzips);

            for ($i = 0; $i < $zipLength; $i++) {
                if ($allzips[$i]['zip'] === $keyword) {
                    $ziplat = $allzips[$i]['latitude'];
                    $ziplng = $allzips[$i]['longitude'];

                    return $this->ci->view->render($response, 'pages/office-all.html.twig', [
                        'keyword' => $params['keyword'],
                        'page' => [
                            'lookupfound' => true,
                            'ziplat' => $ziplat,
                            'ziplng' => $ziplng,
                            'office' => $office,
                            'locations' => $allOffices
                        ]
                    ]);
                } else {
                    return $this->ci->view->render($response, 'pages/office-all.html.twig', [
                        'page' => [
                            'lookupfound' => false,
                            'keyword' => $params['keyword'],
                            'locations' => $allOffices,
                        ]
                    ]);
                }
            }

        } else {
            $office = Office::query()
                ->leftJoin('dentist_details', 'dentist_details.office_id', '=', 'office_details.office_id')
                ->where('office_details.name', 'like', '%' . $keyword . '%')
                ->orWhere('dentist_details.name', 'like', '%' . $keyword . '%')
                ->distinct()->get();
        }


        return $this->ci->view->render($response, 'pages/office-all.html.twig', [
            'keyword' => $params['keyword'],
            'office' => $office,
            'ziplat' => $ziplat,
            'ziplng' => $ziplng,
            'locations' => $allOffices,
            'midwestLogo' => 'https://www.meritdental.com/cecdb/images/midwest-logo.png',
            'mondoviLogo' => 'https://www.meritdental.com/cecdb/images/mondovi-logo.png',
            'meritLogo' => 'https://www.meritdental.com/cecdb/images/merit-logo.png',
            'mountainLogo' => 'https://www.meritdental.com/cecdb/images/mountain-logo.png',
            'page' => [
                'ziplat' => $ziplat,
                'ziplng' => $ziplng,
                'office' => $office,
                'locations' => $allOffices,
                'keyword' => $params['keyword']
            ]
        ]);
    }

    public function pageInfo($request, $response, $args)
    {
        $params = $args["keyword"];

        $office = Office::where('vanity_url', 'like', '%' . $params . '%')->first();

        $doctor = DentistDetails::where('office_id', $office["office_id"])->get();
        $hygienist = HygienistDetails::where('office_id', $office["office_id"])->get();
        $aNPIE = AdultNPIE::where('office_id', $office["office_id"])->get();
        $cNPIE = ChildNPIE::where('office_id', $office["office_id"])->get();
        $aRecall = AdultRecall::where('office_id', $office["office_id"])->get();
        $cRecall = ChildRecall::where('office_id', $office["office_id"])->get();
        $addDetails = AddDetails::where('office_id', $office["office_id"])->first();

        $name = $office['name'];
        $patterns = array();
        $patterns[0] = '/Dentist/';
        $patterns[1] = '/Office/';
        $replacements = array();
        $replacements[0] = '';
        $replacements[1] = '';
        $newName = preg_replace($patterns, $replacements, $name);

        //set closed hours stuff
        $day;
        date_default_timezone_set('America/New_York');
        $today = date("N");

        if ($today == 0) {
            $day = $office['sun_hours'];
            if (!$day) {
                $day = 'Closed';
            }
        } elseif ($today == 1) {
            $day = $office['mon_hours'];
            if (!$day) {
                $day = 'Closed';
            }
        } elseif ($today == 2) {
            $day = $office['tue_hours'];
            if (!$day) {
                $day = 'Closed';
            }
        } elseif ($today == 3) {
            $day = $office['wed_hours'];
            if (!$day) {
                $day = 'Closed';
            }
        } elseif ($today == 4) {
            $day = $office['thu_hours'];
            if (!$day) {
                $day = 'Closed';
            }
        } elseif ($today == 5) {
            $day = $office['fri_hours'];
            if (!$day) {
                $day = 'Closed';
            }
        } elseif ($today == 6) {
            $day = $office['sat_hours'];
            if (!$day) {
                $day = 'Closed';
            }
        } else {
            $day = 'Closed';
        }

        return $this->ci->view->render($response, 'pages/office-single.html.twig', [
            'keyword' => $params,
            'office' => $office,
            'doctor' => $doctor,
            'hygienist' => $hygienist,
            'aNPIE' => $aNPIE,
            'cNPIE' => $cNPIE,
            'aRecall' => $aRecall,
            'cRecall' => $cRecall,
            'additional' => $addDetails,
            'newName' => $newName,
            'day' => $day,
            'icon' => 'https://www.meritdental.com/wp-content/themes/midwest-2016/images/css/loc.png',
            'midwestLogo' => 'https://www.meritdental.com/cecdb/images/midwest-logo.png',
            'mondoviLogo' => 'https://www.meritdental.com/cecdb/images/mondovi-logo.png',
            'meritLogo' => 'https://www.meritdental.com/cecdb/images/merit-logo.png',
            'mountainLogo' => 'https://www.meritdental.com/cecdb/images/mountain-logo.png'
        ]);
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


        //check to see if input is a zip code or text
        $input = $data['input'];

        if (preg_match('/\d{5}/', $input, $matches)) {
            $input = $matches[0];
            Debug::debug("is zip");
            Debug::debug(print_r($input, true));
            $office = Office::distinct()->where('zip', $input)->get();

        } else {
            Debug::debug("else");
            Debug::debug(print_r($input, true));
            $office = Office::distinct()->where('name', 'like', '%' . $input . '%')->get();

        }


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


        if (!$result) {
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


        $office = Office::distinct()->where('name', 'like', '%' . $params['keyword'] . '%')->get();

        // If the user doesn't exist, return 404
        if (!$office) {
            throw new NotFoundException($request, $response);
        }


        $result = $office->toArray();


        // Be careful how you consume this data - it has not been escaped and contains untrusted user-supplied content.
        // For example, if you plan to insert it into an HTML DOM, you must escape it on the client side (or use client-side templating).
        return $response->withJson($result, 200, JSON_PRETTY_PRINT);

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
//        $office = $classMapper->staticMethod('Office', 'where', 'name', $data['input'])
//            ->first();


//        $office = Office::distinct()->where('page_title', $data['office_name'])->get();
        $office = Office::distinct()->where('name', 'like', '%' . $data['input'] . '%')->get();
//        $details = Search::distinct()->where('name', $data['keyword'])->get();

//        $office = $office->merge($details);


        return $office;
    }
}
