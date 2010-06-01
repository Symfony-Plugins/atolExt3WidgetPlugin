<?php
/**
 * PluginExt3Grid représente une grille
 *
 * @package    atolExt3WidgetPlugin
 * @subpackage widget
 * @author     jp.thevenoux@atolcd.com
 * @version    1.0
 */
class PluginExt3Grid extends PluginExt3Base
{

  /**
   * Constructor.
   *
   * @param array  $attributes  An array of default HTML attributes
   * @param array  $options     An array of options
   *
   * @see PluginExt3Panel
   */
  public function __construct($attributes = array (), $options = array ())
  {
    parent::__construct(false, $attributes, $options);
  }

  /**
   * Permet de configurer les propriétés de base de la grille
   *
   * @param array $attributes  An array of default HTML attributes
   * @param array $options     An array of options
   */
  protected function configure($options = array (), $attributes = array ())
  {
    $this->setAttribute('xtype', 'grid');
    $this->setAttribute('columns', array ());
  }

  /**
   * Permet d'ajouter des colonnes à la grille
   *
   * @param object $obj un objet de type PluginExt3Base ou un tableau de PluginExt3Base
   */
  public function addColumns($obj)
  {
    if (is_array($obj))
    {
      foreach ($obj as $column)
      {
        $this->addColumns($column);
      }
    }
    if ($obj instanceof PluginExt3Base)
    {
      $this->addColumn($obj);
    }
  }

  /**
   * Permet d'ajouter une colonne à la grille
   *
   * @return
   * @param object $entete    PluginExt3Base : objet représentant la définition de la colonne, ou string contenant le libellé de la colonne
   * @param object $dataIndex Libellé du champs dans le store correspondant à cette colonne, null par défaut
   * @param object $width     Largeur de la colonne, null par défaut
   * @param object $renderer  Renderer à utiliser pour cette colonne, null par défaut
   * @param object $sortable  Précise si la colonne est triable ou pas, true par defaut
   * @param object $hidden    Précise si la colonne est visible ou pas, null par défaut
   */
  public function addColumn($entete, $dataIndex = null, $width = null, $renderer = null, $sortable = true, $hidden = null)
  {
    if ($entete == null)
    {
      return;
    }
    if ($entete instanceof PluginExt3Base)
    {
      $column = $entete;
    }
    else
    {
      $column = new PluginExt3Base(false);
      $column->setAttribute('header', $entete);
      if ($dataIndex != null)
      {
        $column->setAttribute('dataIndex', $dataIndex);
      }
      if ($width != null)
      {
        $column->setAttribute('width', $width);
      }
      if ($renderer != null)
      {
        $column->setAttribute('renderer', $renderer);
        if ($renderer == 'atolExt3WidgetPluginRendererIcon' || $renderer == 'atolExt3WidgetPluginRendererButton')
        {
          $column->setAttribute('menuDisabled', true);
        }
      }
      if ($sortable != null)
      {
        $column->setAttribute('sortable', $sortable);
      }
      if ($hidden != null)
      {
        $column->setAttribute('hidden', $hidden);
      }
    }
    $columns = $this->getAttribute('columns');
    $columns[] = $column;
    $this->setAttribute('columns', $columns);
    return $column;
  }
}

