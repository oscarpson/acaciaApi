<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php'; 
//require '../vendor/autoload.php';
require __DIR__ . '/../includes/DbOperation.php';
$app = new \Slim\App();

$app->get('/seedmain', function (Request $request, Response $response) {
    
    $response_data = array();
    $response_data['error'] = false;
    $response_data['message'] = 'Registered successfully';
    $response_data['customer'] = 'loloi';
    $response_data['zone'] = 'lolo';

    $response->write(json_encode($response_data));
    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200); 
     //$response->getBody()->write(json_encode($response_data));
});
$app->post('/add_product', function (Request $request, Response $response) {
    $input = $request->getParsedBody();
   $itemName = $input['itemName'];
    $itemtype = $input['itemtype'];
    $quantity = $input['quantity'];

    $db = new DbOperation();
    $responseData = array();
    $result = $db->addProduct($itemName, $itemtype,  $quantity);
    if ($result == PRODUCT_CREATED) {
        $responseData['error'] = false;
        $responseData['message'] = 'Registered successfully';
        $responseData['itemId'] = "2";
           // $responseData['user'] = $db->getUserByEmail($email);
    } elseif ($result == PRODUCT_CREATION_FAILED) {
        $responseData['error'] = true;
        $responseData['message'] = 'Some error occurred';
        $responseData['itemId'] = "2";
    }

    $response->getBody()->write(json_encode($responseData));
});
$app->post('/add_qc', function (Request $request, Response $response) {
    
   $input = $request->getParsedBody();
   $itemId = $input['itemId'];
    $weight = $input['weight'];
    $moisture = $input['moisture'];
    $storage = $input['storage'];
  

    $db = new DbOperation();
    $responseData = array();
    $result = $db->addQC($itemId,$weight,$moisture,$storage);
    if ($result == PRODUCT_CREATED) {
        $responseData['error'] = false;
        $responseData['message'] = 'Registered successfully';
        $responseData['itemId'] = "2";
           // $responseData['user'] = $db->getUserByEmail($email);
    } elseif ($result == PRODUCT_CREATION_FAILED) {
        $responseData['error'] = true;
        $responseData['message'] = 'Some error occurred';
        $responseData['itemId'] = "2";
    }

    $response->getBody()->write(json_encode($responseData));
});
$app->post('/add_test', function (Request $request, Response $response) {
    
    $input = $request->getParsedBody();
   $itemId = $input['itemId'];
    $desc = $input['desc'];
    $nsamples = $input['nsamples'];
    $testtype = $input['testtype'];
    $results = $input['results'];

    $db = new DbOperation();
    $responseData = array();
    $result = $db->addTest($itemId,$desc, $nsamples,  $testtype,$results);
    if ($result == PRODUCT_CREATED) {
        $responseData['error'] = false;
        $responseData['message'] = 'Registered successfully';
        $responseData['itemId'] = "2";
           // $responseData['user'] = $db->getUserByEmail($email);
    } elseif ($result == PRODUCT_CREATION_FAILED) {
        $responseData['error'] = true;
        $responseData['message'] = 'Some error occurred';
        $responseData['itemId'] = "2";
    }

    $response->getBody()->write(json_encode($responseData));
});

$app->post('/assign_lot', function (Request $request, Response $response) {
    
    $input = $request->getParsedBody();
   $itemId = $input['itemId'];
    $lotNo = $input['lotNo'];
    $quantity = $input['quantity'];
    $expDate = $input['expDate'];

    $db = new DbOperation();
    $responseData = array();
    $result = $db->assignLot($itemId, $lotNo,  $quantity,$expDate);
    if ($result == PRODUCT_CREATED) {
        $responseData['error'] = false;
        $responseData['message'] = 'Registered successfully';
        $responseData['itemId'] = "2";
           // $responseData['user'] = $db->getUserByEmail($email);
    } elseif ($result == PRODUCT_CREATION_FAILED) {
        $responseData['error'] = true;
        $responseData['message'] = 'Some error occurred';
        $responseData['itemId'] = "2";
    }

    $response->getBody()->write(json_encode($responseData));
});

$app->post('/approve_lot', function (Request $request, Response $response) {
    
   $input = $request->getParsedBody();
    $lotNo = $input['lotNo'];
   $itemId=$input['itemId'];
    $db = new DbOperation();
    $responseData = array();
    $result = $db->approveLot($lotNo,$itemId);
    if ($result == PRODUCT_CREATED) {
        $responseData['error'] = false;
        $responseData['message'] = 'Registered successfully';
        $responseData['itemId'] = "2";
           // $responseData['user'] = $db->getUserByEmail($email);
    } elseif ($result == PRODUCT_CREATION_FAILED) {
        $responseData['error'] = true;
        $responseData['message'] = 'Some error occurred';
        $responseData['itemId'] = "2";
    }

    $response->getBody()->write(json_encode($responseData));
});

$app->get('/lot_info', function (Request $request, Response $response) {
    
    $db = new DbOperation;
    $lotinfo = $db->getAllLots();
     $responseData= array();
     $responseData['error'] = false;
     $responseData['message'] = 'Registered successfully';
    $responseData['lotinfo'] = $lotinfo;
    $response->write(json_encode($responseData));
    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});

$app->get('/all_products', function (Request $request, Response $response) {
    
    $db = new DbOperation;
    $allproducts = $db->getAllProducts();
     $responseData= array();
     $responseData['error'] = false;
     $responseData['message'] = 'Queried list successfully';
    $responseData['allproducts'] = $allproducts;
    $response->write(json_encode($responseData));
    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});

$app->get('/all_details', function (Request $request, Response $response) {
    
    $db = new DbOperation;
    $details = $db->getAllDetails();
     $responseData= array();
     $responseData['error'] = false;
     $responseData['message'] = 'Registered successfully';
    $responseData['details'] = $details;
    $response->write(json_encode($responseData));
    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});


// Run app
$app->run();
