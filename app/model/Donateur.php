<?php

require_once __DIR__ . '/Model.php';

class Donateur extends Model
{
    protected $table = 'donateurs';

    public function __construct()
    {
        parent::__construct();
    }

    public function createDonateur(array $data)
    {
        return $this->create($data);
    }

    public function findByEmail($email)
    {
        $stmt = $this->db->prepare('SELECT * FROM donateurs WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
}
