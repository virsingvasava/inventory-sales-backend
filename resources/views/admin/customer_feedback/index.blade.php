@extends('layouts.app_admin')

@section('title') 
    {{'index'}}
@endsection

@section('content')
<div class="main-content-part">
    <div class="main-content-padd">
    <div class="title-w-arrow">
        <h1>Customer Feedback</h1>
    </div>
    <div class="cus-feedback">
        <div class="row">
            <div class="col-md-12">
                <div class="progress-vote">
                <h3>Do you like our services?</h3>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">1111 Votes</div>
                   
                    <div class="progress-bar-right">1,44,040 Votes</div>
                </div>
                <div class="total-vote">Total: 5,00,000 Votes</div>
                </div>
                <div class="progress-vote">
                <h3>Do you like our products?</h3>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width:80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">3,55,960 Votes</div>
                    <div class="progress-bar-right">1,44,040 Votes</div>
                </div>
                <div class="total-vote">Total: 5,00,000 Votes</div>
                </div>
                <div class="progress-vote">
                <h3>Do you recommend us to your friend and family?</h3>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">3,55,960 Votes</div>
                    <div class="progress-bar-right">1,44,040 Votes</div>
                </div>
                <div class="total-vote">Total: 5,00,000 Votes</div>
                </div>
            </div>
        </div>
    </div>
    <div class="h30"></div>
    </div>
</div>
@endsection