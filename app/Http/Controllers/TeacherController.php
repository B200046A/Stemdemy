<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TblUsers;
use App\Models\TblCategory;
use App\Models\TblClass;
use App\Models\TblRating;
use App\Models\TblCourse;
use App\Models\TblClassStudent;
use App\Models\TblCart;
use App\Models\TblComment;
use App\Models\TblFavorite;

use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    private $data = array();

    function __construct(){
        $this->middleware(function ($request, $next){
            $this->data+=array('LoggedUserInfo'=>TblUsers::where('id','=', session('LoggedUser'))->first());
            if($this->data['LoggedUserInfo']->userType!='Teacher'){
                return back();
            }
            return $next($request);
        });
    }


    function teacherMain(){
        $this->data+=array('ClassInfo'=>TblClass::join('tbl_category', 'tbl_category.id', '=', 'tbl_class.category_id')
        ->select('tbl_class.id as class_id', 'tbl_class.name as class_name', 'tbl_category.name as category_name','tbl_class.price', 'tbl_class.updated_at as class_update','tbl_class.pic_path as class_thumbnail')
        ->where('tbl_class.user_id', '=', session('LoggedUser'))
        ->groupBy('tbl_class.id')
        ->orderBy('tbl_class.created_at')
        ->get());
        $this->data+=array('RatingInfo'=>TblRating::select('tbl_rating.class_id',DB::raw('AVG(rating_star) as ratings_average'))
        ->groupBy('tbl_rating.class_id')
        ->get());
        return view('teacher.mainPage', $this->data);
    }

    function createClassPage(){
        $this->data+=array('CategoryInfo'=>TblCategory::select('tbl_category.id as category_id', 'tbl_category.name as category_name')
        ->orderBy('tbl_category.id')
        ->get());
        return view('teacher.createClassPage', $this->data);
    }

    function createNewClass(Request $request){
        $request -> validate([
            'className'=>'required',
            'price'=>'required',
            'classCategory'=>'required',
            'description'=>'required'
        ]);
        
        $tbl_class = new TblClass;
        $tbl_class->name = $request->input('className');
        $tbl_class->description = $request->input('description');
        $tbl_class->price = $request->input('price');
        $tbl_class->category_id = $request->input('classCategory');
        $tbl_class->user_id = $request->input('user_id');
        if($request->file('classThumbnail')){
            $path = 'classThumbnail/';
            $file = $request->file('classThumbnail');
            $file_name = time().'_'.$file->getClientOriginalName();
            $upload = $file->storeAs($path, $file_name, 'public');
            if(!$upload){
                return redirect()->back()->with('danger','The uploaded video might has something wrong. Please retry again later.');
            }else{
                $tbl_class->pic_path = $file_name;
            }
        }
        $save = $tbl_class->save();
        if($save){
            return redirect('/teacher/mainPage')->with('status','New class have been created successfully!');
        }else{
            return back()->with('danger','Something went wrong. Please retry again later.');
        }
    }

    //Start:Function of editClassPage
    function editClassPage($id){
        $this->data+=array('ClassInfo'=>TblClass::join('tbl_category', 'tbl_category.id', '=', 'tbl_class.category_id')
        ->select('tbl_class.id as class_id', 'tbl_class.name as class_name', 'tbl_category.name as category_name','tbl_class.price','tbl_class.description as class_description','tbl_class.pic_path as class_thumbnail', 'tbl_class.updated_at as class_update')
        ->where('tbl_class.id', '=', $id)
        ->first());
        $this->data+=array('CourseInfo'=>TblCourse::select('tbl_course.*')
        ->where('tbl_course.class_id', '=', $id)
        ->orderBy('tbl_course.doc_order')
        ->get());
        $this->data+=array('CategoryInfo'=>TblCategory::select('tbl_category.id as category_id', 'tbl_category.name as category_name')
        ->orderBy('tbl_category.id')
        ->get());
        return view('teacher.editClassPage', $this->data);
    }

    function updateClassInfo(Request $request,$id){
        switch ($request->input('action')) {
        case 'submit':
            $request -> validate([
                'className'=>'required',
                'price'=>'required',
                'classCategory'=>'required',
                'description'=>'required'
            ]);
            
            $tbl_class = TblClass::find($id);
            $tbl_class->name = $request->input('className');
            $tbl_class->description = $request->input('description');
            $tbl_class->price = $request->input('price');
            $tbl_class->category_id = $request->input('classCategory');
            if($request->file('classThumbnail')){
                $path = 'classThumbnail/';
                $file = $request->file('classThumbnail');
                $file_name = time().'_'.$file->getClientOriginalName();
                $upload = $file->storeAs($path, $file_name, 'public');
                if(!$upload){
                    return redirect()->back()->with('danger','The uploaded video might has something wrong. Please retry again later.');
                }else{
                    $tbl_class->pic_path = $file_name;
                }
            }
    
            $update = $tbl_class->update();
            if($update){
                return back()->with('status','The class has been updated successfully');
            }else{
                return redirect()->back()->with('danger','Something went wrong. Please retry again later.');
            }
            break;
        case 'delete':
            $tbl_rating = TblRating::where('class_id', '=', $id)->get();
            if(!$tbl_rating!="[]"){
                $tbl_rating->each->delete();
            }
            $tbl_class = TblClass::find($id);
            $delete = $tbl_class->delete();
            if($delete){
                return redirect('/teacher/mainPage')->with('status','The class has been deleted successfully!');
            }else{
                return redirect()->back()->with('danger','Something went wrong. Please retry again later.');
            }
            break;
        }
        return back()->with('danger','Something went wrong. Please retry again later.');
    }


    function updateCourseInfo(Request $request,$id){
        switch ($request->input('action')) {
            case 'submit':
                $request -> validate([
                    'courseNameModal'=>'required',
                    'courseInfoModal'=>'required'
                ]);
                
                $tbl_course = TblCourse::find($id);
                $tbl_course->name = $request->input('courseNameModal');
                $tbl_course->info = $request->input('courseInfoModal');
                if($request->file('courseVideoModal')){
                    $path = 'courseVideo/';
                    $file = $request->file('courseVideoModal');
                    $file_name = time().'_'.$file->getClientOriginalName();
                    $upload = $file->storeAs($path, $file_name, 'public');
                    if(!$upload){
                        return redirect()->back()->with('danger','The uploaded video might has something wrong. Please retry again later.');
                    }else{
                        $tbl_course->doc_path = $file_name;
                    }
                }

                $update = $tbl_course->update();
                if($update){
                    return back()->with('status','The course has been updated Successfully');
                }else{
                    return redirect()->back()->with('danger','Something went wrong. Please retry again later.');
                }
                break;
            case 'delete':
                $tbl_course = TblCourse::find($id);
                $delete = $tbl_course->delete();

                if($delete){
                    $sortHigher = TblCourse::where('tbl_course.class_id', '=', $request->input('class_id'))
                    ->select('tbl_course.id')
                    ->where('tbl_course.id', '!=', $id)
                    ->where('tbl_course.doc_order', '>', $tbl_course->doc_order)
                    ->orderBy('tbl_course.doc_order')
                    ->get();

                    $doc_order_restart=$tbl_course->doc_order;

                    foreach($sortHigher as $currentID){
                        $currentUpdate = TblCourse::find($currentID->id);
                        $currentUpdate->doc_order=$doc_order_restart;
                        $currentUpdate->save();
                        $doc_order_restart+=1;
                    }
                    return back()->with('status','The course has been deleted successfully!');
                }else{
                    return redirect()->back()->with('danger','Something went wrong. Please retry again later.');
                }
                break;
            case 'create':
                $request -> validate([
                    'courseNameModal'=>'required',
                    'courseInfoModal'=>'required',
                    'courseVideoModal'=>'required'
                ]);
        
                $tbl_course= new TblCourse;
                $tbl_course->class_id = $request->class_id;
                $tbl_course->doc_order = $request->nextOrder;
                $tbl_course->name = $request->courseNameModal;
                $tbl_course->info = $request->courseInfoModal;
                if($request->file('courseVideoModal')){
                    $path = 'courseVideo/';
                    $file = $request->file('courseVideoModal');
                    $file_name = time().'_'.$file->getClientOriginalName();
                    $tbl_course->doc_path = $file_name;
                    $upload = $file->storeAs($path, $file_name, 'public');
                    if(!$upload){
                        return back()->with('danger','The uploaded image might has something wrong. Please retry again later.');
                    }
                }
                
                $save = $tbl_course->save();
                if($save){
                    return back()->with('status','The course has been created successfully!');
                }else{
                    return back()->with('danger','Something went wrong. Please retry again later.');
                }
                break;
        }
        return back()->with('danger','Something went wrong. Please retry again later.');
    }
    //End:Function of editClassPage

    function teacher_del_class($classId){
        $this->del_table_class("App\Models\TblCart",$classId);
        $this->del_table_class("App\Models\TblClassStudent",$classId);
        $this->del_table_class("App\Models\TblComment",$classId);
        $this->del_table_class("App\Models\TblCourse",$classId);
        $this->del_table_class("App\Models\TblFavorite",$classId);
        $this->del_table_class("App\Models\TblRating",$classId);
        $tbl_class = TblClass::find($classId);
        $delete = $tbl_class->delete();
        if($delete){
            return redirect('/teacher/mainPage')->with('status','The course has been deleted successfully!');
        }else{
            return redirect()->back()->with('danger','Something went wrong. Please retry again later.');
        }
    }

    function del_table_class($table,$classId){
        $tbl = $table::where('class_id', '=', $classId)->get();
        if(!$tbl!="[]"){
            $tbl->each->delete();
        }
    }
}