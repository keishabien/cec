<?php

namespace UserFrosting\Sprinkle\Site\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\NotFoundException;
use UserFrosting\Sprinkle\Core\Controller\SimpleController;
use UserFrosting\Support\Exception\ForbiddenException;
use UserFrosting\Sprinkle\Site\Database\Models\Search;
use UserFrosting\Sprinkle\Site\Database\Models\Office;

class SearchController extends SimpleController
{
    public function pageSearch($request, $response, $args)
    {
        $location = $_GET['location_name'];

        $results = Search::distinct()->where('office_name', 'like', '%' . $_GET['location_name'] . '%')->get();

        $office = Office::distinct()->where(function ($b) {
            $b->where('page_title', 'like', '%' . $_GET['location_name'] . '%')
                ->orWhere('zip', 'like', '%' . $_GET['location_name'] . '%');
        })->get();


        $merged = $results->merge($office);


//
        $getParams = $request->getQueryParams();
//
//        $result = Search::where('office_name', $location)->get();

//        if ($getParams['format'] == 'json') {
//            return $response->withJson($result, 200, JSON_PRETTY_PRINT);
//        } else {
//            return $response->write("No format specified");
//        }

        return $this->ci->view->render($response, 'pages/search.html.twig', [
            'results' => $results,
            'merged'    => $merged,
            'office'    => $office,
            'location' => $location,
            'get' => $_GET["submit"]
        ]);
    }

}
