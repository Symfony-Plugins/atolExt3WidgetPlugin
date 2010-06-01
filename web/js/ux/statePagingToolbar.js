/*global Ext */
/**
 * @class Ext.ux.state.PagingToolbar
 * 
 * Ext.PagingToolbar State Plugin
 * 
 * Usage:
 * 
 * var tp = new Ext.PagingToolbar({ plugins:[new Ext.ux.state.PagingToolbar()]
 * ,items:[ ... ] });
 */

Ext.ns('Ext.ux.state');

// dummy constructor
Ext.ux.state.PagingToolbar = function() {
};

Ext.override(Ext.ux.state.PagingToolbar, {
  /**
   * Initializes the plugin
   * 
   * @param {Ext.PagingToolbar}
   *          tabpanel
   * @private
   */
  init : function(pagingToolbar) {
    pagingToolbar.stateEvents = pagingToolbar.stateEvents || [];
    pagingToolbar.stateEvents.push('change');

    // add state related props to the tree
    Ext.apply(pagingToolbar, {

        // apply state on tree initialization
        applyState:function(state) {
          if(state) {
            Ext.apply(this, state);
          }
        } // eo function applyState
        
        // returns start page
        ,getState:function() {
          return {cursor:this.cursor};
        } // eo function getState
    });
  } // eo function init
  }); // eo override

// eof

