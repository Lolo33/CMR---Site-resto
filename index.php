<?php
/**
 * Created by PhpStorm.
 * User: Niquelesstup
 * Date: 07/09/2018
 * Time: 19:59
 */

include "init.php";

$panier = unserialize($_SESSION["panier"]);

$reqApi = new Requetes(Requetes::API_URL . "/restaurants/" . $siteParams->restaurant_id, Requetes::API_KEY);
$reqApi = new Requetes(Requetes::API_URL . "/restaurants/" . $siteParams->restaurant_id . "/delivery", Requetes::API_KEY);

?>

<html>
<head>
    <meta charset="UTF-8" />
    <title><?php echo $siteParams->site_name; ?> - <?php echo $siteParams->site_descr; ?></title>
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans|Montserrat|Righteous" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/panier/Produit.js"></script>
    <link href="css/style.css" rel="stylesheet" />
    <style>
    </style>
</head>
<body>


<nav class="navbar navbar-default navbar-fixed-top" style="margin-bottom: 0; padding-right: 15px;">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#"><?php echo $siteParams->site_name; ?></a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#">
                    <span class="glyphicon glyphicon-home"></span> Présentation
                </a>
            </li>
        </ul>
        <!--<ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" count="<?php //echo $panier->getNbTotalProduitsPanier(); ?>" class="dropdown-toggle panier-notif" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="glyphicon glyphicon-shopping-cart"></span> Panier (<?php //echo $panier->getNbTotalProduitsPanier(); ?>) <span class="caret"></span>
                </a>
                <ul class="dropdown-menu items-panier">
                    <?php //echo $panier->affichageListeProduitPanier(); ?>
                </ul>
            </li>
        </ul>-->
    </div>
</nav>


