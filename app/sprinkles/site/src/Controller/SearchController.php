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
        $location = $args['location'];
        $params = $request->getParsedBody();

// Displays 'json'
        //echo $params['format'];

        $results = Search::distinct()->where('office_name', 'like', '%' . $location . '%')->get();
        //            ->join('office_details', 'cec_update.page_id', '=', 'office_details.page_id')

        $office = Office::distinct()->where('page_title', 'like', '%' . $location . '%')
                ->orWhere('zip', 'like', '%' . $location . '%')
            ->get();


        //$merged = $results->merge($office);


        return $this->ci->view->render($response, 'pages/search.html.twig', [
            'results' => $results,
            //'merged' => $merged,
            'office' => $office,
            'location' => $location,
            'get' => $_GET["submit"],
            'midwestLogo' => 'https://www.meritdental.com/cecdb/images/midwest-logo.png',
            'mondoviLogo' => 'https://www.meritdental.com/cecdb/images/mondovi-logo.png',
            'meritLogo' => 'https://www.meritdental.com/cecdb/images/merit-logo.png',
            'mountainLogo' => 'https://www.meritdental.com/cecdb/images/mountain-logo.png'
        ]);
    }

}
