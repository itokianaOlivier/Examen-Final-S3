<?php

require_once __DIR__ . '/Model.php';

class Ville extends Model
{
    protected $table = 'villes';

    public function __construct()
    {
        parent::__construct();
    }

    public function all()
    {
        return $this->findAll('1=1 ORDER BY nom');
    }

    public function findByRegion($regionId)
    {
        return $this->findAll('region_id = ?', [$regionId]);
    }
}