<?php try {
    $restaurantInfo = json_decode($reqApi->sendGetRequest());
    //var_dump($restaurantInfo->townsDeliveredList) ?>
    <section id="presa" class="section-1" style="background: url('img/back/header.jpg'); background-repeat: no-repeat; background-size: 100% 100%;">
        <div class="transparence">
            <div class="container" style="background: rgba(255, 255, 255, 0.7); padding: 0 20px 20px;">
                <div class="row">
                    <div class="col-xs-12">
                        <h1 class="titre-restau text-primary"><?php echo $restaurantInfo->name; ?></h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <img src="<?php echo $restaurantInfo->logoUrl; ?>" width="100%">
                    </div>
                    <div class="col-sm-3">
                        <?php $hourState = $restaurantInfo->openStateString; if ($restaurantInfo->openStateString == null){ $hourState = "Horaires actuelles inconnues"; } ?>
                        <span class="glyphicon glyphicon-time"></span> <?php echo $hourState; ?><br />
                        <span class="glyphicon glyphicon-envelope"></span> <?php
                        if ($restaurantInfo->mail == null || empty($restaurantInfo->mail)) {
                            echo "Pas d'adresse e-mail";
                        }else{
                            echo $restaurantInfo->mail;
                        } ?><br />
                        <span class="glyphicon glyphicon-phone-alt"></span> <?php
                        if ($restaurantInfo->phoneNumber == null || empty($restaurantInfo->phoneNumber)) {
                            echo "Pas de numero de télephone";
                        }else{
                            echo $restaurantInfo->phoneNumber;
                        } ?><br />
                        <span class="glyphicon glyphicon-map-marker"></span> <?php echo $restaurantInfo->addressLine1 . " " . $restaurantInfo->addressLine2 . ", " .
                            $restaurantInfo->town->countryCode . " " . $restaurantInfo->town->name . " " . $restaurantInfo->town->country->name; ?><br /><br />
                        <?php
                        foreach ($restaurantInfo->type as $type){
                            echo "<span class='label label-primary'>" . $type->name . "</span> ";
                        }
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <?php if ($restaurantInfo->description == null || empty($restaurantInfo->description)) {
                            echo $siteParams->site_descr;
                        }else{
                            echo $restaurantInfo->description;
                        }?>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section class="section-1">
        <div class="container">
            <h1 class="text-center titre-section">A la carte en ce moment</h1>
            <div class="row">
                <div class="col-lg-8 carte-infos">
                    <?php foreach ($restaurantInfo->categoriesOfProducts as $category){ ?>
                        <h2 class="titre-category"><?php echo $category->name; ?></h2>
                        <div class="row">
                            <?php foreach ($category->productsList as $product){ ?>
                            <div class="col-lg-12 product" id="product-<?php echo $product->id; ?>" nom="<?php echo $product-> name; ?>" prix="<?php echo $product->price ?>" >
                                <div class="row">
                                    <div class="col-xs-2 text-center">
                                        <img src="<?php echo $product->imgUrl; ?>" height="50"/>
                                    </div>
                                    <div class="col-xs-10 desc-product">
                                        <h5 class="row nom-product">
                                            <div class="col-xs-3">
                                                <?php echo $product->name; ?>
                                            </div>
                                            <div style="color: black; font-size: 0.8em" class="col-xs-5">
                                                <?php echo substr($product->description, 0, 80); ?>
                                            </div>
                                            <div class="col-xs-2 text-right">
                                                <?php echo $product->price; ?> €
                                            </div>
                                            <div class="col-xs-2">
                                                <div class="text-right">
                                                    <button data-toggle="modal" data-target="#modal-options-<?php echo $product->id; ?>" name="submit" id="select-product-<?php echo $product->id; ?>" class="btn-select-prod btn btn-success">
                                                        <span class="glyphicon glyphicon-plus"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="modal in" id="modal-options-<?php echo $product->id; ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabelLarge" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h4 class="modal-title" id="modalLabelLarge">Personnaliser le produit
                                        </div>

                                        <div class="modal-body scrollable">
                                            <form class="form-options-prod" method="post" nom="<?php echo $product->name; ?>" prix="<?php echo $product->price ?>" id="form-options-<?php echo $product->id; ?>">
                                                <?php if (!empty($product->propertiesList)) {
                                                    foreach ($product->propertiesList as $prop) { ?>
                                                        <div class="form-group">
                                                            <label for="select-opt-<?php echo $prop->id; ?>"><?php echo $prop->name; ?></label>
                                                            <select class="form-control" id="select-opt-<?php echo $prop->id; ?>" name="option">
                                                                <?php foreach ($prop->optionsList as $option) { ?>
                                                                    <option value="<?php echo $option->id . "@" . $option->name . "@" . $option->price; ?>">
                                                                        <?php echo $option->name; ?>
                                                                        (+ <?php echo $option->price; ?> €)
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    <?php }
                                                }?>
                                                <div class="form-group text-right">
                                                    <button type="submit" class="btn btn-primary btn-lg btn-grand">Ajouter au panier</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-lg-4">
                    <!--<h2 class="titre-category">Informations clients</h2>

                    <hr>-->
                    <h2 class="titre-category">Commander</h2>
                    <div id="zone-panier">
                        <?php echo $panier->affichageListeProduitPanier(); ?>
                    </div>
                    <hr>
                    <div class="row">
                        <form method="post" id="form-command-infos">
                            <div id="err-commande"></div>
                            <div class="form-group">
                                <label for="orderType">Type de commande</label>
                                <select class="form-control" id="orderType" name="orderType">
                                    <option value="1">A emporter</option>
                                    <option value="2">En Livraison</option>
                                    <option value="3">Coupe-file</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="clientName" name="clientName" placeholder="Nom et prénom">
                            </div>
                            <div class="form-group">
                                <input type="tel" class="form-control" id="clientTel" name="clientTel" placeholder="Numéro de télephone">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="clientAdressLine1" name="clientAdressLine1" placeholder="Adresse">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="clientAdressLine2" name="clientAdressLine2" placeholder="Complément d'adresse">
                            </div>
                            <div class="form-group">
                                <select id="clientTown" name="clientTown" class="form-control">
                                    <?php foreach ($restaurantInfo->townsDeliveredList as $town){ ?>
                                        <option value="<?php echo $town->deliveryTown->id; ?>"><?php echo $town->deliveryTown->countryCode . " - " . $town->deliveryTown->name . " (" . $town->deliveryFee . "€)"; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" id="precisions" name="precisions" placeholder="Précisions concernant votre commande.." rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-lg btn-grand">
                                    <span class="glyphicon glyphicon-shopping-cart"></span> Commander
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <?php
    }catch (ReponseException $ex){
        echo "<h1 style='margin-top: 100px;' class='text-center'>" . $ex->getMessage() . "</h1>";
        echo "<h1 class='text-center'>" .$ex->getReponse() . "</h1>";
    }
    ?>


    <script>

        $("#form-command-infos").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            $.post("actions/command.php", form.serialize(), function (data) {
                $("#err-commande").html(data).slideDown();
            })
        });

        function ajouterProduitPanier(id, nom, prix, options = null) {
            let div_panier = $(".panier-notif");
            let nbItems = parseInt(div_panier.attr("count")) + 1;
            div_panier.html("<span class='glyphicon glyphicon-shopping-cart'></span> Panier (" + nbItems + ") <span class='caret'>");
            div_panier.attr("count", nbItems);
            $.post("actions/add_produit_panier.php", {id:id, nom:nom, prix:prix, options}, function (data) {
                $("#zone-panier").html(data);
            });
        }

        $(".form-options-prod").submit(function (e) {
            e.preventDefault();
            idProduit = $(this).attr("id").substr(13);
            nomProduit = $(this).attr("nom");
            prixProduit = $(this).attr("prix");
            ajouterProduitPanier(idProduit, nomProduit, prixProduit, $(this).serialize());
            console.log("submit");
        });

        $(".btn-commander").click(function () {
            $("#command-content").remove();
            $.post("command.php", {}, function (data) {
                $("body").append(data);
            });
        });

    </script>

</body>
</html>


