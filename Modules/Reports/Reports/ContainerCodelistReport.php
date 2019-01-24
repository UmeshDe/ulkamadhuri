<?php
namespace Modules\Reports\Reports;


use Illuminate\Support\Facades\DB;
use Modules\Process\Entities\Shipment;
use Modules\Process\Entities\ShipmentCarton;
use Carbon\Carbon;
use Modules\Process\Repositories\ShipmentRepository;
use PDF;

class ContainerCodelistReport extends AbstractReport
{
    public $shipment;
    public $shipmentdata;
    public $lotno;
    public $sum;
    public $data;


    public  $t1 ;
    public  $t2 ;
    public  $t3 ;
    public  $t4 ;
    public  $t5 ;
    public  $t6 ;
    public  $t7 ;
    public  $t8 ;
    public  $t9 ;
    public  $t10;
    public  $t11;
    public  $t12;
    public  $t13;
    public  $t14;
    public  $t15;
    public  $t16;
    public  $t17;
    public  $t18;
    public  $t19;
    public $t20;

    public function setup(){


        $this->shipment = DB::table("process__shipmentcartons")
            ->join('process__shipments','process__shipments.id','=','process__shipmentcartons.shipment_id')
            ->join('process__cartons','process__cartons.id','=','process__shipmentcartons.carton_id')
            ->join('process__products','process__products.id','=','process__cartons.product_id')
            ->select('process__products.lot_no','process__cartons.carton_date','process__shipmentcartons.thappy',DB::raw('SUM(process__shipmentcartons.quantity) as quantity'))
            ->where('process__shipments.container_no',$this->containerno)
            ->groupBy('process__products.lot_no','process__shipmentcartons.thappy')
            ->get();

        $this->shipmentdata = app(ShipmentRepository::class)->getByAttributes(['container_no' => $this->containerno]);

        $this->lotno =  DB::table("process__shipmentcartons")
            ->join('process__shipments','process__shipments.id','=','process__shipmentcartons.shipment_id')
            ->join('process__cartons','process__cartons.id','=','process__shipmentcartons.carton_id')
            ->join('process__products','process__products.id','=','process__cartons.product_id')
            ->select('process__products.lot_no','process__cartons.carton_date')
            ->where('process__shipments.container_no',$this->containerno)
            ->distinct('process__products.lot_no')
            ->get();

//        dd($this->shipment);

//        dd($this->lotno);

        $this->data = [];


        foreach ($this->lotno as $lotno)
        {
            $thappy1 = 0;
            $thappy2 = 0;
            $thappy3 = 0;
            $thappy4 = 0;
            $thappy5 = 0;
            $thappy6 = 0;
            $thappy7 = 0;
            $thappy8 = 0;
            $thappy9 = 0;
            $thappy10 = 0;
            $thappy11 = 0;
            $thappy12 = 0;
            $thappy13 = 0;
            $thappy14 = 0;
            $thappy15 = 0;
            $thappy16 = 0;
            $thappy17 = 0;
            $thappy18 = 0;
            $thappy19 = 0;
            $thappy20 = 0;
            foreach ($this->shipment as $shipment)
            {
                if($shipment->lot_no == $lotno->lot_no)
                {
                        if($shipment->thappy == 1)
                        {
                            $thappy1 += $shipment->quantity;
                        }
                        if($shipment->thappy == 2)
                        {
                            $thappy2 += $shipment->quantity;
                        }
                        if($shipment->thappy == 3)
                        {
                            $thappy3 += $shipment->quantity;
                        }
                        if($shipment->thappy == 4)
                        {
                            $thappy4 += $shipment->quantity;
                        }
                        if($shipment->thappy == 5)
                        {
                            $thappy5 += $shipment->quantity;
                        }
                        if($shipment->thappy == 6)
                        {
                            $thappy6 += $shipment->quantity;
                        }
                        if($shipment->thappy == 7)
                        {
                            $thappy7 += $shipment->quantity;
                        }
                        if($shipment->thappy == 8)
                        {
                            $thappy8 += $shipment->quantity;
                        }
                        if($shipment->thappy == 9)
                        {
                            $thappy9 += $shipment->quantity;
                        }
                        if($shipment->thappy == 10)
                        {
                            $thappy10 += $shipment->quantity;
                        }
                        if($shipment->thappy == 11)
                        {
                            $thappy11 += $shipment->quantity;
                        }
                        if($shipment->thappy == 12)
                        {
                            $thappy12 += $shipment->quantity;
                        }
                        if($shipment->thappy == 13)
                        {
                            $thappy13 += $shipment->quantity;
                        }
                        if($shipment->thappy == 14)
                        {
                            $thappy14 += $shipment->quantity;
                        }
                        if($shipment->thappy == 15)
                        {
                            $thappy15 += $shipment->quantity;
                        }
                        if($shipment->thappy == 16)
                        {
                            $thappy16 += $shipment->quantity;
                        }
                        if($shipment->thappy == 17)
                        {
                            $thappy17 += $shipment->quantity;
                        }
                        if($shipment->thappy == 18)
                        {
                            $thappy18 += $shipment->quantity;
                        }
                        if($shipment->thappy == 19)
                        {
                            $thappy19 += $shipment->quantity;
                        }
                        if($shipment->thappy == 20)
                        {
                            $thappy20 += $shipment->quantity;
                        }
                }
            }

            $total = $thappy1 + $thappy2 + $thappy3 + $thappy4 + $thappy5 + $thappy6 + $thappy7 + $thappy8 + $thappy9 + $thappy10 + $thappy11 + $thappy12 + $thappy13 + $thappy14 + $thappy15 + $thappy16 + $thappy17 + $thappy10 + $thappy19 + $thappy20;

            if($thappy1 == 0)
            {
                $thappy1 = "-";
            }
            if($thappy2 == 0)
            {
                $thappy2 = "-";
            }
            if($thappy3 == 0)
            {
                $thappy3 = "-";
            }
            if($thappy4 == 0)
            {
                $thappy4 = "-";
            }
            if($thappy5 == 0)
            {
                $thappy5 = "-";
            }
            if($thappy6 == 0)
            {
                $thappy6 = "-";
            }
            if($thappy7 == 0)
            {
                $thappy7 = "-";
            }
            if($thappy8 == 0)
            {
                $thappy8 = "-";
            }
            if($thappy9 == 0)
            {
                $thappy9 = "-";
            }
            if($thappy10 == 0)
            {
                $thappy10 = "-";
            }
            if($thappy11 == 0)
            {
                $thappy11 = "-";
            }
            if($thappy12 == 0)
            {
                $thappy12 = "-";
            }
            if($thappy13 == 0)
            {
                $thappy13 = "-";
            }
            if($thappy14 == 0)
            {
                $thappy14 = "-";
            }
            if($thappy15 == 0)
            {
                $thappy15 = "-";
            }
            if($thappy16 == 0)
            {
                $thappy16 = "-";
            }
            if($thappy17 == 0)
            {
                $thappy17 = "-";
            }
            if($thappy18 == 0)
            {
                $thappy18 = "-";
            }
            if($thappy19 == 0)
            {
                $thappy19 = "-";
            }
            if($thappy20 == 0)
            {
                $thappy20 = "-";
            }

           $array = [
                        'carton_date' => $lotno->carton_date,
                        'lot_no' => $lotno->lot_no,
                        'thappy1' => $thappy1,
                        'thappy2' => isset($thappy2) ? $thappy2 : 0,
                        'thappy3' => isset($thappy3) ? $thappy3 : 0,
                        'thappy4' => isset($thappy4) ? $thappy4 : 0,
                        'thappy5' => isset($thappy5) ? $thappy5 : 0,
                        'thappy6' => isset($thappy6) ? $thappy6 : 0,
                        'thappy7' => isset($thappy7) ? $thappy7 : 0,
                        'thappy8' => isset($thappy8) ? $thappy8 : 0,
                        'thappy9' => isset($thappy9) ? $thappy9 : 0,
                        'thappy10' => isset($thappy10) ? $thappy10 : 0,
                        'thappy11' => isset($thappy11) ? $thappy11 : 0,
                        'thappy12' => isset($thappy12) ? $thappy12 : 0,
                        'thappy13' => isset($thappy13) ? $thappy13 : 0,
                        'thappy14' => isset($thappy14) ? $thappy14 : 0,
                        'thappy15' => isset($thappy15) ? $thappy15 : 0,
                        'thappy16' => isset($thappy16) ? $thappy16 : 0,
                        'thappy17' => isset($thappy17) ? $thappy17 : 0,
                        'thappy18' => isset($thappy18) ? $thappy18 : 0,
                        'thappy19' => isset($thappy19) ? $thappy19 : 0,
                        'thappy20' => isset($thappy20) ? $thappy20 : 0,
                        'total' => $total
                    ];
                    array_push($this->data,$array);

        }
        $this->t1 = 0;
        $this->t2 = 0;
        $this->t3 = 0;
        $this->t4 = 0;
        $this->t5 = 0;
        $this->t6 = 0;
        $this->t7 = 0;
        $this->t8 = 0;
        $this->t9 = 0;
        $this->t10 = 0;
        $this->t11 = 0;
        $this->t12 = 0;
        $this->t13 = 0;
        $this->t14 = 0;
        $this->t15 = 0;
        $this->t16 = 0;
        $this->t17 = 0;
        $this->t18 = 0;
        $this->t19 = 0;
        $this->t20 = 0;

       foreach ($this->data as $data)
       {
           if($data['thappy1'] == "-")
           {
               $data['thappy1'] = 0;
           }
           if($data['thappy2'] == "-")
           {
               $data['thappy2'] = 0;
           }
           if($data['thappy3'] == "-")
           {
               $data['thappy3'] = 0;
           }
           if($data['thappy4'] == "-")
           {
               $data['thappy4'] = 0;
           }
           if($data['thappy5'] == "-")
           {
               $data['thappy5'] = 0;
           }
           if($data['thappy6'] == "-")
           {
               $data['thappy6'] = 0;
           }
           if($data['thappy7'] == "-")
           {
               $data['thappy7'] = 0;
           }
           if($data['thappy8'] == "-")
           {
               $data['thappy8'] = 0;
           }
           if($data['thappy9'] == "-")
           {
               $data['thappy9'] = 0;
           }
           if($data['thappy10'] == "-")
           {
               $data['thappy10'] = 0;
           }
           if($data['thappy11'] == "-")
           {
               $data['thappy11'] = 0;
           }
           if($data['thappy12'] == "-")
           {
               $data['thappy12'] = 0;
           }
           if($data['thappy13'] == "-")
           {
               $data['thappy13'] = 0;
           }
           if($data['thappy14'] == "-")
           {
               $data['thappy14'] = 0;
           }
           if($data['thappy15'] == "-")
           {
               $data['thappy15'] = 0;
           }
           if($data['thappy16'] == "-")
           {
               $data['thappy16'] = 0;
           }
           if($data['thappy17'] == "-")
           {
               $data['thappy17'] = 0;
           }
           if($data['thappy18'] == "-")
           {
               $data['thappy18'] = 0;
           }
           if($data['thappy19'] == "-")
           {
               $data['thappy19'] = 0;
           }
           if($data['thappy20'] == "-")
           {
               $data['thappy20'] = 0;
           }
         $this->t1 += $data['thappy1'];
         $this->t2 += $data['thappy2'];
         $this->t3 += $data['thappy3'];
         $this->t4 += $data['thappy4'];
         $this->t5 += $data['thappy5'];
         $this->t6 += $data['thappy6'];
         $this->t7 += $data['thappy7'];
         $this->t8 += $data['thappy8'];
         $this->t9 += $data['thappy9'];
         $this->t10 += $data['thappy10'];
         $this->t11 += $data['thappy11'];
         $this->t12 += $data['thappy12'];
         $this->t13 += $data['thappy13'];
         $this->t14 += $data['thappy14'];
         $this->t15 += $data['thappy15'];
         $this->t16 += $data['thappy16'];
         $this->t17 += $data['thappy17'];
         $this->t18 += $data['thappy18'];
         $this->t19 += $data['thappy19'];
         $this->t20 += $data['thappy20'];
       }

//       dd($this->data);


        $this->sum =  DB::table("process__shipmentcartons")
            ->join('process__shipments','process__shipments.id','=','process__shipmentcartons.shipment_id')
            ->select(DB::raw('SUM(process__shipmentcartons.quantity) as total'))
            ->where('process__shipments.container_no',$this->containerno)
            ->get();
        $this->setupDone = true;

    }
}