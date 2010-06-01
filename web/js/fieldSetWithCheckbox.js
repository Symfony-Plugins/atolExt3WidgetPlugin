atolExt3WidgetPlugin.FieldSetWithCheckbox = Ext.extend(Ext.form.FieldSet, 
{
  initComponent: function() 
  {
    this.neverExpand = true;
    
    atolExt3WidgetPlugin.FieldSetWithCheckbox.superclass.initComponent.call(this);
    if (this.checkboxId) 
    {
      this.hiddenCheckboxValue = Ext.getCmp(this.checkboxId);
      //this.checked = !(this.hiddenCheckboxValue.value == null || this.hiddenCheckboxValue.value == 0);
      this.checked = this.hiddenCheckboxValue.value == true;
      if (!this.collapsible) {
        this.collapsed = !this.checked; 
      } else {
        this.hiddenCheckboxValue.value = (this.hiddenCheckboxValue.value == true ? 1 : 0); 
      }
      this.hiddenCheckboxValue.addEvents({'valuechange': true});
      this.hiddenCheckboxValue.setValue = function(v) 
        {
          v = ((v== true || v==1 || v=='on') ? 1 : 0);
          Ext.form.Hidden.superclass.setValue.call(this, v);
          this.fireEvent('valuechange', this, v);
        };
  
      this.hiddenCheckboxValue.on('valuechange', function(field, value) 
      {
        if(this.rendered)
        {
          if (value==0 || !value) 
          {
            this.collapse();
          } 
          else 
          {
            this.expand();
          }
        }
      }, this);      
    }
  },

  onCheckClick : function() 
  {
    this.hideShowTool();
    if (this.hiddenCheckboxValue != null)
    {
      this.hiddenCheckboxValue.setValue(this.checkbox.dom.checked ? 1 : 0);
    }
  },

  hideShowTool: function()
  {
    if (this.collapsible)
    {
      if (this.checkbox.dom.checked == 0)
      {
        this.tools.toggle.hide();
      }
      else 
      {
        this.tools.toggle.show();
      }
    }    
  },
  
  onCollapse : function(doAnim, animArg){
      Ext.form.FieldSet.superclass.onCollapse.call(this, doAnim, animArg);
  },

  onExpand : function(doAnim, animArg){
    Ext.form.FieldSet.superclass.onExpand.call(this, doAnim, animArg);
    if (this.neverExpand && this.rendered)
    {
      this.doLayout();
      delete this.neverExpand;
    }    
  },
  
  expand : function(animate){
    if (this.checkbox.dom.checked == 1)
    {
      var originalValue = "";
      if (this.hiddenCheckboxValue != null)
      {
        originalValue = this.hiddenCheckboxValue.originalValue;
      }
      if (originalValue != "" || !this.collapsible)
      {
        atolExt3WidgetPlugin.FieldSetWithCheckbox.superclass.expand.call(this, animate)
      }
    }
    return this;
  },
  
  onRender : function(ct, position){
    if(!this.el)
    {
        this.el = document.createElement('fieldset');
        this.el.id = this.id;
        if (this.title || this.header || this.checkboxToggle) 
        {
            this.el.appendChild(document.createElement('legend')).className = 'x-fieldset-header';
        }
    }

    Ext.form.FieldSet.superclass.onRender.call(this, ct, position);

    if(this.checkboxToggle){
        var o = typeof this.checkboxToggle == 'object' ?
                this.checkboxToggle :
                {tag: 'input', type: 'checkbox', name: this.checkboxName || this.id+'-checkbox'};
        this.checkbox = this.header.insertFirst(o);
        this.checkbox.dom.checked = this.checked;
        delete this.checked;
        this.mon(this.checkbox, 'click', this.onCheckClick, this);
        if (this.readonly) {
          this.checkbox.dom.disabled="disabled";
        }
    }
    this.hideShowTool();
  },
  
  checkboxToggle : true
});

Ext.reg('fieldsetwithcheckbox', atolExt3WidgetPlugin.FieldSetWithCheckbox);
