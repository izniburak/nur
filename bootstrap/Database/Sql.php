<?php
/**
 * Mubu - A simple framework for PHP Developers
 *
 * @package  Mubu
 * @author   İzni Burak Demirtaş <izniburak@gmail.com>
 * @web      <http://burakdemirtas.org>
 */

namespace Mubu\Database;

use Mubu\Database\Database;
use PDO;

class Sql
{
    private static $instance;

    public static $pdo = null;
    private static $db = null;
    private static $select = '*';
    private static $from = null;
    private static $where = null;
    private static $limit = null;
    private static $join = null;
    private static $orderBy = null;
    private static $groupBy = null;
    private static $having = null;
    private static $num_rows = 0;
    private static $insert_id = null;
    private static $query = null;
    private static $error = null;
    private static $cache = null;
    private static $result = [];
    private static $prefix = null;
    private static $grouped = false;
    private static $op = ['=','!=','<','>','<=','>=','<>'];
    private static $queryCount = 0;

    public function __construct() {}

    public static function getInstance()
    {
        if (null === self::$instance)
        {
            self::$instance = new static();
            self::$db = Database::getInstance();
            self::$pdo = self::$db->connect();
            self::$prefix = self::$db->getPrefix();
        }

        return self::$instance;
    }

    public static function table($from)
    {
        self::instanceControl();

        if(is_array($from))
        {
            $f = '';
            foreach($from as $key)
                $f .= self::$prefix . $key . ', ';

            self::$from = rtrim($f, ', ');
        }
        else
            self::$from = self::$prefix . $from;

        return new self;
    }

    public static function select($fields)
    {
        $select = trim(is_array($fields) ? implode(", ", $fields) : $fields);
        if($select == '')
            self::$select = $select = '*';
        self::$select = (self::$select == '*' ? $select : self::$select . ", " . $select);

        return new self;
    }

    public static function max($field, $name = null)
  {
    $func = "MAX(" . $field . ")" . (!is_null($name) ? " AS " . $name : "");
    self::$select = (self::$select == '*' ? $func : self::$select . ", " . $func);

        return new self;
  }

    public static function min($field, $name = null)
  {
    $func = "MIN(" . $field . ")" . (!is_null($name) ? " AS " . $name : "");
    self::$select = (self::$select == '*' ? $func : self::$select . ", " . $func);

        return new self;
  }

    public static function sum($field, $name = null)
  {
    $func = "SUM(" . $field . ")" . (!is_null($name) ? " AS " . $name : "");
    self::$select = (self::$select == '*' ? $func : self::$select . ", " . $func);

        return new self;
  }

    public static function count($field, $name = null)
  {
    $func = "COUNT(" . $field . ")" . (!is_null($name) ? " AS " . $name : "");
    self::$select = (self::$select == '*' ? $func : self::$select . ", " . $func);

        return new self;
  }

    public static function avg($field, $name = null)
  {
    $func = "AVG(" . $field . ")" . (!is_null($name) ? " AS " . $name : "");
    self::$select = (self::$select == '*' ? $func : self::$select . ", " . $func);

        return new self;
  }

    public static function join($table, $field1 = null, $op = null, $field2 = null, $type = '')
    {
        $on = $field1;
        $table = self::$prefix . $table;

        if(!is_null($op))
            $on = (!in_array($op, self::$op) ?
                self::$prefix . $field1 . ' = ' . self::$prefix . $op :
                self::$prefix . $field1 . ' ' . $op . ' ' . self::$prefix . $field2
            );

        if (is_null(self::$join))
            self::$join = " " . $type . "JOIN" . " " . $table . " ON " . $on;
        else
            self::$join = self::$join . " " . $type . "JOIN" . " " . $table . " ON " . $on;

        return new self;
    }

    public static function innerJoin($table, $field1, $op = null, $field2 = null)
    {
        self::join($table, $field1, $op, $field2, 'INNER ');
        return new self;
    }

    public static function leftJoin($table, $field1, $op = null, $field2 = null)
    {
        self::join($table, $field1, $op, $field2, 'LEFT ');
        return new self;
    }

    public static function rightJoin($table, $field1, $op = null, $field2 = null)
    {
        self::join($table, $field1, $op, $field2, 'RIGHT ');
        return new self;
    }

    public static function fullOuterJoin($table, $field1, $op = null, $field2 = null)
  {
    $this->join($table, $field1, $op, $field2, 'FULL OUTER ');

    return $this;
  }

