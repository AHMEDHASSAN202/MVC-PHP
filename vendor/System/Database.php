<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 * Date: 7/13/2017
 * Time: 11:45 PM
 */

namespace System;

use PDO;
use PDOException;
use PDOStatement;
use PDORow;

class Database
{
    /**
     * Application Class
     *
     * @var $app
     */
    private $app;

    /**
     * Store PDO Object Connection
     *
     * @var \stdClass
     */
    private static $connection;

    /**
     * Store Table Name
     *
     * @var string
     */
    private $tableName;

    /**
     * Data Container
     *
     * @var array
     */
    private $data = [];

    /**
     * Select Statement Container
     *
     * @var array
     */
    private $select = [];

    /**
     * Bindings Container
     *
     * @var array
     */
    private $bindings = [];

    /**
     * Conditions Container
     *
     * @var array
     */
    private $wheres = [];

    /**
     * Having Keyword Container
     *
     * @var array
     */
    private $having = [];

    /**
     * Container Group by
     *
     * @var array
     */
    private $groupBy = [];

    /**
     * Container Joins
     *
     * @var array
     */
    private $joins = [];

    /**
     * Order by Container
     *
     * @var array
     */
    private $orderBy = [];

    /**
     * Store Last ID
     *
     * @var int
     */
    private $lastInsertID;

    /**
     * Store Limit
     *
     * @var int
     */
    private $limit;

    /**
     * Store Offset
     *
     * @var int
     */
    private $offset;

    /**
     * On Statement
     *
     * @var string
     */
    private $on;

    /**
     * Store another Table name
     *
     * @var string
     */
    private $table2;

    /**
     * Store rows
     *
     * @var int
     */
    private $rows;


    public function __construct(App $app)
    {
        $this->app = $app;

        if (! $this->isConnected()) {
            self::connect();
        }
    }

