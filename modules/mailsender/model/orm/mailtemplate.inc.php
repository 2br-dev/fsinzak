<?php
namespace MailSender\Model\Orm;
use \RS\Orm\Type,
    \RS\File\Tools as FileTools;

/**
 * ORM объект - шаблон рассылки
 * --/--
 * @property integer $id Уникальный идентификатор (ID)
 * @property integer $site_id ID сайта
 * @property string $title Название шаблона рассылки
 * @property string $send_type Тип отправки
 * @property array $sources Получатели
 * @property integer $trigger_id Триггер
 * @property array $filters Фильтры
 * @property string $status Статус
 * @property string $dateofsend Отложенная отправка
 * @property string $subject Тема письма
 * @property string $from От кого (from)
 * @property string $reply Ответ (Reply)
 * @property array $contents Дополнительные переменные в шаблоне
 * @property string $body_type Тип формирования тела письма
 * @property string $body Тело письма
 * @property string $body_template Шаблон письма
 * @property array $uploadfiles Вложения
 * @property array $attachments Загруженные вложения
 * @property array $deletefiles Вложения для удаления
 * @property integer $enabled Включен
 * @property integer $recipient_count Количество получателей
 * @property integer $sended_count Количество отправок
 * @property integer $mail_body_size Размер письма, байт
 * --\--
 */
class MailTemplate extends \RS\Orm\OrmObject
{
    const
        SEND_TYPE_MANUAL = 'manual',
        SEND_TYPE_TRIGGER = 'trigger',
        
        STATUS_IDLE = 'idle',
        STATUS_READYFORSEND = 'readyforsend',
        STATUS_SENDING = 'sending',
        STATUS_SENDED = 'sended',
        
        BODY_TYPE_EDITOR = 'editor',
        BODY_TYPE_TEMPLATE = 'template';
        
    
    protected static
        $table = 'mail_template';
    
