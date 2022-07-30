<?php
namespace MailSender\Model\Sample;

/**
* Абстрактный класс образца оформления рассылки
* Образец оформления позволяет загружать в редактор заранее подготовленный HTML
*/
abstract class AbstractSample
{
    protected
        $img_folder = '/img',
        $preview_file = 'preview.jpg',
        $template_file = 'sample.tpl';
        
        
    /**
    * Возвращает название образца письма
    * 
    * @return string
    */
    abstract public function getTitle();
    
    /**
    * Возвращает ID образца
    * 
    */
    function getId()
    {
        $class = strtolower(get_class($this));
        return str_replace(['\\', '-model'], ['-', ''], $class);
    }
    
    /**
    * Возвращает относительный путь к папке, в которой находятся шаблоны образца
    * 
    * @return string
    */
    protected function getViewFolder()
    {
        $module = \RS\Module\Item::nameByObject($this);
        $sample_name = strtolower(basename(str_replace('\\', '/', get_class($this))));
        return \Setup::$FOLDER.\Setup::$MODULE_FOLDER.'/'.$module.\Setup::$MODULE_TPL_FOLDER.'/sample/'.$sample_name;
    }
    
    /**
    * Возвращает ссылку на картинку образца оформления
    * 
    * @return string
    */
    public function getPreviewUrl()
    {
        return $this->getViewFolder().$this->img_folder.'/'.$this->preview_file;
    }
    
    /**
    * Возвращает HTML-код образца письма
    * 
    * @return string
    */
    public function getHtml()
    {
        $view_folder = $this->getViewFolder();
        $view = new \RS\View\Engine();
        $view->assign([
            'sample_img_path' => $view_folder.$this->img_folder,
            'sample' => $this
        ]);
        
        //Ищем шаблон в /modules/{имя модуля}/view/sample/{имя класса образца}/sample.tpl
        return $view->fetch(\Setup::$ROOT.$view_folder.'/'.$this->template_file);
    }
}
