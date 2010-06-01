<?php

/**
 * PluginExt3Base is the base class for all ext form widgets.
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage widget
 * @author     jp.thevenoux@atolcd.com
 * @version    1.0
 */
class PluginExt3Base extends sfWidgetForm
{
  // liste des propriétés qui sont affichés sans mises en forme
  // et dont le type n'est pas reconnaissable
  protected $rawListAttributes = array ();
  // Liste des propriétés qui doivent être interprété comme un objet
  protected $sameAsObject = array ();
  // Liste des items enfants
  protected $items = null;
  // Précise si il faut ou non créé un objet de type hidden
  protected $needHidden = false;
  protected $classPrefix = '';
  protected $classSufix = '';
  protected $nameValueField = 'value';
  protected $valueDefault = null;

  /**
   * Constructor.
   *
   * @param bool  $isContainer Précise si l'objet est un container ou non
   * @param array $attributes  An array of default HTML attributes
   * @param array $options     An array of options
   *
   * @see sfWidgetForm
   */
  public function __construct($isContainer = false, $attributes = array (), $options = array ())
  {
    $this->isContainer = $isContainer;
    $this->setSameAsObject('functionToCall');
    $this->addRawAttribute('validator');
    $this->addRawAttribute('html');

    parent::__construct($options, $attributes);
    if ($this->isContainer)
    {
      $this->items = array ();
    }
  }

  /**
   * Définit le préfixe et le sufixe de la classe
   *
   * @param string $prefix Le préfixe de la classe
   * @param string $sufix Le sufix de la classe
   *
   */
  public function setPrefixAndSufix($prefix, $sufix)
  {
    $this->classPrefix = $prefix;
    $this->classSufix = $sufix;
  }

  /**
   * Redéfinition de la fonction __toString
   *
   *
   */
  public function __toString()
  {
    try
    {
      return str_replace(array(",}", ",]"), array("}","]"), $this->renderJSON());
    }
    catch(Exception $e)
    {
      self::setToStringException($e);
      // we return a simple Exception message in case the form framework is used out of symfony.
      return 'Exception: '.$e->getMessage();
    }
  }

  /**
   * Permet de définir un nom d'enregistrement de l'état
   * Si on ne le définit pas, aucun état ne sera sauvegarder
   * @param $stateId identifiant à définir
   */
  public function setStateId($stateId)
  {
    $this->setAttribute('stateId', $stateId);
  }
  /**
   * Redefinition de la fonction render pour écrire la définition
   * JSON du composant
   *
   * @param  string $name       The name of the HTML widget
   * @param  mixed  $value      The value of the widget
   * @param  array  $attributes An array of HTML attributes
   * @param  array  $errors     An array of errors
   *
   * @return string représentation JSON de l'objet
   */
  public function render($name, $value = null, $attributes = array (), $errors = array ())
  {
    if (is_null($value))
    {
      $value = $this->valueDefault;
    }
    $attributes = array_merge( array ('name'=>$name, $this->nameValueField=>$value), $attributes);
    if ($this->needHidden)
    {
      $attributes = array_merge( array ('hiddenName'=>$name), $attributes);
    }
    return str_replace(array(",}", ",]"), array("}","]"), $this->renderJSON($attributes));
  }

  /**
   * Permet d'écrire l'objet global en JSON
   *
   * @param  array  $attributes Tableau d'attributs supplémentaires de l'objet
   *
   * @return string représentation JSON de l'objet
   */
  protected function renderJSON($attributes = array ())
  {
    $attributes = array_merge($this->attributes, $attributes);
    if ($this->isContainer)
    {
      $attributes = array_merge($attributes, array ('items'=>$this->items));
    }
    return $this->classPrefix.$this->attributesToJSON($attributes).$this->classSufix;
  }

  /**
   * Permet d'écrire une liste d'attribut au format JSON
   *
   * @param array  $attributes Tableau d'attribut à écrire
   * @param string $prefix     Préfixe à utiliser pour l'objet (accolade par défaut)
   * @param string $suffix     Sufixe à utiliser pour l'objet (accolade par défaut)
   *
   * @return string représentation JSON de l'objet
   */
  protected function attributesToJSON($attributes, $prefix = "\n{", $suffix = "}")
  {
    return $prefix.implode(',', array_map( array ($this, 'attributesToJSONCallback'), array_keys($attributes), array_values($attributes))).$suffix;
  }

