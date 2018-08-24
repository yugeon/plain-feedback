<?php
/**
 * Created by PhpStorm.
 * User: SYSTEM
 * Date: 24.08.2018
 * Time: 3:17
 */

namespace App\library;


abstract class BaseModel
{
    /**
     * @var \PDO
     */
    static public $pdo;
    protected $config;

    public function __construct()
    {
        if (!static::$pdo) {
            $this->initPdo();
        }
    }

    public function initPdo()
    {
        $config = $this->getConfig()['pdo'];
        $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['database']}";
        static::$pdo = new \PDO($dsn, $config['username'], $config['password']);
    }

    public function getConfig()
    {
        if (!$this->config) {
            $this->config = include(APP_DIR . '/config.php');
        }

        return $this->config;
    }
}