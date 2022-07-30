<?php
namespace MailSender\Controller\Admin;
use \RS\Html\Table\Type as TableType,
    \RS\Html\Toolbar\Button as ToolbarButton,
    \RS\Html\Filter,
    \RS\Html\Toolbar,
    \RS\Html\Table,
    \MailSender\Model,
    RS\AccessControl\Rights,
    RS\AccessControl\DefaultModuleRights,
    MailSender\Config\ModuleRights;
    
/**
* Контроллер Управление списком магазинов сети
*/
class Templates extends \RS\Controller\Admin\Crud
{
    function __construct()
    {
        //Устанавливаем, с каким API будет работать CRUD контроллер
        parent::__construct(new \MailSender\Model\TemplateApi());
    }
    
    function helperIndex()
    {
        $helper = parent::helperIndex(); //Получим helper по-умолчанию
        $helper->setTopTitle(t('Шаблоны рассылок')); //Установим заголовок раздела
        $helper->setTopToolbar($this->buttons(['add'], ['add' => t('Добавить шаблон рассылки')]));
        
        $helper->setHeaderHtml(
            $this->view
            ->assign('is_cron_work', \RS\Cron\Manager::obj()->isCronWork())
            ->fetch('admin/cron_check.tpl')
        );
        
        //Отобразим таблицу со списком объектов
        $helper->setTable(new Table\Element([
            'Columns' => [
                    new TableType\Checkbox('id'),
                    new TableType\Text('title', t('Название'), [
                        'Sortable' => SORTABLE_BOTH, 
                        'href' => $this->router->getAdminPattern('edit', [':id' => '@id']),
                        'LinkAttr' => ['class' => 'crud-edit'
                        ]]),
                    new TableType\Usertpl('status', t('Статус'), '%mailsender%/admin/col_status.tpl', [
                        'Sortable' => SORTABLE_BOTH, 
                        'href' => $this->router->getAdminPattern('edit', [':id' => '@id']),
                        'LinkAttr' => [
                            'class' => 'crud-edit'
                        ],
                        'TdAttr' => [
                            '@class' => 'mailsend-cell-status-{id}'
                        ]
                    ]),
                    new TableType\Text('send_type', t('Тип отправки'), ['Sortable' => SORTABLE_BOTH]),
                    new TableType\Text('sended_count', t('Отправлено писем'), [
                        'Sortable' => SORTABLE_BOTH, 
                        'href' => $this->router->getAdminPattern('edit', [':id' => '@id']),
                        'LinkAttr' => ['class' => 'crud-edit'],
                        'TdAttr' => [
                            '@class' => 'mailsend-cell-sended-{id}'
                        ]
                    ]),
                    new TableType\Userfunc('recipient_count', t('Кол-во получателей'), function($value, $cell) {
                        if ($cell->getRow()->send_type == \MailSender\Model\Orm\MailTemplate::SEND_TYPE_TRIGGER
                            || $cell->getRow()->status == \MailSender\Model\Orm\MailTemplate::STATUS_IDLE) {
                            return '-';
                        }
                        return $value;
                    }, [
                        'Sortable' => SORTABLE_BOTH,
                    ]),
                    new TableType\Userfunc('mail_body_size', t('Размер письма'), function($value) {
                        return \RS\File\Tools::fileSizeToStr($value);
                        
                    }, [
                        'Sortable' => SORTABLE_BOTH, 
                        'href' => $this->router->getAdminPattern('edit', [':id' => '@id']),
                        'LinkAttr' => ['class' => 'crud-edit'
                        ]]),
                    
                    new TableType\Yesno('enabled', t('Включен'), ['toggleUrl' => $this->router->getAdminPattern('ajaxToggleEnable', [':id' => '@id'])]),
                    new TableType\Text('id', '№', ['TdAttr' => ['class' => 'cell-sgray']]),
                    new TableType\Actions('id', [
                            new TableType\Action\Edit($this->router->getAdminPattern('edit', [':id' => '~field~']), null, [
                                'attr' => [
                                    '@data-id' => '@id'
                                ]
                            ]),
                            new TableType\Action\DropDown([
                                [
                                    'title' => t('предварительный просмотр'),
                                    'attr' => [
                                        '@href' => $this->router->getAdminPattern('previewTemplate', [':id' => '@id']),
                                        'target' => '_blank'
                                    ]
                                ],
                                [
                                    'title' => t('показать получателей'),                                    
                                    'attr' => [
                                        '@href' => $this->router->getAdminPattern('showRecipients', [':id' => '@id']),
                                        'target' => '_blank'
                                    ]
                                ],
                                [
                                    'title' => t('отправить администратору'),
                                    'attr' => [
                                        '@data-url' => $this->router->getAdminPattern('ajaxSendTest', [':id' => '@id']),
                                        'class' => 'crud-get'
                                    ]
                                ],
                                [
                                    'title' => t('отправить всем'),
                                    'attr' => [
                                        '@data-confirm-text' => t("Вы действительно хотите запустить рассылку '{title}' ?"),
                                        '@data-url' => $this->router->getAdminPattern('ajaxSendToAll', [':id' => '@id']),
                                        'class' => 'crud-get'
                                    ]
                                ],
                                [
                                    'title' => t('журнал отправки'),
                                    'attr' => [
                                        '@href' => $this->router->getAdminPattern(false, [':f[template_id]' => '@id'], 'mailsender-logs'),
                                    ]
                                ],
                                [
                                    'title' => t('клонировать шаблон'),
                                    'attr' => [
                                        'class' => 'crud-add',
                                        '@href' => $this->router->getAdminPattern('clone', [':id' => '@id']),
                                    ]
                                ]
                            ])
                    ],
                        ['SettingsUrl' => $this->router->getAdminUrl('tableOptions')]
                    ),
            ],
        'tableAttr' => [
            'data-refresh-url' => $this->router->getAdminUrl('AjaxRefreshCounters')
        ]

        ]));
        
        //Добавим фильтр значений в таблице по названию
        $helper->setFilter(new Filter\Control( [
            'Container' => new Filter\Container( [
                                'Lines' =>  [
                                    new Filter\Line( ['items' => [
                                            new Filter\Type\Text('title', t('Название'), ['SearchType' => '%like%']),
                                            new Filter\Type\Select('status', t('Статус'), ['' => t('Любой')] + \MailSender\Model\Orm\MailTemplate::getStatusList()),
                                            new Filter\Type\Text('subject', t('Тема письма'), ['SearchType' => '%like%']),

                                    ]
                                    ])
                                ],
            ])
        ]));
        
        return $helper;
    }
    
