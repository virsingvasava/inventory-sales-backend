<div class="card-block sbquarter">
    <ul>
        <li class="qa">Cash</li>
        <li class="qb">Card</li>
        <li class="qd">Upi</li>
    </ul>
    <div class="quarter-box">
        <dl class="qt-bg">
            <span class="qa"></span>
        </dl>
        <dl class="qt-text">Cash</dl>
        <dl class="qt-money">₹ {{$order_payment_modeArr['cash']}}</dl>
        <dl class="qt-updown"><span class="budge">{{$payment_modeArr['cash_per']}}%</span></dl>
    </div>
    <div class="quarter-box">
        <dl class="qt-bg">
            <span class="qb"></span>
        </dl>
        <dl class="qt-text">Card</dl>
        <dl class="qt-money">₹ {{$order_payment_modeArr['card']}}</dl>
        <dl class="qt-updown"><span class="budge">{{$payment_modeArr['card_per']}}%</span></dl>
    </div>
    <div class="quarter-box">
        <dl class="qt-bg">
            <span class="qd"></span>
        </dl>
        <dl class="qt-text">Upi</dl>
        <dl class="qt-money">₹ {{$order_payment_modeArr['upi']}}</dl>
        <dl class="qt-updown"><span class="budge">{{$payment_modeArr['upi_per']}}%</span></dl>
    </div>
</div>