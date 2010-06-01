<?php
/**
 * PluginExt3FormSchemaExt représente un tableau d'élement, et permet de les afficher
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage form
 * @author     a.morle@atolcd.com
 * @version    1.0
 */
class PluginExt3FormSchemaExt extends sfWidgetFormSchema
{
  /**
   * Constructor.
   *
   * @param mixed $fields     Initial fields
   * @param array $options    An array of options
   * @param array $attributes An array of default HTML attributes
   * @param array $labels     An array of HTML labels
   * @param array $helps      An array of help texts
   *
   * @see sfWidgetFormSchema
   */
  public function __construct($fields = null, $options = array (), $attributes = array (), $labels = array (), $helps = array ())
  {
    parent::__construct($fields, $options, $attributes, $labels, $helps);

    $decorator = new PluginExt3FormSchemaFormatterExt($this);
    $this->addFormFormatter('ext', $decorator);
    $this->setFormFormatterName('ext');
  }

  /**
   * Redéfinition de la fonction "Renders" qui "affichent" les éléments
   *
   * @param  string $name        The name of the HTML widget
   * @param  mixed  $values      The values of the widget
   * @param  array  $attributes  An array of HTML attributes
   * @param  array  $errors      An array of errors
   *
   * @return string An HTML representation of the widget
   */
  public function render($name, $values = array (), $attributes = array (), $errors = array ())
  {
    if (is_null($values))
    {
      $values = array ();
    }

    if (!is_array($values) && !$values instanceof ArrayAccess)
    {
      throw new InvalidArgumentException('You must pass an array of values to render a widget schema');
    }

    $formFormat = $this->getFormFormatter();

    $rows = array ();
    $hiddenRows = array ();
    $errorRows = array ();

    // render each field
    foreach ($this->positions as $name)
    {
      $widget = $this[$name];
      $value = isset ($values[$name])?$values[$name]:null;
      $error = isset ($errors[$name])?$errors[$name]: array ();
      $widgetAttributes = isset ($attributes[$name])?$attributes[$name]: array ();

      if ($widget instanceof sfWidgetForm && $widget->isHidden())
      {
        $hiddenRows[] = $this->renderField($name, $value, $widgetAttributes);
      }
      else
      {
        $label = $this->getFormFormatter()->generateLabelName($name);

        $errorAsTab = $error;
        $error = is_array($error)?implode('', $error):
          ''.$error;
        if (!$widget instanceof PluginExt3Hidden)
        {
          if(!array_key_exists('fieldLabel',$widget->attributes))
          {
            $widgetAttributes = array_merge($widgetAttributes, array ('fieldLabel'=>$label));
          }

          if(!array_key_exists('invalidText',$widget->attributes))
          {
            $widgetAttributes = array_merge($widgetAttributes, array ('invalidText'=>$error));
          }
        }
        if ($error != "")
        {
          $widgetAttributes = array_merge($widgetAttributes, array ('functionToCall'=>( array ('markInvalid'=>''.$error))));
        }
        $field = $this->renderField($name, $value, $widgetAttributes, $errorAsTab);

        // don't add a label tag and errors if we embed a form schema

        $rows[] = $formFormat->formatRow($label, $field, $error, $this->getHelp($name));
      }
    }

    if ($rows)
    {
      // insert hidden fields in the last row
      for ($i = 0, $max = count($rows); $i < $max; $i++)
      {
        $rows[$i] = strtr($rows[$i], array ('%hidden_fields%'=>$i == $max-1?implode("\n", $hiddenRows):
            ''));
      }
    }
    else
    {
      // only hidden fields
      $rows[0] = implode("\n", $hiddenRows);
    }

    return $this->getFormFormatter()->formatErrorRow($this->getGlobalErrors($errors)).implode(',', $rows);
  }

}

