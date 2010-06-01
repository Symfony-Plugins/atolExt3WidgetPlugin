<?php

/**
 * PluginExt3Button représente un bouton ExtJS
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage widget
 * @author     jp.thevenoux@atolcd.com
 * @version    1.0
 */
class PluginExt3Button extends PluginExt3Base
{
  /**
   * Constructor.
   *
   * @param bool  $text        Libellé du bouton
   * @param array $attributes  An array of default HTML attributes
   * @param array $options     An array of options
   *
   * @see PluginExt3Base
   */
  public function __construct($text, $attributes = array (), $options = array ())
  {
    $this->setAttribute('xtype', 'button');
    parent::__construct(false, $attributes, $options);
    $this->setAttribute('text', $text);
    $this->addRawAttribute('handler');
  }

  /**
   * Permet de définir une redirection sur le click du bouton
   *
   * @param string $url    l'url de destination
   */
  public function redirectOnClick($url)
  {
    if ($url == null)
    {
      return;
    }
    $this->setAttribute('handler', 'function() {window.location = "'.$url.'";}');
  }

}

