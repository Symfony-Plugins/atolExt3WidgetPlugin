<?php
/**
 * PluginExt3Checkbox représente une case à cocher
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage widget
 * @author     jp.thevenoux@atolcd.com
 * @version    1.0
 */
class PluginExt3Checkbox extends PluginExt3Base
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
    $this->nameValueField = 'checked';
    parent::__construct(false, $attributes, $options);
  }

  /**
   * Permet de configurer les paramètres du composant
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see symfony/lib/widget/sfWidget#configure($options, $attributes)
   */
  protected function configure($options = array (), $attributes = array ())
  {
    $this->setAttribute('xtype', 'checkbox');
  }

  /**
   * Renvoi un sfValidator pour ce type de composant
   *
   * @return sfValidator  un sfValidator correspondant à ce composant
   */
  public function getValidator()
  {
    return new sfValidatorBoolean();
  }

}

