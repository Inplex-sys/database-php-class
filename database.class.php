<?php
class Database
{
    public $BDD;
    function __construct($mysql_host, $mysql_database, $mysql_username, $mysql_password)
    {
        try
        {
            $this->BDD = new PDO("mysql:unix_socket=" . $mysql_host . ";dbname=" . $mysql_database . ";", $mysql_username, $mysql_password);
        }
        catch(PDOException $e)
        {
            echo 'Failed to connect : ' . $e->getMessage();
        }
    }

    public function Insert($table_name, $data, $filter_enable = true)
    {
        try
        {
            $value_push = [];

            $sql = "INSERT INTO " . $table_name;

            $key_sql = "(";
            $value_sql = "(";

            foreach ($data as $key => $value)
            {
                $key_sql .= $key . ",";
                $value_sql .= "?,";
                if ($filter_enable)
                {
                    array_push($value_push, htmlspecialchars($value));
                } else {
                    array_push($value_push, $value);
                }
            }

            $key_sql = substr($key_sql, 0, -1) . ")";
            $value_sql = substr($value_sql, 0, -1) . ")";

            $sql = $sql . $key_sql . " VALUES " . $value_sql;

            $req = $this
                ->BDD
                ->prepare($sql);
            $req->execute($value_push);
        }
        catch(PDOException $e)
        {
            echo 'Failure during\'insertion : ' . $e->getMessage();
        }
    }

    public function Delete($table_name, $where_check = [])
    {
        try
        {
            $value_push = [];
            $where = "";

            if (count($where_check) != 0)
            {
                $where = " WHERE ";
                foreach ($where_check as $key => $value)
                {
                    $where .= $key . " = ? AND ";
                    array_push($value_push, $value);
                }

                $where = substr($where, 0, -5);
            }

            $sql = "DELETE FROM " . $table_name . $where;

            $req = $this
                ->BDD
                ->prepare($sql);
            $req->execute($value_push);
        }
        catch(PDOException $e)
        {
            echo 'Failed while deleting : ' . $e->getMessage();
        }
    }

    public function DeleteTable($table_name)
    {
        try
        {
            $sql = "TRUNCATE TABLE " . $table_name;
            $this
                ->BDD
                ->exec($sql);
        }
        catch(PDOException $e)
        {
            echo 'Failed to delete the table : ' . $e->getMessage();
        }
    }

    public function GetContent($table_name, $where_check = [] , $custom = "")
    {
        $value_push = [];
        $where = "";

        if (count($where_check) != 0)
        {
            $where = " WHERE ";
            foreach ($where_check as $key => $value)
            {
                $where .= $key . " = ? AND ";
                array_push($value_push, $value);
            }
            $where = substr($where, 0, -5);
        }

        $sql = "SELECT * FROM " . $table_name . $where . " " . $custom;

        $req = $this
            ->BDD
            ->prepare($sql);
        $req->execute($value_push);
        return $req->fetchAll();
    }

    public function Update($table_name, $where_check, $data, $filter_enable = true, $no_commit = false)
    {
        try
        {
            $value_push = [];
            $where = "";

            $sql = "UPDATE " . $table_name . " SET ";

            foreach ($data as $key => $value)
            {
                $sql .= $key . " = ?,";
                if ($filter_enable)
                {
                    array_push($value_push, htmlspecialchars($value));
                }
                else
                {
                    array_push($value_push, $value);
                }
            }

            if (count($where_check) != 0)
            {
                $where = " WHERE ";
                foreach ($where_check as $key => $value)
                {
                    $where .= $key . " = ? AND ";
                    array_push($value_push, $value);
                }

                $where = substr($where, 0, -5);
            }

            $sql = substr($sql, 0, -1);

            $sql = $sql . $where;

            $req = $this
                ->BDD
                ->prepare($sql);
            
            if (!$no_commit)
                $req->execute($value_push);
        }
        catch(PDOException $e)
        {
            echo 'Failure during\'update : ' . $e->getMessage();
        }
    }

    public function Count($table_name, $where_check = [])
    {
        try
        {
            $value_push = [];
            $where = "";

            if (count($where_check) != 0)
            {
                $where = " WHERE ";
                foreach ($where_check as $key => $value)
                {
                    $where .= $key . " = ? AND ";
                    array_push($value_push, $value);
                }
                $where = substr($where, 0, -5);
            }

            $sql = "SELECT * FROM " . $table_name . $where;

            $req = $this
                ->BDD
                ->prepare($sql);
            $req->execute($value_push);

            return $req->rowCount();
        }
        catch(PDOException $e)
        {
            echo 'Failed on account : ' . $e->getMessage();
            return 0;
        }
    }

    public function LastInsertID()
    {
        return $this
            ->BDD
            ->lastInsertId();
    }
}
