<?php
namespace MailSender\Model\Sample;

/**
* Образец N2
*/
class Sample3 extends AbstractSample
{
    /**
    * Возвращает название образца письма
    * 
    * @return string
    */
    function getTitle()
    {
        return t('Образец №3');
    }
}
