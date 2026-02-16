<?php

require_once __DIR__ . '/Model.php';

class Besoin extends Model
{
    protected $table = 'besoin';

    public function __construct()
    {
        parent::__construct();
    }

    public function createNeed(array $data)
    {
        return $this->create($data);
    }

    public function listByVille($villeId)
    {
        return $this->findAll('ville_id = ? ORDER BY date_creation DESC', [$villeId]);
    }

    public function totalNeededByVille()
    {
        $sql = "SELECT v.id AS ville_id, v.nom AS ville_nom, COALESCE(SUM(b.prix_unitaire * b.quantite),0) AS total_needed
                FROM villes v
                LEFT JOIN besoin b ON b.ville_id = v.id
                GROUP BY v.id, v.nom";
        return $this->query($sql);
    }

    public function decrementRemaining($besoinId, $qty)
    {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare('UPDATE besoin SET quantite_restante = GREATEST(0, quantite_restante - ?) WHERE id = ?');
            $stmt->execute([$qty, $besoinId]);
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
