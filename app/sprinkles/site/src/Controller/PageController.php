<?php

namespace UserFrosting\Sprinkle\Site\Controller;

use UserFrosting\Sprinkle\Core\Controller\SimpleController;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Sprinkle\Site\Database\Models\Office;

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

        $offices = Office::distinct()->where('page_title', 'like', '% Dentist Office')->orderBy('page_title', 'ASC')->get();
//            SELECT distinct page_title, page_id FROM office_details where page_title like "% Dentist Office" ORDER BY page_title

        return $this->ci->view->render($response, 'pages/intake-dr-hyg-details.html.twig', [
            'offices' => $offices,
        ]);
    }

    public function pageNPIE($request, $response, $args)
    {
        $schema = new RequestSchema('schema://requests/intake-form.yaml');

        $offices = Office::distinct()->where('page_title', 'like', '% Dentist Office')->orderBy('page_title', 'ASC')->get();
//            SELECT distinct page_title, page_id FROM office_details where page_title like "% Dentist Office" ORDER BY page_title

        return $this->ci->view->render($response, 'pages/intake-npie.html.twig', [
            'offices' => $offices,
        ]);
    }
}
