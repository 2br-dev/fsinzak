<?php

namespace fsinzak\Controller\Front;

use RS\Application\Application;
use RS\Controller\Front;
use RS\Http\Request as HttpRequest;

/**
 * Фронт контроллер
 */
class Recipient extends Front
{
    function actionIndex()
    {
        $referer = $this->url->request('referer', TYPE_STRING, \RS\Site\Manager::getSite()->getRootUrl());
        $id = $this->url->request('id', TYPE_INTEGER);
        $this->view->assign('referer', urlencode($referer));
        $this->view->assign('id', $id);
        return $this->result->setTemplate('%recipient%/add-recipient-modal.tpl');
    }

    /**
     * Вызов окна-предупреждения при смене Получателя
     * @return \RS\Controller\Result\Standard
     */
    function actionChange()
    {
        $referer = $this->url->request('referer', TYPE_STRING, \RS\Site\Manager::getSite()->getRootUrl());
        $id = $this->url->request('id', TYPE_INTEGER);
        $this->view->assign('referer', urlencode($referer));
        $this->view->assign('id', $id);
        return $this->result->setTemplate('%recipient%/change-modal.tpl');
    }

    /**
     * Добавление получателя
     * @return \RS\Controller\Result\Standard
     */
    public function actionAdd()
    {
        $data = $_POST;
        $error = [];
        $success = false;
        $recipient_api = new \Fsinzak\Model\RecipientsApi();
        $current_user = \RS\Application\Auth::getCurrentUser();

        if($data['name'] == ''){
            $error[] = 'name';
        }
        if($data['midname'] == ''){
            $error[] = 'midname';
        }
        if($data['surname'] == ''){
            $error[] = 'surname';
        }
        if($data['birthday'] == ''){
            $error[] = 'birthday';
        }
        // Если все поля заполнены - проверим есть ли уже такой получатель у пользователя, чтоб не дублировать в бд.
        if(empty($error)){
            $same = $recipient_api->checkTheSame($data['name'], $data['midname'], $data['surname'], $data['birthday'], $current_user['id']);
            if($same){
                $error[] = 'same';
            }
        }
        if(empty($error)){
            $recipient = new \Fsinzak\Model\Orm\Recipients();
            $recipient['name'] = $data['name'];
            $recipient['midname'] = $data['midname'];
            $recipient['surname'] = $data['surname'];
            $recipient['birthday'] = $data['birthday'];
            $recipient['user_id'] = $current_user['id'];
            $success = $recipient->insert();
        }
        if($success){
            $this->app->headers->addCookie('fsinzak-selected-recipient', $recipient['id'], time() + 60*60*24*365*10, '/');
        }
        $this->result->setSuccess($success);
        $this->result->addSection('error', $error);
        return $this->result
            ->setNoAjaxRedirect($data['referer'])
            ->addSection('reloadPage', true);
    }

    public function actionSetRecipient()
    {
        $id = $this->request('id', TYPE_INTEGER, -1);
        $referer = $this->request('referer', TYPE_STRING, HttpRequest::commonInstance()->selfUri());
        $cart = \Shop\Model\Cart::currentCart();
        $cart->clean();
        if($id){
            $this->app->headers->addCookie('fsinzak-selected-recipient', $id, time() + 60*60*24*365*10, '/');
            $this->result->setSuccess(true);
            $current_recipient = new \Fsinzak\Model\Orm\Recipients($id);
            $this->result->addSection('current_recipient', $current_recipient['surname'].' '.$current_recipient['name'].' '.$current_recipient['midname']);
        }
        return $this->result
            ->setNoAjaxRedirect($referer)
            ->addSection('reloadPage', true);
    }

    public function actionEditRecipient()
    {
        $error = '';
        $surname = $this->request('surname', TYPE_STRING, '');
        $name = $this->request('name', TYPE_STRING, '');
        $midname = $this->request('midname', TYPE_STRING, '');
        $birthday_timestamp = $this->request('birthday_timestamp', TYPE_INTEGER);
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
        return $this->result;
    }
}
