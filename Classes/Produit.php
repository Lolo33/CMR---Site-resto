<?php

/**
 * Created by PhpStorm.
 * User: Niquelesstup
 * Date: 03/10/2018
 * Time: 19:42
 */
class Produit
{

    private $id;
    private $nom;
    private $prix;
    private $quantite = 1;
    private $options = array();

    function __construct($id, $nom, $prix, $options = array())
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prix = $prix;
        $this->options = $options;
    }

    public function txtPanier(){
        $html = '<div class="row item-panier">
                    <div class="col-xs-1">
                        <p class="infos-panier"><strong class="nb-produit-panier">' . $this->quantite . '</strong></p>
                    </div>
                    <div class="col-xs-7">
                        <p class="infos-panier">
                        ' . $this->nom . "<br />";
                        if ($this->options != "" && count($this->options) > 0) {
                            foreach ($this->options as $option) {
                                $html .= "<span class='option-prod'>" . $option["name"] . "</span><br />";
                            }
                        }
                        $html .= '</p>
                    </div>
                    <div class="col-xs-2">
                        <p class="infos-panier">' . $this->prix * $this->quantite . '€</p>
                    </div>
                    <div class="col-xs-2 text-right">
                        <button class="btn btn-danger delete-panier"><span class="glyphicon glyphicon-trash"></span> </button>
                    </div>
                </div>';
                return $html;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }
    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrix()
    {
        return $this->prix;
    }
    /**
     * @param mixed $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return mixed
     */
    public function getQuantite()
    {
        return $this->quantite;
    }
    /**
     * @param mixed $quantite
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param mixed $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }




}