  public static function leftOuterJoin($table, $field1, $op = null, $field2 = null)
  {
    $this->join($table, $field1, $op, $field2, 'LEFT OUTER ');

    return $this;
  }

  public static function rightOuterJoin($table, $field1, $op = null, $field2 = null)
  {
    $this->join($table, $field1, $op, $field2, 'RIGHT OUTER ');

    return $this;
  }

    public static function where($where, $op = null, $val = null, $type = '', $and_or = 'AND')
    {
        if (is_array($where))
        {
            $_where = [];
            foreach ($where as $column => $data)
                $_where[] = $type . $column . ' = ' . self::escape($data);

            $where = implode(' '.$and_or.' ', $_where);
        }
        else
        {
            if(is_array($op))
            {
                $x = explode('?', $where);
                $w = '';
                foreach($x as $k => $v)
                    if(!empty($v))
                        $w .= $type . $v . (isset($op[$k]) ? self::escape($op[$k]) : '');

                $where = $w;
            }
            elseif(!is_null($op))
            {
                if (!in_array($op, self::$op) || $op == false)
                    $where = $type . $where . ' = ' . self::escape($op);
                else
                    $where = $type . $where . ' ' . $op . ' ' . self::escape($val);
            }
        }

        if(self::$grouped)
        {
            $where = '(' . $where;
            self::$grouped = false;
        }

        if (is_null(self::$where))
            self::$where = $where;
        else
            self::$where = self::$where . ' '.$and_or.' ' . $where;

        return new self;
    }

    public static function orWhere($where, $op=null, $val=null)
    {
        self::where($where, $op, $val, '', 'OR');
        return new self;
    }

    public static function notWhere($where, $op = null, $val = null)
  {
    self::where($where, $op, $val, 'NOT ', 'AND');
    return new self;
  }

  public static function orNotWhere($where, $op = null, $val = null)
  {
        self::where($where, $op, $val, 'NOT ', 'OR');
    return new self;
  }

    public static function grouped($obj)
    {
        self::$grouped = true;
        call_user_func_array($obj, [new self]);
        self::$where .= ')';

        return new self;
    }

    public static function in($field, $keys, $type = '', $and_or = 'AND')
    {
        if (is_array($keys))
        {
            $_keys = [];
            foreach ($keys as $k => $v)
                $_keys[] = (is_numeric($v) ? $v : self::escape($v));

            $keys = implode(', ', $_keys);

            if (is_null(self::$where))
                self::$where = $field . ' ' . $type . 'IN (' . $keys . ')';
            else
                self::$where = self::$where . ' ' . $and_or . ' ' . $field . ' '.$type.'IN (' . $keys . ')';
        }
        return new self;
    }

    public static function notIn($field, $keys)
    {
        self::in($field, $keys, 'NOT ', 'AND');
        return new self;
    }

    public static function orIn($field, $keys)
    {
        self::in($field, $keys, '', 'OR');
        return new self;
    }

    public static function orNotIn($field, $keys)
    {
        self::in($field, $keys, 'NOT ', 'OR');
        return new self;
    }

    public static function between($field, $value1, $value2, $type = '', $and_or = 'AND')
    {
        if (is_null(self::$where))
            self::$where = $field . ' ' . $type . 'BETWEEN ' . self::escape($value1) . ' AND ' . self::escape($value2);
        else
            self::$where = self::$where . ' ' . $and_or . ' ' . $field . ' ' . $type . 'BETWEEN ' . self::escape($value1) . ' AND ' . self::escape($value2);

        return new self;
    }

    public static function notBetween($field, $value1, $value2)
    {
        self::between($field, $value1, $value2, 'NOT ', 'AND');
        return new self;
    }

    public static function orBetween($field, $value1, $value2)
    {
        self::between($field, $value1, $value2, '', 'OR');
        return new self;
    }

    public static function orNotBetween($field, $value1, $value2)
    {
        self::between($field, $value1, $value2, 'NOT ', 'OR');
        return new self;
    }

    public static function like($field, $data, $type = '', $and_or = 'AND')
    {
        $like = self::escape($data);

        if (is_null(self::$where))
            self::$where = $field . ' ' . $type . ' LIKE ' . $like;
        else
            self::$where = self::$where . ' '.$and_or.' ' . $field . ' ' . $type . ' LIKE ' . $like;

        return new self;
    }

