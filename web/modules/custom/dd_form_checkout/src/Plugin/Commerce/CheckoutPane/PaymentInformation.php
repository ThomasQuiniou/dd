<?php

namespace Drupal\dd_form_checkout\Plugin\Commerce\CheckoutPane;

use Drupal\commerce_payment\Plugin\Commerce\CheckoutPane\PaymentInformation as BasePaymentInformation;
use Drupal\commerce_shipping\Entity\ShippingMethod;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a custom payment information pane.
 */
class PaymentInformation extends BasePaymentInformation {

  /**
   * {@inheritdoc}
   */
  public function buildPaneForm(array $pane_form, FormStateInterface $form_state, array &$complete_form) {
    return parent::buildPaneForm($pane_form, $form_state, $complete_form);
  }

  /**
   * {@inheritdoc}
   */
  public function validatePaneForm(array &$pane_form, FormStateInterface $form_state, array &$complete_form) {
    parent::validatePaneForm($pane_form, $form_state, $complete_form);
    // retrait_de_commande = 6--default
    $userInput = $form_state->getUserInput();
    $shippingMethod = $userInput["shipping_information"]["shipments"][0]["shipping_method"][0];
    $paymentMethod = $userInput["payment_information"]["payment_method"];
    if(
      $shippingMethod === "6--default" && $paymentMethod !== "paiement_au_retrait_de_commande"
      || $shippingMethod !== "6--default"  && $paymentMethod === "paiement_au_retrait_de_commande"
    ){
      $form_state->setErrorByName("name", "Veuillez séléctionner le mode d'expédition associé au mode paiement");
    }
  }
}
