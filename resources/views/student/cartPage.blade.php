@include('header',['Title'=>"Cart Page"])
<script src="https://raw.githubusercontent.com/stripe-archive/jquery.payment/master/lib/jquery.payment.js"></script>
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-8 col-12">
            <label class="offset-1 mb-3 fs-3" onselectstart="return false">Your Cart</label>
            <div class="offset-2 col-10 border mx-auto"></div>
            <div class="row">
                <label class="offset-1 col-7 ps-4 my-3">Item</label>
                <label class="col-1 my-3">Price</label>
            </div>
            <div class="offset-2 col-10 border mb-2 mx-auto"></div>
            @php
            $sum=0;
            @endphp
            @foreach($CartInfo as $cart)
            <div class="row">
                <div class="offset-1 col-7 ps-4 my-2 cart_to_class" onclick="window.location='{{route('ClassPage',['id'=>$cart->class_id])}}'" class="btn btn-outline-danger col-2 my-auto ms-5">
                    <img src="{{ url('storage/classThumbnail/'.$cart->class_thumbnail) }}" onerror="this.onerror=null; this.src='{{url('storage/classThumbnail/image-not-found.png')}}'" class="img-thumbnail col-4 my-auto" style="width:128px;height:128px;" alt="...">
                    <label class="col-6 ps-4 my-auto">{{$cart->class_name}}</label>
                </div>
                <label class="col-1 my-auto">$<span class="cartItem">{{$cart->price}}</span></label>
                <button type="button" onclick="window.location='{{route('addCart',['classId'=>$cart->class_id,'userId'=>$cart->user_id,'type'=>'2'])}}'" class="btn btn-outline-danger col-2 my-auto ms-5" style="width:50px;height:50px;">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
            @php
            $sum+=$cart->price;
            @endphp
            @endforeach
            <div class="offset-2 col-10 border my-3 mx-auto"></div>
            <h4 class="offset-7 my-auto">Total: <label class="ms-2">${{$sum}}</label></h4>
            <div class="offset-2 col-10 border my-3 mx-auto"></div>
        </div>
        <div class="col-sm-4 col-12">
            <div class="card p-3">
                <h3 class="card-title ms-2">Summary</h3>
                <div class="my-4 row gx-1">
                    <form class="row" id="promoForm" action="{{route('matchPromoCode')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-floating col-8">
                            <input type="text" class="form-control" name="promoInput" placeholder="name@example.com" style="text-transform:uppercase">
                            <label class="ps-4 text-muted" for="floatingInput">Promo Code</label>
                        </div>
                        <button type="submit" class="col-4 btn btn-outline-danger m-auto" style="width:25%;" id="btn-apply-promo">
                            Apply
                        </button>
                    </form>
                    <span class="col-12 text-center my-3" id="msgPromo"></span>
                    <div class="col-12 border mb-3 mx-auto"></div>
                    <span class="col-8 fs-5 ps-4 my-auto">Total:</span><span class="col fs-5 m-auto" id="cart-total">${{$sum}}</span>
                    <span class="col-8 fs-5 ps-4 my-auto">Discount:</span><span class="col fs-5 m-auto" id="cart-discount">$0</span>
                    <h3 class="col-8 ps-3 my-auto">Subtotal:</h3><h3 class="col m-auto" id="cart-subtotal">${{$sum}}</h3>
                    <div class="col-12 border mt-3 mx-auto"></div>
                </div>
                <form id="checkoutForm" action="" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="mb-3 col-12 text-center" onselectstart="return false">
                        <span id="msgMethod" style="color:#c5060c;"></span>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payMethodRadio" id="payMethodRadio" value="option1" checked>
                        <label class="form-check-label" for="cdcard">
                            Credit/Debit Card
                        </label>
                    </div>
                    <div class="card my-3 p-3">
                        <div class="form-floating mb-2">
                            <select class="form-select" id="cardSelection" aria-label="Floating label select example">
                                <option value="0" selected>New Card</option>
                                @foreach($CardInfo as $existing_card)
                                <option value="{{$loop->index+1}}">{{$existing_card->name_on_card}}: Credit card end with {{substr ($existing_card->card_number, -4)}}</option>
                                @endforeach
                            </select>
                            <label for="floatingSelect">Card</label>
                        </div>
                        <div class="form-floating mb-2 col-12">
                            <input type="text" class="form-control" name="card_on_name" id="card_on_name">
                            <label class="ps-4 text-muted" for="card">Card on name</label>
                        </div>
                        <div class="form-floating mb-2 col-12">
                            <input type="text" class="form-control" name="cardNo" id="cardNo" maxlength="24" onkeypress="return isNumberKey(event);">
                            <label class="ps-4 text-muted" for="floatingInput">Card number</label>
                        </div>
                        <div class="row">
                            <div class="form-floating mb-2 col-4">
                                <input type="text" class="form-control" name="mm" id="mm" maxlength="2" onkeypress="return isNumberKey(event);">
                                <label class="ps-4 text-muted" for="floatingInput">MM</label>
                            </div>
                            <div class="form-floating mb-2 col-4">
                                <input type="text" class="form-control" name="yy" id="yy" maxlength="2" onkeypress="return isNumberKey(event);">
                                <label class="ps-4 text-muted" for="floatingInput">YY</label>
                            </div>
                            <div class="form-floating mb-2 col-4">
                                <input type="text" class="form-control" name="cvc" id="cvc" maxlength="3" onkeypress="return isNumberKey(event);">
                                <label class="ps-4 text-muted" for="floatingInput">CVC</label>
                            </div>
                        </div>
                        <div class="col-12 mt-2 form-check">
                            <input class="form-check-input" type="checkbox" id="saveCard" name="saveCard" value="yes" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Save card information
                            </label>
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payMethodRadio" id="payMethodRadio" value="option2">
                        <label class="form-check-label" for="onlineBank">
                            Online Banking
                        </label>
                    </div>
                    <input style="display:none" name="card_id" value="new">
                    <input style="display:none" name="dataPromo" value="false">
                    <input style="display:none" name="user_id" value="{{$LoggedUserInfo->id}}">
                    <div class="col-12 border my-4 mx-auto"></div>
                    <button type="submit" id="btnCheckout" class="col-12 mb-3 btn btn-primary m-auto">
                        Checkout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var subtotal=({{$sum}});
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode
        return !(charCode > 31 && (charCode < 48 || charCode > 57));
    }

    document.querySelector('#cardNo').addEventListener('keydown', cardNoF, false);
    document.querySelector('#cardNo').addEventListener('keyup', cardNoF, false);
    document.querySelector('#cardNo').addEventListener('keypress', cardNoF, false);

    function cardNoF(e){
        e.target.value = e.target.value.replace(/(\d{4})(\d+)/g, '$1 $2')
    }

    document.querySelector('#mm').oninput = function () {
        if (this.value > 12) {
            this.value = 12;
        }else if(this.value < 1 && this.value.length>1) {
            this.value = '01';
        }
    }
    $('input[type=radio][name=payMethodRadio]').change(function() {
        if(this.value=="option1"){
            radioSet(false);
        }else if(this.value=="option2"){
            radioSet(true);
        }
    });

    function radioSet(type){
        document.getElementById('cardSelection').disabled = type;
        document.getElementById('card_on_name').disabled = type;
        document.getElementById('cardNo').disabled = type;
        document.getElementById('mm').disabled = type;
        document.getElementById('yy').disabled = type;
        document.getElementById('cvc').disabled = type;
        if(document.getElementById('cardSelection').value==0){
            document.getElementById('saveCard').disabled = type;
        }
    }

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function(){
        $('#promoForm').on('submit', function(e){
            e.preventDefault();
            if($('#btn-apply-promo').text().trim()=="Apply"){
                var form = this;
                $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:new FormData(form),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    success:function(response){
                        $('#msgPromo').text(response['message']);
                        $("[name='dataPromo']").val(response['data']);
                        if(response['data']=='false'){
                            $('#msgPromo').css('color','#c5060c');
                            $('#cart-discount').text('$0');
                            $('#btn-apply-promo').text('Apply');
                            $('#btn-apply-promo').removeClass("btn-danger");
                            $('#btn-apply-promo').addClass("btn-outline-danger");
                            $("[name='promoInput']").val('');
                            $("[name='promoInput']").prop("disabled", false);
                            $('#cart-subtotal').text("$"+{{$sum}});
                            subtotal=({{$sum}});
                        }else{
                            $('#msgPromo').css('color','#34e70c');
                            subtotal=({{$sum}});
                            if((response['type'])==1){
                                subtotal-=(response['amount']);
                                $('#cart-discount').text('$'+response['amount']);
                            }else{
                                subtotal-=({{$sum}}*(response['amount'])/100);
                                $('#cart-discount').text('-'+response['amount']+'%');
                            }
                            $('#cart-subtotal').text('$'+subtotal);
                            $('#btn-apply-promo').text('Undo');
                            $('#btn-apply-promo').removeClass("btn-outline-danger");
                            $('#btn-apply-promo').addClass("btn-danger");
                            $("[name='promoInput']").prop("disabled", true);
                        }
                    }
                });
            }else if($('#btn-apply-promo').text().trim()=="Undo"){
                $('#msgPromo').text('');
                $("[name='dataPromo']").val('false');
                $('#cart-discount').text('$0');
                $('#btn-apply-promo').text('Apply');
                $('#btn-apply-promo').removeClass("btn-danger");
                $('#btn-apply-promo').addClass("btn-outline-danger");
                $("[name='promoInput']").val('');
                $("[name='promoInput']").prop("disabled", false);
                $('#cart-subtotal').text("$"+{{$sum}});
                subtotal=({{$sum}});
            }
            
        });
    });

    $('#btnCheckout').on('click', function(){
        $('#msgMethod').text('');
        var checkout_promoInput;
        if($("[name='dataPromo']").val()=="false"){
            checkout_promoInput = '!';
        }else{
            checkout_promoInput = $("[name='dataPromo']").val();
        }
        var checkout_total = '<?php echo $sum; ?>';
        if($('input[type=radio][name=payMethodRadio]:checked').val()=="option1"){
            if($('#card_on_name').val()==''
            ||$('#cardNo').val()==''
            ||$('#mm').val()==''
            ||$('#yy').val()==''
            ||$('#cvc').val()==''
            ||$('#cvc').val().length!=3){
                $('#msgMethod').text('The card information is not completed!');
                return false;
            }
            $('#checkoutForm').attr('action', '/checkout/'+checkout_promoInput+'/'+checkout_total+'/'+subtotal);
            return true;
        }else if($('input[type=radio][name=payMethodRadio]:checked').val()=="option2"){
            $('#checkoutForm').attr('action', '/checkout/'+checkout_promoInput+'/'+checkout_total+'/'+subtotal);
            return true;
        }
        return false;
    });

    $('#cardSelection').on('change', function() {
        if(this.value==0){
            $('#card_on_name').val('');
            $('#cardNo').val('');
            $('#mm').val('');
            $('#yy').val('');
            $('#cvc').val('');
            $("[name='card_id']").val('new');
            $('#card_on_name').prop( "disabled", false);
            $('#cardNo').prop( "disabled", false);
            $('#mm').prop( "disabled", false);
            $('#yy').prop( "disabled", false);
            $('#cvc').prop( "disabled", false);
            $('#saveCard').prop( "disabled", false);
        }else{
            $('#card_on_name').val(<?php echo json_encode($CardInfo) ?>[this.value-1]['name_on_card']);
            $('#cardNo').val(<?php echo json_encode($CardInfo) ?>[this.value-1]['card_number']);
            $('#mm').val(<?php echo json_encode($CardInfo) ?>[this.value-1]['mm']);
            $('#yy').val(<?php echo json_encode($CardInfo) ?>[this.value-1]['yy']);
            $('#cvc').val(<?php echo json_encode($CardInfo) ?>[this.value-1]['cvc']);
            $('#saveCard').prop('checked', false);
            $("[name='card_id']").val(<?php echo json_encode($CardInfo) ?>[this.value-1]['id']);
            $('#card_on_name').prop( "disabled", true);
            $('#cardNo').prop( "disabled", true);
            $('#mm').prop( "disabled", true);
            $('#yy').prop( "disabled", true);
            $('#cvc').prop( "disabled", true);
            $('#saveCard').prop( "disabled", true);
        }
    });

</script>
@include('footer')