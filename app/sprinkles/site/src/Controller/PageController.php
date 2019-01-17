<?php

namespace UserFrosting\Sprinkle\Site\Controller;

use UserFrosting\Sprinkle\Core\Controller\SimpleController;
use UserFrosting\Fortress\RequestSchema;


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
        return $this->ci->view->render($response, 'pages/intake.html.twig');
    }
}
