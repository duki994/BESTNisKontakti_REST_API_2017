<?php
require_once(__DIR__ . '/../MyErrorHandler.php');
require_once(__DIR__ . '/../../loginData/loginCredentials.php');

/*------------ FILE NAME -------------------- */
define('fileName', basename(__FILE__));

/* ----------- DSN for PDO Object ----------- */
define('dsn', 'mysql:host=' . host . ';dbname=' . db . ';charset=' . charset);


/**
 * Set my custom error handler for this script
 */
set_error_handler('MyErrorHandler::errorLogger');


/**
 * Class MyDBClass - DB access abstraction class
 *
 * @author - Dusan K. <duki994@gmail.com>
 */
class MyDBClass
{
    /**
     * @var PDO - PDO Object
     */
    private $PDO;
    /**
     * @var PDOStatement - prepared statement
     */
    private $stmt;

    /**
     * MyDBClass constructor.
     */
    public function __construct()
    {
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_PERSISTENT => true,
        ];

        try {
            $this->PDO = new PDO(dsn, user, pass, $options);
        } catch (PDOException $e) {
            MyErrorHandler::exceptionLogger($e, fileName);
        }

    }

    /**
     * Makes prepared statement for querying SQL database
     * @param string $query - SQL query string
     */
    public function prepareQuery($query)
    {
        $query = (string)$query;
        try {
            //if not successful returns either false or PDOException depending on error handling method. We use PDOException
            //if successful returns PDOStatement
            $this->stmt = $this->PDO->prepare($query);
        } catch (PDOException $e) {
            MyErrorHandler::exceptionLogger($e, fileName);
        }
    }

    /**
     * @param string $bindParam - placeholder to which we bind value
     * @param string $value - value we want to bind
     */
    public function bind($bindParam, $value)
    {
        $bindParam = (string)$bindParam;
        switch (true) {
            case is_bool($value):
                $type = PDO::PARAM_INT;
                break;
            case is_int($value):
                $type = PDO::PARAM_INT;
                break;
            case is_null($value):
                $type = PDO::PARAM_NULL;
                break;
            default:
                $type = PDO::PARAM_STR;
        }

        if (isset($this->stmt) && $this->stmt instanceof PDOStatement) {
            $this->stmt->bindValue($bindParam, $value, $type) == false
            && MyErrorHandler::exceptionLogger("bind method, bindValue() failure. data: \n" . $bindParam .
                "\n" . $value . "\n" . $type . "\n", fileName);
        } else {
            $msg = 'bind() method: $this->stmt not set or not instance of PDOStatement. Probably calling before prepareQuery() method';
            MyErrorHandler::exceptionLogger($msg, fileName);
        }
    }

    /**
     * @return array - returns fetched associative array from database
     */
    public function resultAssoc()
    {
        /* default fetch mode is PDO::FETCH_ASSOC so no need to set explicitly */
        $this->execute();
        return (array)$this->stmt->fetchAll();
    }

    /**
     * @return bool - returns if operation successful. TRUE for success, false for failure
     */
    public function execute()
    {
        $ret = (bool)$this->stmt->execute();
        $ret == false && MyErrorHandler::exceptionLogger('execute(): error executing', fileName);
        return $ret;
    }

    /**
     * @return mixed - returns false if failure
     */
    public function singleRecord()
    {
        $this->execute();
        $ret = $this->stmt->fetch();
        $ret == false && MyErrorHandler::exceptionLogger('singleRecord(): error fetching single record', fileName);
        return $ret;
    }

    /**
     * @return mixed
     */
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    /**
     * @return string
     */
    public function lastInsertId()
    {
        return (string)$this->PDO->lastInsertId();
    }


    /* -------------------------------- TRANSACTION METHODS -- START -------------------------------- */
    /**
     * @return bool - returns if operation successful. TRUE for success, false for failure
     */
    public function beginTransaction()
    {
        $ret = (bool)$this->PDO->beginTransaction();
        $ret == false && MyErrorHandler::exceptionLogger('beginTransaction() error', fileName);
        return (bool)$ret;
    }

    /**
     * @return bool - returns if operation successful. TRUE for success, false for failure
     */
    public function endTransaction()
    {
        $ret = (bool)$this->PDO->commit();
        $ret == false && MyErrorHandler::exceptionLogger('endTransaction() error', fileName);
        return (bool)$ret;
    }

    /**
     * @return bool - returns if operation successful. TRUE for success, false for failure
     */
    public function cancelTransaction()
    {
        $ret = (bool)$this->PDO->rollBack();
        $ret == false && MyErrorHandler::exceptionLogger('cancelTransaction() error', fileName);
        return (bool)$ret;
    }
    /* -------------------------------- TRANSACTION METHODS -- END ---------------------------------- */

    /**
     * @return bool - no return here. read PDO documentation for more.
     * @link http://php.net/manual/en/pdostatement.debugdumpparams.php
     */
    public function debugDumpParams()
    {
        return $this->stmt->debugDumpParams();
    }


}