<?php
namespace Fsinzak\Model\ExportModels;

use Custom\Model\OrderApi;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class XLSX extends AbstractExportModel {

    protected $now_row = 2; //Текущая строка

    /**
     * Добавляет заголовки в сгенерированный файл
     *
     * @param Worksheet $sheet - текущий активный лист
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \RS\Db\Exception
     * @throws \RS\Orm\Exception
     */
    private function addTitles($sheet, \Shop\Model\Orm\Order $order)
    {
        //Заголовок
        $sheet->setCellValueByColumnAndRow(1, $this->now_row, t('Заказ №%0', [$order['order_num']]));
        $field = $sheet->getStyleByColumnAndRow(1, $this->now_row);
        $field->getFont()->setBold(true)->setSize(11);
        $field->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->mergeCellsByColumnAndRow(1, $this->now_row, 6, $this->now_row);

        $this->now_row++;

        $order_date = date('d.m.Y', strtotime($order['dateof']));
        $sheet->setCellValueByColumnAndRow(1, $this->now_row, t('Дата заказа: %0', [$order_date]));
        $field = $sheet->getStyleByColumnAndRow(1, $this->now_row);
        $field->getFont()->setBold(true)->setSize(11);
        $field->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');
        $sheet->getRowDimension(1)->setRowHeight(20);
        $sheet->mergeCellsByColumnAndRow(1, $this->now_row, 6, $this->now_row);

        $this->now_row++; //Пустая строка
        $this->now_row++;
        //Заголовки
        $sheet->setCellValueByColumnAndRow(1, $this->now_row, t('Заказчик:') )
            ->setCellValueByColumnAndRow(2, $this->now_row, $order->getUser()->getFio())
            ->setCellValueByColumnAndRow(3, $this->now_row, t('Получатель:'))
            ->setCellValueByColumnAndRow(4, $this->now_row, $order->getRecipient()->getFio());

        $sheet->getColumnDimensionByColumn(1)->setWidth(20);
        $sheet->getColumnDimensionByColumn(2)->setWidth(30);
        $sheet->getStyle("B5")->getAlignment()->setWrapText(true);
        $sheet->getStyle("D5")->getAlignment()->setWrapText(true);
        $sheet->getStyle("A5")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        $sheet->getStyle("C5")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        $sheet->getColumnDimensionByColumn(3)->setWidth(20);

        $sheet->mergeCellsByColumnAndRow(4, $this->now_row, 6, $this->now_row);

        $this->now_row++;

        $sheet->setCellValueByColumnAndRow(1, $this->now_row, t('Адрес заказчика:'))
            ->setCellValueByColumnAndRow(2, $this->now_row, $order->getUserAddress());
        $sheet->getStyle("B6")->getAlignment()->setWrapText(true);
        $sheet->getStyle("B6")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        $sheet->mergeCellsByColumnAndRow(2, $this->now_row, 2, $this->now_row + 2);

        $sheet->setCellValueByColumnAndRow(3, $this->now_row, t('Дата рождения'))
            ->setCellValueByColumnAndRow(4, $this->now_row, $order->getRecipient()->getBirthday('Y-m-d'));
        $this->now_row++;

        $sheet->setCellValueByColumnAndRow(3, $this->now_row, t('Регион'))
            ->setCellValueByColumnAndRow(4, $this->now_row, $order->getRegion()->title);
        $this->now_row++;

        $sheet->setCellValueByColumnAndRow(3, $this->now_row, t('Учреждение'))
            ->setCellValueByColumnAndRow(4, $this->now_row, $order->getColonyTitle(false));
        $sheet->getStyle('A5:B8')->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A5:B8')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A5:B8')->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('C5:F8')->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('C5:F8')->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('C5:F8')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('C5:F8')->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);
    }

    /**
     * Устанавливает выравнивание в колонке
     *
     * @param Worksheet $sheet - текущий активный лист
     * @param integer $column - номер колонки
     * @param string $align - выравнивание по горизонтали
     * @param string $valign - выравнивание по вертикали
     */
    private function setColumnAlignment($sheet, $column, $align = 'center', $valign = 'center')
    {
        $field = $sheet->getStyleByColumnAndRow($column, $this->now_row);
        $field->getAlignment()
            ->setHorizontal($align)
            ->setVertical($valign);
    }

