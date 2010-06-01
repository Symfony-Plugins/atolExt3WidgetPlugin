<?php

/**
 * PluginExt3ComboBox représente une combobox ExtJS (liste déroulante)
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage widget
 * @author     jp.thevenoux@atolcd.com
 * @version    1.0
 */
class PluginExt3ComboBox extends PluginExt3Base
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
    $this->valueDefault = '';
  }

  /**
   * Permet de configurer les propriétés de base d'une combo
   *
   * @param array $attributes  An array of default HTML attributes
   * @param array $options     An array of options
   */
  protected function configure($options = array (), $attributes = array ())
  {
    $this->addRawAttribute('store');
    $this->addRawAttribute('validator');
    $this->setAttribute('xtype', 'combo');
    $this->setAttribute('mode', 'local');
    $this->setAttribute('forceSelection', true);
    $this->setAttribute('selectOnFocus', true);
    $this->setAttribute('triggerAction', 'all');
    $this->setAttribute('listWidth', 220);
    $this->setAttribute('width', 225);
    $this->setAttribute('resizable', true);

    $this->needHidden = true;
  }

  /**
   * Renvoi un sfValidator pour ce type de composant
   *
   * @return sfValidator  un sfValidator correspondant à ce composant
   */
  public function getValidator()
  {
    $configValidator = array ();
    $allowBlank = $this->getAttribute('allowBlank')===null?true:$this->getAttribute('allowBlank');
    $configValidator['required'] = !$allowBlank;

    return new sfValidatorInteger($configValidator);
  }

}

