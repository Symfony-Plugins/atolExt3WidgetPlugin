<?php

/**
 * PluginExt3MultiSelect représente une liste de multiselection 
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage widget
 * @author     jp.thevenoux@atolcd.com
 * @version    1.0
 */
class PluginExt3MultiSelect extends PluginExt3Base
{

  public function __construct($attributes = array (), $options = array ())
  {
    parent::__construct(false, $attributes, $options);
  }

  /**
   * Permet de configurer les propriétés de base de la liste
   *
   * @param array $attributes  An array of default HTML attributes
   * @param array $options     An array of options
   */
  protected function configure($options = array (), $attributes = array ())
  {
    $this->addRawAttribute('store');
    $this->setAttribute('xtype', 'multiselect');
    $this->setAttribute('mode', 'local');
    $this->setAttribute('width', 225);
    
    $selectOne = "function(){
      if(this.store.totalLength == 1)
      {
        this.view.select(0) 
      }
      }";
     $this->addAttributesData('listeners','@afterrender',$selectOne);
    
  }


  public static function fromResult($result, $value = null, $text = null, $insertFirst = null)
  {
        $multiselect = new PluginExt3MultiSelect();
        
        $store = PluginExt3DoctrineStore::fromResult($result, $value, $text);
        $store->setAttribute('fields', array ('value', 'text'));
        $multiselect->setAttribute('store', $store);
        
        $multiselect->setAttribute('displayField', 'text');
        $multiselect->setAttribute('valueField', 'value');
        
        return $multiselect;
  }


}

