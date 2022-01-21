<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TblCardInformation;
use App\Models\TblCart;
use App\Models\TblCategory;
use App\Models\TblClass;
use App\Models\TblClassStudent;
use App\Models\TblComment;
use App\Models\TblCourse;
use App\Models\TblFavorite;
use App\Models\TblPromo;
use App\Models\TblRating;
use App\Models\TblReceipt;
use App\Models\TblReceiptItems;
use App\Models\TblTeacherInfo;
use App\Models\TblUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class AdminController extends Controller
{
    private $data = array();

    function __construct(){
        $this->middleware(function ($request, $next){
            $this->data+=array('LoggedUserInfo'=>TblUsers::where('id','=', session('LoggedUser'))->first());
            if($this->data['LoggedUserInfo']->userType!='Admin'){
                return back();
            }
            return $next($request);
        });
    }

    function index(){
        // $data = TblUsers::join('tbl_class','tbl_class.user_id','=','tbl_users.id')
        //     ->join('tbl_receipt_items','tbl_class.id','=','tbl_receipt_items.class_id')
        //     ->select('tbl_users.id','tbl_users.username',DB::raw('SUM(tbl_receipt_items.id) as teacher_earn'))
        //     ->groupBy('tbl_users.id')
        //     ->where('userType','!=','Admin')
        //     ->where('userType','!=','Student')
        //     ->get();
        //     $user = array();
        //     $earn = array();
        //     foreach($data as $row){
        //         array_push($user, $row['id'].' - '.$row['username']);
        //         array_push($earn, $row['teacher_earn']);
        //     }
        // return $user;
        // return TblUsers::select('created_at')
        // ->groupBy('created_at')
        // ->whereNotNull('id')
        // ->whereDate('created_at', '>=' , Carbon::now()->subDays(30))
        // ->get();
        // return TblUsers::select(DB::raw('COUNT(tbl_users.id) as total_registered'), 'tbl_class.name as class_name')
        //     ->orderBy('tbl_class.created_at')
        //     ->groupBy('tbl_class.id')
        //     ->get();
        // $abu = TblClass::join('tbl_receipt_items', 'tbl_receipt_items.class_id', '=', 'tbl_class.id')
        // ->select(DB::raw('SUM(tbl_class.price) as total_earn'), 'tbl_class.name as class_name')
        // ->orderBy('tbl_class.created_at')
        // ->groupBy('tbl_class.id')
        // ->get();
        // $earn = array();
        // $class = array();
        // foreach($abu as $row){
        //     array_push($earn, $row['total_earn']);
        //     array_push($class, $row['class_name']);
        // }
        // return $earn;
        $this->data+=array("dashboard"=>TblCategory::select('id','name')->get());
        // $users = User::where(DB::raw("(DATE_FORMAT(created_at,'%Y'))"),date('Y'))
    	// 			->get();
        //return $this->data;
        // $this->data+=array('PopularClassInfo'=>TblRating::join('tbl_class','tbl_class.id','=','tbl_rating.class_id')
        // ->join('tbl_category', 'tbl_category.id', '=', 'tbl_class.category_id')
        // ->select('tbl_class.id as class_id', 'tbl_class.name as class_name', 'tbl_category.name as category_name','tbl_class.price', 'tbl_class.updated_at as class_update','tbl_class.pic_path as class_thumbnail',DB::raw('AVG(rating_star) as ratings_average'))
        // ->groupBy('tbl_rating.class_id')
        // ->orderBy('ratings_average','DESC')
        // ->skip(0)
        // ->take(8)
        // ->get());
        return view('admin.index', $this->data);
    }

    function table($table){
        $this->data+=array("tbl"=>($table));
        $this->data+=array("TableName"=>Schema::getColumnListing('tbl_'.$table));
        $this->data+=array("Title"=>str_replace("_", " ", ucfirst($table)));
        $this->data+=array("Table"=>("App\Models\Tbl".str_replace("_", "", $table))::get());
        $this->data+=array("category_id"=>TblCategory::select('id','name')->get());
        $this->data+=array("user_id"=>TblUsers::select('id','username')->get());
        $this->data+=array("class_id"=>TblClass::select('id','name')->get());
        //return $this->data;
        // $this->data+=array('PopularClassInfo'=>TblRating::join('tbl_class','tbl_class.id','=','tbl_rating.class_id')
        // ->join('tbl_category', 'tbl_category.id', '=', 'tbl_class.category_id')
        // ->select('tbl_class.id as class_id', 'tbl_class.name as class_name', 'tbl_category.name as category_name','tbl_class.price', 'tbl_class.updated_at as class_update','tbl_class.pic_path as class_thumbnail',DB::raw('AVG(rating_star) as ratings_average'))
        // ->groupBy('tbl_rating.class_id')
        // ->orderBy('ratings_average','DESC')
        // ->skip(0)
        // ->take(8)
        // ->get());
        return view('admin.edit_table', $this->data);
    }

    function update_admin_table(Request $request){
        if($request->action=="edit"){
            $tbl = ("App\Models\Tbl".str_replace("_", "", $request->table))::find($request->id);
            $tbl_column = Schema::getColumnListing('tbl_'.$request->table);
            $ignoreList = array('created_at','updated_at','save');
            foreach($tbl_column as $column){
                if (in_array($column, $ignoreList)==false) {
                    $tbl->$column = $request->input($column);
                }
            }
            $tbl->updated_at = Carbon::now();
            $update = $tbl->update();
            if($update){
                return back()->with('status','Table '.$request->table.' has been updated successfully');
            }else{
                return redirect()->back()->with('danger','Something went wrong. Please retry again later.');
            }
        }else if($request->action=="create"){
            $tbl= new ("App\Models\Tbl".str_replace("_", "", $request->table));
            $tbl_column = Schema::getColumnListing('tbl_'.$request->table);
            $ignoreList = array('created_at','updated_at','id');
            foreach($tbl_column as $column){
                if (in_array($column, $ignoreList)==false) {
                    $tbl->$column = $request->$column;
                }
            }
            if($request->table=="users"){
                $tbl->password = Hash::make($request->password);
            }
            $save = $tbl->save();
            if($save){
                return back()->with('status','New data from Table '.$request->table.' has been created successfully');
            }else{
                return redirect()->back()->with('danger','Something went wrong. Please retry again later.');
            }
        }
    }

    function admin_logout(){
        if(session()->has('LoggedUser')){
            session()->pull('LoggedUser');
            return redirect('admin/login');
        }
    }
}
