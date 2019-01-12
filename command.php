<?php
/**
 * Created by PhpStorm.
 * User: Niquelesstup
 * Date: 03/10/2018
 * Time: 21:35
 */

include "init.php";

$panier = unserialize($_SESSION["panier"]);

?>

<div id="#command-content">
    <button style="display: none;" id="btn-modal" type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#largeShoes"></button>


    <div class="modal in" id="largeShoes" tabindex="-1" role="dialog" aria-labelledby="modalLabelLarge" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modalLabelLarge">Ma commande : <?php echo $panier->getNbTotalProduitsPanier(); ?> Produit(s)</h4>
                </div>

                <div class="modal-body scrollable">

                    <div class="commande-infos">
                        <?php foreach ($panier->getListeProduits() as $produit){ ?>
                        <div class="row">
                            <div class="col-xs-1"><?php echo $produit->getQuantite();?></div>
                            <div class="col-xs-8"><?php echo $produit->getNom();?></div>
                            <div class="col-xs-3 text-right"><?php echo $produit->getPrix() * $produit->getQuantite();?> €</div>
                        </div>
                        <?php } ?>
                        <hr>
                        <div class="row bold">
                            <div class="col-xs-9">Total</div>
                            <div class="col-xs-3 text-right"><?php echo $panier->getPrixTotal(); ?> €</div>
                        </div>
                    </div>

                    <hr>

                    <h4>Informations de paiement</h4>
                    <form id="form-commande">
                        <div class="row">
                            <div class="col-md-6">
                                <input class="form-control" placeholder="Votre nom">
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" placeholder="Votre prénom">
                            </div>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>


    <script>$("#btn-modal").click();</script>
</div>
