<?php
/**
 * PluginExt3FormDoctrine permet de définir la base des formulaires
 * lié à un objet doctrine
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage form
 * @author     a.morle@atolcd.com
 * @version    1.0
 */
abstract class PluginExt3FormDoctrine extends sfFormDoctrine
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
  public function __construct($object = null, $options = array (), $CSRFSecret = null)
  {
    $class = $this->getModelName();
    if (!$object)
    {
      $this->object = new $class();
    }
    else
    {
      if (!$object instanceof $class)
      {
        throw new sfException(sprintf('The "%s" form only accepts a "%s" object.', get_class($this), $class));
      }

      $this->object = $object;
      $this->isNew = !$this->object->exists();
    }

    // constructeur de PluginExt3Form -- début
    $this->setDefaults( array ());
    $this->options = $options;

    $this->validatorSchema = new sfValidatorSchema();
    $this->widgetSchema = new PluginExt3FormSchemaExt();
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setup();
    $this->configure();

    $this->addCSRFProtection($CSRFSecret);
    $this->resetFormFields();
    // constructeur de PluginExt3Form -- fin

    $this->updateDefaultsFromObject();

  }

  /**
   * Permet de définir les items du formulaires
   *
   * @param array $widgets Tableau contenant les éléments du formulaire
   */
  public function setWidgets( array $widgets)
  {
    $this->setWidgetSchema( new PluginExt3FormSchemaExt($widgets));
  }

  /**
   * Fonction appelée depuis la fonction saveEmbeddedForms et permet de savoir
   * si il faut ou pas supprimer l'objet. Par défaut, renvoi false
   * @param $objet
   * @return unknown_type
   */
  public function deleteSubObjet($objet)
  {
    return false;
  }

  /**
   * Saves embedded form objects.
   *
   * @param Connection $con   An optional Connection object
   * @param array      $forms An array of forms
   */
  public function saveEmbeddedForms($con = null, $forms = null)
  {
    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    if (is_null($forms))
    {
      $forms = $this->embeddedForms;
    }

    foreach ($forms as $form)
    {
      if ($form instanceof PluginExt3FormDoctrine)
      {
        if ($form->getObject() != null)
        {
          if ($form->deleteSubObjet($form->getObject()))
          {
            if (!$form->getObject()->isNew())
            {
              $form->getObject()->delete();
            }
          }
          else
          {
            $form->getObject()->save($con);
          }
        }
        $form->saveEmbeddedForms($con);
      }
      else
      {
        $this->saveEmbeddedForms($con, $form->getEmbeddedForms());
      }
    }
  }

  /**
   * Updates the values of the object with the cleaned up values.
   *
   * @param  array $values An array of values
   *
   * @return BaseObject The current updated object
   */
  public function updateObject($values = null)
  {
    if (is_null($values))
    {
      $values = $this->values;
    }

    $values = $this->processValues($values);
    $this->values = $values;
    $this->object->fromArray($values);

    // embedded forms
    $this->updateObjectEmbeddedForms($values);

    return $this->object;
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
    if (false === $secret || (null === $secret && false === self::$CSRFSecret))
    {
      return;
    }

    if (is_null($secret))
    {
      if (is_null(self::$CSRFSecret))
      {
        self::$CSRFSecret = md5( __FILE__ .php_uname());
      }

      $secret = self::$CSRFSecret;
    }

    $token = $this->getCSRFToken($secret);

    $this->validatorSchema[self::$CSRFFieldName] = new sfValidatorCSRFToken( array ('token'=>$token));
    $this->widgetSchema[self::$CSRFFieldName] = new PluginExt3Hidden();
    $this->setDefault(self::$CSRFFieldName, $token);
    */
  }

}

