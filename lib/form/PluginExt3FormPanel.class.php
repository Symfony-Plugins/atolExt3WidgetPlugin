<?php
/**
 * PluginExt3FormPanel représente un panel de type form
 * Le "form" pourra être posté en POST via une url
 * Le "submit" est de type standard (et non ajax)
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage form
 * @author     a.morle@atolcd.com
 * @version    1.0
 */
class PluginExt3FormPanel extends PluginExt3Panel
{
  /**
   * Constructor.
   * Un bouton "Valider" est inclu automatiquement
   *
   * @param string $url          Url qui sert d'adresse pour le POST du formulaire
   * @param array  $items        Tableau des items
   * @param array  $attributes   An array of default HTML attributes
   * @param array  $otherbuttons tableau contenant des boutons supplémentaire
   * @param array  $options      An array of options
   *
   * @see PluginExt3Panel
   */
  public function __construct($url, $items = null, $attributes = array (), $otherbuttons = array (), $options = array ())
  {
    parent::__construct($attributes, $options);
    $this->setAttribute('xtype', 'form');
    $this->setAttribute('url', $url);
    $this->setAttribute('monitorValid', TRUE);
    $this->setAttribute('standardSubmit', TRUE);
    $this->setAttribute('method', 'POST');
    $this->setAttribute('autoScroll', true);
    $this->setAttribute('labelWidth', 150);

    $this->addAttributesData('bodyStyle', 'padding', '10px');

    $tabBouton = array();
    $defaultsButtons = $this->getDefaultsButtons();
    if ($defaultsButtons != null)
    {
      $defaultsButtons = is_array($defaultsButtons)?$defaultsButtons: array ($defaultsButtons);
      $tabBouton = array_merge($tabBouton, $defaultsButtons);
    }
    if ($otherbuttons != null)
    {
      $otherbuttons = is_array($otherbuttons)?$otherbuttons: array ($otherbuttons);
      $tabBouton = array_merge($tabBouton, $otherbuttons);
    }


    $this->setAttribute('buttons', $tabBouton);
    if ($items != null)
    {
      $this->setItems($items);
    }
  }

  /**
   * Fonction qui renvoi le bouton par défaut. Peut-être surchargé pour personnaliser
   * ce bouton
   * @return tableau avec un bouton
   */
  protected function getDefaultsButtons()
  {
    return new PluginExt3Button('Valider',
    array (
    'id'=>'btnValid',
    'xtype'=>'submitbutton',
    'cls'=>'sf_validate_button'
    ));
  }

  /**
   * Permet de configurer les propriétés de base de la grille
   *
   * @param array $attributes  An array of default HTML attributes
   * @param array $options     An array of options
   */
  protected function configure($options = array (), $attributes = array ())
  {
  }

}

