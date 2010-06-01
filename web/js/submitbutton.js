Ext.namespace('Ext.ux');

Ext.ux.SubmitButton = Ext.extend(Ext.Button, {
    formBind: true,
    parentType: 'form',

    initComponent: function(){
        Ext.ux.SubmitButton.superclass.initComponent.call(this);
        this.handler = this.submit;
    },

    submit: function() {
      var form = this.getForm();
      if (form != null) {
        if (this.url == null) {
          form.body.dom.action = form.url;
        } else {
          form.body.dom.action = this.url;
        }
        form.getForm().submit();
      }
    },
    
    getForm: function() {
      if (this.idForm != null)
        return Ext.getCmp(this.idForm);
        
      return this.findParentByType(this.parentType);
    }
});

Ext.reg('submitbutton', Ext.ux.SubmitButton);
