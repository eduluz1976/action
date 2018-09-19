<?php
namespace eduluz1976\action;

trait DBAccessible {

    /**
     * @var \PDO
     */
    protected $conn;

    /**
     * @return \PDO
     */
    public function getConn()
    {
        return $this->conn;
    }

    /**
     * @param \PDO $conn
     */
    public function setConn(\PDO $conn)
    {
        $this->conn = $conn;
    }




}