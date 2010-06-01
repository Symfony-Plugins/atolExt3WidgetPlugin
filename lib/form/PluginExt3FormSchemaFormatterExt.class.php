<?php
/**
 * PluginExt3FormSchemaFormatterExt représente la définition du widget format
 * utilisé par la classe PluginExt3form
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage form
 * @author     a.morle@atolcd.com
 * @version    1.0
 */
class PluginExt3FormSchemaFormatterExt extends sfWidgetFormSchemaFormatter
{
  protected
  $rowFormat = "%field%",
  $errorRowFormat = "",
  $helpFormat = "",
  $decoratorFormat = "%content%";
}

