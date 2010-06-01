<?php
/**
 * PluginExt3Panel représente un panel
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage widget
 * @author     jp.thevenoux@atolcd.com
 * @version    1.0
 */
class PluginExt3Panel extends PluginExt3Base
{
  /**
   * Constructor.
   *
   * @param array $attributes  An array of default HTML attributes
   * @param array $options     An array of options
   *
   * @see PluginExt3Base
   */
  public function __construct($attributes = array(), $options = array())
  {
    parent::__construct(true, $attributes, $options);
  }

  /**
   * Permet de configurer les propriétés de base d'une combo
   *
   * @param array $attributes  An array of default HTML attributes
   * @param array $options     An array of options
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->setAttribute('xtype', 'panel');
    $this->setAttribute('collapsible', true);
    $this->setAttribute('titleCollapse', true);
  }

}