    function helperAdd()
    {
        $helper = parent::helperAdd();
        $helper->setBottomToolbar($this->buttons(['save','cancel'], ['save' => t('Сохранить как черновик')]));
        
        return $helper;
    }
    
    function actionAdd($primaryKeyValue = null, $returnOnSuccess = false, $helper = null)
    {        
        if ($primaryKeyValue == 0) {
            $this->api->getElement()->setTemporaryId();
        }
        
        if ($primaryKeyValue > 0) {
            $this->getHelper()->setTopTitle(t('Редактировать шаблон рассылки ').'{title}');   
        } else {
            $this->getHelper()->setTopTitle(t('Добавить шаблон рассылки'));
        }
        
        $this->api->getElement()->status = \MailSender\Model\Orm\MailTemplate::STATUS_IDLE;
        return parent::actionAdd($primaryKeyValue, $returnOnSuccess, $helper);
    }
    
    function actionAjaxGetFilter()
    {
        $filter_class = $this->url->request('filter_class', TYPE_STRING);
        $filter_key = $this->url->request('filter_key', TYPE_STRING, null);
        
        if ($filter_class) {
            //Изменение
            $filter = \Mailsender\Model\FilterApi::getFilterByClass($filter_class);
            return $this->result->setHtml($filter->getSettingsHtml($filter_key));
        } else {
            //Добавление
            $filters = \Mailsender\Model\FilterApi::getFilters();
            $filter = reset($filters);
            
            return $this->result->setHtml($filter->getView());
        }
    }
    
    function actionAjaxToggleEnable()
    {
        if ($access_error = Rights::CheckRightError($this, DefaultModuleRights::RIGHT_UPDATE)) {
            return $this->result->setSuccess(false);
        }
                
        $id = $this->url->request('id', TYPE_INTEGER);
        
        $mail_template = new \MailSender\Model\Orm\MailTemplate($id);
        if ($mail_template['id']) {
            $mail_template['enabled'] = !$mail_template['enabled'];
            $mail_template->update();
            return $this->result->setSuccess(true);
        }
        return $this->result->setSuccess(false);
    }
    
