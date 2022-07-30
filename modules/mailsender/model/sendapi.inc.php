<?php
namespace MailSender\Model;
use \RS\Helper\Mailer;
use \RS\Event\Manager as EventManager;

/**
* Класс содержит методы для проведения рассылки шаблона
*/
class SendApi extends \RS\Module\AbstractModel\BaseModel
{
    const
        RESULT_SESSION_SEND_LIMIT = 'sessionlimit';
    
    protected static
        $session_send_count = 0;
        
    protected
        $template;
    
    /**
    * Конструктор
    * 
    * @param Orm\MailTemplate $template - шаблон рассылки
    */
    function __construct(Orm\MailTemplate $template)
    {
        $this->template = $template;
    }
    
    /**
    * Отправляет одно письмо на указанный Email
    * 
    * @param string $email
    * @return boolean
    */
    function sendTest($email)
    {
        $recipient = $this->getTestRecipient();
        $recipient->email = $email;
        return $this->sendTo($recipient);
    }

    /**
    * Отправляет одно письмо указанному получателю
    * 
    * @param Recipient $recipient - получатель
    * @return boolean(false)
    */
    function sendTo(Orm\MailRecipient $recipient)
    {
        if (!$recipient->email) {
            return $this->addError(t('Email получателя не задан'));
        }
        
        $mailer = $this->getReadyMailer($recipient);
        $mailer->addCustomHeader('List-Unsubscribe', $recipient->getUnsubscribeUrl());
        
        if (!$mailer->Body) {
            return $this->addError(t('Не задано тело письма'));
        }
        
        return $mailer->send();
    }

    /**
    * Выполняет одну итерацию отправки шаблона всем пользователям.
    * 
    * @return mixed возвращает:
    * bool(true) - если рассылка шаблона полностью завершена
    * bool(false) - если рассылка невозможна
    * string(sessionlimit) - если достигнут лимит на отправку писем за одну сессию
    */
    function sendToAll()
    {
        if ($this->template['status'] == Orm\MailTemplate::STATUS_READYFORSEND) {
            $this->updateTemplate(Orm\MailTemplate::STATUS_SENDING);
        }
        
        if ($this->template['status'] == Orm\MailTemplate::STATUS_SENDING) {
            $config = \RS\Config\Loader::byModule($this, $this->template['site_id']);
            $session_send_limit = $config->session_send_limit;
            $sleep_time_in_seconds = (int)$config->sleep_time_in_seconds;
            if (self::$session_send_count >= $session_send_limit) {
                return self::RESULT_SESSION_SEND_LIMIT;
            }
            
            //Выбираем получателей
            $recipients = \RS\Orm\Request::make()
                ->from(new Orm\MailRecipient())
                ->where([
                    'template_id' => $this->template['id'],
                    'is_sended' => 0
                ])
                ->limit($session_send_limit + 1)
                ->objects();
            foreach($recipients as $recipient) {
                $this->sendTo($recipient);
                $recipient['is_sended'] = 1;
                $recipient['user_extra'] = @unserialize($recipient['_user_extra']);
                $recipient['dateof'] = date('Y-m-d H:i:s');
                $recipient->update();

                self::$session_send_count++;
                
                //Проверяем лимит отправки
                if ($is_break = self::$session_send_count >= $session_send_limit) break;
                if ($sleep_time_in_seconds) {
                    sleep($sleep_time_in_seconds);
                }	
            }
            
            $sended_count = \RS\Orm\Request::make()
                ->from(new Orm\MailRecipient())
                ->where([
                    'template_id' => $this->template['id'],
                    'is_sended' => 1
                ])->count();
            
            $this->updateTemplate(null, $sended_count);
            
            if (!empty($is_break)) {
                return self::RESULT_SESSION_SEND_LIMIT;
            }
            
            //Рассылка полностью завершена
            if ($this->template['send_type'] == Orm\MailTemplate::SEND_TYPE_MANUAL) {
                $this->updateTemplate(Orm\MailTemplate::STATUS_SENDED);
            }
            
            return true;
        }
        return $this->addError(t('Неверный статус рассылки'));
    }
    
