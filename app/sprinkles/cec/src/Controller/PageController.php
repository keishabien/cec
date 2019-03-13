<?php

namespace UserFrosting\Sprinkle\Cec\Controller;

use Illuminate\Database\Capsule\Manager as Capsule;
use UserFrosting\Sprinkle\Core\Controller\SimpleController;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Sprinkle\Cec\Database\Models\Office;
use UserFrosting\Sprinkle\Cec\Database\Models\CECOffice;
use UserFrosting\Sprinkle\Cec\Database\Models\Intake;
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

        $offices = CECOffice::distinct()->where('name', 'like', '% Dentist Office')->orderBy('name', 'ASC')->get();
//            SELECT distinct page_title, page_id FROM office_details where page_title like "% Dentist Office" ORDER BY page_title

        return $this->ci->view->render($response, 'pages/intake-dr-hyg-details.html.twig', [
            'offices' => $offices
        ]);
    }

    public function intake($request, $response, $args)
    {

        /** @var \UserFrosting\Sprinkle\Core\Alert\AlertStream $ms */
        $ms = $this->ci->alerts;

        /** @var \UserFrosting\Sprinkle\Core\Util\ClassMapper $classMapper */
        $classMapper = $this->ci->classMapper;

        /** @var \UserFrosting\Support\Repository\Repository $config */
        $config = $this->ci->config;

        // Get POST parameters: user_name, first_name, last_name, email, password, passwordc, captcha, spiderbro, csrf_token
        $params = $request->getParsedBody();
        Debug::debug("var params 1");
        Debug::debug(print_r($params, true));

        $error = false;

//        $officeSchema = new RequestSchema('schema://requests/office.yaml');
//        $officeTransformer = new RequestDataTransformer($officeSchema);
//        $location = $officeTransformer->transform($params);
//
//        Debug::debug("var location selected");
//        Debug::debug(print_r($location, true));


        // Validate request data
//        $validator = new ServerSideValidator($officeSchema, $this->ci->translator);
//
//        if (!$validator->validate($location)) {
//            $ms->addValidationErrors($validator);
//            Debug::debug("var location");
//            Debug::debug(print_r($location,true));
//            Debug::debug(print_r($validator->errors()));
//            return $response->withStatus(400);
//        }


        $dentistSchema = new RequestSchema('schema://requests/dentist.yaml');
        $dentistTransformer = new RequestDataTransformer($dentistSchema);


        $data = $dentistTransformer->transform($params);
        Debug::debug("transformed data");
        Debug::debug(print_r($data, true));

        $dentistValidator = new ServerSideValidator($dentistSchema, $this->ci->translator);
        // Add error messages and halt if validation failed
        if (!$dentistValidator->validate($data)) {
            $ms->addValidationErrors($dentistValidator);
            Debug::debug("var data");
            Debug::debug(print_r($data, true));
            Debug::debug(print_r($dentistValidator->errors()));
            return $response->withStatus(400);
        }


// All checks passed!
        // Begin transaction - DB will be rolled back if an exception occurs
        Capsule::transaction(function () use ($classMapper, $data, $ms, $config) {
            // Log throttleable event
            //$throttler->logEvent('registration_attempt');

            $intake = new Intake($data);
            Debug::debug("var intake");
            Debug::debug(print_r($intake, true));


//            $intake->office_id = $data['dentist-full-name'];
//            $intake->dentist_id = $data['dentist-full-name'];
//            $intake->name = $data['dentist-full-name'];
//            $intake->nickname = $data['dentist-called-name'];
//            $intake->provider_num = $data['dentist-provider-num'];
//            $intake->emergency_num = $data['dentist-emer-num'];
//            $intake->locum = $data['locum-radio'];
//            $intake->start_date = $data['dentist-start-date'];
//            $intake->end_date = $data['dentist-end-date'];
//            $intake->leave = $data['leave-radio'];
//            $intake->leave_start_date = $data['leave-start-date'];
//            $intake->leave_end_date = $data['leave-end-date'];


//            Debug::debug("var data");
//            Debug::debug(print_r($data,true));
            Debug::debug("var intake");
            Debug::debug(print_r($intake, true));
            // Store new user to database
            $intake->save();

            // Create activity record
//            $this->ci->userActivityLogger->info("User {$user->user_name} registered for a new account.", [
//                'type' => 'sign_up',
//                'user_id' => $user->id
//            ]);
//            $ms->addMessageTranslated('success', 'OFFICE.COMPLETE');

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

        $offices = CECOffice::distinct()->where('name', 'like', '% Dentist Office')->orderBy('name', 'ASC')->get();
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

        $offices = CECOffice::distinct()->where('name', 'like', '% Dentist Office')->orderBy('name', 'ASC')->get();
//            SELECT distinct page_title, page_id FROM office_details where page_title like "% Dentist Office" ORDER BY page_title

        return $this->ci->view->render($response, 'pages/intake-recall.html.twig', [
            'offices' => $offices
        ]);
    }

    public function pageFinal($request, $response, $args)
    {
        $schema = new RequestSchema('schema://requests/intake-form.yaml');

        $offices = CECOffice::distinct()->where('name', 'like', '% Dentist Office')->orderBy('name', 'ASC')->get();
//            SELECT distinct page_title, page_id FROM office_details where page_title like "% Dentist Office" ORDER BY page_title

        return $this->ci->view->render($response, 'pages/intake-final.html.twig', [
            'offices' => $offices
        ]);
    }
}
