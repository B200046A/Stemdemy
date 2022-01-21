<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TblUsers;
use App\Models\TblCategory;
use App\Models\TblClass;
use App\Models\TblRating;
use App\Models\TblClassStudent;
use App\Models\TblCourse;
use App\Models\TblComment;
use App\Models\TblFavorite;
use App\Models\TblCart;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SharedController extends Controller
{
    private $data = array();

    function __construct(){
        $this->middleware(function ($request, $next){
            $this->data+=array('LoggedUserInfo'=>TblUsers::where('id','=', session('LoggedUser'))->first());
            $this->data+=array('StudentCartInfo'=>TblCart::join('tbl_class','tbl_class.id','=','tbl_cart.class_id')
            ->select('tbl_cart.*','tbl_class.name')
            ->where('tbl_cart.user_id','=', session('LoggedUser'))->get());
            return $next($request);
        });
    }

    function homePage(){
        $this->data+=array('PopularClassInfo'=>TblRating::join('tbl_class','tbl_class.id','=','tbl_rating.class_id')
        ->join('tbl_category', 'tbl_category.id', '=', 'tbl_class.category_id')
        ->select('tbl_class.id as class_id', 'tbl_class.name as class_name', 'tbl_category.name as category_name','tbl_class.price', 'tbl_class.updated_at as class_update','tbl_class.pic_path as class_thumbnail',DB::raw('AVG(rating_star) as ratings_average'))
        ->groupBy('tbl_rating.class_id')
        ->orderBy('ratings_average','DESC')
        ->skip(0)
        ->take(8)
        ->get());
        return view('homePage', $this->data);
    }

    function admin_login(){
        return view('admin.login');
    }

    function admin_check(Request $request){
        $request -> validate([
            'email'=>'required|email',
            'password'=>'required|min:8|max:20'
        ]);

        $userInfo = TblUsers::where('email','=', $request->email)
        ->where('tbl_users.userType', '=', 'Admin')
        ->first();
        if(!$userInfo){
            return back()->with('fail','We do not recognize your email address');
        }else{
            //check password
            if(Hash::check($request->password, $userInfo->password)){
                $request->session()->put('LoggedUser', $userInfo->id);
                return redirect('admin/index');
            }else{
                return back()->with('fail','Incorrect password');
            }
        }
    }
    
    function login(){
        return view('login');
    }

    function register(){
        return view('register');
    }

    function save(Request $request){
        $request -> validate([
            'username'=>'required|unique:tbl_users',
            'email'=>'required|email|unique:tbl_users',
            'password'=>'required|min:8|max:20',
            'rpassword'=>'required|required_with:password|same:password',
            'contact'=>'required',
            'btnradio'=>'required',
            'agree'=>'required'
        ]);

        $tbl_users= new TblUsers;
        $tbl_users->username = $request->username;
        $tbl_users->password = Hash::make($request->password);
        $tbl_users->email = $request->email;
        $tbl_users->user_status = 0;
        $tbl_users->contact_number = $request->contact;
        if($request->file('profilePic')){
            $path = 'profilePic/';
            $file = $request->file('profilePic');
            $file_name = time().'_'.$file->getClientOriginalName();
            $tbl_users->profile_pic_path = $file_name;
            $upload = $file->storeAs($path, $file_name, 'public');
            if(!$upload){
                return back()->with('danger','The uploaded image might has something wrong. Please retry again later.');
            }
        }
        $tbl_users->introduction = $request->description;
        $tbl_users->userType = $request->btnradio;
        
        $save = $tbl_users->save();
        if($save){
            return back()->with('success','Your account have been created successfully!');
        }else{
            return back()->with('danger','Something went wrong. Please retry again later.');
        }
    }

    function logout(){
        if(session()->has('LoggedUser')){
            session()->pull('LoggedUser');
            return redirect('login');
        }
    }

    function check(Request $request){
        $request -> validate([
            'email'=>'required|email',
            'password'=>'required|min:8|max:20'
        ]);

        $userInfo = TblUsers::where('email','=', $request->email)->first();
        if(!$userInfo){
            return back()->with('fail','We do not recognize your email address');
        }else{
            //check password
            if(Hash::check($request->password, $userInfo->password)){
                $request->session()->put('LoggedUser', $userInfo->id);
                if(($userInfo->userType)=='Student'){
                    return redirect('student/mainPage');
                }else if(($userInfo->userType)=='Teacher'){
                    return redirect('teacher/mainPage');
                }
            }else{
                return back()->with('fail','Incorrect password');
            }
        }
    }

    function personalInfoPage(){
        return view('personalInfoPage', $this->data);
    }

    function updatePersonalInfo(Request $request,$id){
        $request -> validate([
            'username'=>'required|unique:tbl_users,username,'.$id,
            'email'=>'required|email|unique:tbl_users,email,'.$id,
            'contact'=>'required'
        ]);

        $tbl_users = TblUsers::find($id);
        $tbl_users->username = $request->input('username');
        $tbl_users->email = $request->input('email');
        $tbl_users->contact_number = $request->input('contact');
        $tbl_users->introduction = $request->input('description');
        if($request->file('profilePic')){
            $path = 'profilePic/';
            $file = $request->file('profilePic');
            $file_name = time().'_'.$file->getClientOriginalName();
            $tbl_users->profile_pic_path = $file_name;
            $upload = $file->storeAs($path, $file_name, 'public');
            if(!$upload){
                return redirect()->back()->with('danger','The uploaded image might has something wrong. Please retry again later.');
            }
        }
        $update = $tbl_users->update();
        if($update){
            return redirect()->back()->with('status','Updated Successfully');
        }else{
            return redirect()->back()->with('danger','Something went wrong. Please retry again later.');
        }
    }

    function classPage($id){
        $this->data+=array('RatingInfo'=>TblRating::select('tbl_rating.class_id',DB::raw('AVG(rating_star) as ratings_average'))
        ->where('tbl_rating.class_id', '=', $id)
        ->groupBy('tbl_rating.class_id')
        ->first());
        $this->data+=array('ClassInfo'=>TblClass::join('tbl_category', 'tbl_category.id', '=', 'tbl_class.category_id')
        ->select('tbl_class.id as class_id', 'tbl_class.name as class_name', 'tbl_category.name as category_name','tbl_class.price', 'tbl_class.updated_at as class_update','tbl_class.created_at as class_created','tbl_class.pic_path as class_thumbnail','tbl_class.description as class_info','tbl_class.user_id as teacher_id')
        ->where('tbl_class.id', '=', $id)
        ->orderBy('tbl_class.created_at')
        ->first());
        $teacherID=$this->data['ClassInfo']->teacher_id;
        if($this->data['LoggedUserInfo']!=''){
            $userID=$this->data['LoggedUserInfo']->id;
            $this->data+=array('FavClassInfo'=>TblFavorite::join('tbl_class', 'tbl_favorite.class_id', '=', 'tbl_class.id')
            ->join('tbl_users', 'tbl_users.id', '=', 'tbl_favorite.user_id')
            ->select('tbl_favorite.*')
            ->where('tbl_class.id', '=', $id)
            ->where('tbl_users.id', '=', $userID)
            ->get());
            $this->data+=array('BtnRatingInfo'=>TblRating::select('tbl_rating.rating_star')
            ->where('tbl_rating.user_id', '=', $userID)
            ->where('tbl_rating.class_id', '=', $id)
            ->get());
            $this->data+=array('CartInfo'=>TblCart::select('tbl_cart.*')
            ->where('tbl_cart.user_id', '=', $userID)
            ->where('tbl_cart.class_id', '=', $id)
            ->get());
            $this->data+=array('TeacherOwnedClassInfo'=>TblClass::select('tbl_class.id')
            ->where('tbl_class.user_id', '=', $userID)
            ->where('tbl_class.id', '=', $id)
            ->get());
            $this->data+=array('ClassStudentInfo'=>TblClassStudent::join('tbl_class', 'tbl_class_student.class_id', '=', 'tbl_class.id')
            ->join('tbl_users', 'tbl_users.id', '=', 'tbl_class_student.user_id')
            ->select('tbl_class.id')
            ->where('tbl_class_student.user_id', '=', $userID)
            ->where('tbl_class_student.class_id', '=', $id)
            ->get());
        }
        
        $this->data+=array('JoinedStudentNum'=>TblClassStudent::join('tbl_class', 'tbl_class_student.class_id', '=', 'tbl_class.id')
        ->select('tbl_class_student.*')
        ->where('tbl_class.id', '=', $id)
        ->count());
        $this->data+=array('CourseInfo'=>TblCourse::join('tbl_class', 'tbl_class.id', '=', 'tbl_course.class_id')
        ->select('tbl_course.*')
        ->where('tbl_class.id', '=', $id)
        ->orderBy('tbl_course.doc_order')
        ->get());
        $this->data+=array('TeacherInfo'=>TblUsers::select('tbl_users.*')
        ->where('tbl_users.id', '=', $teacherID)
        ->first());
        $this->data+=array('TeacherRatingInfo'=>TblRating::join('tbl_class', 'tbl_rating.class_id', '=', 'tbl_class.id')
        ->select('tbl_rating.rating_star')
        ->where('tbl_class.user_id', '=', $teacherID)
        ->avg('rating_star'));
        $this->data+=array('StudentNumInfo'=>TblClassStudent::join('tbl_class', 'tbl_class_student.class_id', '=', 'tbl_class.id')
        ->select('tbl_class_student.user_id')
        ->where('tbl_class.user_id', '=', $teacherID)
        ->distinct()
        ->count('tbl_class_student.user_id'));
        $this->data+=array('CommentInfo'=>TblComment::join('tbl_class', 'tbl_comment.class_id', '=', 'tbl_class.id')
        ->join('tbl_users', 'tbl_users.id', '=', 'tbl_comment.user_id')
        ->select('tbl_users.id as user_id','tbl_users.username as username','tbl_users.profile_pic_path as profile','tbl_comment.comment' ,'tbl_comment.id as comment_id' ,'tbl_comment.sub_comment','tbl_comment.likes','tbl_comment.updated_at as comment_at')
        ->where('tbl_class.id', '=', $id)
        ->where('tbl_comment.sub_comment', '=', -1)
        ->orderBy('tbl_comment.created_at','DESC')
        ->get());
        $this->data+=array('SubCommentInfo'=>TblComment::join('tbl_class', 'tbl_comment.class_id', '=', 'tbl_class.id')
        ->join('tbl_users', 'tbl_users.id', '=', 'tbl_comment.user_id')
        ->select('tbl_users.id as user_id','tbl_users.username as username','tbl_users.profile_pic_path as profile','tbl_comment.comment' ,'tbl_comment.sub_comment','tbl_comment.likes','tbl_comment.updated_at as comment_at','tbl_comment.id as comment_id')
        ->where('tbl_class.id', '=', $id)
        ->where('tbl_comment.sub_comment', '!=', -1)
        ->orderBy('tbl_comment.created_at','ASC')
        ->get());
        $this->data+=array('ClassRatingInfo'=>TblRating::join('tbl_class', 'tbl_rating.class_id', '=', 'tbl_class.id')
        ->join('tbl_users', 'tbl_users.id', '=', 'tbl_rating.user_id')
        ->select('tbl_users.username as username','tbl_users.profile_pic_path as profile','tbl_rating.rating_star','tbl_rating.review','tbl_rating.updated_at as review_at')
        ->where('tbl_rating.class_id', '=', $id)
        ->orderBy('tbl_rating.updated_at','DESC')
        ->get());
        
        return view('classPage', $this->data);
    }

    function submitComment(Request $request){
        $request -> validate([
            'txtcomment'=>'required'
        ]);
        
        $tbl_comment = new TblComment;
        $tbl_comment->comment = $request->input('txtcomment');
        $tbl_comment->class_id = $request->input('class_id');
        $tbl_comment->user_id = $request->input('user_id');
        $tbl_comment->sub_comment = -1;
        $save = $tbl_comment->save();
        if($save){
            return back()->with('status','Your comment have been created successfully!');
        }else{
            return back()->with('danger','Something went wrong. Please retry again later.');
        }
    }

    function replyComment(Request $request){
        $request -> validate([
            'txtreply'=>'required'
        ]);
        
        $tbl_comment = new TblComment;
        $tbl_comment->comment = $request->input('txtreply');
        $tbl_comment->class_id = $request->input('class_id');
        $tbl_comment->user_id = $request->input('user_id');
        $tbl_comment->sub_comment = $request->input('reply_id');
        $save = $tbl_comment->save();
        if($save){
            return back()->with('status','Your comment have been created successfully!');
        }else{
            return back()->with('danger','Something went wrong. Please retry again later.');
        }
    }

    function deleteComment($commentId){
        $tbl_subcomment = TblComment::where('sub_comment', '=', $commentId)
        ->get();
        if($tbl_subcomment!="[]"){
            $tbl_subcomment->each->delete();
        }
        $tbl_comment = TblComment::where('id', '=', $commentId)
        ->delete();
        if(!$tbl_comment){
            return redirect()->back()->with('danger','Something went wrong. Please retry again later.');
        }else{
            return redirect()->back()->with('status','The comment has been removed!');
        }
    }

    function coursePage($id){
        $this->data+=array('CurrentCourseInfo'=>TblCourse::join('tbl_class', 'tbl_class.id', '=', 'tbl_course.class_id')
        ->select('tbl_class.name as class_name','tbl_course.*')
        ->where('tbl_course.id', '=', $id)
        ->orderBy('tbl_course.doc_order')
        ->first());
        $classID=$this->data['CurrentCourseInfo']->class_id;
        $userID=$this->data['LoggedUserInfo']->id;
        $this->data+=array('CourseInfo'=>TblCourse::select('tbl_course.name','tbl_course.id')
        ->where('tbl_course.class_id', '=', $classID)
        ->orderBy('tbl_course.doc_order')
        ->get());
        $this->data+=array('StudentPermissionInfo'=>TblClassStudent::select('tbl_class_student.*')
        ->where('tbl_class_student.user_id', '=', $userID)
        ->where('tbl_class_student.class_id', '=', $classID)
        ->get());
        $this->data+=array('TeacherPermissionInfo'=>TblClass::select('tbl_class.*')
        ->where('tbl_class.user_id', '=', $userID)
        ->where('tbl_class.id', '=', $classID)
        ->get());
        if((($this->data['LoggedUserInfo']->userType=='Teacher')&&($this->data['TeacherPermissionInfo']=='[]'))||
        (($this->data['LoggedUserInfo']->userType=='Student')&&($this->data['StudentPermissionInfo']=='[]'))){
            return redirect()->back()->with('danger','You do not have permission to access the course.');
        }
        
        return view('coursePage', $this->data);
    }

    function searchPage(Request $request){
        //return $request;
        $page=$request->page;
        if($request->direct_search=='yes'||$page==''){
            $page=1;
        }
        $class_get_start_at=($page*8)-8;
        $userID='';
        if($this->data['LoggedUserInfo']!=''){
            $userID=$this->data['LoggedUserInfo']->id;
        }
        $sort=$request->sort;
        $category=$request->category;
        if($request->nav_category!=''){
            $category=array($request->nav_category);
        }
        $minPrice=$request->minPrice;
        $maxPrice=$request->maxPrice;
        $rating=$request->rating;
        $keyterm=$request->keyterm;
        $ClassInfo=TblClass::join('tbl_category', 'tbl_class.category_id', '=', 'tbl_category.id');
        $select='tbl_class.id as class_id';
        if($rating!=''||$sort=='2'||$sort=='3'){
            $ClassInfo->join('tbl_rating','tbl_rating.class_id','=','tbl_class.id');
        }
        if($rating!=''){
            $select=DB::raw('AVG(rating_star) as ratings_average');
        }
        if($sort=='2'){
            $ClassInfo->select($select,DB::raw('count(tbl_rating.id) as most_review'),'tbl_class.id as class_id', 'tbl_class.name as class_name', 'tbl_category.name as category_name','tbl_class.price', 'tbl_class.updated_at as class_update','tbl_class.created_at as class_created','tbl_class.pic_path as class_thumbnail','tbl_class.description as class_info','tbl_class.user_id as teacher_id')
            ->groupBy('tbl_rating.class_id')
            ->orderBy(DB::raw('count(tbl_rating.id)'),'DESC');
        }else if($sort=='3'){
            $ClassInfo->select($select,DB::raw('AVG(rating_star) as higest_rating'),'tbl_class.id as class_id', 'tbl_class.name as class_name', 'tbl_category.name as category_name','tbl_class.price', 'tbl_class.updated_at as class_update','tbl_class.created_at as class_created','tbl_class.pic_path as class_thumbnail','tbl_class.description as class_info','tbl_class.user_id as teacher_id')
            ->groupBy('tbl_rating.class_id')
            ->orderBy(DB::raw('AVG(rating_star)'),'DESC');
        }else if($sort=='4'){
            $ClassInfo->select($select,'tbl_class.id as class_id', 'tbl_class.name as class_name', 'tbl_category.name as category_name','tbl_class.price', 'tbl_class.updated_at as class_update','tbl_class.created_at as class_created','tbl_class.pic_path as class_thumbnail','tbl_class.description as class_info','tbl_class.user_id as teacher_id')
            ->orderBy('tbl_class.updated_at','DESC');
            if($rating!=''){
                $ClassInfo->groupBy('tbl_rating.class_id');
            }
        }else{
            $ClassInfo->select($select,'tbl_class.id as class_id', 'tbl_class.name as class_name', 'tbl_category.name as category_name','tbl_class.price', 'tbl_class.updated_at as class_update','tbl_class.created_at as class_created','tbl_class.pic_path as class_thumbnail','tbl_class.description as class_info','tbl_class.user_id as teacher_id')
            ->orderBy('tbl_class.id');
            if($rating!=''){
                $ClassInfo->groupBy('tbl_rating.class_id');
            }
        }
        if($category!=''){
            $subjects=[];
            foreach($category as $subject){
                array_push($subjects, $subject);
            }
            $ClassInfo->whereIn('tbl_class.category_id', $subjects);
        }
        if($minPrice!=''){
            $ClassInfo->where('tbl_class.price','>=', $minPrice);
        }
        if($maxPrice!=''){
            $ClassInfo->where('tbl_class.price','<=', $maxPrice);
        }
        if($rating!=''){
            $ClassInfo->having('ratings_average','>=', $rating);
        }
        if($keyterm!=''){
            $ClassInfo->where('tbl_class.name','LIKE','%'.$keyterm.'%')
            ->orWhere('tbl_class.description','LIKE','%'.$keyterm.'%');
        }
        $this->data+=array('lastPage'=>((int)(($ClassInfo->count()-1)/8)+1));
        $this->data+=array('ClassInfo'=>$ClassInfo->skip($class_get_start_at)
        ->take(8)
        ->get());
        $this->data+=array('RatingInfo'=>TblRating::select('tbl_rating.class_id',DB::raw('AVG(rating_star) as ratings_average'))
        ->groupBy('tbl_rating.class_id')
        ->get());
        if($userID!=''){
            $this->data+=array('FavStatusInfo'=>TblFavorite::select('tbl_favorite.*')
            ->where('tbl_favorite.user_id','=',$userID)
            ->get());
            $this->data+=array('CartStatusInfo'=>TblCart::select('tbl_cart.*')
            ->where('tbl_cart.user_id','=',$userID)
            ->get());
            $this->data+=array('ClassStudentInfo'=>TblClassStudent::join('tbl_class', 'tbl_class_student.class_id', '=', 'tbl_class.id')
            ->join('tbl_users', 'tbl_users.id', '=', 'tbl_class_student.user_id')
            ->select('tbl_class.id')
            ->where('tbl_class_student.user_id', '=', $userID)
            ->get());
        }
        $this->data+=array('page'=>$page);
        $this->data+=array('pageCount'=>$ClassInfo->count());
        $this->data+=array('searchSelection'=>$request->all());
        return view('searchPage', $this->data);
        
    }
    
}
