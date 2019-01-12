<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 27/11/2018
 * Time: 21:59
 */

include "../init.php";

$panier = unserialize($_SESSION["panier"]);

/**
 * @param $siteParams
 * @param $orderType
 * @param $clientName
 * @param $clientTel
 * @param $adressLine1
 * @param $adressLine2
 * @param $precisions
 * @throws Exception
 */
function createOrder($siteParams, $orderType, $clientName, $clientTel, $adressLine1, $adressLine2, $precisions)
{
    $panier = unserialize($_SESSION["panier"]);
    $req = new Requetes(Requetes::API_URL ."/restaurants/" . $siteParams->restaurant_id . "/orders", Requetes::API_KEY);
    $postContent = array(
        "orderType" => $orderType,
        "clientName" => $clientName,
        "clientPhone" => $clientTel,
        "clientAddressLine1" => $adressLine1,
        "clientAddressLine2" => $adressLine2,
        "precisions" => $precisions,
        "hourToBeReady" => "2018-12-19 17:55:00",
	    "clientTown" => 3668,
        "restaurantAmountToCash" => $panier->getPrixTotal(),
        "amountTakenByBusiness" => 0
    );
    $order = $req->sendPostRequest($postContent);
    $_SESSION["order"] = serialize($order);
    return json_decode($order);
}

if (isset($_POST) && !empty($_POST)){

    $orderType = htmlspecialchars(trim($_POST["orderType"]));
    $clientName = htmlspecialchars(trim($_POST["clientName"]));
    $clientTel = htmlspecialchars(trim($_POST["clientTel"]));
    $adressLine1 = htmlspecialchars(trim($_POST["clientAdressLine1"]));
    $adressLine2 = htmlspecialchars(trim($_POST["clientAdressLine2"]));
    $precisions = htmlspecialchars(trim($_POST["precisions"]));

    // CREATION DE LA COMMANDE
        if (!empty($orderType) && !empty($clientName) && !empty($clientTel) && !empty($adressLine1)) {
            try {
                $order = createOrder($siteParams, $orderType, $clientName, $clientTel, $adressLine1, $adressLine2, $precisions);
                foreach ($panier->getListeProduits() as $produit) {
                    $reqAddProd = new Requetes(Requetes::API_URL . "/orders/" . $order->id . "/add-product", Requetes::API_KEY);
                    $options = [];
                    if (!empty($produit->getOptions()) && count($produit->getOptions()) > 0){
                        foreach ($produit->getOptions() as $option) {
                            $options[] = $option["id"];
                        }
                    }
                    $str_json = '{"id": ' . $produit->getId();
                    if (!empty($produit->getOptions()) && count($produit->getOptions()) > 0) {
                        $string_options = implode('} , {"id": ',$options);
                        $str_json .= ', "options": [{"id": ' . $string_options . "}]";
                    }
                    $str_json .= "}";
                    $rep = json_decode($reqAddProd->sendPostRequestJSON($str_json));
                }
                var_dump($rep);
                $reqConfirm = new Requetes(Requetes::API_URL . "/orders/" . $order->id . "/confirm", Requetes::API_KEY);
                $repConf = $reqConfirm->sendPostRequest(array());
                var_dump($repConf);
                echo "ok";
            } catch (ReponseException $ex) {
                echo alert($ex->getReponse() . " / " . $ex->getMessage() . " / " . $ex->getCode());
            } catch (Exception $e){
                echo alert($e->getMessage());
            }
        } else {
            echo alert("Certains champs obligatoires sont manquants");
        }
}else{
    echo alert("Le formulaire doit être rempli");
}