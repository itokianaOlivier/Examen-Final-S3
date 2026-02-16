<?php

require_once __DIR__ . '/Model.php';

class TypeBesoin extends Model
{
    protected $table = 'type_besoin';

    public function __construct()
    {
        parent::__construct();
    }

    public function all()
    {
        return $this->findAll('1=1 ORDER BY libelle');
    }
}
