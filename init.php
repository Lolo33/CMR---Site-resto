<?php
/**
 * Created by PhpStorm.
 * User: Niquelesstup
 * Date: 03/10/2018
 * Time: 19:40
 */

session_start();
require "Classes/Config.php";
require "Classes/Requetes.php";
require "Classes/Produit.php";
require "Classes/Panier.php";

$bdd = Config::getBddInstance();
$reqSiteParams = $bdd->query("SELECT * FROM site_params LIMIT 1");
$reqSiteParams->execute();
$siteParams = $reqSiteParams->fetch(PDO::FETCH_OBJ);

if (!isset($_SESSION["panier"]) || empty($_SESSION["panier"])) {
    $panier = new Panier();
    $_SESSION["panier"] = serialize($panier);
}

function alert($msg, $success = false){
    $class = "danger";
    $title = "Erreur :";
    if ($success) {
        $class = "success";
        $title = "Bravo!";
    }
    return '<div class="alert alert-dismissible alert-'. $class .'"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>'. $title . '</strong> ' . $msg . '</div>';
}