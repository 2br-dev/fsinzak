(window.webpackJsonp=window.webpackJsonp||[]).push([[60],{365:function(e,t,i){"use strict";var a=i(7),s=i(1);t.a={data:()=>({tinymceOptions:{height:200,theme:"modern",plugins:["link image lists anchor","searchreplace wordcount visualblocks visualchars code fullscreen media","save table contextmenu paste textcolor"],menubar:"file edit view",toolbar:"insertfile undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",language:"ru"},tinymceInlineOptions:{toolbar_items_size:"small",language:"ru",menubar:!1,inline:!0,plugins:"link textcolor",toolbar:"bold italic underline strikethrough",valid_elements:"*",valid_styles:{"*":"font-size,font-family,color,text-decoration,text-align"},extended_valid_elements:"*[*]",cleanup:!1,verify_html:!1,powerpaste_word_import:"clean",powerpaste_html_import:"clean",content_css:[]}}),methods:{getItemValue(e,t,i=null){let a=this.getItem();if(i){if(a.childs[i][e]&&a.childs[i][e][t])return a.childs[i][e][t].value;console.error(lang.t(`No property "${t}" in SUB CHILD item[${e}]`),a.childs[i][e])}else{if(a[e]&&a[e][t])return a[e][t].value;console.error(lang.t(`No property "${t}" in item[${e}]`),a[e])}return""},getItem(){switch(this.itemType){case s.a.atom:return this.getAtomData(this.blockId,this.itemId);case s.a.column:return this.getColumnData(this.blockId,this.itemId);case s.a.row:return this.getRowData(this.blockId,this.itemId);default:throw new Error(lang.t("Нет метода для получения данных. Тип: %0",[this.itemType]))}},getItemOptions(){return this.getItem()[this.keyName][this.item.name].data.options},setItemData(e){switch(this.itemType){case s.a.atom:this.setAtomData(e);break;case s.a.column:this.setColumnData(e);break;case s.a.row:this.setRowData(e);break;default:throw new Error(lang.t("Нет метода для получения данных. Тип: %0",[this.itemType]))}},setAtomKeyValue(e){let t=this.getItem();t[this.item.name]=e,this.setItemData(t);let i=new CustomEvent("designer.redraw-atom."+t.id,{detail:{id:t.id,value:e}});document.dispatchEvent(i),setTimeout(()=>{this.checkIfNeedSendEventAfterEdit(t)},500)},addStyleIfNeeded(e,t){"css"==this.keyName&&("background-image"==e&&t.trim().length&&(t="url('"+t+"')"),this.addStyleParameter(e,t))},checkIfNeedSendEventAfterEdit(e){if(e[this.keyName][this.item.name].debug_event){let t=new CustomEvent(e[this.keyName][this.item.name].debug_event,{detail:{id:this.itemId}});document.dispatchEvent(t)}},sendDataValueFromEvent(e){let t=e.target.value;"background-image"==this.item.name&&(t=t.replaceAll(" ","%20"));let i=this.getItem();"css"==this.keyName&&this.itemChildId?i.childs[this.itemChildId][this.keyName][this.item.name].value=t:(i[this.keyName][this.item.name].value=t,this.checkIfNeedSendEventAfterEdit(i)),this.setItemData(i)},sendDataValue(e){let t=this.getItem();"background-image"==this.item.name&&(e=e.replaceAll(" ","%20")),"css"==this.keyName&&this.itemChildId?t.childs[this.itemChildId][this.keyName][this.item.name].value=e:(t[this.keyName][this.item.name].value=e,this.checkIfNeedSendEventAfterEdit(t)),this.setItemData(t)},clear(){this.sendDataValue(""),this.isHoverable&&this.sendDataHoverValue("")},getStyleLikeObject(){let e=this.getItem();return s.b.convertInlineStyleToObject(e.attrs.style.value)},addStyleParameter(e,t){let i=this.getStyleLikeObject();"string"==typeof t?0==(t=t.trim()).length?delete i[e]:i[e]=t:"object"==typeof t&&(i[e]=t);let a=this.getItem();a.attrs.style.value=s.b.convertStyleObjectToString(i),this.setItemData(a)},...Object(a.b)("blocks",["setAtomData","setRowData","setColumnData"])},computed:{itemValue(){return this.getItemValue(this.keyName,this.item.name,this.itemChildId)},itemHoverValue(){return this.getItemHoverValue(this.keyName,this.item.name,this.itemChildId)},...Object(a.c)("blocks",["getAtomData","getColumnData","getRowData"])}}},381:function(e,t,i){"use strict";t.a={methods:{getTitleForValue(e){return this.getItemOptions()[e]},getName(){return this.keyName+"["+this.item.name+"]"},toggleValue(){this.sendDataValue(this.itemValue?0:1)}}}},454:function(e,t,i){"use strict";i.r(t);var a=function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("div",{staticClass:"d-menu-control-toggle-checkbox"},[i("input",{attrs:{id:e.getName(),value:"1",type:"checkbox"},domProps:{checked:e.itemValue},on:{click:function(t){return t.stopPropagation(),e.toggleValue()}}}),e._v(" "),i("label",{attrs:{for:e.getName()},on:{click:function(t){return t.preventDefault(),t.stopPropagation(),e.toggleValue()}}},[e._v(e._s(e.lang("Включить")))])])};a._withStripped=!0;var s=i(365),l=i(381),n={name:"ControlToggleCheckbox",mixins:[s.a,l.a],props:{keyName:{type:String,required:!0},blockId:{type:[String,Number],required:!0},itemType:{type:String,required:!0},itemId:{type:String,required:!0},item:{type:Object,required:!0},itemChildId:{type:[String,Number]}}},r=i(98),o=Object(r.a)(n,a,[],!1,null,null,null);o.options.__file="-readyscript/modules/designer/view/js/app/src/components/leftpanel/controls/togglecheckbox/togglecheckbox.vue";t.default=o.exports}}]);