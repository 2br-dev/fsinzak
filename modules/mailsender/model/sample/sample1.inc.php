<?php
namespace MailSender\Model\Sample;

/**
* Образец N1
*/
class Sample1 extends AbstractSample
{
    /**
    * Возвращает название образца письма
    * 
    * @return string
    */
    function getTitle()
    {
        return t('Образец №1');
    }
}
