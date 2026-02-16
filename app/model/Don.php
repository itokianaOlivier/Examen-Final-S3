<?php

require_once __DIR__ . '/Model.php';

class Don extends Model
{
    protected $table = 'dons';

    public function __construct()
    {
        parent::__construct();
    }

    public function createDon(array $data)
    {
        return $this->create($data);
    }

    public function listAll()
    {
        return $this->findAll('1=1 ORDER BY date_don DESC');
    }

    public function totals()
    {
        $sql = "SELECT
                    SUM(COALESCE(quantite,0)) AS total_quantite,
                    SUM(COALESCE(montant,0)) AS total_montant
                FROM dons";
        $res = $this->query($sql);
        return isset($res[0]) ? $res[0] : ['total_quantite' => 0, 'total_montant' => 0];
    }
}
