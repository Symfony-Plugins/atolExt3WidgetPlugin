<?php
/**
 * PluginExt3NumberField représente un champs de saisie numérique
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage widget
 * @author     jp.thevenoux@atolcd.com
 * @version    1.0
 */
class PluginExt3NumberField extends PluginExt3Base
{

  /**
   * Constructor.
   *
   * @param bool  $allowDecimals Booléen précisant si les décimals sont autorisées ou non, par défaut true
   * @param array $attributes    An array of default HTML attributes
   * @param array $options       An array of options
   *
   * @see PluginExt3Base
   */
  public function __construct($allowDecimals = true, $attributes = array (), $options = array ())
  {
    parent::__construct(false, $attributes, $options);
    if (!$allowDecimals)
    {
      $this->setAttribute('allowDecimals', false);
    }
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
    $this->setAttribute('xtype', 'numberfield');
  }

  /**
   * Renvoi un sfValidator pour ce type de composant
   *
   * @return sfValidator  un sfValidatorInteger ou un sfValidatorNumber
   */
  public function getValidator()
  {
    $configValidator = array ();
    $allowBlank = $this->getAttribute('allowBlank');
    if (!is_null($allowBlank))
    {
      $configValidator['required'] = !$allowBlank;
    }

    $allowNegative = $this->getAttribute('allowNegative');
    if (!$allowNegative)
    {
      $configValidator['min'] = 0;
    }
    $minValue = $this->getAttribute('minValue');
    if (!is_null($minValue))
    {
      $configValidator['min'] = $configValidator['min'] || $minValue;
    }
    $maxValue = $this->getAttribute('maxValue');
    if (!is_null($maxValue))
    {
      $configValidator['max'] = $maxValue;
    }

    $allowDecimals = $this->getAttribute('allowDecimals');
    if ($allowDecimals == false)
    {
      //validatorinteger
      return new sfValidatorInteger($configValidator);
    }
    else
    {
      //validatornumber
      return new sfValidatorNumber($configValidator);
    }
  }
}

