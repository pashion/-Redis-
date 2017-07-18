<?php


  class Model
  {
    protected $pdo;
    public function __construct()
    {
        $dsn = 'mysql:host=127.0.0.1;dbname=cinema;charset=utf8';
        $this->pdo = new PDO($dsn, 'root', '123456');

    }

    public function select($sql, $params=[])
    {
      $stmtObj = $this->pdo->prepare($sql);

      $stmtObj->execute($params);

      return $stmtObj->fetchAll(2);
    }
  }
