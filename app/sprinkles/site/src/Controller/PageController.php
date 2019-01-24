<?php

namespace UserFrosting\Sprinkle\Site\Controller;

use UserFrosting\Sprinkle\Core\Controller\SimpleController;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Sprinkle\Site\Database\Models\Office;
use UserFrosting\Sprinkle\Site\Database\Models\Intake;
use UserFrosting\Fortress\Adapter\JqueryValidationAdapter;
use UserFrosting\Fortress\RequestDataTransformer;
use UserFrosting\Fortress\ServerSideValidator;

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

        $offices = Office::distinct()->where('page_title', 'like', '% Dentist Office')->orderBy('page_title', 'ASC')->get();
//            SELECT distinct page_title, page_id FROM office_details where page_title like "% Dentist Office" ORDER BY page_title

        return $this->ci->view->render($response, 'pages/intake-dr-hyg-details.html.twig', [
            'offices' => $offices,
            'page' => [
                'validators' => [
                    'intake' => $validator->rules('json', false)
                ]
            ]
        ]);
    }

    public function intake($request, $response, $args)
    {

        /** @var \UserFrosting\Sprinkle\Core\Alert\AlertStream $ms */
        $ms = $this->ci->alerts;

        // Get POST parameters: user_name, first_name, last_name, email, password, passwordc, captcha, spiderbro, csrf_token
        $params = $request->getParsedBody();

        $schema = new RequestSchema('schema://requests/intake-form.yaml');
        // Whitelist and set parameter defaults
        $transformer = new RequestDataTransformer($schema);
        $data = $transformer->transform($params);


        $error = false;

        // Validate request data
        $validator = new ServerSideValidator($schema, $this->ci->translator);
        if (!$validator->validate($data)) {
            $ms->addValidationErrors($validator);
            $error = true;
        }

        if ($error) {
            return $response->withStatus(400);
        }

        $intake = new Intake([
            'name' => $data['name']
        ]);

        // check if saved
        $saved = $intake->save();

        if(!$saved){
            return $response->withStatus(400);
        }

        $ms->addMessageTranslated('success', 'OFFICE.COMPLETE', $data);

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

        $offices = Office::distinct()->where('page_title', 'like', '% Dentist Office')->orderBy('page_title', 'ASC')->get();
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

        $offices = Office::distinct()->where('page_title', 'like', '% Dentist Office')->orderBy('page_title', 'ASC')->get();
//            SELECT distinct page_title, page_id FROM office_details where page_title like "% Dentist Office" ORDER BY page_title

        return $this->ci->view->render($response, 'pages/intake-recall.html.twig', [
            'offices' => $offices
        ]);
    }

    public function pageFinal($request, $response, $args)
    {
        $schema = new RequestSchema('schema://requests/intake-form.yaml');

        $offices = Office::distinct()->where('page_title', 'like', '% Dentist Office')->orderBy('page_title', 'ASC')->get();
//            SELECT distinct page_title, page_id FROM office_details where page_title like "% Dentist Office" ORDER BY page_title

        return $this->ci->view->render($response, 'pages/intake-final.html.twig', [
            'offices' => $offices
        ]);
    }
}
