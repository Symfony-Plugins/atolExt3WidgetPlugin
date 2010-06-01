<?php
/**
 * PluginExt3TextArea représente un champs textearea
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage widget
 * @author     jp.thevenoux@atolcd.com
 * @version    1.0
 */
class PluginExt3TextArea extends PluginExt3Base
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
    $rows = 5;
    $cols = 30;
    if (is_array($attributes) && array_key_exists('rows', $attributes))
    {
      $rows = $attributes['rows'];
    }
    if (is_array($attributes) && array_key_exists('cols', $attributes))
    {
      $cols = $attributes['cols'];
    }
    parent::__construct(false, $attributes, $options);
    $this->addAttributesData('autoCreate', 'tag', 'textarea');
    $this->addAttributesData('autoCreate', 'rows', $rows);
    $this->addAttributesData('autoCreate', 'cols', $cols);
    
  }

  /**
   * Permet de configurer les propriétés de base d'une combo
   *
   * @param array $attributes  An array of default HTML attributes
   * @param array $options     An array of options
   */
  protected function configure($options = array (), $attributes = array ())
  {
    $this->setAttribute('xtype', 'textarea');
  }

  /**
   * Renvoi un validator pour ce composant
   *
   * @return sfValidator  un sfValidatorString
   */
  public function getValidator()
  {
    $configValidator = array ();
    $allowBlank = $this->getAttribute('allowBlank')===null?true:$this->getAttribute('allowBlank');
    $configValidator['required'] = !$allowBlank;

    $maxLength = $this->getAttribute('maxLength');
    if (!is_null($maxLength))
    {
      $configValidator['max_length'] = $maxLength;
    }
    $minLength = $this->getAttribute('minLength');
    if (!is_null($minLength))
    {
      $configValidator['min_length'] = $minLength;
    }

    return new sfValidatorString($configValidator);
  }

}

