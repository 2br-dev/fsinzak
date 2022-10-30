
{addcss file="%templates%/previewblock.css"}
{addjs file="%templates%/previewblock.js"}

<div class="previewConstructor">
    <div class="formbox" >
                        <form method="POST" action="{urlmake}" enctype="multipart/form-data" class="crud-form">
            <input type="submit" value="" style="display:none">
            <div class="notabs">
                                                                                                            
                                                                                            
                                                                                            
                                                                                            
                                                                                            
                                                                                            
                                                                                            
                                                                                            
                                                                                            
                                                                                            
                                                                                            
                                                    
                                    <table class="otable">
                                                                                                                    
                                <tr>
                                    <td class="otitle">{$elem.__width_xl->getTitle()}&nbsp;&nbsp;{if $elem.__width_xl->getHint() != ''}<a class="help-icon" title="{$elem.__width_xl->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__width_xl->getRenderTemplate() field=$elem.__width_xl}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__inset_align_xl->getTitle()}&nbsp;&nbsp;{if $elem.__inset_align_xl->getHint() != ''}<a class="help-icon" title="{$elem.__inset_align_xl->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__inset_align_xl->getRenderTemplate() field=$elem.__inset_align_xl}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__align_items_xl->getTitle()}&nbsp;&nbsp;{if $elem.__align_items_xl->getHint() != ''}<a class="help-icon" title="{$elem.__align_items_xl->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__align_items_xl->getRenderTemplate() field=$elem.__align_items_xl}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__align_self_xl->getTitle()}&nbsp;&nbsp;{if $elem.__align_self_xl->getHint() != ''}<a class="help-icon" title="{$elem.__align_self_xl->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__align_self_xl->getRenderTemplate() field=$elem.__align_self_xl}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__prefix_xl->getTitle()}&nbsp;&nbsp;{if $elem.__prefix_xl->getHint() != ''}<a class="help-icon" title="{$elem.__prefix_xl->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__prefix_xl->getRenderTemplate() field=$elem.__prefix_xl}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__order_xl->getTitle()}&nbsp;&nbsp;{if $elem.__order_xl->getHint() != ''}<a class="help-icon" title="{$elem.__order_xl->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__order_xl->getRenderTemplate() field=$elem.__order_xl}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__css_class->getTitle()}&nbsp;&nbsp;{if $elem.__css_class->getHint() != ''}<a class="help-icon" title="{$elem.__css_class->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__css_class->getRenderTemplate() field=$elem.__css_class}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__is_clearfix_after->getTitle()}&nbsp;&nbsp;{if $elem.__is_clearfix_after->getHint() != ''}<a class="help-icon" title="{$elem.__is_clearfix_after->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__is_clearfix_after->getRenderTemplate() field=$elem.__is_clearfix_after}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__inset_template->getTitle()}&nbsp;&nbsp;{if $elem.__inset_template->getHint() != ''}<a class="help-icon" title="{$elem.__inset_template->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__inset_template->getRenderTemplate() field=$elem.__inset_template}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__outside_template->getTitle()}&nbsp;&nbsp;{if $elem.__outside_template->getHint() != ''}<a class="help-icon" title="{$elem.__outside_template->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__outside_template->getRenderTemplate() field=$elem.__outside_template}</td>
                                </tr>
                                                                                                                            
                                <tr>
                                    <td class="otitle">{$elem.__invisible->getTitle()}&nbsp;&nbsp;{if $elem.__invisible->getHint() != ''}<a class="help-icon" title="{$elem.__invisible->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__invisible->getRenderTemplate() field=$elem.__invisible}</td>
                                </tr>
                                                                                                        </table>
                            </div>
        </form>
    </div>    <div class="previewCode" data-url="{adminUrl element="{$elem.element_type}" do="AjaxRenderPreview" mod_controller="templates-blockctrl" page_id=$elem.page_id}">
        <div>
            <p><strong>Предварительный просмотр HTML-кода</strong></p>
            <p>Для данного элемента будет автоматически сгенерирован следующий код</p>
        </div>
        <div class="previewBody">
            <div class="gray-c text-center">Загрузка...</div>
        </div>
    </div>
</div>