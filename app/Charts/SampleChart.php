<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use App\Models\TblReceiptItems;
use App\Models\TblClass;
use App\Models\TblUsers;
use Illuminate\Support\Facades\DB;

class SampleChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $id = $request->id;
        
        if($id==1){
            $data = TblClass::join('tbl_receipt_items', 'tbl_receipt_items.class_id', '=', 'tbl_class.id')
            ->select(DB::raw('SUM(tbl_class.price) as total_earn'), 'tbl_class.name as class_name')
            ->orderBy('tbl_class.created_at')
            ->groupBy('tbl_class.id')
            ->get();
            $earn = array();
            $class = array();
            foreach($data as $row){
                array_push($earn, $row['total_earn']);
                array_push($class, $row['class_name']);
            }
            return Chartisan::build()
                ->labels($class)
                ->dataset('Total Earn',$earn);
        }else if($id==3){
            $data = TblUsers::select(DB::raw('COUNT(tbl_users.id) as total_registered'))
            ->groupBy('userType')
            ->where('userType','!=','Admin')
            ->get();
            return Chartisan::build()
                ->labels(['Student','Teacher'])
                ->dataset('Total Users',[$data[0]->total_registered,$data[1]->total_registered]);
        }else if($id==4){
            $data = TblUsers::join('tbl_class','tbl_class.user_id','=','tbl_users.id')
            ->join('tbl_receipt_items','tbl_class.id','=','tbl_receipt_items.class_id')
            ->select('tbl_users.id','tbl_users.username',DB::raw('SUM(tbl_receipt_items.id) as teacher_earn'))
            ->groupBy('tbl_users.id')
            ->where('userType','!=','Admin')
            ->where('userType','!=','Student')
            ->get();
            $user = array();
            $earn = array();
            foreach($data as $row){
                array_push($user, $row['id'].' - '.$row['username']);
                array_push($earn, $row['teacher_earn']);
            }
            return Chartisan::build()
                ->labels($user)
                ->dataset('Total Earn',$earn);
        }
        
    }
}