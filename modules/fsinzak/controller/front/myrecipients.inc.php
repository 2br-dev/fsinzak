<?php

namespace fsinzak\Controller\Front;

use fsinzak\Model\Orm\Recipients;
use RS\Application\Auth;
use RS\Controller\Front;

/**
 * Фронт контроллер
 */
class MyRecipients extends Front
{
    function actionIndex()
    {
        $current_user = Auth::getCurrentUser();
        $recipients = $current_user->getRecipients();
        $referer = urlencode($this->url->server('REQUEST_URI'));
        $this->view->assign([
            'recipients' => $recipients,
            'referer' => $referer
        ]);
        return $this->result->setTemplate('%fsinzak%/myrecipients.tpl');
    }

    public function actionEdit()
    {
        $recipient_id = $this->url->request('recipient', TYPE_INTEGER, 0);
        $recipient = new \Fsinzak\Model\Orm\Recipients($recipient_id);
        $birthday_timestamp = strtotime($recipient['birthday']);
        $referer = urlencode($_SERVER['HTTP_REFERER']);
        $this->view->assign([
            'recipient' => $recipient,
            'birthday_timestamp' => $birthday_timestamp,
            'referer' => $referer
        ]);
        if($this->url->isPost()){
            $error = '';
            $surname = $this->request('surname', TYPE_STRING, '');
            $name = $this->request('name', TYPE_STRING, '');
            $midname = $this->request('midname', TYPE_STRING, '');
            $birthday_timestamp = $this->request('birthday_timestamp', TYPE_INTEGER);
            $referer = $this->request('referer', TYPE_STRING, \RS\Site\Manager::getSite()->getRootUrl());
            if(trim($surname) == ''){
                $error = 'surname';
            }
            if(trim($name) == ''){
                $error = 'name';
            }
            if(trim($midname) == ''){
                $error = 'midname';
            }
            if(!$birthday_timestamp){
                $error = 'birthday';
            }
            if($error == ''){
                $recipient = new \Fsinzak\Model\Orm\Recipients($_POST['id']);
                $recipient['surname'] = $surname;
                $recipient['name'] = $name;
                $recipient['midname'] = $midname;
                $recipient['birthday'] = date('Y-m-d', $birthday_timestamp);
                if($recipient->update()){
                    $this->result->setSuccess(true);
                }
            }else{
                $this->result->setSuccess(false);
            }
            $this->result->addSection('error', $error);
            $this->result->addSection('referer', urldecode($referer));
            return $this->result;
        }
        return $this->result->setTemplate('%fsinzak%/recipient-edit.tpl');
    }

    public function actionRemove()
    {
        $recipient_id = $this->url->request('recipient', TYPE_INTEGER, 0);
        $recipient = new \Fsinzak\Model\Orm\Recipients($recipient_id);
        if($this->url->isPost()){
            $id = $this->request('id', TYPE_INTEGER, 0);
            $referer = $this->request('referer', TYPE_STRING, '/my/recipients/');
            if($id){
                $recipient = new Recipients($id);
                $recipient['removed'] = 1;
                $recipient->update();
                $this->result->setNoAjaxRedirect($referer)->addSection('reloadPage', true);
            }
        }
        $this->view->assign('recipient', $recipient);
        return $this->result->setTemplate('%fsinzak%/recipient-remove.tpl');
    }

    public function actionCreate()
    {
        if($this->url->isPost()){
            $error = '';
            $surname = $this->request('surname', TYPE_STRING, '');
            $name = $this->request('name', TYPE_STRING, '');
            $midname = $this->request('midname', TYPE_STRING, '');
            $birthday_timestamp = $this->request('birthday_timestamp', TYPE_INTEGER);
            $user_id = $this->request('user', TYPE_INTEGER, 0);
            $set_crrent = $this->url->request('setCurrent', TYPE_BOOLEAN, false);
            $recipient_api = new \Fsinzak\Model\RecipientsApi();
            if(trim($surname) == ''){
                $error = 'surname';
            }
            if(trim($name) == ''){
                $error = 'name';
            }
            if(trim($midname) == ''){
                $error = 'midname';
            }
            if(!$birthday_timestamp){
                $error = 'birthday';
            }
            if($error == '') {
                $same = $recipient_api->checkTheSame($name, $midname, $surname, date('Y-m-d', $birthday_timestamp), $user_id);
                if ($same) {
                    $error = 'same';
                }
            }
            if($error == '') {
                $same_removed = $recipient_api->checkTheSameRemoved($name, $midname, $surname, date('Y-m-d', $birthday_timestamp), $user_id);
                if($same_removed){
                    $recipient = new \Fsinzak\Model\Orm\Recipients($same_removed['id']);
                    $recipient['removed'] = 0;
                    if($recipient->update()){
                        $this->result->setSuccess(true);
                    }
                }else{
                    $recipient = new \Fsinzak\Model\Orm\Recipients();
                    $recipient['surname'] = $surname;
                    $recipient['name'] = $name;
                    $recipient['midname'] = $midname;
                    $recipient['birthday'] = date('Y-m-d', $birthday_timestamp);
                    $recipient['removed'] = 0;
                    $recipient['user_id'] = $user_id;
                    if($recipient->insert()){
                        $this->result->setSuccess(true);
                        $this->app->headers->addCookie('fsinzak-selected-recipient', $recipient['id'], time() + 60*60*24*365*10, '/');
                    }
                }
            }else{
                $this->result->setSuccess(false);
            }
            $this->result->addSection('error', $error);
            return $this->result;
        }
        return $this->result->setTemplate('%fsinzak%/recipient-create.tpl');
    }
}
