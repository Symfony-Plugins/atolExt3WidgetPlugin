<?php

/**
 * PluginExt3ButtonLink représente un bouton qui redirige vers
 * une url lors du click
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage widget
 * @author     jp.thevenoux@atolcd.com
 * @version    1.0
 */
class PluginExt3ButtonLink extends PluginExt3Button
{

  /**
   * Constructor.
   *
   * @param bool  $text        Libellé du bouton
   * @param bool  $url         Url du lien
   * @param array $attributes  An array of default HTML attributes
   * @param array $options     An array of options
   *
   * @see PluginExt3Base
   */
  public function __construct($text, $url, $attributes = array (), $options = array ())
  {
    $defaultAttributes = array('cls'=>'sf_link_button');

    $allAttributes = array_merge($defaultAttributes, $attributes);

    parent::__construct($text, $allAttributes, $options);
    $this->redirectOnClick($url);
  }

}