    public static function orLike($field, $data)
    {
        self::like($field, $data, '', 'OR');
        return new self;
    }

    public static function notLike($field, $data)
    {
        self::like($field, $data, 'NOT ', 'AND');
        return new self;
    }

    public static function orNotLike($field, $data)
    {
        self::like($field, $data, 'NOT ', 'OR');
        return new self;
    }

    public static function limit($limit, $limitEnd = null)
    {
        if (!is_null($limitEnd))
            self::$limit = $limit . ', ' . $limitEnd;
        else
            self::$limit = $limit;

        return new self;
    }

    public static function orderBy($orderBy, $orderDir = null)
    {
        if (!is_null($orderDir))
            self::$orderBy = $orderBy . ' ' . strtoupper($orderDir);
        else
        {
            if(stristr($orderBy, ' ') || $orderBy == 'rand()')
                self::$orderBy = $orderBy;
            else
                self::$orderBy = $orderBy . ' ASC';
        }

        return new self;
    }

    public static function groupBy($groupBy)
    {
        if(is_array($groupBy))
            self::$groupBy = implode(', ', $groupBy);
        else
            self::$groupBy = $groupBy;

        return new self;
    }

    public static function having($field, $op = null, $val = null)
    {
        if(is_array($op))
        {
            $x = explode('?', $field);
            $w = '';
            foreach($x as $k => $v)
                if(!empty($v))
                    $w .= $v . (isset($op[$k]) ? self::escape($op[$k]) : '');

            self::$having = $w;
        }
        elseif (!in_array($op, self::$op))
            self::$having = $field . ' > ' . self::escape($op);
        else
            self::$having = $field . ' ' . $op . ' ' . self::escape($val);

        return new self;
    }

    public static function numRows()
    {
        return self::$num_rows;
    }

    public static function insertId()
    {
        return self::$insert_id;
    }

    public static function error()
    {
        $msg = '<h1>Database Error</h1>
        <h4>Query: <em style="font-weight:normal;">" '.self::$query.' "</em></h4>
        <h4>Error: <em style="font-weight:normal;">'.self::$error.'</em></h4>';
        die($msg);
    }

    public static function get($type = false)
    {
        self::$limit = 1;
        $query = self::getAll(true);

        if($type == true)
            return $query;
        else
            return self::query( $query, false, (($type == 'array') ? true : false) );
    }

    public static function getAll($type = false)
    {
        $query = "SELECT " . self::$select . " FROM " . self::$from;

        if (!is_null(self::$join)) $query .= self::$join;
        if (!is_null(self::$where)) $query .= ' WHERE ' . self::$where;
        if (!is_null(self::$groupBy)) $query .= ' GROUP BY ' . self::$groupBy;
        if (!is_null(self::$having)) $query .= ' HAVING ' . self::$having;
        if (!is_null(self::$orderBy)) $query .= ' ORDER BY ' . self::$orderBy;
        if (!is_null(self::$limit)) $query .= ' LIMIT ' . self::$limit;

        if($type == true)
            return $query;
        else
            return self::query( $query, true, (($type == 'array') ? true : false) );
    }

    public static function insert($data, $print = false)
    {
        if (is_array($data))
        {
            $columns = array_keys($data);
            $column = implode(', ', $columns);
            $val = implode(", ", array_map([new self, 'escape'], $data));
        }
        else
            return false;

        $query = 'INSERT INTO ' . self::$from . ' (' . $column . ') VALUES (' . $val . ')';

        if ($print == true)
            return $query;
        else
        {
            $query = self::query($query);
            if ($query)
            {
                self::$insert_id = self::$pdo->lastInsertId();
                return self::insertId();
            }

            return false;
        }
    }

    public static function update($data, $print = false)
    {
        $query = "UPDATE " . self::$from . " SET ";

        if (is_array($data))
        {
            $values = [];
            foreach ($data as $column => $val)
                $values[] = $column . ' = ' . self::escape($val);

            $query .= implode(', ', $values);
        }
        else
            return false;

        if (!is_null(self::$where)) $query .= ' WHERE ' . self::$where;
        if (!is_null(self::$orderBy)) $query .= ' ORDER BY ' . self::$orderBy;
        if (!is_null(self::$limit)) $query .= ' LIMIT ' . self::$limit;

        return ($print == true) ? $query : self::query($query);
    }

