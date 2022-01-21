<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TblUsers;
use App\Models\TblClass;
use App\Models\TblClassStudent;
use App\Models\TblCategory;
use App\Models\TblRating;
use App\Models\TblFavorite;
use App\Models\TblCart;
use App\Models\TblPromo;
use App\Models\TblCardInformation;
use App\Models\TblReceipt;
use App\Models\TblReceiptItems;
use Illuminate\Support\Facades\DB;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use Carbon\Carbon;


class StudentController extends Controller
{
    private $data = array();

    function __construct(){
        $this->middleware(function ($request, $next){
            $this->data+=array('LoggedUserInfo'=>TblUsers::where('id','=', session('LoggedUser'))->first());
            $this->data+=array('StudentCartInfo'=>TblCart::join('tbl_class','tbl_class.id','=','tbl_cart.class_id')
            ->select('tbl_cart.*','tbl_class.name')
            ->where('tbl_cart.user_id','=', session('LoggedUser'))
            ->get());
            if($this->data['LoggedUserInfo']->userType!='Student'){
                return back();
            }
            return $next($request);
        });
    }

    function studentMain(){
        $this->data+=array('CategoryInfo'=>TblCategory::all());
        $this->data+=array('JoinedClassInfo'=>TblClassStudent::join('tbl_class', 'tbl_class_student.class_id', '=', 'tbl_class.id')
        ->join('tbl_category', 'tbl_category.id', '=', 'tbl_class.category_id')
        ->select('tbl_class.id as class_id', 'tbl_class.name as class_name', 'tbl_category.name as category_name','tbl_class.price', 'tbl_class.updated_at as class_update','tbl_class.pic_path as class_thumbnail')
        ->where('tbl_class_student.user_id', '=', session('LoggedUser'))
        ->groupBy('tbl_class.id')
        ->orderBy('tbl_class.created_at','DESC')
        ->skip(0)
        ->take(8)
        ->get());
        $this->data+=array('RatingInfo'=>TblRating::select('tbl_rating.class_id',DB::raw('AVG(rating_star) as ratings_average'))
        ->groupBy('tbl_rating.class_id')
        ->get());
        $userID=$this->data['LoggedUserInfo']->id;
        $this->data+=array('FavStatusInfo'=>TblFavorite::select('tbl_favorite.*')
        ->where('tbl_favorite.user_id','=',$userID)
        ->get());
        $this->data+=array('CartStatusInfo'=>TblCart::select('tbl_cart.*')
        ->where('tbl_cart.user_id','=',$userID)
        ->get());
        $this->data+=array('PopularClassInfo'=>TblRating::join('tbl_class','tbl_class.id','=','tbl_rating.class_id')
        ->join('tbl_category', 'tbl_category.id', '=', 'tbl_class.category_id')
        ->select('tbl_class.id as class_id', 'tbl_class.name as class_name', 'tbl_category.name as category_name','tbl_class.price', 'tbl_class.updated_at as class_update','tbl_class.pic_path as class_thumbnail',DB::raw('AVG(rating_star) as ratings_average'))
        ->groupBy('tbl_rating.class_id')
        ->orderBy('ratings_average','DESC')
        ->skip(0)
        ->take(8)
        ->get());
        $this->data+=array('JoinedClassNum'=>TblClassStudent::join('tbl_class', 'tbl_class_student.class_id', '=', 'tbl_class.id')
        ->select('tbl_class_student.*')
        ->where('tbl_class_student.user_id', '=', $userID)
        ->orderBy('tbl_class.created_at')
        ->count());
        $this->data+=array('ClassStudentInfo'=>TblClassStudent::join('tbl_class', 'tbl_class_student.class_id', '=', 'tbl_class.id')
        ->join('tbl_users', 'tbl_users.id', '=', 'tbl_class_student.user_id')
        ->select('tbl_class.id')
        ->where('tbl_class_student.user_id', '=', $userID)
        ->get());
        return view('student.mainPage', $this->data);
    }

