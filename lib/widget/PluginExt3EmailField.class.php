<?php
/**
 * PluginExt3EmailField représente un champs de type email
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage widget
 * @author     n.chevobbe@atolcd.com
 * @version    1.0
 */
class PluginExt3EmailField extends PluginExt3TextField
{

  /**
   * Renvoi un sfValidator de type "vérification email"
   *
   * @return sfValidator  un sfValidatorEmail
   */
  public function getValidator()
  {
    $configValidator = array ();

    $allowBlank = $this->getAttribute('allowBlank')===null?true:$this->getAttribute('allowBlank');
    $configValidator['required'] = !$allowBlank;

    return new sfValidatorEmail($configValidator);
  }

}

