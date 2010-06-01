<?php
/**
 * PluginExt3Hidden représente un champd caché
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage widget
 * @author     jp.thevenoux@atolcd.com
 * @version    1.0
 */
class PluginExt3Hidden extends PluginExt3Base
{
  /**
   * Constructor.
   *
   * @param array $attributes  An array of default HTML attributes
   * @param array $options     An array of options
   *
   * @see PluginExt3Base
   */
  public function __construct($attributes = array (), $options = array ())
  {
    parent::__construct(false, $attributes, $options);
  }

  /**
   * Permet de configurer les propriétés de base d'une combo
   *
   * @param array $attributes  An array of default HTML attributes
   * @param array $options     An array of options
   */
  protected function configure($options = array (), $attributes = array ())
  {
    $this->setAttribute('xtype', 'hidden');
  }

  /**
   * Permet de définir le nom et la valeur du champ hidden en une seule fonction
   *
   * @param string $name  Nom du champs
   * @param string $value Valeur du champs
   */
  public function setInformation($name, $valeur)
  {
    $this->setAttribute('name', $name);
    $this->setAttribute('value', $valeur);
  }

}

