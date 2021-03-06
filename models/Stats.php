<?php

class Stats extends ItemCollector
{
    public function getBestSalle()
    {
        $sql = "SELECT salles.titre AS salleTitre,
                       avis.note    AS avisNote
                FROM salles
                LEFT JOIN avis ON avis.salles_id = salles.id
                WHERE avis.note = (SELECT MAX(note) FROM avis);";

        $result = $this->getItemsCustomSQL($sql);

        if ( empty($result) ) {
            return [];
        } else {
            return $result;
        }
    }

    public function getBestRent()
    {
        $sql = "SELECT salles.titre AS salleTitre,
                       COUNT(*)     AS rentCount
                FROM details_commandes
                INNER JOIN produits ON produits.id = details_commandes.produits_id
                INNER JOIN salles ON salles.id = produits.salles_id
                GROUP BY salles.titre
                ORDER BY rentCount DESC
                LIMIT 1;";

        $result = $this->getItemsCustomSQL($sql);

        if ( empty($result) ) {
            return [];
        } else {
            return $result;
        }
    }

    public function getBestClient()
    {
        $sql = "SELECT m.pseudo AS membrePseudo,
                       COUNT(*) AS rentCount
                FROM commandes AS c
                INNER JOIN membres AS m ON m.id = c.membres_id
                GROUP BY m.pseudo
                ORDER BY rentCount DESC
                LIMIT 1;";

        $result = $this->getItemsCustomSQL($sql);

        if ( empty($result) ) {
            return [];
        } else {
            return $result;
        }
    }

    public function getChiffreAffaire()
    {
        $sql = "SELECT SUM(montant) AS chiffreAffaire FROM commandes;";

        $result = $this->getItemsCustomSQL($sql);

        if ( empty($result) ) {
            return [];
        } else {
            return $result[0];
        }
    }
}
