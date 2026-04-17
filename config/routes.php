<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

/*
 * This file is loaded in the context of the `Application` class.
 * So you can use `$this` to reference the application class instance
 * if required.
 */
return function (RouteBuilder $routes): void {
    /*
     * The default class to use for all routes
     *
     * The following route classes are supplied with CakePHP and are appropriate
     * to set as the default:
     *
     * - Route
     * - InflectedRoute
     * - DashedRoute
     *
     * If no call is made to `Router::defaultRouteClass()`, the class used is
     * `Route` (`Cake\Routing\Route\Route`)
     *
     * Note that `Route` does not do any inflections on URLs which will result in
     * inconsistently cased URLs when used with `{plugin}`, `{controller}` and
     * `{action}` markers.
     */
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder): void {
        /*
         * Here, we are connecting '/' (base path) to a controller called 'Pages',
         * its action called 'display', and we pass a param to select the view file
         * to use (in this case, templates/Pages/home.php)...
         */
        $builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
        $builder->connect('/abc', ['controller' => 'Pages', 'action' => 'display', 'abc'], ['_name' => 'abc']);
        $builder->connect('/abcgame', ['controller' => 'Pages', 'action' => 'display', 'abcgame'], ['_name' => 'abcgame']);
        $builder->connect('/papotv', ['controller' => 'Papo', 'action' => 'papotv'], ['_name' => 'papotv']);
        $builder->connect('/papotv/item', ['controller' => 'Papo', 'action' => 'item'], ['_name' => 'papotv_item']);
        $builder->connect('/papotv/image/{fileId}', ['controller' => 'Papo', 'action' => 'image'], ['_name' => 'papotv_image'])->setPass(['fileId']);
        $builder->connect('/papotv/video/{fileId}', ['controller' => 'Papo', 'action' => 'video'], ['_name' => 'papotv_video'])->setPass(['fileId']);
        $builder->connect('/scavenge', ['controller' => 'Scavenger', 'action' => 'index'], ['_name' => 'scavenger_index']);
        $builder->connect('/scavenge/stage9', ['controller' => 'Scavenger', 'action' => 'stage9'], ['_name' => 'scavenger_stage9']);
        $builder->connect('/scavenge/stage_sudoku', ['controller' => 'Scavenger', 'action' => 'stageSudoku'], ['_name' => 'scavenger_stage_sudoku']);
        $builder->connect('/scavenge/stage_einstein', ['controller' => 'Scavenger', 'action' => 'stageEinstein'], ['_name' => 'scavenger_stage_einstein']);
        $builder->connect('/scavenge/stage_pocitanie', ['controller' => 'Scavenger', 'action' => 'stagePocitanie'], ['_name' => 'scavenger_stage_pocitanie']);
        $builder->connect('/scavenge/stage_floppy', ['controller' => 'Scavenger', 'action' => 'stageFloppy'], ['_name' => 'scavenger_stage_floppy']);
        $builder->connect('/scavenge/stage_timebomb', ['controller' => 'Scavenger', 'action' => 'stageTimebomb'], ['_name' => 'scavenger_stage_timebomb']);
        $builder->connect('/scavenge/stage_memory', ['controller' => 'Scavenger', 'action' => 'stageMemory'], ['_name' => 'scavenger_stage_memory']);
        $builder->connect('/scavenge/stage_mastermind', ['controller' => 'Scavenger', 'action' => 'stageMastermind'], ['_name' => 'scavenger_stage_mastermind']);
        $builder->connect('/scavenge/stage_code', ['controller' => 'Scavenger', 'action' => 'stageCode'], ['_name' => 'scavenger_stage_code']);

        /*
         * ...and connect the rest of 'Pages' controller's URLs.
         */
        $builder->connect('/pages/*', 'Pages::display');

        $builder->connect('/tv', ['controller' => 'Monitoring', 'action' => 'index']);
        $builder->connect('/tv/{screen_id}', ['controller' => 'Monitoring', 'action' => 'screen'], ['_name' => 'monitoring_screen'])->setPass(['screen_id']);
        $builder->connect('/tv-app/{screen_id}', ['controller' => 'TvApp', 'action' => 'view'], ['_name' => 'tvapp_view'])->setPass(['screen_id']);
        $builder->connect('/tv-app/{screen_id}/admin/add', ['controller' => 'TvAppAdmin', 'action' => 'add'], ['_name' => 'tvapp_admin_add'])->setPass(['screen_id']);
        $builder->connect('/tv-app/{screen_id}/admin', ['controller' => 'TvAppAdmin', 'action' => 'index'], ['_name' => 'tvapp_admin_index'])->setPass(['screen_id']);

        /*
         * Connect catchall routes for all controllers.
         *
         * The `fallbacks` method is a shortcut for
         *
         * ```
         * $builder->connect('/{controller}', ['action' => 'index']);
         * $builder->connect('/{controller}/{action}/*', []);
         * ```
         *
         * It is NOT recommended to use fallback routes after your initial prototyping phase!
         * See https://book.cakephp.org/5/en/development/routing.html#fallbacks-method for more information
         */
        $builder->fallbacks();
    });

    /*
     * If you need a different set of middleware or none at all,
     * open new scope and define routes there.
     *
     * ```
     * $routes->scope('/api', function (RouteBuilder $builder): void {
     *     // No $builder->applyMiddleware() here.
     *
     *     // Parse specified extensions from URLs
     *     // $builder->setExtensions(['json', 'xml']);
     *
     *     // Connect API actions here.
     * });
     * ```
     */
};