    /**
    * Обновляет сведения шаблона рассылки
    * 
    * @param string $status - новый статус
    * @param integer $sended_count - количество отправленных писем
    */
    protected function updateTemplate($status = null, $sended_count = null)
    {
        $q = \RS\Orm\Request::make()
            ->update($this->template)
            ->where([
                'id' => $this->template['id']
            ]);
        
        if ($status) {
            $q->set([
                'status' => $this->template['status'] = $status
            ]);
        }
        if ($sended_count !== null) {
            $q->set([
                'sended_count' => $this->template['sended_count'] = $sended_count
            ]);
        }
        $q->exec();
    }
    
    /**
    * Возвращает размер письма в байтах
    * 
    * @return int
    */
    function getBodySize()
    {
        $recipient = $this->getTestRecipient();
        $mailer = $this->getReadyMailer($recipient);
        $mailer->preSend();
        
        return strlen($mailer->getSentMIMEMessage());
    }

    /**
    * Возвращает получателей рассылки
    * 
    * @return \MailSender\Model\Orm\MailRecipient[]
    */
    function getRecipients()
    {
        $recipients = [];
        if ($this->template['send_type'] == Orm\MailTemplate::SEND_TYPE_MANUAL) {
            $sources = $this->template->getSources();
            foreach($sources as $source) {
                $recipients = array_merge($recipients, $source->getRecipients());
            }
        }
        
        return $recipients;
    }
    
    /**
    * Фильтрует получателей
    * 
    * @param \MailSender\Model\Orm\MailRecipient[] $recipients
    */
    function filterRecipients($recipients)
    {
        //Фильтруем по стоп-листу        
        $api = new StopListApi();
        $stop_emails = $api->getStopEmailsInLowerCase();
        
        //Применяем фильтры
        foreach($recipients as $key => $recipient) {
            foreach($this->template->getFilters() as $filter) {
                if (!$filter->canSendToRecipient($recipient)) {
                    unset($recipients[$key]);
                }
            }
            if (isset($stop_emails[strtolower($recipient->email)])) {
                unset($recipients[$key]);
            }
        }

        $event_result = EventManager::fire('mailsender.filterrecipients', [
            'recipients' => $recipients
        ]);
        list($recipients) = $event_result->extract();
        
        return $recipients;
    }
    
    /**
    * Возвращает тестового получателя
    * 
    * @return \MailSender\Model\Orm\MailRecipient
    */
    function getTestRecipient()
    {
        $recipient = new \MailSender\Model\Orm\MailRecipient();
        $recipient->makeFromUser(\RS\Application\Auth::getCurrentUser());
        
        $recipient->email = 'test@example.com';
        $recipient->name = t('Иван');
        $recipient->surname = t('Иванов');
        $recipient->middle_name = t('Иванович');
        $recipient->company = t('ООО Ромашка');        
        return $recipient;
    }

    /**
    * Возвращает подготовленное тело письма для отправки
    * 
    * @param mixed $recipient
    */
    function getBody(Orm\MailRecipient $recipient)
    {
        $vars = $recipient->getReplaceVars();
        
        foreach($this->template->getContents() as $content) {
            $vars += (array)$content->getReplaceVars($recipient);
        }
        
        $view = new \RS\View\Engine();        
        switch($this->template['body_type']) {
            case Orm\MailTemplate::BODY_TYPE_TEMPLATE:
                $view->assign($vars);
                $html = $view->fetch($this->template['body_template']);
                break;
            default:
                $html = $this->template['body'];             
        }
        
        //Заменяем переменные
        foreach($vars as $key => $value) {
            if (is_string($value)) {
                $html = str_replace('{$'.$key.'}', $value, $html);
            }
        }
        
        $view->clearAllAssign()->assign([
            'html' => $html
        ]);
        
        $result_html = $view->fetch('%mailsender%/mail_template.tpl');
        
        //Переводим CSS стили в inline 
        if (\RS\Config\Loader::byModule($this, $this->template['site_id'])->css_to_inline) {
            $emogrifier = new CssToInline\Emogrifier();
            $emogrifier->setHtml($result_html);
            $result_html = @$emogrifier->emogrify(); //Не отображаем ошибки, если HTML невалиден
        }        
        return $result_html;
    }
    
