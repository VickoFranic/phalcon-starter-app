<?php

namespace app;

use Phalcon\Mvc\Application;
use Phalcon\DI\FactoryDefault;
use Phalcon\Session\Adapter\Files as SessionAdapter;

define('APP_ROOT', realpath(__DIR__ . '/..'));

class BandManager {

    /**
     * @var Phalcon\DI\FactoryDefault
     */
    private $di;

    /**
     * @var Phalcon\Mvc\Application
     */
    private $application;

    /**
     * @var Phalcon\Session\Adapter\Files as SessionAdapter
     */
    private $session;

    /**
     * @var Phalcon\Config
     */
    private $config;

    public function __construct()
    {
    	$this->di = new FactoryDefault();
    	$this->loadServices();

    	$this->application = new Application($this->di);
    }

    private function loadServices()
    {
        require APP_ROOT . '/app/config/services.php';
        $this->session = $this->di->get('session');
        $this->config = $this->di->get('config');
    }

    /**
     * Runs basic tables creation script on database
     */
    public function basicDatabase()
    {
        $this->di->get('app.services.migration')->init();
    }

    /**
     * Runs all new migrations from /db/migrations folder
     */
    public function migrate()
    {
        $this->di->get('app.services.migration')->migrate();
    }

	public function run()
	{
		try {
			
			/**
			 * Handle the request
			 */
			echo $this->application->handle()->getContent();

		} catch (\Exception $e) {
            
            $logger = $this->di->get('app.log.error');
            $logger->error('Message: ' . $e->getMessage());
            $logger->error('Error trace: ' . $e->getTraceAsString());
            exit;
        }
	}

}