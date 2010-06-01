<?php
/**
 * PluginExt3TextField représente un champs texte
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage widget
 * @author     jp.thevenoux@atolcd.com
 * @version    1.0
 */
class PluginExt3TextField extends PluginExt3Base
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
    $size = 40;
    if (is_array($attributes) && array_key_exists('size', $attributes))
    {
      $size = $attributes['size'];
    }
    parent::__construct(false, $attributes, $options);
    $this->addAttributesData('autoCreate', 'tag', 'input');
    $this->addAttributesData('autoCreate', 'type', 'text');
    $this->addAttributesData('autoCreate', 'size', $size);
    $this->addAttributesData('autoCreate', 'autocomplete', 'on');

  }

  /**
   * Permet de configurer les propriétés de base d'une combo
   *
   * @param array $attributes  An array of default HTML attributes
   * @param array $options     An array of options
   */
  protected function configure($options = array (), $attributes = array ())
  {
    $this->setAttribute('xtype', 'textfield');
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

