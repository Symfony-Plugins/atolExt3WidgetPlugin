<?php
/**
 * dummyExt3FormDoctrine permet de définir un formulaire sans objet pouvant contenir
 * des sous-formulaire
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage form
 * @author     jp.thevenoux@atolcd.com
 * @version    1.0
 */
class dummyExt3FormDoctrine extends PluginExt3FormDoctrine
{
  /**
   * Constructor.
   *
   * @param object $object      Objet représenter par le formulaire, null par défaut
   * @param array  $attributes  An array of default HTML attributes
   * @param array  $options     An array of options
   *
   * @see PluginExt3Base
   */
  public function __construct($object = null, $options = array (), $CSRFSecret = null)
  {
    $this->object = null;

    $this->setDefaults( array ());
    $this->options = $options;

    $this->validatorSchema = new sfValidatorSchema();
    $this->widgetSchema = new PluginExt3FormSchemaExt();
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setup();
    $this->configure();

    $this->addCSRFProtection($CSRFSecret);
    $this->resetFormFields();

  }

  /**
   * Renvoi le type d'objet -> null
   * @return null
   */
  public function getModelName()
  {
    return null;
  }

  /**
   * renvoi si l'objet est nouveau ou pas
   * @return false
   */
  public function isNew()
  {
    return false;
  }

  /**
   * Redéfinition de la fonction
   * -> on ne met pas à jour l'objet
   */
  public function updateObject($values = null)
  {
    if (is_null($values))
    {
      $values = $this->values;
    }
    $values = $this->processValues($values);
    $this->values = $values;

    // embedded forms
    $this->updateObjectEmbeddedForms($values);

    return $this->object;
  }

  /**
   * Redéfinition de la fonction
   * -> on appel la fonction de mise a jour, mais pas de sauvegarde
   */
  protected function doSave($con = null)
  {
    if (is_null($con))
    {
      $con = $this->getConnection();
    }
    $this->updateObject();
    // embedded forms
    $this->saveEmbeddedForms($con);
  }
}


