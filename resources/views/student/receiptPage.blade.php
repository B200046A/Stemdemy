@include('header',['Title'=>"Payment Success"])
<span class="p-5"></span>
<div class="col-10 col-sm-6 mt-5 mx-auto pb-5 text-center">
    <div class="card">
        <h3 class="card-title py-3 bg-secondary text-white text-center">
            Receipt
        </h3>
        <div class="col-12 row">
            <div class="col-5 my-3 text-end">
                <label class="fs-5 me-3">Receipt No:</label>
            </div>
            <div class="col-7 my-3 text-center">
                <label class="fs-5 me-3">{{$ReceiptInfo->id}}</label>
            </div>
            <div class="col-5 my-3 text-end">
                <label class="fs-5 me-3">Payment Method:</label>
            </div>
            <div class="col-7 my-3 text-center">
                <label class="fs-5 me-3">
                @if($ReceiptInfo->payment_method==1)
                Credit card end with {{substr ($cardInfo->card_number, -4)}}
                @else
                Online banking
                @endif
                </label>
            </div>
            <div class="col-5 my-3 text-end">
                <label class="fs-5 me-3">Transaction Date:</label>
            </div>
            <div class="col-7 my-3 text-center">
                <label class="fs-5 me-3"><?php echo date('m/d/Y H:i:s', $ReceiptInfo->created_at);?></label>
            </div>
            <div class="col-5 my-3 text-end">
                <label class="fs-5 me-3">Product Description:</label>
            </div>
            <div class="col-7 my-3 text-center">
                <label class="fs-5 me-3">
                    @foreach($ReceiptItemsInfo as $item)
                    {{$item->class_name}}({{$item->category_name}}) - ${{$item->price}}
                    <br>
                    @endforeach
                </label>
            </div>
            <div class="col-11 border border-2 mt-5 mx-auto"></div>
            <div class="col-5 my-2 text-end">
                <label class="fs-5 me-3">Total Amount(RM):</label>
            </div>
            <div class="col-7 my-2 text-center">
                <label class="fs-5 me-3">${{$total}}</label>
            </div>
            <div class="col-5 my-3 text-end">
                <label class="fs-5 me-3">Discount :</label>
            </div>
            <div class="col-7 my-3 text-center">
            <label class="fs-5 me-3">
            @isset($promoInfo)
                @if($promoInfo->type==1)
                ${{$promoInfo->amount}}
                @elseif($promoInfo->type==2)
                {{$promoInfo->amount}}%
                @endif
            @else
            $0
            @endisset
            </label>
            </div>
            <div class="col-5 my-2 text-end">
                <label class="fs-5 me-3 fw-bold">Subtotal Amount(RM):</label>
            </div>
            <div class="col-7 mt-2 mb-5 text-center">
                <label class="fs-5 me-3 fw-bold">${{$subtotal}}</label>
            </div>
            <form action="{{route('receiptPDF')}}" method="post">
            @csrf
                <input style="display:none" name="user_id" value="{{$userInfo->id}}">
                @isset($promoInfo)
                <input style="display:none" name="promo" value="{{$promoInfo->id}}">
                @endisset
                <input style="display:none" name="receipt_id" value="{{$ReceiptInfo->id}}">
                {{-- <input style="display:none" name="user_id" value="{{$userInfo->id}}"> --}}
                <button type="submit" class="btn btn-primary fs-4 px-5 py-2 mb-5">Generate Receipt PDF</button>
            </form>
        </div>
    </div>
    <p class="mt-1"><a href="{{route('studentMain')}}" class="text-info fs-5">Back to Main Page</a></p>
</div>
@include('footer')