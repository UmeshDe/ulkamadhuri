<?php
namespace Modules\Reports\Reports;


use Carbon\Carbon;
use Modules\Process\Entities\QualityParameter;
use PDF;


class QualityCertificateReport extends AbstractReport
{
    public $columns = [
        'sr_no' => [
            'column_name' => 'sr_no',
            'display_name' => 'Sr No',
            'type' => REPORT_ROWNO_COLUMN
        ],
        'carton_date' => [
            'column_name' => 'carton',
            'display_name' => 'Carton Date',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'carton_date'
        ],
        'product_date' => [
            'column_name' => 'carton.product',
            'display_name' => 'Product Date',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'product_date'
        ],
        'lot_no' => [
            'column_name' => 'carton.product',
            'display_name' => 'Lot No',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'lot_no'
        ],
        'C/s' => [
            'column_name' => 'carton',
            'display_name' => 'C/s',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'no_of_cartons'
        ],
        'moisture' => [
            'column_name' => 'moisture',
            'display_name' => 'Moisture',
        ],
        'breaking' => [
            'column_name' => 'work_force',
            'display_name' => 'Breaking (WF)',
        ],
        'depth' => [
            'column_name' => 'length',
            'display_name' => 'Depth (L)',
        ],
        'standard_gl' => [
            'column_name' => 'gel_strength',
            'display_name' => 'Gel Strength',
        ],
        'whiteness' => [
            'column_name' => 'kamaboko_hw',
            'display_name' => 'Whiteness',
        ],
        'contam' => [
            'column_name' => 'contam',
            'display_name' => 'Contam',
        ],
        'ph' => [
            'column_name' => 'ph',
            'display_name' => 'PH',
        ],
        'grade' => [
            'column_name' => 'grades',
            'display_name' => 'Grade',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'grade'
        ],
    ];

    public function setup()
    {
        if(Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) == Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT))
        {
            $this->reportMaster->sub_title = 'Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) ;
        }
        else{
            $this->reportMaster->sub_title = 'From Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) . '____To Date:' .Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT) ;
        }

        $this->reportMaster->sub_title_style = 'text-align:left';

        $queryBuilder = QualityParameter::with('carton','carton.product', 'user')->whereDate('created_at' , '>=' , $this->startDate->format('Y-m-d'))->whereDate('created_at' ,'<=',$this->endDate->format('Y-m-d'));

        $this->reportMaster->footer = ' Printed by :'.  auth()->user()->first_name." ".auth()->user()->last_name .' , ' .'Date & Time :' . Carbon::now()->format(PHP_DATE_TIME_FORMAT) ;
        
        $this->data = $queryBuilder->get();

        $this->setupDone = true;

    }
}