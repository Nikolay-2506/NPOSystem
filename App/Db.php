<?php

namespace App;


class Db
{
    protected $dbh;

    public function __construct()
    {
        $config = new Config;
        $this->dbh = new \PDO('mysql:host=' .$config->data['db']['host']. '; 
                                    dbname=' .$config->data['db']['dbname'] ,
            $config->data['db']['user'], $config->data['db']['password']);
    }

    public function query($sql, $params = [], $class = null)
    {
        $sth = $this->dbh->prepare($sql);
        $sth->execute($params);
        if ($class == null){
            $sth->setFetchMode(\PDO::FETCH_ASSOC);
        } else {
            $sth->setFetchMode(\PDO::FETCH_CLASS, $class);
        }
        return $sth->fetchAll();
    }

    public function execute($query, $params=[])
    {
        $sth = $this->dbh->prepare($query);
        return $sth->execute($params);
    }

    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }
}