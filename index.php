<?php

/** When you enable strict type checking, PHP ensures that the data types of function arguments 
 *  and return values match exactly with the declared types.
 *  
 *  Example:
 * 
 * function speak(string $name): string
 * {
 *     return "Hello {$name}!";
 *  }
 * speak(1); // This fires the error "Uncaught TypeError"
 * speak("Valerio"); // This prints "Hello Valerio!"
 */

declare(strict_types=1);

include "config.php";

// automatically load the controller classes
spl_autoload_register(function ($class) {
    require __DIR__ . "/src/$class.php";
});

set_error_handler("ErrorHandler::handleError"); // for php-errors
set_exception_handler("ErrorHandler::handleException");

header("Content-type: application/json; charset=UTF-8");

$parts = parse_url($_SERVER["REQUEST_URI"]);

if (
    $parts['path'] != "/digihak-car-search/brands" &&
    $parts['path'] != "/digihak-car-search/cars" &&
    $parts['path'] != "/digihak-car-search/cars/models" &&
    $parts['path'] != "/digihak-car-search/cars/registrations" &&
    $parts['path'] != "/digihak-car-search/cars/fuels" &&
    $parts['path'] != "/digihak-car-search/cars/rating"
) {
    http_response_code(404);
    exit;
}

$database = new Database($DB_HOST, $DB_NAME, $DB_USER, $DB_PASSWORD, $DB_PORT);

switch ($parts['path']) {
    case "/digihak-car-search/brands":
        $brandController = new BrandController($database);
        $brandController->getAll();
        break;
    case "/digihak-car-search/cars":
        $brandId = $_GET['brandId'] ? $_GET['brandId'] : null;
        $model = $_GET['model'] ? $_GET['model'] : null;
        $registration = $_GET['registration'] ? $_GET['registration'] : null;
        $mileage = $_GET['mileage'] ? $_GET['mileage'] : null;
        $fuelId = $_GET['fuelId'] ? $_GET['fuelId'] : null;

        if (!$brandId) throw new Exception('Parameter brandId is required', 400);

        $carController = new CarController($database);
        $carController->getCars($brandId, $model, $registration, $mileage, $fuelId, false);
        break;
    case "/digihak-car-search/cars/models":
        $brandId = $_GET['brandId'] ? $_GET['brandId'] : null;

        if (!$brandId) throw new Exception('Parameter brandId is required', 400);

        $carController = new CarController($database);
        $carController->getModels($brandId);
        break;
    case "/digihak-car-search/cars/registrations":
        $brandId = $_GET['brandId'] ? $_GET['brandId'] : null;
        $model = $_GET['model'] ? $_GET['model'] : null;

        if (!$brandId) throw new Exception('Parameter brandId is required', 400);
        if (!$model) throw new Exception('Parameter model is required', 400);

        $carController = new CarController($database);
        $carController->getInitialRegistrations($brandId, $model);
        break;
    case "/digihak-car-search/cars/fuels":
        $brandId = $_GET['brandId'] ? $_GET['brandId'] : null;
        $model = $_GET['model'] ? $_GET['model'] : null;
        $registration = $_GET['registration'] ? $_GET['registration'] : null;

        if (!$brandId) throw new Exception('Parameter brandId is required', 400);
        if (!$model) throw new Exception('Parameter model is required', 400);
        if (!$registration) throw new Exception('Parameter registration is required', 400);

        $carController = new CarController($database);
        $carController->getFuels($brandId, $model, $registration);
        break;
    case "/digihak-car-search/cars/rating":
        $brandId = $_GET['brandId'] ? $_GET['brandId'] : null;
        $model = $_GET['model'] ? $_GET['model'] : null;
        $registration = $_GET['registration'] ? $_GET['registration'] : null;
        $mileage = $_GET['mileage'] ? $_GET['mileage'] : null;
        $fuelId = $_GET['fuelId'] ? $_GET['fuelId'] : null;

        if (!$brandId) throw new Exception('Parameter brandId is required', 400);
        if (!$model) throw new Exception('Parameter model is required', 400);
        if (!$registration) throw new Exception('Parameter registration is required', 400);
        if (!$mileage) throw new Exception('Parameter mileage is required', 400);
        if (!$fuelId) throw new Exception('Parameter fuelId is required', 400);

        $carController = new CarController($database);
        $carController->getCars($brandId, $model, $registration, $mileage, $fuelId, true);
        break;
}
