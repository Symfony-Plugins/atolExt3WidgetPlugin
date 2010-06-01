// A renommer quand on aura trouvé un joli nom pour le plugins

Ext.namespace('atolExt3WidgetPlugin');

atolExt3WidgetPlugin.cascadeFunctionToCall = function() {
  if (this.functionToCall != null) {
    for (fct in this.functionToCall) {
      if (typeof (this[fct]) == 'function') {
        this[fct](this.functionToCall[fct]);
      }
    }
    delete this.functionToCall;
  }
};

atolExt3WidgetPlugin.updateStringFromField = function(chaine, objet, carac) {
  // déclaration des variables :
  var newChaine, s;
  // initialisation des variables :
  newChaine = chaine;
  carac = carac || '%40';
  s = '' + carac + carac;

  var Expression = new RegExp("(" + s + "[a-zA-Z]*" + s + ")", "gi");
  tabChamps = newChaine.match(Expression);
  if (tabChamps != null) {
    for (field in tabChamps) {
      if (typeof (tabChamps[field]) == 'string') {
        propriete = tabChamps[field].replace(new RegExp(s, "gi"), '');
        // propriete = tabChamps[field].substring(6, tabChamps[field].length -
        // );
        if (objet[propriete] != null) {
          newChaine = newChaine.replace(new RegExp(tabChamps[field], "gi"),
              objet[propriete]);
        }
      }
    }
  }
  return newChaine;
};

Ext
.apply(
    Ext.util.Format,
    {
      atolExt3WidgetPluginRendererURL : function(value, metadata, record, rowIndex,
          colIndex, store) {
        if (this.url) {
            if (value) 
            {
              urlResult = atolExt3WidgetPlugin.updateStringFromField(this.url, record.data);
              return '<a href="' + urlResult + '">' + value + '</a>';
            }
        }
        return value;
      },
      atolExt3WidgetPluginRendererButton : function(value, metadata, record, rowIndex,
          colIndex, store) {
        if (this.url) {
          urlResult = atolExt3WidgetPlugin.updateStringFromField(this.url, record.data);
          classResult = atolExt3WidgetPlugin.updateStringFromField(this.classe, record.data);
          qtipResult = atolExt3WidgetPlugin.updateStringFromField(this.qtip, record.data);
          return '<a href="' + urlResult + '"><div ext:qtip="' + qtipResult
              + '" class="' + classResult + '">&nbsp;</div></a>';
        }
        return value;
      },
      atolExt3WidgetPluginRendererIcon : function(value, metadata, record, rowIndex,
          colIndex, store) {
        if (value != '' && value != null) {
          return '<img src="' + value + '"></img>';
        } else {
          return value;
        }
      },
      atolExt3WidgetPluginRendererBoolean : function(value, metadata, record, rowIndex,
          colIndex, store) {
        var classResult = (value ? 'clsTRUE' : 'clsFALSE');
        return '<div class="' + classResult + '">&nbsp;</div>';
      }
    });