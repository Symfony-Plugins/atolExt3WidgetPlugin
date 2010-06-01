<?php
/**
 * PluginExt3Password représente un champs de type password
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage widget
 * @author     jp.thevenoux@atolcd.com
 * @version    1.0
 */
class PluginExt3Password extends PluginExt3TextField
{

  /**
   * Constructor.
   *
   * @param array $attributes  An array of default HTML attributes
   * @param array $options     An array of options
   *
   * @see PluginExt3TextField
   */
  public function __construct($attributes = array (), $options = array ())
  {
    parent::__construct($attributes, $options);

  }

  /**
   * Permet de configurer les propriétés de base d'une combo
   *
   * @param array $attributes  An array of default HTML attributes
   * @param array $options     An array of options
   */
  protected function configure($options = array (), $attributes = array ())
  {
    parent::configure($options, $attributes);
    $this->setAttribute('inputType', 'password');
  }

}

