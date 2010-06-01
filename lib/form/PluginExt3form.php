<?php
/**
 * PluginExt3form permet de définir un formulaire complet
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage form
 * @author     a.morle@atolcd.com
 * @version    1.0
 */
class PluginExt3form extends sfForm
{

  /**
   * Constructor.
   *
   * @param array  $defaults    An array of field default values
   * @param array  $options     An array of options
   * @param string $CSRFSecret  clé de protection
   *
   * @see sfWidgetForm
   */
  public function __construct($defaults = array(), $options = array(), $CSRFSecret = null) {
    $this->setDefaults($defaults);
    $this->options = $options;

    $this->validatorSchema = new sfValidatorSchema();
    $this->widgetSchema    = new PluginExt3FormSchemaExt();
    $this->errorSchema     = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setup();
    $this->configure();

    $this->addCSRFProtection($CSRFSecret);
    $this->resetFormFields();
  }

  /**
   * Permet de définir les items du formulaires
   *
   * @param array $widgets Tableau contenant les éléments du formulaire
   */
  public function setWidgets(array $widgets)
  {
    $this->setWidgetSchema(new PluginExt3FormSchemaExt($widgets));
  }


  /**
   * Adds CSRF protection to the current form.
   *
   * @param string $secret The secret to use to compute the CSRF token
   */
  public function addCSRFProtection($secret = null)
  {
    if (null === $secret)
    {
      $secret = $this->localCSRFSecret;
    }

    if (false === $secret || (null === $secret && false === self::$CSRFSecret))
    {
      return $this;
    }

    if (null === $secret)
    {
      if (null === self::$CSRFSecret)
      {
        self::$CSRFSecret = md5(__FILE__.php_uname());
      }

      $secret = self::$CSRFSecret;
    }

    $token = $this->getCSRFToken($secret);

    $this->validatorSchema[self::$CSRFFieldName] = new sfValidatorCSRFToken(array('token' => $token));
    $this->widgetSchema[self::$CSRFFieldName] = new PluginExt3Hidden();
    $this->setDefault(self::$CSRFFieldName, $token);

    return $this;  
    /*
    if (false === $secret || (is_null($secret) && !self::$CSRFProtection))
    {
      return;
    }

    if (is_null($secret))
    {
      if (is_null(self::$CSRFSecret))
      {
        self::$CSRFSecret = md5(__FILE__.php_uname());
      }

      $secret = self::$CSRFSecret;
    }

    $token = $this->getCSRFToken($secret);

    $this->validatorSchema[self::$CSRFFieldName] = new sfValidatorCSRFToken(array('token' => $token));
    $this->widgetSchema[self::$CSRFFieldName] = new PluginExt3Hidden();
    $this->setDefault(self::$CSRFFieldName, $token);
    */
  }

  /**
   * Génere un décorator (string) pour etre intégré dans un panel.
   * Fonction qui peut etre appeléee pour générer le troisieme parametre (decorator) de la fonction embedform d'un sfform par exemple.
   */
  public static function generateDefaultDecorator($attributes)
  {
    $attributesDebase = array ();
    $lesAttributes = array_merge($attributes, $attributesDebase);
    $decorator = new PluginExt3Base(false, $lesAttributes);
    $decorator->setAttribute('@items', "[%content%]");
    return $decorator->__toString();
  }

  /**
   * Genere un décorator de type panel.
   * @return
   * @param object $attributes
   */
  public static function generatePanelDecorator($attributes)
  {
    $attributesDebase = array ();
    $attributesDebase['xtype'] = 'panel';
    $lesAttributes = array_merge($attributes, $attributesDebase);
    return PluginExt3form::generateDefaultDecorator($lesAttributes);
  }

  /**
   * Genere un décorator de type panel.
   * @return
   * @param object $attributes
   */
  public static function generateInlineFormDecorator($attributes = null)
  {
    if ($attributes == null)
    {
      $attributes = array();
    }
    $attributesDebase = array ();
    $attributesDebase['xtype'] = 'fieldset';
    $attributesDebase['border'] = false;
    $a = new PluginExt3Base(false);
    $a->setAttribute('@fieldTpl', 'new Ext.Template(\'<div class="{itemCls}" tabIndex="-1" style="display:inline"><label for="{id}" class="x-form-item-label">{label}{labelSeparator}</label><div id="x-form-el-{id}" style="display:inline"></div></div>\')');
    $attributesDebase['layoutConfig'] = $a;
    $attributesDebase['style'] = 'padding: 1px;';

    $lesAttributes = array_merge($attributes, $attributesDebase);
    return PluginExt3form::generateDefaultDecorator($lesAttributes);
  }

  /**
   * Genere un décorator de type fielset.
   * @return
   * @param object $attributes
   */
  public static function generateFieldSetDecorator($attributes = null)
  {
    if ($attributes == null)
    {
      $attributes = array();
    }
    $attributesDebase = array ();
    $attributesDebase['xtype'] = 'fieldset';
    $attributesDebase['forceLayout'] = true;
    $lesAttributes = array_merge($attributes, $attributesDebase);
    return PluginExt3form::generateDefaultDecorator($lesAttributes);
  }

  /**
   * Génère un décorateur de type fieldset avec checkbox
   * @param $attributes
   * @return unknown_type
   */
  public static function generateFieldSetWithCheckboxDecorator($attributes = null)
  {
    if ($attributes == null)
    {
      $attributes = array();
    }
    $attributesDebase = array ();
    $attributesDebase['xtype'] = 'fieldsetwithcheckbox';
    $attributesDebase['forceLayout'] = true;
    $lesAttributes = array_merge($attributes, $attributesDebase);
    return PluginExt3form::generateDefaultDecorator($lesAttributes);
  }

  /**
   * Génère un décorateur de type colonne
   * @param $columnSize
   * @param $attributes
   * @return unknown_type
   */
  public static function generateColumnDecorator($columnSize = .45, $attributes = null)
  {
    if ($attributes == null)
    {
      $attributes = array();
    }
    $attributesDebase = array ();
    $attributesDebase['xtype'] = 'panel';
    $attributesDebase['layout'] = 'column';
    $attributesDebase['border'] = false;
    $lesAttributes = array_merge($attributes, $attributesDebase);
    $decorator = new PluginExt3Base(false, $lesAttributes);
    $decorator->addAttributesData('defaults', 'layout', 'form');
    $decorator->addAttributesData('defaults', 'border', false);
    $decorator->setAttribute('@items', "[{columnWidth: $columnSize, items:[%content%]}]");
    return $decorator->__toString();
  }

  /**
   * Génère une nouvelle colonne (à utiliser avec generateColumnDecorator)
   * @param $columnSize
   * @return unknown_type
   */
  public static function generateNewColumnDecorator($columnSize = .50)
  {
    return "]},{columnWidth: $columnSize, items:[%content%";
  }

  /**
   * Génère une nouvelle colonne contenant un fieldset
   * @param $title
   * @param $columnSize
   * @return unknown_type
   */
  public static function generateNewColumnContainerDecorator($title = null, $columnSize = .50)
  {
    return "]},{columnWidth: $columnSize, border: true, style:'padding: 10px;', title:'$title', xtype:'fieldset', items:[%content%";
  }
}

