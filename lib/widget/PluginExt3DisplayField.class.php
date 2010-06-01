<?php
/**
 * PluginExt3DisplayField représente un champs non modifiable
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage widget
 * @author     jp.thevenoux@atolcd.com
 * @version    1.0
 */
class PluginExt3DisplayField extends PluginExt3Base
{
  public static $TAB_PATTERN = array("/\n/", "/ /");
  public static $TAB_REPLACEMENT = array('<br>', '&nbsp;');
  
  /**
   * Constructor.
   *
   * @param string $value       Valeur du champs
   * @param string $label       Libellé précédant le champs
   * @param array  $attributes  An array of default HTML attributes
   * @param array  $options     An array of options
   * @param boolean $boolField  Afficher une image à la place d'un booléen
   * @param string $msgFalse Afficher un message et non une image lorsque le booléen est faux
   *
   * @see PluginExt3Base
   */
  public function __construct($value='',$label='', $class = '', $attributes = array (), $options = array (),$boolField = false,$msgFalse = null)
  {
    parent::__construct(false, $attributes, $options);

    $this->setAttribute('fieldLabel', $label);

    if($boolField)
    {
      $attValue=' ';
      if($value == 1 || $value == true)
      {
        $boolClass = 'sigaFormDisplayTRUE';
      }
      else
      {
        if($msgFalse == NULL)
        {
          $boolClass = 'sigaFormDisplayFALSE';
        }
        else
        {
          $attValue=$msgFalse;
          $boolClass = 'msgImportant';
        }      
      }   
      $this->setAttribute('value',$attValue);
      $this->setAttribute('cls', $boolClass.' '.$class); 
    }
    else
    {
      $this->setAttribute('value', preg_replace(self::$TAB_PATTERN, self::$TAB_REPLACEMENT, $value));
    $this->setAttribute('cls', $class);
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
    $this->setAttribute('xtype', 'displayfield');
  }

}