    function favoritePage($Type){
        $this->data+=array('RatingInfo'=>TblRating::select('tbl_rating.class_id',DB::raw('AVG(rating_star) as ratings_average'))
        ->groupBy('tbl_rating.class_id')
        ->get());
        if($Type=="myClass"){
            $this->data+=array('JoinedClassInfo'=>TblClassStudent::join('tbl_class', 'tbl_class_student.class_id', '=', 'tbl_class.id')
            ->join('tbl_category', 'tbl_category.id', '=', 'tbl_class.category_id')
            ->select('tbl_class.id as class_id', 'tbl_class.name as class_name', 'tbl_category.name as category_name','tbl_class.price', 'tbl_class.updated_at as class_update','tbl_class.pic_path as class_thumbnail')
            ->where('tbl_class_student.user_id', '=', $this->data['LoggedUserInfo']->id)
            ->groupBy('tbl_class.id')
            ->orderBy('tbl_class.created_at','DESC')
            ->get());
            $this->data+=array('Title'=> "My Class");
        }else{
            $this->data+=array('ClassStudentInfo'=>TblClassStudent::join('tbl_class', 'tbl_class_student.class_id', '=', 'tbl_class.id')
            ->join('tbl_users', 'tbl_users.id', '=', 'tbl_class_student.user_id')
            ->select('tbl_class.id')
            ->where('tbl_class_student.user_id', '=', $this->data['LoggedUserInfo']->id)
            ->get());
            $this->data+=array('FavClassInfo'=>TblFavorite::join('tbl_class','tbl_class.id','=','tbl_favorite.class_id')
            ->join('tbl_category', 'tbl_category.id', '=', 'tbl_class.category_id')
            ->select('tbl_class.id as class_id', 'tbl_class.name as class_name', 'tbl_category.name as category_name','tbl_class.price', 'tbl_class.updated_at as class_update','tbl_class.pic_path as class_thumbnail')
            ->where('tbl_favorite.user_id', '=', $this->data['LoggedUserInfo']->id)
            ->groupBy('tbl_favorite.class_id')
            ->orderBy('tbl_class.created_at','DESC')
            ->get());
            $this->data+=array('Title'=> "My Favorite");
        }
        return view('student.favoritePage', $this->data);
    }

    function addRating(Request $request){
        $request -> validate([
            'star'=>'required',
            'txtreview'=>'required'
        ]);
        $tbl_rating = new TblRating;
        $tbl_rating->review = $request->input('txtreview');
        $tbl_rating->class_id = $request->input('class_id');
        $tbl_rating->user_id = $request->input('user_id');
        $tbl_rating->rating_star = $request->input('star');
        $save = $tbl_rating->save();
        if($save){
            return back()->with('status','Your review have been created successfully!');
        }else{
            return back()->with('danger','Something went wrong. Please retry again later.');
        }
    }

    function addCart($classId,$userId,$type){
        if($type=='1'){
            $tbl_cart = new TblCart;
            $tbl_cart->user_id = $userId;
            $tbl_cart->class_id = $classId;
            $save = $tbl_cart->save();
            if($save){
                return back()->with('status','The class has been added to Cart List!');
            }else{
                return back()->with('danger','Something went wrong. Please retry again later.');
            }
        }else if($type=='2'){
            $tbl_cart = TblCart::where('class_id', '=', $classId)
            ->where('user_id', '=', $userId)
            ->delete();
            if(!$tbl_cart){
                return redirect()->back()->with('danger','Something went wrong. Please retry again later.');
            }else{
                return back()->with('status','The class has been removed from Cart List!');
            }
        }
    }

    function addFav($classId,$userId,$type){
        if($type=='1'){
            $tbl_fav = new TblFavorite;
            $tbl_fav->user_id = $userId;
            $tbl_fav->class_id = $classId;
            $save = $tbl_fav->save();
            if($save){
                return back()->with('status','The class has been added to Favorite List!');
            }else{
                return back()->with('danger','Something went wrong. Please retry again later.');
            }
        }else if($type=='2'){
            $tbl_fav = TblFavorite::where('class_id', '=', $classId)
            ->where('user_id', '=', $userId)
            ->delete();
            if(!$tbl_fav){
                return redirect()->back()->with('danger','Something went wrong. Please retry again later.');
            }else{
                return back()->with('status','The class has been removed from Favorite List!');
            }
        }
    }