    function actionAjaxSendTest()
    {
        if ($access_error = Rights::CheckRightError($this, ModuleRights::RIGHT_SEND_TEST)) {
            return $this->result->addEMessage($access_error)->setSuccess(false);
        }
                
        $adminemail = \RS\Config\Loader::getSiteConfig()->admin_email;
        if (!$adminemail) {
            return $this->result->setSuccess(false)->addEMessage(t('Не указан Email администратора в настройках Веб-сайта'));
        }
        $emails = explode(',', $adminemail);
        $id = $this->url->request('id', TYPE_INTEGER);
        $mail_template = new Model\Orm\MailTemplate($id);
        if ($mail_template['id']) {
            foreach($emails as $email) {
                $send_api = new \MailSender\Model\SendApi($mail_template);
                $this->result->setSuccess($send_api->sendTest($email));
                if ($this->result->isSuccess()) {
                    $this->result->addMessage(t('Сообщение успешно отправлено на %0', $email));
                } else {
                    $this->result->addEMessage($send_api->getErrorsStr());
                }
            }
            return $this->result;
        }

        $this->e404(t('Шаблон рассылки не найден'));
    }
    
    function actionAjaxGetReplaceVars()
    {
        $post = $this->url->getSource(POST);
        $template = new \MailSender\Model\Orm\MailTemplate();
        foreach($post as $key => $value) {
            $template[$key] = $value;
        }
        
        return $this->result->setSuccess(true)->setHtml($template->getReplaceVarsHtml());
    }
    
    function actionAjaxSendToAll()
    {
        if ($access_error = Rights::CheckRightError($this, ModuleRights::RIGHT_SEND_TO_ALL)) {
            return $this->result->addEMessage($access_error)->setSuccess(false);
        }
        
        $id = $this->url->request('id', TYPE_INTEGER);
        $mail_template = new Model\Orm\MailTemplate($id);
        if ($mail_template['id']) {
            $mail_template->startSending();
            return $this->result->setSuccess(true);
        }
        $this->e404(t('Шаблон рассылки не найден'));
    }
    
    function actionAjaxRefreshCounters()
    {
        $templates_id = $this->url->post('templates_id', TYPE_ARRAY);
        $info = $this->api->getShortInfo($templates_id);
        return $this->result->setSuccess(true)->addSection('info', $info);
    }
    
    function actionPreviewTemplate()
    {
        $id = $this->url->request('id', TYPE_INTEGER);
        $mail_template = new Model\Orm\MailTemplate($id);
        if ($mail_template['id']) {
            $this->wrapOutput(false);
            $send_api = new Model\SendApi($mail_template);
            $recipient = $send_api->getTestRecipient();
            return $send_api->getBody($recipient);
        }
        $this->e404(t('Шаблон рассылки не найден'));        
    }
    
    
    function actionShowRecipients()
    {
        $id = $this->url->request('id', TYPE_INTEGER);
        if (!$template = $this->api->getOneItem($id)) {
            $this->e404(t('Шаблон рассылки не найден'));
        }
        $send_api = new \MailSender\Model\SendApi($template);
        $recipients = $send_api->filterRecipients($send_api->getRecipients());
        
        $helper = new \RS\Controller\Admin\Helper\CrudCollection($this);
        $helper->setTopTitle(t('Получатели рассылки &laquo;%0&raquo; (%1)', [$template['title'], count($recipients)]));
        $helper->setBottomToolbar(new \RS\Html\Toolbar\Element([
            'Items' => [
                new ToolbarButton\Button($this->url->getSavedUrl($this->controller_name.'index'), t('Назад'))
            ]
        ]));
        $table = new Table\Element([
            'Columns' => [
                new TableType\Text('email', t('Email'), [
                    'href' => $this->router->getAdminPattern('edit', [':id' => '@user_id'], 'users-ctrl'),
                    'LinkAttr' => ['class' => 'crud-edit']
                ]),
                new TableType\Text('name', t('Имя')),
                new TableType\Text('surname', t('Фамилия')),
                new TableType\Text('midname', t('Отчество')),
                new TableType\Text('company', t('Компания')),
                new TableType\Text('user_id', t('ID')),
            ]]);
        $table->setData($recipients);
        
        $helper->viewAsTable();
        $helper->setTable($table);
        
        return $this->result->setTemplate( $helper['template'] );
    }    
    
    
    function actionAjaxSelectSample()
    {
        $this->view->assign([
            'samples' => \MailSender\Model\SampleApi::getSamples()
        ]);
        
        return $this->result->setTemplate('%mailsender%/admin/samples.tpl');
    }
    
    function actionAjaxGetSampleHtml()
    {
        $id = $this->url->request('id', TYPE_STRING);
        $sample = \MailSender\Model\SampleApi::getSampleByClass($id);
        
        return $this->result->setHtml($sample->getHtml());
    }
}
