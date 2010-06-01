<?php

/**
 * PluginExt3DateField représente un composant date, avec choix via un calendrier
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage widget
 * @author     jp.thevenoux@atolcd.com
 * @version    1.0
 */
class PluginExt3DateField extends PluginExt3Base
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

    $this->addAttributesData('autoCreate', 'tag', 'input');
    $this->addAttributesData('autoCreate', 'type', 'text');
    $this->addAttributesData('autoCreate', 'size', '20');
    $this->addAttributesData('autoCreate', 'autocomplete', 'on');

  }

  /**
   * Permet de configurer les paramètres du composant
   *
   * @param array $options     An array of options*
   * @param array $attributes  An array of default HTML attributes
   *
   * @see symfony/lib/widget/sfWidget#configure($options, $attributes)
   */
  protected function configure($options = array (), $attributes = array ())
  {
    $this->setAttribute('xtype', 'datefield');
    $this->setAttribute('format','d/m/Y');
    $this->setAttribute('invalid','La date doit être au format jj/mm/aaaa');
    $this->setAttribute('altFormats','d/m/Y|d/m/y|Y-m-d');
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
    $configValidator['date_format'] ='@(?P<day>\d{2}).(?P<month>\d{2}).(?P<year>\d{4})@';

    return new sfValidatorDate($configValidator);
  }

}