    function cartPage(){
        $this->data+=array('CartInfo'=>TblCart::join('tbl_class', 'tbl_class.id', '=', 'tbl_cart.class_id')
        ->join('tbl_category', 'tbl_category.id', '=', 'tbl_class.category_id')
        ->select('tbl_cart.class_id as class_id', 'tbl_cart.user_id as user_id', 'tbl_class.name as class_name', 'tbl_category.name as category_name', 'tbl_class.description as class_info','tbl_class.price', 'tbl_class.pic_path as class_thumbnail')
        ->where('tbl_cart.user_id', '=', $this->data['LoggedUserInfo']->id)
        ->orderBy('tbl_cart.created_at','ASC')
        ->get());
        $this->data+=array('PromoInfo'=>TblPromo::all());
        $this->data+=array('CardInfo'=>TblCardInformation::select('tbl_card_information.*')
        ->where('tbl_card_information.user_id', '=', $this->data['LoggedUserInfo']->id)
        ->where('tbl_card_information.save', '=', 1)
        ->get());
        return view('student.cartPage', $this->data);
    }

    function matchPromoCode(Request $request){
        $promoInfo = TblPromo::where('code','=', $request->promoInput)->first();
        if(!$promoInfo){
            return response()->json(['message' => 'This promo code does not exist.','data'=>'false']);
        }else{
            if(time()>($promoInfo->expired_at)){
                return response()->json(['message' => 'The promo code is expired.','data'=>'false']);
            }else{
                return response()->json(['message' => $promoInfo->description,
                                        'data'=>$promoInfo->id,
                                        'type'=>$promoInfo->type,
                                        'amount'=>$promoInfo->amount
                                    ]);
            }
        }
    }

    function generateReceipt(Request $request,$promo,$total,$subtotal){
        $cartInfo = TblCart::join('tbl_class', 'tbl_class.id', '=', 'tbl_cart.class_id')
        ->join('tbl_category', 'tbl_category.id', '=', 'tbl_class.category_id')
        ->select('tbl_class.id', 'tbl_class.name as class_name', 'tbl_category.name as category_name', 'tbl_class.description as class_info','tbl_class.price')
        ->where('tbl_cart.user_id', '=', $request->user_id)
        ->orderBy('tbl_cart.created_at','ASC')
        ->get();
        $ReceiptInfo = new TblReceipt;
        $ReceiptInfo->user_id = $request->user_id;
        if($promo!="!"){
            $ReceiptInfo->promo_id = $promo;
        }
        if($request->payMethodRadio=='option1'){
            $ReceiptInfo->payment_method = 1;
            if($request->card_id=='new'){
                $new_card = new TblCardInformation;
                $new_card->user_id = $request->user_id;
                $new_card->name_on_card = $request->card_on_name;
                $new_card->card_number = $request->cardNo;
                $new_card->mm = $request->mm;
                $new_card->yy = $request->yy;
                $new_card->cvc = $request->cvc;
                if($request->saveCard!=''){
                    $new_card->save=1;
                }else{
                    $new_card->save=2;
                }
                $new_card->save();
                $ReceiptInfo->card_information_id = $new_card->id;
            }else{
                $existing_card = TblCardInformation::where('id','=', $request->card_id)->first();
                $ReceiptInfo->card_information_id = $existing_card->id;
            }
        }else if($request->payMethodRadio=='option2'){
            $ReceiptInfo->payment_method = 2;
        }
        $ReceiptInfo->save();
        $index=0;
        foreach($cartInfo as $item){
            $new_item = new TblReceiptItems;
            $new_item->receipt_id=$ReceiptInfo->id;
            $new_item->class_id=$item->id;
            $new_item->item_order=$index;
            $new_item->save();
            $index+=1;
        }
        $tbl_cart = TblCart::where('user_id', '=', $request->user_id)->delete();
        // $this->data+=array('ReceiptInfo'=>TblReceipt::where('id','=', $ReceiptInfo->id)->first());
        // $this->data+=array('userInfo'=>$userInfo);
        // $this->data+=array('cartInfo'=>$cartInfo);
        // $this->data+=array('subtotal'=>$subtotal);
        // $this->data+=array('total'=>$total);
        // $this->data+=array('promo'=>$promo);
        return redirect()->route('receiptPage',['user_id' => $ReceiptInfo->user_id,
         'promo_id' => $ReceiptInfo->promo_id,
         'card_id' => $ReceiptInfo->card_information_id,
         'receipt_id' => $ReceiptInfo->id,
         'subtotal' => $subtotal,
         'total' => $total]);
    }

