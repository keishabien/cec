<?php

namespace UserFrosting\Sprinkle\Cec\Controller;

use Illuminate\Database\Capsule\Manager as Capsule;
use UserFrosting\Sprinkle\Core\Controller\SimpleController;
use UserFrosting\Sprinkle\Core\Facades\Debug;
use UserFrosting\Sprinkle\Cec\Database\Models\Office;
use UserFrosting\Sprinkle\Cec\Database\Models\DentistDetails;
use UserFrosting\Sprinkle\Cec\Database\Models\HygienistDetails;
use UserFrosting\Fortress\Adapter\JqueryValidationAdapter;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\RequestDataTransformer;
use UserFrosting\Fortress\ServerSideValidator;


class PageController extends SimpleController
{
    public function pageIndex($request, $response, $args)
    {
        $ms = $this->ci->alerts;

        $ms->addMessageTranslated('success', 'ACCOUNT.REQUIRED');
        return $this->ci->view->render($response, 'pages/index.html.twig');
    }

    public function pageMembers($request, $response, $args)
    {
        $ms = $this->ci->alerts;

        $ms->addMessage('info', 'Your owl has successfully captured another vole!');
        return $this->ci->view->render($response, 'pages/members.html.twig');
    }
}
