<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Statistic\Controller\Admin\Block;

use Statistic\Model\Components\DatePeriodSelector;
use Statistic\Model\Utils;

/**
* Блок "Ключевые показатели"
*/
class KeyIndicators extends \RS\Controller\Admin\Block
{
    protected $id;

    /**
     * KeyIndicators constructor.
     * @param array $param - массив параметров
     */
    function __construct($param = [])
    {
        parent::__construct($param);        
        $this->id = $this->getUrlName();
    }

    /**
     * Показ блока с данными
     *
     * @return \RS\Controller\Result\Standard
     */
    function actionIndex()
    {
        $period_selector = new DatePeriodSelector($this);

        $raw_data  = $this->getRawData($period_selector);
        $flot_data = $this->getFlotData($period_selector, $raw_data);

        $this->view->assign([
            'ctrl' => $this,
            'period_selector' => $period_selector,
            'raw_data'    => $raw_data,
            'block_id'    => $this->id,
            'json_bars'   => json_encode($flot_data['bars'], JSON_UNESCAPED_UNICODE),
            'json_ticks'  => json_encode($flot_data['ticks'], JSON_UNESCAPED_UNICODE),
            'json_values' => json_encode($flot_data['absoluteValues'], JSON_UNESCAPED_UNICODE),
        ]);
        
        return $this->result->setTemplate( 'blocks/key_indicators.tpl' );
    }

    /**
     * Возвращает данные таблицы и графика
     *
     * @param DatePeriodSelector $dps - объект класса селектора
     * @return array
     */
    function getRawData(DatePeriodSelector $dps)
    {
        $profit1 = Utils::getOrdersSummaryProfit($dps->getPrevDateFrom(), $dps->getPrevDateTo());
        $profit2 = Utils::getOrdersSummaryProfit($dps->date_from, $dps->date_to);

        $totalCost1 = Utils::getOrdersSummaryCost($dps->getPrevDateFrom(), $dps->getPrevDateTo());
        $totalCost2 = Utils::getOrdersSummaryCost($dps->date_from, $dps->date_to);

        $ordersCount1 = Utils::getOrdersCount($dps->getPrevDateFrom(), $dps->getPrevDateTo());
        $ordersCount2 = Utils::getOrdersCount($dps->date_from, $dps->date_to);

        $avgCost1 = Utils::getOrderAverageCost($dps->getPrevDateFrom(), $dps->getPrevDateTo());
        $avgCost2 = Utils::getOrderAverageCost($dps->date_from, $dps->date_to);

        $repeatedCount1 = Utils::getRepeatedOrdersCount($dps->getPrevDateFrom(), $dps->getPrevDateTo());
        $repeatedCount2 = Utils::getRepeatedOrdersCount($dps->date_from, $dps->date_to);
        
        $repeatedUsers1 = Utils::getRepeatedUsersCount($dps->getPrevDateFrom(), $dps->getPrevDateTo());
        $repeatedUsers2 = Utils::getRepeatedUsersCount($dps->date_from, $dps->date_to);

        $ltvCount1 = Utils::getOrderLTV($dps->getPrevDateFrom(), $dps->getPrevDateTo());
        $ltvCount2 = Utils::getOrderLTV($dps->date_from, $dps->date_to);
        
        $baseCurrency = \Catalog\Model\CurrencyApi::getBaseCurrency()->stitle;


        $data = [
            [
                'id' => 'profit',
                'label' => t('Доход'),
                'values' => [$profit1, $profit2],
                'percent' => Utils::getPercentageValue($profit1, $profit2),
                'help' => t('Сумма дохода полученного от продажи товаров за выбранный период. Доход одного товара исчисляется по формуле: сумма продажи товара - закупочная цена товара.'),
                'unit' => $baseCurrency
            ],
            [
                'id' => 'totalCost',
                'label' => t('Выручка'),
                'values' => [$totalCost1, $totalCost2],
                'percent' => Utils::getPercentageValue($totalCost1, $totalCost2),
                'help' => t('Общая сумма всех заказов за выбранный период'),
                'unit' => $baseCurrency
            ],
            [
                'id' => 'ordersCount',
                'label' => t('Количество заказов'),
                'values' => [$ordersCount1, $ordersCount2],
                'percent' => Utils::getPercentageValue($ordersCount1, $ordersCount2),
                'help' => t('Общее количество заказов за выбранный период'),
                'unit' => t('шт.')
            ],
            [
                'id' => 'avgCost',
                'label' => t('Средний чек'),
                'values' => [$avgCost1, $avgCost2],
                'percent' => Utils::getPercentageValue($avgCost1, $avgCost2),
                'help' => t('Стоимость заказов деленная на количество заказов за выбранный период'),
                'unit' => $baseCurrency
            ],
            [
                'id' => 'ordersRepeatCount',
                'label' => t('Повторные покупки'),
                'values' => [$repeatedCount1, $repeatedCount2],
                'percent' => Utils::getPercentageValue($repeatedCount1, $repeatedCount2),
                'help' => t('Количество повторных покупок всех пользователей за выбранный период'),
                'unit' => t('шт.')
            ],
            [
                'id' => 'repeatedUsers',
                'label' => t('Повторные покупатели'),
                'values' => [$repeatedUsers1, $repeatedUsers2],
                'percent' => Utils::getPercentageValue($repeatedUsers1, $repeatedUsers2),
                'help' => t('Количество пользователей, совершивших повторные покупки за выбранный период'),
                'unit' => t('чел.')
            ],
            [
                'id' => 'ordersLTV',
                'label' => t('LTV (Life Time Value)'),
                'values' => [$ltvCount1, $ltvCount2],
                'percent' => Utils::getPercentageValue($ltvCount1, $ltvCount2),
                'help' => t('Показатель LTV за выбранный период (Вычисляется как Среднее количество покупок умноженное на Средний чек)'),
                'unit' => $baseCurrency
            ]
        ];

        foreach($data as &$row)
        {
            $max = max($row['values']);
            if ($max != 0){
                $row['percents'] = [$row['values'][0] * 100 / $max, $row['values'][1] * 100 / $max];
            }else{
                $row['percents'] = 0;
            }
        }
        
        return $data;
    }

    /**
     * Возвращает данные в массиве для формирования графика
     *
     * @param DatePeriodSelector $dps - объект класса селектора (Здесь нужен для совместимости с наследниками)
     * @param array $rawData - массив данных для графика
     * @return array
     */
    function getFlotData(DatePeriodSelector $dps, $rawData)
    {
        $data1 = [];
        $data2 = [];
        $ticks = [];
        $absoluteValues = [];

        foreach($rawData as $index => $one)
        {
            $data1[] = [$index, $one['percents'][0]];
            $data2[] = [$index, $one['percents'][1]];
            $ticks[] = [$index, $one['label']];
            $absoluteValues[0][] = \RS\Helper\CustomView::cost( $one['values'][0] ).' '.$one['unit'];
            $absoluteValues[1][] = \RS\Helper\CustomView::cost( $one['values'][1] ).' '.$one['unit'];
        }

        $bars = [
            [
                'label' => t('Предыдущий период'),
                'data' => $data1
            ],
            [
                'label' => t('Выбранный период'),
                'data' => $data2
            ],
        ];
        
        $ret = [
            'ticks' => $ticks,
            'bars' => $bars,
            'absoluteValues' => $absoluteValues
        ];

        return $ret;
    }
}