    function receiptPage(){
        $user_id=request()->user_id;
        $promo_id='!';
        if(request()->promo_id!=''){
            $promo_id=request()->promo_id;
        }
        $card_id=request()->card_id;
        $receipt_id=request()->receipt_id;
        $this->data+=array('userInfo'=>TblUsers::where('id','=', $user_id)->first());
        $this->data+=array('ReceiptInfo'=>TblReceipt::where('id','=', $receipt_id)->first());
        $this->data+=array('ReceiptItemsInfo'=>TblReceiptItems::join('tbl_class', 'tbl_class.id', '=', 'tbl_receipt_items.class_id')
        ->join('tbl_category', 'tbl_category.id', '=', 'tbl_class.category_id')
        ->select('tbl_class.id', 'tbl_class.name as class_name', 'tbl_category.name as category_name', 'tbl_class.description as class_info','tbl_class.price')
        ->where('tbl_receipt_items.receipt_id', '=', $receipt_id)
        ->orderBy('tbl_receipt_items.item_order','ASC')
        ->get());
        if($promo_id!="!"){
            $this->data+=array('promoInfo'=>TblPromo::where('id','=', $promo_id)->first());
        }
        if($this->data['ReceiptInfo']->payment_method==1){
            $this->data+=array("cardInfo"=>TblCardInformation::where('id','=', $card_id)->first());
        }
        $this->data+=array('subtotal'=>request()->subtotal);
        $this->data+=array('total'=>request()->total);
        return view('student.receiptPage',$this->data);
    }

    function receiptPDF(Request $request){
        $userInfo = TblUsers::where('id','=', $request->user_id)->first();
        $receiptItemsInfo = TblReceiptItems::join('tbl_class', 'tbl_class.id', '=', 'tbl_receipt_items.class_id')
        ->join('tbl_category', 'tbl_category.id', '=', 'tbl_class.category_id')
        ->select('tbl_class.name as class_name', 'tbl_category.name as category_name','tbl_class.price')
        ->where('tbl_receipt_items.receipt_id', '=', $request->receipt_id)
        ->orderBy('tbl_receipt_items.item_order','ASC')
        ->get();
        
        $company = new Party([
            'name'          => 'Stemdemy',
            'phone'         => '+ 01 234 567 88',
            'custom_fields' => [
                // 'note'        => 'IDDQD',
                // 'business id' => '365#GG',
            ],
        ]);

        $customer = new Buyer([
            'name'          => $userInfo->username,
            'custom_fields' => [
                'email' => $userInfo->email,
                'contact' => $userInfo->contact_number,
            ],
        ]);

        $invoice = Invoice::make()
        ->sequence(123)
        ->buyer($customer)
        ->seller($company)
        ->date(now())
        ->payUntilDays(0)
        ->currencyFormat('{SYMBOL}{VALUE}');
        
        foreach($receiptItemsInfo as $item){
            $invoice->addItem((new InvoiceItem())
                ->title($item->class_name.' ('.$item->category_name.')')
                ->pricePerUnit($item->price));
        }

        if($request->promo!='!'){
            $promoInfo = TblPromo::where('id','=', $request->promo)->first();
            if(($promoInfo->type)==1){
                $invoice->totalDiscount($promoInfo->amount);
            }else if(($promoInfo->type)==2){
                $invoice->discountByPercent($promoInfo->amount);
            }
        }

        return $invoice->download();
    }

}
