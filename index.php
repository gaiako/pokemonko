<?php
require_once 'vendor/autoload.php';
require_once 'config.php';

include 'home.php';

// Abaixo sistema de rotas SLIM

// // Create and configure Slim app
// $config = ['settings' => [
//     'addContentLengthHeader' => false,
//     'templates.path' => ''
// ]];
// $app = new \Slim\App($config);

//  // Acessar raiz do projeto
// $app->group('(/)', function () use ($app) {

//     $app->get('(/)', function ($request, $response, $args) {
//         // $app->render('/home.php', array('title' => $title));
//         $app->render('/home.php');
//     });

//     $app->group('/app(/)', function (){
//         $app->view->setTemplatesDirectory('app/');

//         $app->group('/jogador(/)', function (){
//             $app->get('(/)', function ($request, $response, $args) {

//             });

//             $app->get('{id}', function ($request, $response, $id) {

//             });

//             $app->post('(/)', function ($request, $response, $args) {

//             });
//         });

//         $app->group('/pokemon(/)', function (){
//             $app->get('(/)', function ($request, $response, $args) {

//             });

//             $app->get('{id}', function ($request, $response, $id) {

//             });

//             $app->post('(/)', function ($request, $response, $args) {

//             });
//         });

//         $app->group('/tipo(/)', function (){
//             $app->get('(/)', function ($request, $response, $args) {

//             });

//             $app->get('{id}', function ($request, $response, $id) {

//             });

//             $app->post('(/)', function ($request, $response, $args) {

//             });
//         });
//     });

// });

// $app->run();