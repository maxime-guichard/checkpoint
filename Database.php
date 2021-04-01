<?php

require_once '../connec.php';

class Database
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new \PDO(DSN, USER, PASS);
    }

    public function read(): array
    {
        $query = 'SELECT * FROM bribe ORDER BY name ASC';
        $statement = $this->pdo->query($query);
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function add(array $form): void
    {
        $query = 'INSERT INTO bribe (name, payment) VALUES (:name, :payment)';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':name', $form['name'], PDO::PARAM_STR);
        $statement->bindValue(':payment', $form['payment'], PDO::PARAM_INT);
        $statement->execute();
    }
}