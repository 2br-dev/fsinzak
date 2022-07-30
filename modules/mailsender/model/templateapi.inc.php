<?php
namespace MailSender\Model;

use RS\Site\Manager as SiteManager;
use Site\Model\Orm\Site;

class TemplateApi extends \RS\Module\AbstractModel\EntityList
{
    function __construct()
    {
        parent::__construct(new Orm\MailTemplate(), [
            'nameField' => 'title',
            'defaultOrder' => 'id DESC',
            'multisite' => true
        ]);
    }        
    
    /**
    * Возвращает информацию для обновления счетчиков и статусов всего списка шаблонов рассылок
    * 
    * @param mixed $ids
    */
    function getShortInfo($ids)
    {
        $result = [];
        if ($ids) {
            $templates = \RS\Orm\Request::make()
                ->from($this->obj_instance)
                ->whereIn('id', $ids)
                ->objects();
                
            $view = new \RS\View\Engine();
            
            foreach($templates as $template) {
                $view->assign('elem', $template);
                
                $result[$template['id']] = [
                    'status' => $view->fetch('%mailsender%/admin/col_status.tpl'),
                    'sended' => $template['sended_count']
                ];
            }
        }
        return $result;
    }
    
    /**
    * Выполняет поиск шаблонов для рассылки, запускает 1 шаг 
    * 
    * @param mixed $last_time
    * @param mixed $current_time
    * @return Возвращает количество отправленных писем
    */
    function sendTemplates($last_time, $current_time)
    {
        $current_site = SiteManager::getSiteId();

        //Выбираем активные шаблоны рассылок
        $offset = 0;
        $limit = 20;
        $result = true;
                
        $q = \RS\Orm\Request::make()
            ->from(new Orm\MailTemplate)
            ->where([
                'enabled' => 1
            ])
            ->whereIn('status', [
                Orm\MailTemplate::STATUS_READYFORSEND, 
                Orm\MailTemplate::STATUS_SENDING
            ])
            ->limit($limit);

        while($templates = $q->offset($offset)->objects()) {
            foreach($templates as $template) {
                //Если рассылка запланирована на определенное время на отправку
                if ($template['send_type'] == Orm\MailTemplate::SEND_TYPE_MANUAL 
                    && $template['dateofsend'] !== null 
                    && $template['status'] == Orm\MailTemplate::STATUS_READYFORSEND) 
                { 
                    $need_time = strtotime($template['dateofsend']);
                    if ($last_time >= $need_time || $need_time > $current_time) {
                        continue;
                    }
                }
                SiteManager::setCurrentSite(new Site($template['site_id']));
                $send_api = new SendApi($template);
                $result = $send_api->sendToAll();
                
                if ($result !== true) {
                    break 2;
                }
            }
            $offset += $limit;
        }
        SiteManager::setCurrentSite(new Site($current_site));
        return $result;
    }
    
    /**
    * Производит рассылку связанных с триггером шаблонов.
    * Рассылка происходит всем получателям, которых предоставил триггер
    * 
    * @param mixed $trigger
    */
    function addRecipientsByTrigger($trigger, $data)
    {
        //Выбираем шаблоны рассылки, которые связаны с триггером
        $templates = \RS\Orm\Request::make()
            ->from(new Orm\MailTemplate())
            ->where([
                'send_type' => Orm\MailTemplate::SEND_TYPE_TRIGGER,
                'trigger_id' => $trigger['id'],
                'enabled' => 1
            ])
            ->whereIn('status', [Orm\MailTemplate::STATUS_READYFORSEND, Orm\MailTemplate::STATUS_SENDING])
            ->objects();
        
        //Запускаем рассылку
        foreach($templates as $template) {
            foreach($data as $trigger_data_object) {
                $recipient = new Orm\MailRecipient();
                $recipient->makeFromUser($trigger_data_object->getUser());
                $recipient['template_id'] = $template['id'];
                $recipient['dateof'] = date('Y-m-d H:i:s');
                $recipient['user_extra'] = $trigger_data_object->getData();
                $recipient['uniq'] = $trigger_data_object->getUniq();
                $recipient->insert(true);
            }
        }
    }
}