    /**
    * Подготавливает тело письма к отправке. Делает изображения встроенными в письмо.
    * 
    * @param \RS\Helper\Mailer $mailer - объект письма
    * @return string
    */
    function prepareBody(Mailer $mailer, $body)
    {
        $replace_function = function($matches) use ($mailer) {
            
            $src = trim($matches[2],"'\"");
            $cid = md5($src);
            if (preg_match('/^data:/', $src)) {
                return $matches[0];
            }
            
            if (strpos($src, '://') === false) {
                $root = \RS\Site\Manager::getSite()->getRootUrl(true, false);
                //Если путь относительный, значит фото локальное
                $filename =  $root.ltrim($src,'/');
            } else {
                $filename = $src;
            }
            
            //Все фото загружаем через запрос, чтобы они генерировались в случае их отсутствия
            $image_data = @file_get_contents($filename);
            if ($image_data) {
                $mailer->addStringEmbeddedImage($image_data, $cid, basename($src));
            }
            
            return $matches[1]."cid:$cid".$matches[3];
        };
        
        $body = preg_replace_callback('/(<img[^>]*src=["\'])(.*?)(["\'][^>]*>)/i', $replace_function, $body);
        $body = preg_replace_callback('/(style=["\'][^>]*url\()(.*?)(\))/i', $replace_function, $body);
        $body = preg_replace_callback('/(background=["\'])(.*?)(["\'])/i', $replace_function, $body);
        
        
        return $body;
    }
    
    /**
    * Добавляет вложения к письму
    * 
    * @param Mailer $mailer
    * @return Mailer
    */
    function prepareAttachments(Mailer $mailer)
    {
        if ($this->template['attachments']) {
            foreach($this->template['attachments'] as $file) {
                $mailer->addAttachment($file['fullpath'], $file['name']);
            }
        }
        return $mailer;
    }
    
    /**
    * Возвращает объект с подготовленным телом для отправки письма
    * cо всеми вложениями, и.т.д.
    * 
    * @param Recipient $recipient
    * @return \RS\Helper\Mailer
    */
    function getReadyMailer(Orm\MailRecipient $recipient)
    {
        $mailer = new \RS\Helper\Mailer();
        if ($this->template['from']) {
            list($mailer->From, $mailer->FromName) = $this->parseEmail($this->template['from']);
        }
        if ($this->template['reply']) {
            $data = $this->parseEmail($this->template['reply']);
            $mailer->clearReplyTos();
            $mailer->addReplyTo($data[0], $data[1]);
        }
        $mailer->Subject = $this->template['subject'];        
        $mailer->Body = $this->prepareBody($mailer, $this->getBody($recipient));
        $mailer->AltBody = $mailer->html2text($mailer->Body);
        
        $this->prepareAttachments($mailer);
        $mailer->addAddress($recipient->email);
        
        return $mailer;
    }
    
    /**
    * Парсит строку с именем и Email'ом. 
    * 
    * @param string $string
    * @return array Возвращает массив с двумя элементами: именем и Email'ом
    */
    protected function parseEmail($string)
    {
        $result = [];
        if (preg_match('/^(.*?)<(.*)>$/', html_entity_decode($string), $match)) {
            $result[0] = $match[2];
            $result[1] = $match[1];
        } else {
            $result[0] = $string;
            $result[1] = '';
        }
        return $result;
    }
}