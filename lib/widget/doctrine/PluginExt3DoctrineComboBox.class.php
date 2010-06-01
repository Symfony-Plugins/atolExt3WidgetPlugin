<?php
/**
 * PluginExt3DoctrineComboBox représente une liste déroulante lié à un store doctrine
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage widget/doctrine
 * @author     jp.thevenoux@atolcd.com
 * @version    1.0
 */
class PluginExt3DoctrineComboBox extends PluginExt3ComboBox
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
  }

  /**
   * Fonction qui crée une combo à partir d'un resultat doctrine
   * @param $result      Obligatoire, Le résultat Doctrine
   * @param $value       Facultatif, le nom du champs qui sera utilisé comme valeur clé. Si non spécifié, on utilise la primary key retournée par doctrine.
   * @param $text        Facultatif, le nom du champs utilisé pour l'affichage. Si non spécifié, on utilise le __toString de l'objet.
   * @param $insertFirst Facultatif, objet à insérer avant les résultats de la requête
   */
  public static function fromResult($result, $value = null, $text = null, $insertFirst = null)
  {
    $store = PluginExt3DoctrineStore::fromResult($result, $value, $text, $insertFirst);
    $store->setAttribute('fields', array ('value', 'text'));

    $cbo = new PluginExt3ComboBox();
    $cbo->setAttribute('store', $store);
    $cbo->setAttribute('valueField', 'value');
    $cbo->setAttribute('displayField', 'text');
    return $cbo;
  }

  /**
   * Fonction qui crée une combo à partir d'un ensemble de donnée
   * @param $data   Objet au fomat JSON, ou tableau de donnée
   */
  public static function fromData($data)
  {
    $store = PluginExt3DoctrineStore::fromData($data);
    $store->setAttribute('fields', array ('value', 'text'));

    $cbo = new PluginExt3ComboBox();
    $cbo->setAttribute('store', $store);
    $cbo->setAttribute('valueField', 'value');
    $cbo->setAttribute('displayField', 'text');
    return $cbo;
  }

}

