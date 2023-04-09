<?php

namespace Drupal\dd_form_checkout\Plugin\Commerce\CheckoutPane;

use Drupal\commerce_checkout\Plugin\Commerce\CheckoutPane\CheckoutPaneBase;
use Drupal\commerce_order\Entity\Order;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a custom message pane.
 *
 * @CommerceCheckoutPane(
 *   id = "dd_form_checkout_custom_ratings",
 *   label = @Translation("Custom ratings"),
 *   default_step = "complete",
 * )
 */
class CustomRatingsCheckoutPane extends CheckoutPaneBase {

  /**
   * {@inheritdoc}
   */
  public function buildPaneForm(array $pane_form, FormStateInterface $form_state, array &$complete_form) {
    $comment = $this->order->getData('order_comment');
    $rating = $this->order->getData('order_rating');
    $pane_form['comment'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Laissez-nous un commentaire !'),
      '#size' => 60,
      '#default_value' => $comment ?: '',
    ];
    $pane_form["rating"] = [
      '#type' => 'radios',
      '#title' => $this->t('Qu\'avez vous pensez de votre commande ?'),

      '#attributes' => ['class' => ['ratings-radios']],
      '#options' => [
        1 => t('1'),
        2 => t('2'),
        3 => t('3'),
        4 => t('4'),
        5 => t('5'),
        6 => t('6'),
        7 => t('7'),
        8 => t('8'),
        9 => t('9'),
        10 => t('10')
      ],
      "#default_value" => $rating ?: 10
    ];

    $pane_form["ratings-btn-save-container"] = [
      "#type" => "container",
      '#attributes' => ['class' => ['ratings-btn-save-container']],

    ];
    $pane_form["ratings-btn-save-container"]['accueil'] = [
      '#type' => 'submit',
      "#name" => "accueil",
      '#value'=> t('Accueil'),
    ];
    $pane_form["ratings-btn-save-container"]['submit'] = [
      '#type'       => 'submit',
      "#name" => "sauvegarder",
      '#value'      => t('Sauvegarder'),
      '#attributes' => ['class' => ['ratings-btn-save']],
    ];
    return $pane_form;
  }

  public function buildPaneSummary() {
    if ($order_comment = $this->order->getData('order_comment')) {
      return [
        '#plain_text' => $order_comment,
      ];
    }
    return [];
  }

  public function submitPaneForm(array &$pane_form, FormStateInterface $form_state, array &$complete_form) {
    if($form_state->getTriggeringElement()["#name"] !== "accueil"){
      $values = $form_state->getValue($pane_form['#parents']);
      $this->order->setData('order_comment', $values['comment']);
      $this->order->setData('order_rating', $values['rating']);
    }
    $form_state->setRedirect("<front>");
  }

}