//    /**
//     * Записывает данные по колониям для Excel
//     *
//     * @param Worksheet $sheet - текущий активный лист
//     * @param array $colony_data - информация по региону
//     * @param int $m - номер строки
//     */
//    private function writeXLSXColonyData($sheet, $colony_data, &$m)
//    {
//        $m++;
//        $payment_commission = $colony_data['totalcost'] - ($colony_data['totalcost'] - ($colony_data['totalcost']*0.028));
//        $im_commission = $colony_data['commission'] - $payment_commission;
//
//        $colony = new \Shop\Model\Orm\Region($colony_data['colony_id']);
//        $sheet->setCellValueByColumnAndRow(1, $this->now_row, t($m) )
//            ->setCellValueByColumnAndRow(2, $this->now_row, $colony['title'])
//            ->setCellValueByColumnAndRow(3, $this->now_row, $colony_data['cnt'])
//            ->setCellValueByColumnAndRow(4, $this->now_row, \RS\Helper\CustomView::cost($colony_data['totalcost'], 'р.'))
//            ->setCellValueByColumnAndRow(5, $this->now_row, \RS\Helper\CustomView::cost($colony_data['commission'], 'р.'))
//            ->setCellValueByColumnAndRow(6, $this->now_row, \RS\Helper\CustomView::cost($payment_commission, 'р.'))
//            ->setCellValueByColumnAndRow(7, $this->now_row, \RS\Helper\CustomView::cost($im_commission, 'р.'));
//
//        $this->setColumnAlignment($sheet, 1);
//        $this->setColumnAlignment($sheet, 2, 'right');
//        $this->setColumnAlignment($sheet, 3, 'right');
//        $this->setColumnAlignment($sheet, 4, 'right');
//        $this->setColumnAlignment($sheet, 5, 'right');
//        $this->setColumnAlignment($sheet, 6, 'right');
//        $this->setColumnAlignment($sheet, 7, 'right');
//
//        $field = $sheet->getStyleByColumnAndRow(3, $this->now_row);
//        $field->getFill()
//            ->setFillType(Fill::FILL_SOLID)
//            ->getStartColor()->setARGB('FFE5E5E5');
//        $field = $sheet->getStyleByColumnAndRow(4, $this->now_row);
//        $field->getFill()
//            ->setFillType(Fill::FILL_SOLID)
//            ->getStartColor()->setARGB('FFE5E5E5');
//
//
//        $this->total_cnt += $colony_data['cnt'];
//        $this->total_cost += $colony_data['totalcost'];
//        $this->total_comission += $colony_data['commission'];
//        $payment_commission = $colony_data['totalcost'] - ($colony_data['totalcost'] - ($colony_data['totalcost']*0.028));
//        $this->total_comission_paysystem += $payment_commission;
//        $im_commission = $colony_data['commission'] - $payment_commission;
//        $this->total_comission_im += $im_commission;
//
//        $this->now_row++;
//    }

    /**
     * Записывает данные по товарам в заказе для Excel
     *
     * @param Worksheet $sheet - текущий активный лист
     * @param array $region_data - информация по региону
     * @param int $m - номер строки
     * @param string $detalization - тип детализации
     */
    private function writeXLSXOrderItems($sheet, $data)
    {
        $sheet->setCellValueByColumnAndRow(1, $this->now_row, t(htmlspecialchars_decode($data['title'])))
            ->setCellValueByColumnAndRow(3, $this->now_row, t($data['barcode']))
            ->setCellValueByColumnAndRow(4, $this->now_row, $data['amount'])
            ->setCellValueByColumnAndRow(5, $this->now_row, $data['single_cost'])
            ->setCellValueByColumnAndRow(6, $this->now_row, $data['price']);
        $sheet->mergeCellsByColumnAndRow(1, $this->now_row, 2, $this->now_row);
        $sheet->getStyle('A'.$this->now_row)->getAlignment()->setWrapText(true);
        $sheet->getStyle('C'.$this->now_row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    }

    /**
     * Добавляет в файл XLSX строки с позициями заказа
     *
     * @param Worksheet $sheet - текущий активный лист
     * @param array $info - информация по заказам
     * @param string $detalization - тип детализации
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \RS\Db\Exception
     * @throws \RS\Orm\Exception
     */
    private function addOrderItems($sheet, \Shop\Model\Orm\Order $order)
    {
        $this->now_row++;
        $this->now_row++;

        $sheet->setCellValueByColumnAndRow(1, $this->now_row, t('Детализация заказа'));
        $field = $sheet->getStyleByColumnAndRow(1, $this->now_row);
        $field->getFont()->setBold(true)->setSize(11);
        $field->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->mergeCellsByColumnAndRow(1, $this->now_row, 6, $this->now_row);

        $this->now_row++;

        $sheet->setCellValueByColumnAndRow('1', $this->now_row, t('Наименование товара'))
            ->mergeCellsByColumnAndRow(1, $this->now_row, 2, $this->now_row)
            ->setCellValueByColumnAndRow(3, $this->now_row, t('Артикул'))
            ->setCellValueByColumnAndRow(4, $this->now_row, t('Кол-во'))
            ->setCellValueByColumnAndRow(5, $this->now_row, t('Цена'))
            ->setCellValueByColumnAndRow(6, $this->now_row, t('Сумма'));
        $sheet->getStyle('A11:F11')->getFont()->setBold(true);
        $this->now_row++;

        $cart = $order->getCart();
        $products = $cart->getProductItems();
        $cartItems = $cart->getItems();
        $data = [];
        foreach ($cartItems as $item){
            if($item['type'] == 'product'){
                $data['title'] = $item->getEntity()->title;
                $data['barcode'] = $item->getEntity()->barcode;
                $data['amount'] = $item['amount'];
                $data['single_cost'] = $item['single_cost'];
                $data['price'] = $item['price'];
                $this->writeXLSXOrderItems($sheet, $data);
                $this->now_row++;
            }
        }
        $sheet->getStyle('A11:F'.$this->now_row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

//        return [
//            'total_cnt' => $this->total_cnt,
//            'total_cost' => $this->total_cost,
//            'total_comission' => $this->total_comission,
//            'total_comission_paysystem' => $this->total_comission_paysystem,
//            'total_comission_im' => $this->total_comission_im,
//        ];
    }

    /**
     * Получает ссылку на файл с данными детализации
     *
     * @param \Shop\Model\Orm\Order $order
     *
     * @return string
     */
    function getExportFile($order): string
    {
        require_once (__DIR__."/../phpexcel/vendor/autoload.php");

        //Смотрим данные по заказам
//        $order_api = new OrderApi();
//        $info      = $order_api->getOrdersExportInfo($from, $to, $this->detalization);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        $this->addTitles($sheet, $order);
        $this->addOrderItems($sheet, $order);

//        $total_info = $this->addOrders($sheet, $info, $this->detalization);

        //Стиль границ
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => [
                        'rgb' => '000000'
                    ],
                ],
            ],
        ];
        $last_row = $sheet->getHighestRow();

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $file_name = 'export_order'.$order['order_num'].'.xlsx';
        $dir = \Setup::$MODULE_FOLDER.'/fsinzak/xlsx/';
        \RS\File\Tools::makePath(\Setup::$ROOT.$dir);
        $writer->save(\Setup::$ROOT.$dir.$file_name);
        return $dir.$file_name;
    }
}