    function _init()
    {
        $from_reply_checker = function($_this, $value) 
        {
            $value = html_entity_decode($value);
            if ($value == '') return true;
            if (filter_var($value, FILTER_VALIDATE_EMAIL) !== false) {
                return true;
            }
            if (preg_match('/^[^\<\>]*?\<(.*?)\>$/', $value, $match)) {
                if (filter_var($match[1], FILTER_VALIDATE_EMAIL) !== false) {
                    return true;
                }
            }
            return t('Неверный формат. Ожидается: "Магазин ReadyScript&lt;robot@your-domain.ru&gt;" или "robot@your-domain.ru"');
        };
        
        $subdata_checker = function($_this, $objects, $field, $field_name) 
        {
            foreach($objects as $key => $object) {
                if ($settings = $object->getSettingsObject()) {
                    $settings->getFromArray($object->getSettings());
                    
                    if (!$settings->validate()) {
                        foreach($settings->getFormError() as $field) {
                            $error = $settings->getErrorsByForm($field);
                            $this->addError($error, $field_name.' &rarr; '.$object->getTitle().' &rarr;'.$settings['__'.$field]->getDescription());
                        }
                    }
                }
            }
            return true;
        };
                
        parent::_init()->append([
            'site_id' => new Type\CurrentSite(),
            'title' => new Type\Varchar([
                'description' => t('Название шаблона рассылки'),
                'checker' => ['ChkEmpty', t('Не указано название шаблона рассылки')]
            ]),
            'send_type' => new Type\Enum(array_keys(self::getSendTypeList()), [
                'description' => t('Тип отправки'),
                'default' => 'manual',
                'listFromArray' => [self::getSendTypeList()],
                'RadioListView' => [true, true],
                'template' => '%mailsender%/form/mailtemplate/send_type.tpl'
            ]),
            'sources' => new Type\ArrayList([
                'description' => t('Получатели'),
                'list' => [['\MailSender\Model\SourceApi', 'getSourceNames']],
                'Attr' => [['size' => 5, 'multiple' => 'multiple', 'class' => 'multiselect']],
                'template' => '%mailsender%/form/mailtemplate/sources.tpl',
                'checker' => [function($_this, $value) use ($subdata_checker) {
                    $sources = $_this->getSources();
                    if ($_this['send_type'] == MailTemplate::SEND_TYPE_MANUAL && !$sources) {
                        return t('Выберите получателей рассылки');
                    }
                    
                    return $subdata_checker($_this, $sources, 'sources', t('Получатели'));
                }],
                'hint' => t('Формируют список получателей'),
            ]),
            'trigger_id' => new Type\Integer([
                'description' => t('Триггер'),
                'list' => [['\MailSender\Model\TriggerApi', 'staticSelectList']],
                'hint' => t('Рассылка выполнится автоматически в момент возникновения события триггера. Получатели автоматически формируются триггером'),
                'checker' => [function($_this, $value) {
                    if ($_this['send_type'] == MailTemplate::SEND_TYPE_MANUAL) {
                        if (!$_this['sources']) $this->addError(t('Укажите получателей рассылки'), 'sources');
                    } 
                    elseif ($_this['send_type'] == MailTemplate::SEND_TYPE_TRIGGER) {
                        if (!$value) $this->addError(t('Выберите триггер для рассылки'), 'trigger');
                    }
                    return true;
                }]
            ]),
            'filters' => new Type\ArrayList([
                'description' => t('Фильтры'),
                'hint' => t('Используется для всех типов отправки, в том числе для триггерных. Фильтры объединяются логическим И, т.е. письмо будет отправленю только пользователю, удовлетворяющему условиям всех фильтров'),
                'template' => t('%mailsender%/form/mailtemplate/filters.tpl'),
                'checker' => [function($_this, $value) use($subdata_checker) {
                    return $subdata_checker($_this, $_this->getFilters(), 'filters', t('Фильтры'));
                }],
            ]),
            'status' => new Type\Enum(array_keys(self::getStatusList()), [
                'description' => t('Статус'),
                'listFromArray' => [self::getStatusList()],
                'visible' => false
            ]),
            'dateofsend' => new Type\Datetime([
                'description' => t('Отложенная отправка'),
                'hint' => t('С помощью данной опции рассылку можно автоматически выполнить в определенное время в будущем.'),
                'template' => '%mailsender%/form/mailtemplate/dateofsend.tpl'
            ]),
            'subject' => new Type\Varchar([
                'description' => t('Тема письма')
            ]),
            'from' => new Type\Varchar([
                'description' => t('От кого (from)'),
                'hint' => t('Например: "Магазин ReadyScript&lt;robot@your-domain.ru&gt;" или просто "robot@your-domain.ru". Если не задано, то будут использованы настройки сайта'),
                'checker' => $from_reply_checker
            ]),
            'reply' => new Type\Varchar([
                'description' => t('Ответ (Reply)'),
                'hint' => t('Например: "Магазин ReadyScript&lt;robot@your-domain.ru&gt;" или просто "robot@your-domain.ru". Если не задано, то будут использованы настройки сайта'),
                'checker' => $from_reply_checker
            ]),
            'contents' => new Type\ArrayList([
                'description' => t('Дополнительные переменные в шаблоне'),
                'list' => [['\MailSender\Model\ContentApi', 'getContentNames']],
                'template' => '%mailsender%/form/mailtemplate/contents.tpl',
                'checker' => [function($_this, $value) use($subdata_checker) {
                    return $subdata_checker($_this, $_this->getContents(), 'contents', t('Доп.переменные в шаблоне'));
                }],
            ]),
            'body_type' => new Type\Enum([self::BODY_TYPE_EDITOR, self::BODY_TYPE_TEMPLATE], [
                'description' => t('Тип формирования тела письма'),
                'default' => 'editor',
                'listFromArray' => [[
                    self::BODY_TYPE_EDITOR => t('Редактор'),
                    self::BODY_TYPE_TEMPLATE => t('Шаблон(для опытных пользователей)')
                ]],
                'RadioListView' => [true, true],
                'template' => '%mailsender%/form/mailtemplate/body_type.tpl'
            ]),
            'body' => new Type\Richtext([
                'description' => t('Тело письма'),
                'editorOptions' => [[
                    'tiny_options' => [
                        'convert_urls' => false
                    ]
                ]]
            ]),
            'body_template' => new Type\Template([
                'description' => t('Шаблон письма'),
                'checker' => [function($_this, $value) {
                    if ($_this['body_type'] == MailTemplate::BODY_TYPE_TEMPLATE) {
                        //Проверяем наличие шаблона
                        $view = new \RS\View\Engine();
                        if ($value == '' || !$view->templateExists($value)) {
                            return t('Указанный шаблон не найден');
                        }
                    }
                    return true;                    
                }]
            ]),
            'uploadfiles' => new Type\ArrayList([
                'description' => t('Вложения'),
                'template' => '%mailsender%/form/mailtemplate/attachments.tpl'
            ]),
            'attachments' => new Type\ArrayList([
                'description' => t('Загруженные вложения'),
                'listenPost' => false,
                'visible' => false
            ]),
            'deletefiles' => new Type\ArrayList([
                'description' => t('Вложения для удаления'),
                'visible' => false
            ]),
            'enabled' => new Type\Integer([
                'description' => t('Включен'),
                'default' => 1,
                'checkboxView' => [1,0]
            ]),
            'recipient_count' => new Type\Integer([
                'description' => t('Количество получателей'),
                'visible' => false
            ]),
            'sended_count' => new Type\Integer([
                'description' => t('Количество отправок'),
                'visible' => false
            ]),
            'mail_body_size' => new Type\Integer([
                'description' => t('Размер письма, байт'),
                'visible' => false
            ]),
        ]);
        
        //Включаем в форму hidden поле id.
        $this['__id']->setVisible(true);
        $this['__id']->setMeVisible(false);
        $this['__id']->setHidden(true);
    }
    
