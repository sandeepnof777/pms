<?php
/**
 * Doctrine 2.4 bootstrap
 *
 */

use Doctrine\Common\ClassLoader,
    Doctrine\ORM\Configuration,
    Doctrine\ORM\EntityManager,
    Doctrine\Common\Cache\ArrayCache,
    Doctrine\DBAL\Logging\EchoSQLLogger;
use Doctrine\ORM\Tools\Setup;

class Doctrine
{

    public $em = null;
    public $queryCacheDriver = null;
    public $resultCacheDriver = null;
    public $metaCacheDriver = null;


    public function __construct()
    {
        // load database configuration from CodeIgniter
        require_once APPPATH . 'config/database.php';

        // load the Doctrine classes
        $doctrineClassLoader = new ClassLoader('Doctrine', APPPATH . 'libraries');
        // or, if installed in third_party:
        // $doctrineClassLoader = new ClassLoader('Doctrine',  APPPATH.'third_party');
        $doctrineClassLoader->register();
        // load the entities
        $entityClassLoader = new ClassLoader('Entities', APPPATH . 'models');
        $entityClassLoader->register();
        // load the proxy entities
        $proxiesClassLoader = new ClassLoader('Proxies', APPPATH . 'models/proxies');
        $proxiesClassLoader->register();

        $entitiesClassLoader = new ClassLoader('models', rtrim(APPPATH, "/"));
        $entitiesClassLoader->register();
        // load Symfony2 classes
        // this is necessary for YAML mapping files and for Command Line Interface (cli-doctrine.php)
        $symfonyClassLoader = new ClassLoader('Symfony', APPPATH . 'libraries/Doctrine');
        $symfonyClassLoader->register();

        // Set up the configuration
        $config = new Configuration;

        // Set up caches
        //if(ENVIRONMENT == 'development'):  // set environment in index.php
        // set up simple array caching for development mode
        //$cache = new \Doctrine\Common\Cache\ArrayCache;
        //else:

        // Set up logger (recommended to remove for production)
        //$logger = new EchoSQLLogger;
        //$config->setSQLLogger($logger);
        //$config->addEntityNamespace('', 'src\entity');
        //$config->setAutoGenerateProxyClasses(True); // only for development




        // Database connection information
        $connectionOptions = array(
            'driver' => 'pdo_mysql',
            'user' => $db['default']['username'],
            'password' => $db['default']['password'],
            'host' => $db['default']['hostname'],
            'dbname' => $db['default']['database'],
            'charset' => $db['default']['char_set']
        );

        $paths = array(APPPATH . 'models');
        $isDevMode = false;

        // Are we generating proxies?
        $generateProxies = (bool) $_ENV['DB_GENERATE_PROXIES'];

        // Meta Cache
        switch ($_ENV['DOCTRINE_META_CACHE_DRIVER']) {
            case 'apc':
                $metaCacheDriver = new \Doctrine\Common\Cache\ApcuCache();
                break;

            case 'redis':
                $metaCacheDriver = new \Doctrine\Common\Cache\PredisCache(new \Predis\Client());
                break;

            default:
                $metaCacheDriver = new \Doctrine\Common\Cache\ArrayCache;
                break;
        }

        $metaCacheDriver->setNamespace($_ENV['DB_CACHE_NAMESPACE']);
        $this->metaCacheDriver = $metaCacheDriver;

        // Query Cache
        switch ($_ENV['DOCTRINE_QUERY_CACHE_DRIVER']) {
            case 'apc':
                $queryCacheDriver = new \Doctrine\Common\Cache\ApcuCache();
                break;

            case 'redis':
                $queryCacheDriver = new \Doctrine\Common\Cache\PredisCache(new \Predis\Client());
                break;

            default:
                $queryCacheDriver = new \Doctrine\Common\Cache\ArrayCache;
                break;
        }

        $queryCacheDriver->setNamespace($_ENV['DB_CACHE_NAMESPACE']);
        $this->queryCacheDriver = $queryCacheDriver;

        // Result Cache
        switch ($_ENV['DOCTRINE_RESULT_CACHE_DRIVER']) {
            case 'apc':
                $resultCacheDriver = new \Doctrine\Common\Cache\ApcuCache();
                break;

            case 'redis':
                $resultCacheDriver = new \Doctrine\Common\Cache\PredisCache(new \Predis\Client());
                break;

            default:
                $resultCacheDriver = new \Doctrine\Common\Cache\ArrayCache;
                break;
        }

        $resultCacheDriver->setNamespace($_ENV['DB_CACHE_NAMESPACE']);
        $this->resultCacheDriver = $resultCacheDriver;

        // Create the Config
        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, $metaCacheDriver, false);

        // Proxy path and namespace configuration
        $config->setProxyDir(APPPATH . '/models/Proxies');
        $config->setProxyNamespace('Proxies');
        $config->setAutoGenerateProxyClasses( $generateProxies);

        // Cache Drivers
        $config->setQueryCacheImpl($queryCacheDriver);
        $config->setResultCacheImpl($resultCacheDriver);

        // Create EntityManager, and store it for use in our CodeIgniter controllers
        $this->em = EntityManager::create($connectionOptions, $config);
    }

    public function deleteSiteAllCache() {

        // Clear meta driver
        if ($this->metaCacheDriver) {
            $this->metaCacheDriver->deleteAll();
        }

        // Clear query driver
        if($this->queryCacheDriver){
            $this->queryCacheDriver->deleteAll();
        }

        // Clear result driver
        if($this->resultCacheDriver){
            $this->resultCacheDriver->deleteAll();
        }
    }
}