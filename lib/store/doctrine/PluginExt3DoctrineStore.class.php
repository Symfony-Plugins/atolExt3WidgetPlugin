<?php
/**
 * PluginExt3DoctrineStore représente un store lié à doctrine.
 * Possède des fonctions statiques simplifiant la création automatique
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage store
 * @author     jp.thevenoux@atolcd.com
 * @version    1.0
 */
class PluginExt3DoctrineStore extends PluginExt3Store
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
    parent::__construct($attributes, $options);
  }

  /**
   * Fonction qui crée un store à partir d'un resultat doctrine
   * @param $result      Obligatoire, Le résultat Doctrine
   * @param $value       Facultatif, le nom du champs qui sera utilisé comme valeur clé. Si non spécifié, on utilise la primary key retournée par doctrine.
   * @param $text        Facultatif, le nom du champs utilisé pour l'affichage. Si non spécifié, on utilise le __toString de l'objet.
   * @param $insertFirst Facultatif, objet à insérer avant les résultats de la requête
   */
  public static function fromResult($result, $value = null, $text = null, $insertFirst = null)
  {
    $data = array ();
    if ($insertFirst != null) {
      $obj = new PluginExt3Base();
      $obj->setAttribute('value', ($value == null?(is_array($valuePK = $insertFirst->getPrimaryKey())?current($valuePK):$valuePK):
      $insertFirst->$value));
      $obj->setAttribute('text', ($text == null? $insertFirst->__toString() : $insertFirst->$text));
      $data[] = $obj;
    }
    foreach ($result as $object)
    {
      $obj = new PluginExt3Base();
      $obj->setAttribute('value', ($value == null?(is_array($valuePK = $object->getPrimaryKey())?current($valuePK):$valuePK):
      $object->$value));
      $obj->setAttribute('text', ($text == null? $object->__toString() : $object->$text));
      $data[] = $obj;
    }
    return PluginExt3Store::fromData($data);
  }

}

