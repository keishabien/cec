<?php
namespace UserFrosting\Sprinkle\Site\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\NotFoundException;
use UserFrosting\Sprinkle\Core\Controller\SimpleController;
use UserFrosting\Support\Exception\ForbiddenException;
use UserFrosting\Sprinkle\Site\Database\Models\Search;

class SearchController extends SimpleController
{
    public function pageSearch($request, $response, $args)
    {
        $results = Search::all();

        return $this->ci->view->render($response, 'pages/search.html.twig', [
            'results' => $results
        ]);
    }

}