    public static function delete($print = false)
    {
        $query = "DELETE FROM " . self::$from;

        if (!is_null(self::$where))
            $query .= ' WHERE ' . self::$where;

        if (!is_null(self::$orderBy))
            $query .= ' ORDER BY ' . self::$orderBy;

        if (!is_null(self::$limit))
            $query .= ' LIMIT ' . self::$limit;

        if($query == "DELETE FROM " . self::$from)
            $query = 'TRUNCATE TABLE ' . self::$from;

        return ($print == true) ? $query : self::query($query);
    }

    public static function query($query, $all = true, $array = false)
    {
        self::instanceControl();
        self::reset();

        if(is_array($all))
        {
            $x = explode('?', $query);
            $q = '';
            foreach($x as $k => $v)
                if(!empty($v))
                    $q .= $v . (isset($all[$k]) ? self::escape($all[$k]) : '');

            $query = $q;
        }

        $query = preg_replace('/\s\s+|\t\t+/', ' ', trim($query));
        self::$query =  $query;

        $str = stristr(self::$query, 'SELECT');

        $cache = self::readCache(self::$query);

        if (!$cache && $str)
        {
            $sql = self::$pdo->query(self::$query);
            if($sql)
            {
                self::$num_rows = $sql->rowCount();
                if ((self::$num_rows > 0))
                {
                    if ($all)
                    {
                        $q = [];
                        while ($result = ($array == false) ? $sql->fetchAll(PDO::FETCH_OBJ) : $sql->fetchAll(PDO::FETCH_ASSOC))
                            $q[] = $result;

                        self::$result =  $q[0];
                    }
                    else
                    {
                        $q = ($array == false) ? $sql->fetch(PDO::FETCH_OBJ) : $sql->fetch(PDO::FETCH_ASSOC);
                        self::$result = $q;
                    }
                }

                if (!is_null(self::$cache)) self::saveCache(self::$query, self::$result);
                self::$cache = null;
            }
            else
            {
                self::$cache = null;
                self::$error = self::$pdo->errorInfo();
                self::$error = self::$error[2];
                return self::error();
            }
        }
        elseif((!$cache && !$str) || ($cache && !$str))
        {
            self::$cache = null;
            self::$result = self::$pdo->query(self::$query);
            if(!self::$result)
            {
                self::$error = self::$pdo->errorInfo();
                self::$error = self::$error[2];
                return self::error();
            }
        }
        else
        {
            self::$cache = null;
            self::$result = $cache;
        }

        self::$queryCount++;

        return self::$result;
    }

    public static function pager($type = false)
    {
        $recordsSql = self::getAll(true);
        self::$limit = null;
        $totalSql = self::getAll(true);
        $totalQuery = self::query($totalSql);

        return [
            'total'   => self::count(),
            'records' => self::query($recordsSql, true, $type)
        ];
    }

    public static function cache($cache = 0)
    {
        self::$cache = $cache;
        return new self;
    }

    private static function saveCache($sql, $result)
    {
        if (is_null(self::$cache)) return false;

        $name = md5($sql);
        $finish = time() + (self::$cache);
        $file = realpath(__DIR__ . '/../../storage/cache/sql/' . $name . '.cache');
        $file = fopen($file, 'w');

        if($file)
            fputs($file, serialize(['data' => $result, 'finish' => $finish]));
    }

    private static function readCache($sql)
    {
        if (is_null(self::$cache)) return false;

        $name = md5($sql);
        $file = realpath(__DIR__ . '/../../storage/cache/sql/' . $name . '.cache');

        if (file_exists($file))
        {
            $cache = unserialize(file_get_contents($file));
            if ($cache['finish'] < time())
            {
                unlink($file);
                return;
            }
            else
                return $cache['data'];
        }

        return false;
    }

    public static function reset()
    {
        self::$select = '*';
        self::$where = null;
        self::$limit = null;
        self::$orderBy = null;
        self::$groupBy = null;
        self::$having = null;
        self::$join = null;
        self::$num_rows = 0;
        self::$insert_id = null;
        self::$query = null;
        self::$error = null;
        self::$result = [];
        self::$grouped = false;
    }

    public static function escape($data)
    {
        if(is_null($data))
            return null;

        return self::$pdo->quote(trim($data));
    }

    private static function instanceControl()
    {
        if(is_null(self::$instance)) self::getInstance();
    }

    function __destruct()
    {
        self::$db = null;
    }
}
