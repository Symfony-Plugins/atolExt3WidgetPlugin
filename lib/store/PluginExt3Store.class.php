<?php
/**
 * PluginExt3Store représente un store
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage store
 * @author     jp.thevenoux@atolcd.com
 * @version    1.0
 */
class PluginExt3Store extends PluginExt3Base
{
  /**
   *
   * @return un objet Store initialisé à partir d'un résultat
   * @param object $data
   */
  public static function fromData($data)
  {
    $store = new PluginExt3Store();
    $store->setAttribute('data', $data);
    if (is_string($data) && stripos($data, '[[') !== false)
    {
      $store->setType('array');
    }
    elseif (is_array($data))
    {
      $store->setType('json');
      if (count($data) > 0)
      {
        if (is_array($data[0]))
        {
          // on a un tableau de tableau, finalement, c'est un array, et non pas un json
          $store->setType('array');
        }
      }
    }
    return $store;
  }

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
   * Permet de configurer les paramètres du composant
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see symfony/lib/widget/sfWidget#configure($options, $attributes)
   */
  protected function configure($options = array (), $attributes = array ())
  {
    $this->setAttribute('xtype', 'store');
    $this->addRawAttribute('data');
  }

  /**
   * Permet de définir le type de store (array ou json)
   *
   * @param string $typeStore  définit le type de store (json ou array)
   *
   */
  public function setType($typeStore)
  {
    if ($typeStore == 'array')
    {
      $this->setAttribute('xtype', 'arraystore');
    }
    elseif ($typeStore == 'json')
    {
      $this->setAttribute('xtype', 'jsonstore');
    }
  }

}

