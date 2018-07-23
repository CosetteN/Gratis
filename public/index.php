<?php
require_once '../vendor/autoload.php';

use Slim\Http\{Request, Response};
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

try {
    //dotenv loads .env file into server environmental variables
    $dotenv = new Dotenv\Dotenv(realpath(__DIR__ . "/../"));
    $dotenv->load();


    // Avoid digging into vagrant to get to logs to figure what what is going wrong.
    $container = new \Slim\Container;

    $container['Logger'] = function($container) {
        $log = new Logger('log');
        $log->pushHandler(new StreamHandler(realpath(__DIR__ . "/../logs/error.log", Logger::WARNING)));
        return $log;
    };

    mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
    //load database connection into a slim container.
    $container['database'] = function($container) {
        $database = new mysqli(
            getenv("DB_HOST"),
            getenv("DB_USER"),
            getenv("DB_PASSWORD"),
            getenv("DB_NAME")
        );
        return $database;
    };

    // Load twig container to use view templates.
    $container['view'] = function ($container) {
        $view = new \Slim\Views\Twig(__DIR__ . '/../templates', ['cache' => false]);

        // Instantiate and add Slim specific extension
        $basePath = rtrim(str_ireplace('index.php', '', $container->get('request')->getUri()->getBasePath()), '/');
        $view->addExtension(new Slim\Views\TwigExtension($container->get('router'), $basePath));

        return $view;
    };


    // Defining instantiation of the login class.
    $container['Cars\Login'] = function($container) {
        return new \Cars\Login($container->get('database'));
    };

    //Build app and it's individual pages
    $app = new \Slim\App($container);

    //Display the home page
    $app->get('/home', function($request, $response, $args) {
        return $this->view->render( $response, 'home.html', ['login => true', 'username' => 'Hope'] );
    })->setName('home');

    //Display the base login and login failure page
    $app->get('/user/login', function($request, $response, $args) {
        return $this->view->render( $response, 'login.html', ['loginFailed' => false] );
    })->setName('login');

    //Display an individual vehicle detail page
    $app->get('/details/{stockId}', function($request, $response, $args) {

        //Faking the database here, but would use this stockId to get all relevant variables.
        $body = [
            'stock' => $args['stockId'],
            'vin' => '5GAERCKW9KJ111448',
            'type' => 'New',
            'price' => '50,085',
            'mileage' => '18',
            'series' => 'Premium FWD',
            'color' => 'RED QUARTZ',
            'transmission' => '9-Speed Automatic',
            'restraints' => 'Air Bags',
            'options' => [
                "3.49 Axle Ratio","18 Painted Aluminum Wheels","7-Passenger Seating",
                "Perforated Leather-Appointed Seat Trim",
                "Radio: Buick Infotainment System AM/FM Stereo"," Memory Package",
                "Power Driver Lumbar Control Seat Adjuster", "Front Bucket Seats",
                "3rd Row 60/40 Power Fold Split-Bench",
                "Power Passenger Lumbar Control Seat Adjuster",
                "Outside Heated Power-Adjustable Mirrors", "Heated Driver & Front Passenger Seats",
                "Heated 2nd Row Outboard Seats", "Automatic Heated Steering Wheel",
                "120-Volt Power Outlet", "Ventilated Driver & Front Passenger Seats"]
        ];

        return $this->view->render( $response, 'details.html', $body);
    })->setName('details');


    //Confirm login credentials
    $app->post('/user/login', function($request, $response, $args) {
        $login = $this->get('Cars\Login');
        $view = $this->view;
        $body = $request->getParsedBody();
        $username = filter_var($body['loginusername'], FILTER_SANITIZE_STRING);
        $password = filter_var($body['loginpassword'], FILTER_SANITIZE_STRING);

        if ($username === false || $password === false) {
            return $view->render(
                $response,
                'login.html',
                ['loginFailed' => true]
            );
        } else if (empty($username) || empty($password)) {
        //Future: display a different message when no password and/or user name is given.
            return $view->render(
                $response,
                'login.html',
                ['loginFailed' => true]
            );
        }

        $confirm = $login->confirmUser($username, $password);

        if ($confirm === false) {
            return $view->render(
                $response,
                'login.html',
                ['loginFailed' => true]
            );
        }

        //return $view->render($response, 'loginSuccess.html', ['username' => $username]);
        return $response->withRedirect('/home');
    });


    $app->run();

} catch (Exception $error) {

    error_log($error);

} finally {
    //Shut down the program if it is successful or not after sending (hopefully) a response.

}
