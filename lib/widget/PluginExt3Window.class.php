<?php
/**
 * PluginExt3Window représente une fenêtre
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage widget
 * @author     jp.thevenoux@atolcd.com
 * @version    1.0
 */
class PluginExt3Window extends PluginExt3Base
{
  /**
   * Constructor.
   *
   * @param bool  $modal       Précise si la fenêtre est modale ou non, par défaut true
   * @param array $attributes  An array of default HTML attributes
   * @param array $options     An array of options
   *
   * @see PluginExt3Base
   */
  public function __construct($modal = true, $attributes = array (), $options = array ())
  {
    parent::__construct(true, $attributes, $options);
    $this->setAttribute('modal', $modal);
    $this->setAttribute('constrainHeader', true);
  }

  /**
   * Permet de configurer les propriétés de base d'une toolbar
   *
   * @param array $attributes  An array of default HTML attributes
   * @param array $options     An array of options
   */
  protected function configure($options = array (), $attributes = array ())
  {
    $this->setAttribute('xtype', 'window');
  }

  /**
   * Permet de définir si la fenêtre peut-être fermé
   * @param bool $bClosable booleén pour préciser l'état, true par défaut
   */
  public function setClosable($bClosable = true)
  {
    $this->setAttribute('closable', $bClosable);
  }

  /**
   * Permet de définir si la fenêtre est modale
   * @param bool $bModal booleén pour préciser l'état, true par défaut
   */
  public function setModal($bModal = true)
  {
    $this->setAttribute('modal', $bModal);
  }

  /**
   * Permet de définir si la fenêtre est déplaçable
   * @param bool $bDraggable booleén pour préciser l'état, true par défaut
   */
  public function setDraggable($bDraggable = true)
  {
    $this->setAttribute('draggable', $bDraggable);
  }

  /**
   * Permet de définir si la fenêtre est redimensionnable
   * @param bool $bResizable booleén pour préciser l'état, true par défaut
   */
  public function setResizable($bResizable = true)
  {
    $this->setAttribute('resizable', $bResizable);
  }

}

