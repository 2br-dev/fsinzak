<?php

namespace fsinzak\Controller\Front;

use fsinzak\Model\Orm\Recipients;
use fsinzak\Model\Orm\Review;
use fsinzak\Model\ReviewApi;
use RS\Application\Auth;
use RS\Controller\Front;

/**
 * Фронт контроллер
 */
class Reviews extends Front
{
    function actionIndex()
    {
        $review_api = new ReviewApi();
        $reviews = $review_api->setFilter('public', 1)->getList();
        $current_user = \RS\Application\Auth::getCurrentUser();
        $has_review = $current_user->checkReview();
        $referer = urlencode($this->url->server('REQUEST_URI'));
        $this->view->assign([
            'reviews' => $reviews,
            'referer' => $referer,
            'can_write_review' => !$has_review,
            'user' => $current_user
        ]);
        return $this->result->setTemplate('%fsinzak%/reviews.tpl');
    }

    public function actionGetReviewModal()
    {
        $referer = $this->url->request('referer', TYPE_STRING, '/');
        $user_id = $this->url->request('user', TYPE_INTEGER);
        $this->view->assign([
            'user_id' => $user_id,
            'referer' => $referer
        ]);
        return $this->result->setTemplate('%fsinzak%/review_modal.tpl');
    }

    public function actionCreateReview()
    {
        $user_id = $this->request('user_id', TYPE_INTEGER);
        $text = $this->request('text', TYPE_MIXED, '');
        $error = '';
        $success = false;
        if(strip_tags($text) == ''){
            $error = 'text';
        }
        if($error == ''){
            $review = new Review();
            $review['user_id'] = $user_id;
            $review['text'] = $text;
            $review['public'] = 0;
            $review['dateof'] = date('Y-m-d');
            $review['site_id'] = \RS\Site\Manager::getSiteId();
            $success = $review->insert();
        }
        $this->result->setSuccess($success);
        $this->result->addSection('error', $error);
        return $this->result;
    }
}
