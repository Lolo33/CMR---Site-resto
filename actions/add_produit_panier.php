<?php
/**
 * Created by PhpStorm.
 * User: Niquelesstup
 * Date: 03/10/2018
 * Time: 19:39
 */

function getArrayFromFormAjax($ajaxString){
    if (empty($ajaxString) || $ajaxString == '')
        return null;
    $tabPropValue = explode("&", $ajaxString);
    $tabKeyValue = [];
    if ($tabPropValue != false && count($tabPropValue) > 1) {
        foreach ($tabPropValue as $propValue) {
            $tabValue = explode("@", explode("=", $propValue)[1]);
            $tabKeyValue[] = array(
                "id" => $tabValue[0],
                "name" => $tabValue[1],
                "price" => $tabValue[2]
            );
        }
    }else{
        $tabValue = explode("@",explode("=", $tabPropValue[0])[1]);
        $tabKeyValue = array(array(
            "id" => $tabValue[0],
            "name" => $tabValue[1],
            "price" => $tabValue[2]
        ));
    }
    return $tabKeyValue;
}

include "../init.php";

$id = htmlspecialchars(trim($_POST["id"]));
$nom = htmlspecialchars(trim($_POST["nom"]));
$prix = htmlspecialchars(trim($_POST["prix"]));
$options = urldecode($_POST["options"]);
$opts = getArrayFromFormAjax($options);

$produit = new Produit($id, $nom, $prix, $opts);

$panier = unserialize($_SESSION["panier"]);
$panier->ajouterProduitListe($produit);
$_SESSION["panier"] = serialize($panier);

echo $panier->affichageListeProduitPanier();
