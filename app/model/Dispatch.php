<?php

require_once __DIR__ . '/Model.php';

class Dispatch extends Model
{
    protected $table = 'dispatch';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Assign a donation (quantity or amount) to a need. Performs insert and updates remaining quantity on besoin.
     */
    public function assign($donId, $besoinId, $quantite = null, $montant = null)
    {
        try {
            $this->db->beginTransaction();

            $data = [
                'don_id' => $donId,
                'besoin_id' => $besoinId,
                'quantite_attribuee' => $quantite,
                'montant_attribue' => $montant,
                'date_dispatch' => date('Y-m-d H:i:s'),
            ];

            $cols = [];
            $vals = [];
            foreach ($data as $k => $v) {
                if ($v !== null) {
                    $cols[] = $k;
                    $vals[] = $v;
                }
            }

            $sql = "INSERT INTO dispatch (" . implode(',', $cols) . ") VALUES (" . implode(',', array_fill(0, count($vals), '?')) . ")";
            $stmt = $this->db->prepare($sql);
            $stmt->execute($vals);

            if ($quantite !== null) {
                // decrement besoin.quantite_restante
                $stmt2 = $this->db->prepare('UPDATE besoin SET quantite_restante = GREATEST(0, quantite_restante - ?) WHERE id = ?');
                $stmt2->execute([$quantite, $besoinId]);
            }

            $this->db->commit();
            return $this->db->lastInsertId();
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function listByBesoin($besoinId)
    {
        return $this->findAll('besoin_id = ? ORDER BY date_dispatch DESC', [$besoinId]);
    }
}