  /**
   * Permet d'écrire une propriété en fonction de son type
   *
   * @param string $k Clé de la propriété
   * @param array/string/obj/bool/... $v Valeur de la propriété
   *
   * @return string représentation JSON de la propriété
   */
  protected function attributesToJSONCallback($k, $v)
  {
    // test pour les raw values => @*
    $isRawValue = false;
    if (strpos($k, '@') !== false)
    {
      $k = substr($k, 1);
      $isRawValue = true;
    }

    if (is_null($k) || is_numeric($k))
    {
      $debut = '';
    }
    else
    {
      $debut = sprintf("%s:", $k);
    }

    if (is_null($v))
    {
      return $debut.'null';
    }

    if (is_bool($v))
    {
      return $debut.($v == true?'true':'false');
    }

    if (is_numeric($v))
    {
      if($k == 'value' && substr($v, 0, 1) == '0')
      {
        return $debut.sprintf('"%s"', $v);
      }
      else
      {
        return $debut.$v;
      } 
    }

    if ($isRawValue)
    {
      return $debut.$v;
    }

    if (is_object($v))
    {
      if (method_exists($v, 'getRawValue'))
      {
        $v = $v->getRawValue();
      }
      if (method_exists($v, 'count'))
      {
        if ($v->count() > 1)
        {
          return $debut.sprintf("[%s]", $v->__toString());
        }
      }
      if (method_exists($v, '__toString'))
      {
        return $debut.sprintf("%s", $v->__toString());
      }
      return $debut.sprintf("%s", json_encode($v));
    }

    if (in_array($k, $this->sameAsObject, true))
    {
      return $debut.$this->attributesToJSON($v);
    }

    if (is_array($v))
    {
      return $debut.$this->attributesToJSON($v, '[', ']');
    }

    if (in_array($k, $this->rawListAttributes, true))
    {
      return $debut.sprintf("%s", $v);
    }
    //return $debut.sprintf('"%s"', $this->escapeOnce($v));
    return $debut.sprintf('"%s"', str_replace(array("\n", "\r"),array('\n', ''),addslashes($v)));
  }

  /**
   * Ajoute un attribut dans la liste des propriétés sans mise en forme
   * de type caractère ( attribut: valeur et non attribut: "valeur" )
   *
   * @param string $name Nom de l'attribut
   *
   */
  public function addRawAttribute($name)
  {
    $this->rawListAttributes[$name] = $name;
  }

  /**
   * Ajoute un attribut dans la liste des propriétés à mettre en forme comme
   * un objet (entouré de d'accolade)
   *
   * @param string $name Nom de l'attribut
   *
   */
  public function setSameAsObject($name)
  {
    $this->sameAsObject[$name] = $name;
  }

  /**
   * Définis tous les items de l'objet
   *
   * @param array/object $items collection, tableau, objet définissant les items
   * enfant de l'objet en cour
   *
   */
  public function setItems($items)
  {
    if ($this->isContainer)
    {
      $this->items = $items;
    }
  }

  /**
   * Ajoute un item enfant à l'objet courant
   *
   * @param array/object $items collection, tableau, objet définissant l'item
   * à ajouter
   *
   */
  public function addItem($item)
  {
    if ($this->isContainer)
    {
      $this->items[] = $item;
    }
  }

  /**
   * Ajoute un dans un attribut un couple nom/valeur
   *
   * @param string $attributes Nom de l'attribut contenant la nouvelle propriété
   * @param string $name       Nom de la nouvelle propriété
   * @param string $value      Valeur de la nouvelle propriété
   * @example addAttributesData("defaults", "width", "200");
   */
  public function addAttributesData($attributes, $name, $value)
  {
    $att = parent::getAttribute($attributes);
    if ($att == null)
    {
      $att = array ();
    }
    $att[$name] = $value;
    $this->setSameAsObject($attributes);
    $this->addRawAttribute($attributes);
    $this->setAttribute($attributes, $att);
  }

  /**
   * Définit une propriété de l'objet
   *
   * @param string $name       Nom de la nouvelle propriété
   * @param string $value      Valeur de la nouvelle propriété
   * @example setAttribute("width", "200");
   */
  public function setAttribute($name, $value)
  {
    if ($name == 'items') {
      $this->setItems($value);
    } else {
      parent::setAttribute($name, $value);
    }
  }


  /**
   * Renvoi un sfValidator de base (pass)
   *
   * @return sfValidator  un sfValidatorPass
   */
  public function getValidator()
  {
    $configValidator = array ();
    $configValidator['required'] = false;
    return new sfValidatorPass($configValidator);
  }

}

