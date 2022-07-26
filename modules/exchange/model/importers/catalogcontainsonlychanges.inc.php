<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/

namespace Exchange\Model\Importers;

use Exchange\Model\Log\LogExchange;

/**
 * Этот класс имеет смысл только при импорте старой версии схемы - 2.03
 * В версии схемы 2.03 флаг "СодержитТолькоИзменения" передается _НЕ_ аттрибутом тэга <Каталог>
 * а в виде отдельного тэга <СодержитТолькоИзменения> внутри тэга <Каталог>
 *
 * Для остальных версих схем тэга <СодержитТолькоИзменения> вообще не существует в файлах импорта,
 * таким образом для них данный импортер не применится
 */
class CatalogContainsOnlyChanges extends AbstractImporter
{
    static public $pattern = '/КоммерческаяИнформация\/Каталог\/СодержитТолькоИзменения$/i';
    static public $title = 'Импорт тэга <СодержитТолькоИзменения>';

    public function import(\XMLReader $reader)
    {
        // Сохраняем содержит ли классификатор только изменения. Сохраняем в сессию, так как импорт идет во много шагов, и переменные будут потеряны
        if ((string)$this->getSimpleXML() == 'true') {
            $this->log->write(t('Запись в сессию флага, что выгрузка содержит только изменения'), LogExchange::LEVEL_CATALOG_IMPORT);
            $_SESSION[Catalog::CONTAINS_ONLY_CHANGES_SESSION_KEY] = true;
        } else {
            $this->log->write(t('Запись в сессию флага, что это полная выгрузка'), LogExchange::LEVEL_CATALOG_IMPORT);
            $_SESSION[Catalog::CONTAINS_ONLY_CHANGES_SESSION_KEY] = false;
        }
    }
}