    function beforeWrite($flag)
    {        
        if ($this['dateofsend'] == '') {
            $this['dateofsend'] = null;
        }

        //Сохраняем вложения
        $this->removeAttachment($this['deletefiles']);
        $result = $this->addAttachment($this['uploadfiles']);

        //Рассчитываем размер письма для отправки
        $sendApi = new \MailSender\Model\SendApi($this);
        $this['mail_body_size'] = $sendApi->getBodySize();        

        if ($this['id'] < 0) {
            $this['tmp_id'] = $this['id'];
            unset($this['id']);
        }
        
        return $result;
    }
    
    function afterObjectLoad()
    {
        $params = \RS\Orm\Request::make()
                    ->from(new MailTemplateParam())
                    ->where([
                        'template_id' => $this['id'],
                    ])->exec()->fetchAll();
                            
        //Загружаем источники получателей
        $this['sources'] = $this->loadParam($params, MailTemplateParam::ENTITY_SOURCE, true);
        
        //Загружаем фильтры
        $this['filters'] = $this->loadParam($params, MailTemplateParam::ENTITY_FILTER);
        
        //Загружаем генераторы контента
        $this['contents'] = $this->loadParam($params, MailTemplateParam::ENTITY_CONTENT, true);
        
        //Загружаем вложения
        $this['attachments'] = $this->loadAttachments($params);
    }
   
    function afterWrite($flag)
    {        
        if ($this['tmp_id']<0) {
            //Переносим временные объекты, если таковые имелись
            \RS\Orm\Request::make()
                ->update(new MailTemplateParam())
                ->set([
                    'template_id' => $this['id']
                ])->where([
                    'template_id' => $this['tmp_id']
                ])->exec();
        }
        
        //Сохраняем источники получателей
        $this->saveParam('sources', MailTemplateParam::ENTITY_SOURCE);
        
        //Сохраняем фильтры
        $this->saveParam('filters', MailTemplateParam::ENTITY_FILTER);
        
        //Сохраняем контент-генераторы
        $this->saveParam('contents', MailTemplateParam::ENTITY_CONTENT);        
    }

    /**
    * Возвращает относительный путь к папке с вложениями
    * 
    * @return string
    */
    function getAttachmentDir()
    {
        return \Setup::$STORAGE_DIR.'/mailsender/attachments';
    }    
    
