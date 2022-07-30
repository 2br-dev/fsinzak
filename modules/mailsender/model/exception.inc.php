<?php
namespace MailSender\Model;

/**
* Исключения модуля рассылки
*/
class Exception extends \RS\Exception
{
    const
        BAD_FILTER_CLASS  = 0,  //Неверное имя класса фильтра
        BAD_CONTENT_CLASS = 1,  //Неверное имя класса генератора контента
        BAD_SOURCE_CLASS  = 2,  //Неверное имя класса источника контента
        BAD_TRIGGER_CLASS = 3,  //Неверное имя класса типа триггера
        
        BAD_FILTER_ID     = 4,  //Неверный id фильтра
        BAD_CONTENT_ID    = 5,  //Неверный id генератора контента
        BAD_SOURCE_ID     = 6,  //Неверный id источника контента
        BAD_TRIGGER_ID    = 7;  //Неверный id типа триггера        
}