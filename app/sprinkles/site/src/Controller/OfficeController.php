<?php

namespace UserFrosting\Sprinkle\Site\Controller;

use UserFrosting\Sprinkle\Core\Controller\SimpleController;

class OfficeController extends SimpleController
{
    public function pageOffice($request, $response, $args)
    {
        return $this->ci->view->render($response, 'pages/office.html.twig');
    }
}
