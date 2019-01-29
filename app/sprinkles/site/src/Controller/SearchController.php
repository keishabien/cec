<?php

namespace UserFrosting\Sprinkle\Site\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\NotFoundException;
use UserFrosting\Sprinkle\Core\Controller\SimpleController;
use UserFrosting\Support\Exception\ForbiddenException;
use UserFrosting\Sprinkle\Site\Database\Models\Search;
use UserFrosting\Sprinkle\Site\Database\Models\CECOffice;

class SearchController extends SimpleController
{
    public function pageSearch($request, $response, $args)
    {
        $keyword = $request->getParsedBody();

        $office = CECOffice::distinct()->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('zip', 'like', '%' . $keyword . '%')
            ->orderBy('name', "ASC")
            ->get();


        return $this->ci->view->render($response, 'pages/search.html.twig', [
            'results' => $results,
            'keyword'   => $keyword,
            'office' => $office,
            'location' => $location,
            'midwestLogo' => 'https://www.meritdental.com/cecdb/images/midwest-logo.png',
            'mondoviLogo' => 'https://www.meritdental.com/cecdb/images/mondovi-logo.png',
            'meritLogo' => 'https://www.meritdental.com/cecdb/images/merit-logo.png',
            'mountainLogo' => 'https://www.meritdental.com/cecdb/images/mountain-logo.png',
            "page" => [
                'keyword'   => $keyword
            ]
        ]);
    }

    public function getOwls($request, $response, $args)
    {
        $location = $args['location'];

        // GET parameters
        $params = $request->getQueryParams();

        $this->ci->db;
        $result = Search::distinct()->where('office_name', 'like', '%' . $location . '%')->get();

        if ($params['format'] == 'json') {
            return $response->withJson($result, 200, JSON_PRETTY_PRINT);
        } else {
            return $response->withJson($result, 200, JSON_PRETTY_PRINT);
        }
    }

}
