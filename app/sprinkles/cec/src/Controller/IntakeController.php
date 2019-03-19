<?php

namespace UserFrosting\Sprinkle\Cec\Controller;

use Illuminate\Database\Capsule\Manager as Capsule;
use UserFrosting\Sprinkle\Core\Controller\SimpleController;
use UserFrosting\Sprinkle\Core\Facades\Debug;
use UserFrosting\Sprinkle\Cec\Database\Models\Office;
use UserFrosting\Sprinkle\Cec\Database\Models\DentistDetails;
use UserFrosting\Sprinkle\Cec\Database\Models\HygienistDetails;
use UserFrosting\Sprinkle\Cec\Database\Models\AdultNPIE;
use UserFrosting\Sprinkle\Cec\Database\Models\ChildNPIE;
use UserFrosting\Fortress\Adapter\JqueryValidationAdapter;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\RequestDataTransformer;
use UserFrosting\Fortress\ServerSideValidator;


class IntakeController extends SimpleController
{

    public function pageDetails($request, $response, $args)
    {
        $schema = new RequestSchema('schema://requests/office.yaml');
        $validator = new JqueryValidationAdapter($schema, $this->ci->translator);
        $rules = $validator->rules();

        $offices = Office::query()->orderBy('name', 'ASC')->get();

        return $this->ci->view->render($response, 'pages/intake/page1.html.twig', [
            'offices' => $offices,
            'page' => [
                'validators' => [
                    'office' => $rules
                ]
            ]
        ]);
    }

    public function details($request, $response, $args)
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

        foreach ($params['dentist'] as $dentistParams) {
            $dData = $dentistTransformer->transform($dentistParams);
            $dentistValidator = new ServerSideValidator($dentistSchema, $this->ci->translator);
            Debug::debug("var dentist");
            Debug::debug(print_r($dData, true));
            if (!$dentistValidator->validate($dData)) {
                $ms->addValidationErrors($dentistValidator);
                Debug::debug("not valid");
                Debug::debug(print_r($dData, true));
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

        foreach ($params['hygienist'] as $hygienistParams) {
            $hData = $hygienistTransformer->transform($hygienistParams);
            $hygienistValidator = new ServerSideValidator($hygienistSchema, $this->ci->translator);
            Debug::debug("var hygienist");
            Debug::debug(print_r($hData, true));
            if (!$hygienistValidator->validate($hData)) {
                $ms->addValidationErrors($hygienistValidator);
                Debug::debug("not valid");
                Debug::debug(print_r($hData, true));
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

            foreach ($dentistData as $dentist) {
                $intake = new DentistDetails($dentist);
                Debug::debug("var intake");
                Debug::debug(print_r($intake, true));
                // Store new user to database
                $intake->save();
            }

            foreach ($hygienistData as $hygienist) {
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
        $params = $request->getQueryParams();
        $id = $params['id'];
        $schema = new RequestSchema('schema://requests/npie.yaml');
        $validator = new JqueryValidationAdapter($schema, $this->ci->translator);
        $rules = $validator->rules();

        return $this->ci->view->render($response, 'pages/intake/page2.html.twig', [
            'office_id' => $id,
            'page' => [
                'validators' => [
                    'npie' => $rules
                ]
            ]
        ]);
    }

    public function npie($request, $response, $args)
    {
        $ms = $this->ci->alerts;
        $classMapper = $this->ci->classMapper;
        $config = $this->ci->config;

        // Get POST parameters: user_name, first_name, last_name, email, password, passwordc, captcha, spiderbro, csrf_token
        $params = $request->getParsedBody();
        Debug::debug("var params 1");
        Debug::debug(print_r($params, true));

        $npieSchema = new RequestSchema('schema://requests/npie.yaml');
        $npieTransformer = new RequestDataTransformer($npieSchema);
        $adultNPIE = [];
        $childNPIE = [];

        foreach ($params['adult'] as $adultParams) {
            $aData = $npieTransformer->transform($adultParams);
            $npieValidator = new ServerSideValidator($npieSchema, $this->ci->translator);
            Debug::debug("var adult");
            Debug::debug(print_r($aData, true));
            if (!$npieValidator->validate($aData)) {
                $ms->addValidationErrors($npieValidator);
                Debug::debug("not valid");
                Debug::debug(print_r($aData, true));
                return $response->withStatus(400);
            }
            $aData["office_id"] = $params["office_id"];
            $adultData[] = $aData;
        }
        Debug::debug("var adultData");
        Debug::debug(print_r($adultData, true));

        foreach ($params['child'] as $childParams) {
            $cData = $npieTransformer->transform($childParams);
            $npieValidator = new ServerSideValidator($npieSchema, $this->ci->translator);
            Debug::debug("var child");
            Debug::debug(print_r($cData, true));
            if (!$npieValidator->validate($cData)) {
                $ms->addValidationErrors($npieValidator);
                Debug::debug("not valid");
                Debug::debug(print_r($cData, true));
                return $response->withStatus(400);
            }
            $cData["office_id"] = $params["office_id"];
            $childData[] = $cData;
        }
        Debug::debug("var childData");
        Debug::debug(print_r($childData, true));
//
//
//        // All checks passed!
//        // Begin transaction - DB will be rolled back if an exception occurs
        Capsule::transaction(function () use ($classMapper, $adultData, $childData, $ms, $config) {

            foreach ($adultData as $adult) {
                $intake = new AdultNPIE($adult);
                Debug::debug("var intake");
                Debug::debug(print_r($intake, true));
                // Store new user to database
                $intake->save();
            }

            foreach ($childData as $child) {
                $intake = new ChildNPIE($child);
                Debug::debug("var intake");
                Debug::debug(print_r($intake, true));
                // Store new user to database
                $intake->save();
            }

        });
        return $response->withStatus(200);
    }

    public function pageRecall($request, $response, $args)
    {
        $schema = new RequestSchema('schema://requests/intake-form.yaml');

        $offices = Office::query()->orderBy('name', 'ASC')->get();

        return $this->ci->view->render($response, 'pages/intake/page3.html.twig', [
            'offices' => $offices
        ]);
    }

    public function pageFinal($request, $response, $args)
    {
        $schema = new RequestSchema('schema://requests/intake-form.yaml');

        $offices = Office::query()->orderBy('name', 'ASC')->get();

        return $this->ci->view->render($response, 'pages/intake/page4.html.twig', [
            'offices' => $offices
        ]);
    }
}
