<?php
/**
 * PluginExt3Fieldset représente un container de type fieldset
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage widget
 * @author     n.chevobbe@atolcd.com
 * @version    1.0
 */
class PluginExt3Fieldset extends PluginExt3Panel
{
  /**
   * Constructor.
   *
   * @param string $title       Titre du fieldset
   * @param array  $attributes  An array of default HTML attributes
   * @param array  $options     An array of options
   *
   * @see PluginExt3Panel
   */
  public function __construct($title = null, $attributes = array(), $options = array())
  {
    parent::__construct($attributes, $options);
    $this->setAttribute('title', $title);
  }

  /**
   * Permet de configurer les paramètres du composant
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see PluginExt3Panel#configure($options, $attributes)
   */
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);
    $this->setAttribute('xtype', 'fieldset');
  }

}