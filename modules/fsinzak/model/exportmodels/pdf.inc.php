<?php
namespace Fsinzak\Model\ExportModels;

use Custom\Model\OrderApi;

class PDF extends AbstractExportModel {

//    /**
//     * Заполненте данных по колонии
//     *
//     * @param array $colony_data - массив данных регионов
//     */
//    function fillColoniesData(&$colony_data)
//    {
//        if ($this->detalization == 'colonies' && !in_array($colony_data['colony_id'], $this->needed_colonies)){
//            return;
//        }
//
//        $colony = new \Shop\Model\Orm\Region($colony_data['colony_id']);
//        $this->total_cnt += $colony_data['cnt'];
//        $this->total_cost += $colony_data['totalcost'];
//        $this->total_comission += $colony_data['commission'];
//
//        $payment_commission = round($colony_data['totalcost'] - ($colony_data['totalcost'] - ($colony_data['totalcost'] * 0.028)), 2);
//        $this->total_comission_paysystem += $payment_commission;
//        $colony_data['title'] = $colony['title'];
//        $colony_data['payment_commission'] = $payment_commission;
//        $im_commission = $colony_data['commission'] - $payment_commission;
//        $this->total_comission_im += $im_commission;
//        $colony_data['im_commission'] = (float)$im_commission;
//    }
//
//    /**
//     * Заполненте данных по региону
//     *
//     * @param array $info - массив данных c регионами
//     */
//    function fillRegionData($info)
//    {
//        foreach ($info as &$data){
//            if ($this->detalization == 'colonies' && !in_array($data['region_id'], $this->needed_regions)){
//                continue;
//            }
//
//            if ($this->detalization != 'colonies') { // Если общий отчет по регионам
//                $this->total_cnt += $data['cnt'];
//                $this->total_cost += $data['totalcost'];
//                $this->total_comission += $data['commission'];
//
//                $payment_commission = $data['totalcost'] - ($data['totalcost'] - ($data['totalcost'] * 0.028));
//                $this->total_comission_paysystem += $payment_commission;
//                $data['payment_commission'] = $payment_commission;
//                $im_commission = $data['commission'] - $payment_commission;
//                $this->total_comission_im += $im_commission;
//                $data['im_commission'] = $im_commission;
//            }
//
//            if ($this->detalization == 'colonies' && !empty($data['childs'])){
//                foreach ($data['childs'] as &$child){
//                    $this->fillColoniesData($child);
//                }
//            }
//        }
//
//        return $info;
//    }
//
//    /**
//     * Получает ссылку на файл с данными детализации
//     * @param string $from - дата периода от
//     * @param string $to - дата периода до
//     *
//     * @return string
//     * @throws \SmartyException
//     */
    function getExportFile($from, $to): string
    {
//        require_once(__DIR__.'/../dompdf/dompdf_config.inc.php');
//
//        $order_api = new OrderApi();
//        $info       = $order_api->getOrdersExportInfo($from, $to, $this->detalization);
//        //Смотрим данные по пользователям
//        $users_info = $order_api->getUsersExportInfo($from, $to);
//
//        $date_from = date('d.m.Y', strtotime($from));
//        $date_to   = date('d.m.Y', strtotime($to));
//        $view = new \RS\View\Engine();
//
//        $info = $this->fillRegionData($info);
//
//        $html = $view->assign([
//            'date_from' => $date_from,
//            'date_to' => $date_to,
//            'info' => $info,
//            'users_info' => $users_info,
//            'total_cnt' => $this->total_cnt,
//            'total_cost' => $this->total_cost,
//            'total_comission' => $this->total_comission,
//            'total_comission_paysystem' => $this->total_comission_paysystem,
//            'total_comission_im' => $this->total_comission_im,
//            'detalization' => $this->detalization,
//        ])->fetch('%custom%/export/pdf.tpl');
//
//        $dompdf = new \DOMPDF();
//        $dompdf->load_html($html);
//        $dompdf->render();
//        $pdf_content = $dompdf->output();
//
//        $dir = \Setup::$MODULE_FOLDER.'/custom/xlsx/';
//        $file_name = 'export_orders.pdf';
//        file_put_contents(\Setup::$ROOT.$dir.$file_name, $pdf_content);
//
//        return $dir.$file_name;
    }
}
