<?php
/**
 * PluginExt3ToolBarLabel représente un label dans une toolbar
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage widget
 * @author     jp.thevenoux@atolcd.com
 * @version    1.0
 */
class PluginExt3ToolBarLabel extends PluginExt3Base
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
    parent::__construct(true, $attributes, $options);
  }

  /**
   * Permet de configurer les propriétés de base d'une toolbar
   *
   * @param array $attributes  An array of default HTML attributes
   * @param array $options     An array of options
   */
  protected function configure($options = array (), $attributes = array ())
  {
    $this->setAttribute('xtype', 'tbtext');
  }

}
