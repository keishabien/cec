<?php

namespace UserFrosting\Sprinkle\Cec\Controller;

use Illuminate\Database\Capsule\Manager as Capsule;
use UserFrosting\Sprinkle\Cec\Database\Models\HygienistDetails;
use UserFrosting\Sprinkle\Core\Controller\SimpleController;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Sprinkle\Cec\Database\Models\Office;
use UserFrosting\Sprinkle\Cec\Database\Models\DentistDetails;
use UserFrosting\Fortress\Adapter\JqueryValidationAdapter;
use UserFrosting\Fortress\RequestDataTransformer;
use UserFrosting\Fortress\ServerSideValidator;
use UserFrosting\Sprinkle\Core\Facades\Debug;

class PageController extends SimpleController
{
    public function pageIndex($request, $response, $args)
    {
        return $this->ci->view->render($response, 'pages/index.html.twig');
    }

    public function pageMembers($request, $response, $args)
    {
        $ms = $this->ci->alerts;

        $ms->addMessage('info', 'Your owl has successfully captured another vole!');
        return $this->ci->view->render($response, 'pages/members.html.twig');
    }

    public function pageIntake($request, $response, $args)
    {
        $schema = new RequestSchema('schema://requests/intake-form.yaml');
        $validator = new JqueryValidationAdapter($schema, $this->ci->translator);

        $offices = Office::distinct()->where('name', 'like', '% Dentist Office')->orderBy('name', 'ASC')->get();
//            SELECT distinct page_title, page_id FROM office_details where page_title like "% Dentist Office" ORDER BY page_title

        return $this->ci->view->render($response, 'pages/intake-ufCollection.html.twig', [
            'offices' => $offices
        ]);
    }

    public function intake($request, $response, $args)
    {
        $ms = $this->ci->alerts;
        $classMapper = $this->ci->classMapper;
        $config = $this->ci->config;

        // Get POST parameters: user_name, first_name, last_name, email, password, passwordc, captcha, spiderbro, csrf_token
        $params = $request->getParsedBody();
        Debug::debug("var params 1");
        Debug::debug(print_r($params, true));

        $officeSchema = new RequestSchema('schema://requests/office.yaml');
        $officeTransformer = new RequestDataTransformer($officeSchema);
        $location = $officeTransformer->transform($params);
        Debug::debug("var location selected");
        Debug::debug(print_r($location, true));

        $validator = new ServerSideValidator($officeSchema, $this->ci->translator);
        if (!$validator->validate($location)) {
            $ms->addValidationErrors($validator);
            return $response->withStatus(400);
        }

        $dentistSchema = new RequestSchema('schema://requests/dentist.yaml');
        $dentistTransformer = new RequestDataTransformer($dentistSchema);
        $dentistData = [];

        foreach($params['dentist'] as $dentistParams) {
            $dData = $dentistTransformer->transform($dentistParams);
            $dentistValidator = new ServerSideValidator($dentistSchema, $this->ci->translator);
            Debug::debug("var dentist");
            Debug::debug(print_r($dData,true));
            if (!$dentistValidator->validate($dData)) {
                $ms->addValidationErrors($dentistValidator);
                Debug::debug("not valid");
                Debug::debug(print_r($dData,true));
                return $response->withStatus(400);
            }
            $dData["office_id"] = $location["office_id"];
            $dentistData[] = $dData;
        }
        Debug::debug("var dentistData");
        Debug::debug(print_r($dentistData, true));


        $hygienistSchema = new RequestSchema('schema://requests/hygienist.yaml');
        $hygienistTransformer = new RequestDataTransformer($hygienistSchema);
        $hygienistData = [];

        foreach($params['hygienist'] as $hygienistParams) {
            $hData = $hygienistTransformer->transform($hygienistParams);
            $hygienistValidator = new ServerSideValidator($hygienistSchema, $this->ci->translator);
            Debug::debug("var hygienist");
            Debug::debug(print_r($hData,true));
            if (!$hygienistValidator->validate($hData)) {
                $ms->addValidationErrors($hygienistValidator);
                Debug::debug("not valid");
                Debug::debug(print_r($hData,true));
                return $response->withStatus(400);
            }
            $hData["office_id"] = $location["office_id"];
            $hygienistData[] = $hData;
        }
        Debug::debug("var hygienistData");
        Debug::debug(print_r($hygienistData, true));


        // All checks passed!
        // Begin transaction - DB will be rolled back if an exception occurs
        Capsule::transaction(function () use ($classMapper, $dentistData, $hygienistData, $ms, $config) {

            foreach($dentistData as $dentist){
                $intake = new DentistDetails($dentist);
                Debug::debug("var intake");
                Debug::debug(print_r($intake, true));
                // Store new user to database
                $intake->save();
            }

            foreach($hygienistData as $hygienist){
                $intake = new HygienistDetails($hygienist);
                Debug::debug("var intake");
                Debug::debug(print_r($intake, true));
                // Store new user to database
                $intake->save();
            }

        });
        return $response->withStatus(200);
    }

    public function pageNPIE($request, $response, $args)
    {

// Get submitted data
        $params = $request->getParsedBody();

// Load the request schema
        $schema = new RequestSchema('schema://requests/intake-form.yaml');

// Whitelist and set parameter defaults
        $validator = new JqueryValidationAdapter($schema, $this->ci->translator);

        $offices = Office::distinct()->where('name', 'like', '% Dentist Office')->orderBy('name', 'ASC')->get();
//            SELECT distinct page_title, page_id FROM office_details where page_title like "% Dentist Office" ORDER BY page_title

        $rules = $validator->rules();


        return $this->ci->view->render($response, 'pages/intake-npie.html.twig', [
            'offices' => $offices,
            'data' => $data,
            'page' => [
                'validators' => [
                    'intake' => $rules
                ]
            ]
        ]);
    }

    public function pageRecall($request, $response, $args)
    {
        $schema = new RequestSchema('schema://requests/intake-form.yaml');

        $offices = Office::distinct()->where('name', 'like', '% Dentist Office')->orderBy('name', 'ASC')->get();
//            SELECT distinct page_title, page_id FROM office_details where page_title like "% Dentist Office" ORDER BY page_title

        return $this->ci->view->render($response, 'pages/intake-recall.html.twig', [
            'offices' => $offices
        ]);
    }

    public function pageFinal($request, $response, $args)
    {
        $schema = new RequestSchema('schema://requests/intake-form.yaml');

        $offices = Office::distinct()->where('name', 'like', '% Dentist Office')->orderBy('name', 'ASC')->get();
//            SELECT distinct page_title, page_id FROM office_details where page_title like "% Dentist Office" ORDER BY page_title

        return $this->ci->view->render($response, 'pages/intake-final.html.twig', [
            'offices' => $offices
        ]);
    }
}
