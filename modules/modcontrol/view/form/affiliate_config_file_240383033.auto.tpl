<div class="formbox" >
    {if $elem._before_form_template}{include file=$elem._before_form_template}{/if}

                        <form method="POST" action="{urlmake}" enctype="multipart/form-data" class="crud-form">
            <input type="submit" value="" style="display:none">
            <div class="notabs">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                
                                    <table class="otable">
                                                                                    
                                    <tr>
                                    <td class="otitle">{$elem.__name->getTitle()}&nbsp;&nbsp;{if $elem.__name->getHint() != ''}<a class="help-icon" title="{$elem.__name->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__name->getRenderTemplate() field=$elem.__name}</td>
                                    </tr>
                                                            
                                    <tr>
                                    <td class="otitle">{$elem.__description->getTitle()}&nbsp;&nbsp;{if $elem.__description->getHint() != ''}<a class="help-icon" title="{$elem.__description->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__description->getRenderTemplate() field=$elem.__description}</td>
                                    </tr>
                                                            
                                    <tr>
                                    <td class="otitle">{$elem.__version->getTitle()}&nbsp;&nbsp;{if $elem.__version->getHint() != ''}<a class="help-icon" title="{$elem.__version->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__version->getRenderTemplate() field=$elem.__version}</td>
                                    </tr>
                                                            
                                    <tr>
                                    <td class="otitle">{$elem.__core_version->getTitle()}&nbsp;&nbsp;{if $elem.__core_version->getHint() != ''}<a class="help-icon" title="{$elem.__core_version->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__core_version->getRenderTemplate() field=$elem.__core_version}</td>
                                    </tr>
                                                            
                                    <tr>
                                    <td class="otitle">{$elem.__author->getTitle()}&nbsp;&nbsp;{if $elem.__author->getHint() != ''}<a class="help-icon" title="{$elem.__author->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__author->getRenderTemplate() field=$elem.__author}</td>
                                    </tr>
                                                            
                                    <tr>
                                    <td class="otitle">{$elem.__enabled->getTitle()}&nbsp;&nbsp;{if $elem.__enabled->getHint() != ''}<a class="help-icon" title="{$elem.__enabled->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__enabled->getRenderTemplate() field=$elem.__enabled}</td>
                                    </tr>
                                                            
                                    <tr>
                                    <td class="otitle">{$elem.__use_geo_ip->getTitle()}&nbsp;&nbsp;{if $elem.__use_geo_ip->getHint() != ''}<a class="help-icon" title="{$elem.__use_geo_ip->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__use_geo_ip->getRenderTemplate() field=$elem.__use_geo_ip}</td>
                                    </tr>
                                                            
                                    <tr>
                                    <td class="otitle">{$elem.__coord_max_distance->getTitle()}&nbsp;&nbsp;{if $elem.__coord_max_distance->getHint() != ''}<a class="help-icon" title="{$elem.__coord_max_distance->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__coord_max_distance->getRenderTemplate() field=$elem.__coord_max_distance}</td>
                                    </tr>
                                                            
                                    <tr>
                                    <td class="otitle">{$elem.__confirm_city_select->getTitle()}&nbsp;&nbsp;{if $elem.__confirm_city_select->getHint() != ''}<a class="help-icon" title="{$elem.__confirm_city_select->getHint()|escape}">?</a>{/if}
                                    </td>
                                    <td>{include file=$elem.__confirm_city_select->getRenderTemplate() field=$elem.__confirm_city_select}</td>
                                    </tr>
                                                                        </table>
                            </div>
        </form>
    </div>