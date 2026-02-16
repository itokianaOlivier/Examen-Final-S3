<?php

require_once __DIR__ . '/Model.php';

class Region extends Model
{
    protected $table = 'region';

    public function __construct()
    {
        parent::__construct();
    }

    public function all()
    {
        return $this->findAll('1=1 ORDER BY nom');
    }

    public function withVilles()
    {
        $sql = "SELECT r.id AS region_id, r.nom AS region_nom, v.id AS ville_id, v.nom AS ville_nom
                FROM region r
                LEFT JOIN villes v ON v.region_id = r.id
                ORDER BY r.nom, v.nom";
        return $this->query($sql);
    }
}