    /**
    * Удаляет вложения
    * 
    * @param array $filenames - список с именами файлов вложений
    * @return void
    */
    function removeAttachment($filenames)
    {
        if ($filenames) {
            \RS\Orm\Request::make()
                ->delete()
                ->from(new MailTemplateParam())
                ->where([
                    'template_id' => $this['id'],
                    'entity' => MailTemplateParam::ENTITY_ATTACHMENT
                ])
                ->whereIn('entity_id', $filenames)
                ->exec();
            
            $attachments = $this['attachments'];
            foreach($filenames as $filename) {
                unset($attachments[$filename]);
                $path = \Setup::$PATH.$this->getAttachmentDir().'/'.$filename;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $this['attachments'] = $attachments;
            return true;            
        }                
        return false;
    }
    
    /**
    * Добавляет вложения
    * 
    * @param array $upload_files - массив загруженных файлов из $_FILES
    * @return bool
    */
    function addAttachment($upload_files)
    {
        $upload_files = FileTools::normalizeFilePost($upload_files);
        $upload_folder = $this->getAttachmentDir();
        
        $params = [];
        $errors = [];
        $uploader = new \RS\File\Uploader(null, $upload_folder);
        foreach($upload_files as $file) {
            if ($uploader->uploadFile($file)) {
                
                $param = new MailTemplateParam();
                $param['template_id'] = $this['id'];
                $param['entity'] = MailTemplateParam::ENTITY_ATTACHMENT;
                $param['entity_id'] = $uploader->getFilename();
                $param['params'] = serialize($file);
                $param->insert();
                
                $params[] = $param;
            }
        }
        
        if ($errors = $uploader->getErrors()) {
            foreach($params as $param) {
                //Удаляем успешно загруженные файлы, так как они будут отправлены повторно
                $this->removeAttachment([$param['entity_id']]);
            }
            return $this->addErrors($errors, 'uploadfiles');
        }
        
        $this['attachments'] = array_merge((array)$this['attachments'], $this->loadAttachments($params));
        return true;
    }
    
    /**
    * Возвращает список имеющихся вложений
    * 
    * @param \MailSender\Model\Orm\MailTemplateParam[] $params - список параметров шаблона рассылки
    * @return array
    */
    function loadAttachments($params)
    {
        $result = [];
        foreach($params as $param) {
            if ($param['entity'] == MailTemplateParam::ENTITY_ATTACHMENT) {        
                $settings = @unserialize($param['params']) ?: [];
                $result[$param['entity_id']] = [
                    'filename' => $param['entity_id'],
                    'link' => $this->getAttachmentDir().'/'.$param['entity_id'],
                    'fullpath' => \Setup::$PATH.$this->getAttachmentDir().'/'.$param['entity_id']
                    ] + $settings;
            }
        }
        return $result;
    }
    
    /**
    * Возвращает значение параметра шаблона рассылки
    * 
    * @param \MailSender\Model\Orm\MailTemplateParam[] $params - список параметров шаблона рассылки
    * @param string $entity - тип параметра
    * @param bool $entity_in_key - если true, то в ключ будет подставляться entity_id
    * @return array
    */
    function loadParam($params, $entity, $entity_in_key = false)
    {                    
        $result = [];
        foreach($params as $param) {
            if ($param['entity'] == $entity) {
                $item = [
                    'class' => $param['entity_id'],
                    'settings' => unserialize($param['params'])
                ];
                if ($entity_in_key) {
                    $result[$param['entity_id']] = $item;
                } else {
                    $result[] = $item;
                }
            }
        }
        return $result;
    }
    
    /**
    * Сохраняет значение параметра
    * 
    * @param string $field - поле со значением
    * @param string $entity - тип параметра
    * @return void
    */
    function saveParam($field, $entity)
    {
        if ($this->isModified($field)) {
            \RS\Orm\Request::make()
                ->delete()
                ->from(new MailTemplateParam())
                ->where([
                    'template_id' => $this['id'],
                    'entity' => $entity
                ])->exec();
                
            foreach($this[$field] as $item) {
                if (isset($item['class'])) {
                    $param = new MailTemplateParam();
                    $param['template_id'] = $this['id'];
                    $param['entity'] = $entity;
                    $param['entity_id'] = $item['class'];
                    if (!isset($item['settings'])) {
                        $item['settings'] = [];
                    }
                    $param['params'] = serialize($item['settings']);
                    $param->insert();
                }
            }
        }
    }
    
    /**
    * Удаляет шаблон рассылки
    * 
    * @return boolean - true, в случае успеха
    */
    function delete()
    {
        if ($result = parent::delete()) {
            \RS\Orm\Request::make()
                ->delete()
                ->from(new MailTemplateParam())
                ->where([
                    'template_id' => $this['id']
                ])->exec();
            
            \RS\Orm\Request::make()
                ->delete()
                ->from(new MailRecipient())
                ->where([
                    'template_id' => $this['id']
                ])->exec();
            
        }
        return $result;
    }
    
    /**
    * Возвращает фильтры, которые установлены для данного шаблона
    * 
    * @return \MailSender\Model\Filter\AbstractFilter[]
    */
    function getFilters()
    {
        $result = [];
        if ($this['filters']) {
            foreach($this['filters'] as $data) {
                try {
                    $filter = \MailSender\Model\FilterApi::getFilterByClass($data['class']);
                    $filter->init($this, isset($data['settings']) ? $data['settings'] : []);
                    
                    $result[] = $filter;
                } catch(\MailSender\Model\Exception $e) {}
            }
        }
        return $result;
    }
    
    /**
    * Возвращает получателей, которые установлены для данного шаблона
    * 
    * @return \MailSender\Model\Source\AbstractSource[]
    */    
    function getSources()
    {
        $result = [];
        if ($this['sources']) {
            foreach($this['sources'] as $data) {
                if (isset($data['class'])) {
                    try {
                        $source = \MailSender\Model\SourceApi::getSourceByClass($data['class']);
                        $source->init($this, isset($data['settings']) ? $data['settings'] : []);
                            
                        $result[$data['class']] = $source;
                    } catch(\MailSender\Model\Exception $e) {}
                }
            }
        }
        return $result;
    }
    
    /**
    * Возвращает генераторы контента, которые установлены для данного шаблона
    * 
    * @return \MailSender\Model\Content\AbstractContent[]
    */
    function getContents()
    {
        $result = [];
        if ($this['contents']) {
            foreach($this['contents'] as $content) {
                if (isset($content['class'])) {
                    try {
                        $contents = \MailSender\Model\ContentApi::getContentByClass($content['class']);
                        $contents->init($this, isset($content['settings']) ? $content['settings'] : []);
                        
                        $result[$content['class']] = $contents;
                    } catch(\MailSender\Model\Exception $e) {}
                }
            }
        }
        return $result;        
    }
    
    /**
    * Возвращает объект генератора контента с загруженными настройками
    * 
    * @param string $content_class - идентификатор генератора контента
    * @return Content\AbstractContent
    */
    function getContentById($content_class)
    {
        $content = \MailSender\Model\ContentApi::getContentByClass($content_class);
        if (isset($this['contents'][$content_class])) {
            $content->init($this, $this['contents'][$content_class]['settings']);
        }
        
        return $content;
    }
    
    /**
    * Возвращает объект источника пользователей
    * 
    * @param string $source_class - идентификатор источника пользователей
    */
    function getSourceById($source_class)
    {
        $source = \MailSender\Model\SourceApi::getSourceByClass($source_class);
        if (isset($this['sources'][$source_class])) {
            $source->init($this, (array)$this['sources'][$source_class]['settings']);
        }
        return $source;
    }
    
    /**
    * Возвращает описания переменных, которые могут использоваться в шаблоне
    * 
    * @return array
    */
    function getReplaceVarsTitle()
    {
        $recipient = new MailRecipient();
        $result = [[
            'group' => t('Пользователь(получатель)'),
            'vars' => $recipient->getReplaceVarsTitles()
        ]];
        
        foreach($this->getContents() as $content) {
            $result[] = [
                'group' => $content->getTitle(),
                'vars' => $content->getReplaceVarsTitle()
            ];
        }
        
        return $result;
    }
    
    /**
    * Возвращает HTML-код блока со списком переменных, которые можно использовать в шаблоне
    * 
    * @return string
    */
    function getReplaceVarsHtml()
    {
        $vars_title = $this->getReplaceVarsTitle();
        $view = new \RS\View\Engine();
        $view->assign([
            'elem' => $this
        ]);
        return $view->fetch('%mailsender%/form/mailtemplate/contents_vars.tpl');
    }
    
    /**
    * Запускает рассылку текущего шаблона, переводя его в соответствующий статус
    * 
    * @return void
    */
    function startSending()
    {
        $send_api = new \MailSender\Model\SendApi($this);
        $recipients = $send_api->filterRecipients($send_api->getRecipients());
        
        //Добавляем потенциальных получателей в базу, не обновляем существующие записи
        foreach($recipients as $recipient) {
            $recipient['template_id'] = $this['id'];
            $recipient['dateof'] = date('Y-m-d H:i:s');
            $recipient->insert(true);
        }
        
        $this['sended_count'] = 0;
        $this['recipient_count'] = count($recipients);
        
        $this['status'] = self::STATUS_READYFORSEND;
        $this->update();
    }
    
    /**
    * Возвращает список возможныйх статусов Шаблона рассылок
    * 
    * @return array
    */
    public static function getStatusList()
    {
        return [
            self::STATUS_IDLE => t('Черновик'),
            self::STATUS_READYFORSEND => t('Готов к отправке'),
            self::STATUS_SENDING => t('Рассылается'),
            self::STATUS_SENDED => t('Отправлен всем')
        ];
    }
    
    /**
    * Возвращает список возможныйх типов отправки шаблона
    * 
    * @return array
    */    
    public static function getSendTypeList()
    {
        return [
            self::SEND_TYPE_MANUAL => t('Вручную'),
            self::SEND_TYPE_TRIGGER => t('По триггеру'),
        ];
    }
}