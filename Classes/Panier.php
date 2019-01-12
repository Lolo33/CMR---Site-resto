<?php

/**
 * Created by PhpStorm.
 * User: Niquelesstup
 * Date: 03/10/2018
 * Time: 20:21
 */
class Panier
{

    private $listeProduits = array();
    private $prixTotal = 0;

    function __construct(){}

    public function ajouterProduitListe(Produit $produit) {
        $this->listeProduits[] = $produit;
        $this->prixTotal += $produit->getPrix();
    }

    public function ajouterListeProduit(Produit $produit){
        $produitExiste = false;
        $nbOptionsProduitPanier = count($produit->getOptions());
        $nbOptionsCorrect = 0;
        foreach ($this->listeProduits as $k => $produitInListe) {
            if ($produitInListe->getId() == $produit->getId()) {
                $produitExiste = true;
                foreach ($produitInListe->getOptions() as $optionProdInListe){
                    foreach ($produit->getOptions() as $optionProd) {
                        if ($optionProdInListe == $optionProd)
                            $nbOptionsCorrect++;
                    }
                }
            }
            if ($produitExiste && $nbOptionsProduitPanier == $nbOptionsCorrect) {
                $this->listeProduits[$k]->setQuantite($produitInListe->getQuantite() + 1);
                break;
            }
        }
        if (!$produitExiste || $nbOptionsProduitPanier != $nbOptionsCorrect)
            $this->listeProduits[] = $produit;
        $this->prixTotal += $produit->getPrix();
    }

    public function getNbTotalProduitsPanier(){
        $totalProd = 0;
        foreach ($this->listeProduits as $produit) {
            $totalProd += $produit->getQuantite();
        }
        return $totalProd;
    }

    public function affichageListeProduitPanier(){
        $html = "";
        foreach ($this->listeProduits as $unProduit) {
            $html .= $unProduit->txtPanier();
        }
        $html .= $this->affichageTotalEtActionsPanier();
        return $html;
    }
    private function affichageTotalEtActionsPanier(){
        return '<div class="row item-panier total-panier">
            <div class="col-xs-1">
            </div>
            <div class="col-xs-7">
                <p class="infos-panier">Total</p>
            </div>
            <div class="col-xs-2">
                <p class="infos-panier">' . $this->getPrixTotal() . '€</p>
            </div>
            
        </div>';
    }

    /**
     * @return array
     */
    public function getListeProduits()
    {
        return $this->listeProduits;
    }
    /**
     * @param array $listeProduits
     */
    public function setListeProduits($listeProduits)
    {
        $this->listeProduits = $listeProduits;
    }

    /**
     * @return int
     */
    public function getPrixTotal()
    {
        return $this->prixTotal;
    }
    /**
     * @param int $prixTotal
     */
    public function setPrixTotal($prixTotal)
    {
        $this->prixTotal = $prixTotal;
    }



}