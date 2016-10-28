<?php
/**
 * Mubu - A simple framework for PHP Developers
 *
 * @package  Mubu
 * @author   İzni Burak Demirtaş <izniburak@gmail.com>
 * @web      <http://burakdemirtas.org>
 */

namespace Mubu\Database;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $conn = null;
    private $db_host = null;
    private $db_user = null;
    private $db_pass = null;
    private $db_name = null;
    private $db_type = null;
    private $charset = null;
    private $collation = null;
    private $prefix = null;
    private $db_dsn = null;

    private function __construct() { }

    /**
    * instance of Class.
    *
    * @return instance
    */
    public static function getInstance()
    {
        if (null === self::$instance)
            self::$instance = new static();

        return self::$instance;
    }

    /**
    * Connect to Database. 
    *
    * @return PDO Object | throw PDOException
    */
    public function connect()
    {
        global $config;

        $this->db_host        = ($config['db']['host'] ? $config['db']['host'] : 'localhost');
        $this->db_type        = ($config['db']['driver'] ? $config['db']['driver'] : 'mysql');
        $this->db_name        = $config['db']['database'];
        $this->db_user        = $config['db']['username'];
        $this->db_pass        = $config['db']['password'];
        $this->charset        = ($config['db']['charset'] ? $config['db']['charset'] : 'utf8');
        $this->collation      = ($config['db']['collation'] ? $config['db']['collation'] : 'utf8_general_ci');
        $this->prefix         = $config['db']['prefix'];

        if($this->db_type == '' || $this->db_type == 'mysql' || $this->db_type == 'pgsql')
            $this->db_dsn = $this->db_type.':host='.$this->db_host.';dbname='.$this->db_name;

        elseif($this->db_type == 'sqlite')
        {
            $dbFolder = '';

            if($this->db_name != ':memory:')
            {
                $dbFolder = ROOT . '/storage/database/';
                if(!file_exists($dbFolder . $this->db_name))
                    touch($dbFolder . $this->db_name);
            }

            $this->db_dsn = $this->db_type. ':' . $dbFolder . $this->db_name;
        }

        elseif($this->db_type == 'oracle')
            $this->db_dsn = 'oci:dbname=' . $this->db_host . '/' . $this->db_name;

        try
        {
            $this->conn = new PDO($this->db_dsn, $this->db_user, $this->db_pass);
            $this->conn->exec("SET NAMES '".$this->charset."' COLLATE '".$this->collation."'");
            $this->conn->exec("SET CHARACTER SET '".$this->charset."'");
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

            return $this->conn;
        }
        catch (PDOException $e)
        {
            die($this->error('Can not connect to database with PDO.<br /><br />'.$e->getMessage()));
        }
    }

    /**
    * Get database table prefix. 
    *
    * @return string
    */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
    * Database Error Message. 
    *
    * @return null
    */
    private function error($error)
    {
        $msg = '<h1>Database Error</h1>';
        $msg .= '<h4>Error: <em style="font-weight:normal;">'.$error.'</em></h4>';
        die($msg);
    }

    /**
    * Close to Database connection. 
    *
    * @return string | null
    */
    function __destruct()
    {
        if($this->conn)
            $this->conn = null;
    }
}
