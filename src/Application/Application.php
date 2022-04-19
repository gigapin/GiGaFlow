<?php
/*
 * This file is part of the GiGaFlow package.
 *
 * (c) Giuseppe Galari <gigaprog@protonmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Src\Application;

use Exception;
use Src\Router\Router;
use Src\Router\RouterFactory;
use Src\Session\Session;
use Src\Session\SessionFactory;

/**
 * Running the application
 *
 * @package Src
 * @author GiGa <gigaprog@protonmail.com>
 * @version 1.0.0
 */
class Application
{
    /**
     * Load all method to running the application.
     *
     * @return self
     * @throws Exception
     */
    public function run(): self
    {
        if (version_compare(PHP_VERSION, $appVersion = Config::$appVersion, '<')) {
            die(sprintf("Your PHP Version is %s, but for running correctly the application is needed the %s version.", PHP_VERSION, $appVersion));
        }
        $this->initSession();
        $this->errorHandling();
        $this->routing();  
        
        return $this;
    }

    /**
     * Handling errors and exceptions
     * 
     * @return void
     */
    private function errorHandling(): void
    {
        error_reporting(E_ALL | E_STRICT);
        set_error_handler('Src\ErrorHandling\Error::errorHandler');
        set_exception_handler('Src\ErrorHandling\Error::exceptionHandler');
    }

    /**
     * Initialized a session
     * @return void
     */
    private function initSession(): void
    {
        SessionFactory::build();
    }

    /**
     * Initialized routing class
     *
     * @throws Exception
     * @return Router
     */
    protected function routing(): Router
    {
        return RouterFactory::build();
    }


}
