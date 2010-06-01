<?php
/**
 * PluginExt3Label représente un simple texte
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage widget
 * @author     jp.thevenoux@atolcd.com
 * @version    1.0
 */
class PluginExt3Label extends PluginExt3Base
{
  /**
   * Constructor.
   *
   * @param string $texte      Texte à afficher
   * @param string $class      Classe CSS spécifique pour ce champs
   * @param array  $attributes An array of default HTML attributes
   * @param array  $options    An array of options
   *
   * @see PluginExt3Base
   */
  public function __construct($texte= '', $class = '', $attributes = array (), $options = array ())
  {
    parent::__construct(false, $attributes, $options);
    $this->setAttribute('text', "'".addslashes($texte)."'");
    $this->addRawAttribute('text');
    $this->setAttribute('cls', $class);
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
    $this->setAttribute('xtype', 'label');
  }

}