    /**
     * Connect With Database
     *
     * @return mixed
     */
    private static function connect()
    {
        $dbHost   = Config::get('database/host');
        $dbName   = Config::get('database/name');
        $username = Config::get('database/username');
        $password = Config::get('database/password');

        try {

            self::$connection = new PDO(sprintf('mysql:dbhost=%s;dbname=%s;' , $dbHost , $dbName) , $username , $password);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
            self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_OBJ);
            self::$connection->exec('SET NAMES utf8');

        }catch (PDOException $error) {

            die($error->getMessage());

        }
    }

    /**
     * Check If There Connection With database
     *
     * @return bool
     */
    private function isConnected()
    {
        return self::$connection instanceof PDO;
    }

    /**
     * Set Table Name
     *
     * @param $table
     * @return $this
     */
    public function table($table)
    {
        $this->tableName = $table;

        return $this;
    }

    /**
     * Set Table Name
     *
     * @param $table
     * @return $this
     */
    public function from($table)
    {
        $this->tableName = $table;

        return $this;
    }

    /**
     * Set Data
     *
     * @param $column
     * @param null $value
     * @return $this
     */
    public function data($column , $value = null)
    {
        if (is_array($column)) {

            $this->data = array_merge($this->data , $column);

            $this->bindings($this->data);

        }else {

            $this->data[$column] = $value;
        }

        return $this;
    }

    /**
     * Add The Given Value to bindings array
     *
     * @param $value
     * @return $this
     */
    public function bindings($value)
    {
        if (is_array($value)) {

            $this->bindings = array_merge($this->bindings , array_values($value));

        }else {

            $this->bindings[] = escape_tags_html($value);
        }

        return $this;
    }

    /**
     * Query Is Execute The Given Statement
     *
     * @return $this
     */
    public function query()
    {
        $arguments = func_get_args();

        $sql = array_shift($arguments);

        if (count($arguments) == 1) {

            $arguments = $arguments[0];

        }

        $query = self::$connection->prepare($sql);

        foreach ($arguments as $key => $value) {

            $query->bindValue(++$key , $value);

        }

        if (!$query->execute()) {
            die('error is execute this query ' . $sql);
        }

        return $query;
    }

    /**
     * Insert Data To Database
     *
     * @param null $table
     * @return $this
     */
    public function insert($table = null)
    {

        if ($table) { $this->tableName = $table; }

        $sql = sprintf('INSERT INTO `%s` SET ' , $this->tableName);

        foreach ($this->data as $key => $value) {

            $sql .= sprintf('`%s` = ?, ' , $key);

        }

        $sql = rtrim($sql , ', ');

        $this->query($sql , $this->bindings);

        $this->lastInsertID = self::$connection->lastInsertId();

        $this->resat();

        return $this;
    }

    /**
     * Get Last Insert ID
     *
     * @return int
     */
    public function lastInsertId()
    {
        return $this->lastInsertID;
    }

    /**
     * Add a New where [condition]
     *
     * @return $this
     */
    public function where()
    {
        $arguments = func_get_args();

        $sql = array_shift($arguments);

        $this->bindings($arguments);

        $this->wheres[] = $sql;

        return $this;
    }

    /**
     * Add a New groupBy Statement
     *
     * @return $this
     */
    public function groupBy()
    {
        $arguments = func_get_args();

        $sql = array_shift($arguments);

        $this->bindings($arguments);

        $this->groupBy[] = $sql;

        return $this;
    }

    /**
     * Add a New having Statement
     *
     * @return $this
     */
    public function having()
    {
        $arguments = func_get_args();

        $sql = array_shift($arguments);

        $this->bindings($arguments);

        $this->having[] = $sql;

        return $this;
    }

    /**
     * Update Data
     *
     * @param null $table
     * @return $this
     */
    public function update($table = null)
    {
        if ($table) { $this->tableName = $table; }

        $sql = sprintf('UPDATE `%s` SET ' , $this->tableName);

        foreach ($this->data as $key => $value) {

            $sql .= sprintf('`%s` = ?, ' , $key);
        }

        $sql = rtrim($sql , ', ');

        if (!empty($this->wheres)) {

            $sql .= ' WHERE ' . implode(' ' , $this->wheres);

        }

        $this->query($sql , $this->bindings);

        $this->resat();

        return $this;
    }


    /*================= SELECT STATEMENT =================*/
    // SELECT COLUMN(*) FROM name_table1
    // [type join] JOIN name_table2 ON[number]
    // WHERE[number] LIMIT [number] OFFSET[number] ORDER BY[ASC|DESC]

    /**
     * Select Statement
     *
     * @return $this
     */
    public function select()
    {
        $this->select[] = implode(' , ' , func_get_args());

        return $this;
    }

    /**
     * Set Join Statement
     *
     * @param $join
     * @return $this
     */
    public function join($join)
    {
        $this->joins[] = $join;

        return $this;
    }

    /**
     * Set Order by Statement
     *
     * @param $column
     * @param string $sort
     * @return $this
     */
    public function orderBy($column , $sort = 'ASC')
    {
        $this->orderBy = [$column , $sort];

        return $this;
    }

    /**
     * Set Limit
     *
     * @param $limit
     * @param int $offset
     * @return $this
     */
    public function limit($limit , $offset = 0)
    {
        $this->limit = $limit;

        $this->offset = $offset;

        return $this;
    }

    /**
     * Set Another Table
     *
     * @param $table
     * @return $this
     */
    public function table2($table)
    {
        $this->table2 = $table;

        return $this;
    }

    /**
     * Set On Condition
     *
     * @param $condition
     * @return $this
     */
    public function on($condition)
    {
        $this->on = $condition;

        return $this;
    }

    /**
     * Generate Fetch Statement
     * SELECT COLUMN(*) FROM name_table1 [type join] JOIN name_table2 ON[number] WHERE[number]
     * LIMIT [number] OFFSET[number] ORDER BY[ASC|DESC
     *
     * @return string
     */
    private function fetchStatement()
    {

        $sql = 'SELECT ';

        if ($this->select) {

            $sql .= sprintf('%s' , implode(' , ' , $this->select));

        }else {

            $sql .= '*';

        }

        if ($this->tableName) {

            $sql .= sprintf(' FROM `%s`' , $this->tableName);

        }

        if ($this->joins) {

            $sql .= sprintf(' %s' , implode(' ' , $this->joins));

        }

        if ($this->on) {

            $sql .= sprintf(' ON %s' , $this->on);

        }

        if ($this->wheres) {

            $sql .= sprintf(' WHERE %s' , implode(' ' , $this->wheres));

        }

        if ($this->groupBy) {

            $sql .= sprintf(' GROUP BY %s' , implode(' , ' , $this->groupBy));

        }

        if ($this->having) {

            $sql .= sprintf(' HAVING %s' , implode(' ' , $this->having));

        }

        if ($this->orderBy) {

            $sql .= sprintf(' ORDER BY %s' , implode(' ' , $this->orderBy));

        }

        if ($this->limit) {

            $sql .= sprintf(' LIMIT %d' , $this->limit);

        }

        if ($this->offset) {

            $sql .= sprintf(' OFFSET %d' , $this->offset);

        }

        $sql .= ' ;';

        return $sql;
    }

    /**
     * Fetch Statement
     *
     * @param null $table
     * @return mixed
     */
    public function fetch($table = null)
    {
        if ($table) { $this->tableName = $table; }

        $sql = $this->fetchStatement();

        $query = $this->query($sql , $this->bindings);

        $result = $query->fetch();

        $this->rows = $query->rowCount();

        $this->resat();

        return $result;
    }

    /**
     * Fetch All Statement
     *
     * @param $table
     * @return mixed
     */
    public function fetchAll($table)
    {
        if ($table) { $this->tableName = $table; }

        $sql = $this->fetchStatement();

        $query = $this->query($sql , $this->bindings);

        $result = $query->fetchAll();

        $this->rows = $query->rowCount();

        $this->resat();

        return $result;
    }

    /**
     * Get Rows Affected by The Last SQL Statement
     *
     * @return int
     */
    public function count()
    {
        return $this->rows;
    }

    /**
     * DELETE Date From Database
     *
     * @param $table
     * @return $this
     */
    public function delete($table)
    {
        if ($table) { $this->tableName = $table; }

        $sql = sprintf('DELETE FROM `%s`' , $this->tableName);

        if ($this->wheres) {

            $sql .= sprintf(' WHERE %s' , implode(' ' , $this->wheres));

        }

        $query  = $this->query($sql , $this->bindings);

        $this->rows = $query->rowCount();

        $this->resat();

        return $this;
    }

    /**
     * Resat Stored Properties
     *
     * @return mixed
     */
    private function resat()
    {
        $this->tableName = null;
        $this->data = [];
        $this->select = [];
        $this->bindings = [];
        $this->wheres = [];
        $this->groupBy = [];
        $this->having = [];
        $this->joins = [];
        $this->orderBy = [];
        $this->limit = null;
        $this->offset = null;
        $this->on = null;
        $this->table2 = null;
    }

    /**
     * data [] ;
     * bindings [];
     * set data with function data($key , Value)
     * set data with function bindings($key , Value)
     * data[$column1] = $value1
     * data[$column2] = $value2
     * binding[0] = $value1
     * binding[1] = $value2
     * $sql = INSERT INTO users SET $column1 = ? , $column2 = ? ;
     * query($sql , bindings);
     * For each Loop On bindings Array
     * foreach(bindings as key => value) {
     *      bindParam($key+1 , value);
     * }
     *
     * $sql = INSERT INTO users SET $column1 = $value1 , $column2 = $value2;
     *
     */
}