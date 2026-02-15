<?php
declare(strict_types=1);

namespace ShareLoop;

use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;

/**
 * ShareLoop plugin
 */
class Plugin extends BasePlugin
{
    /**
     * The name of this plugin
     *
     * @var string
     */
    protected ?string $name = 'ShareLoop';

    /**
     * Enable routes for this plugin
     *
     * @return void
     */
    protected bool $routesEnabled = true;

    /**
     * Enable middleware for this plugin
     *
     * @return void
     */
    protected bool $middlewareEnabled = true;

    /**
     * Console middleware
     *
     * @var bool
     */
    protected bool $consoleEnabled = true;

    /**
     * Bootstrap the plugin
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        parent::bootstrap($app);
    }
}

