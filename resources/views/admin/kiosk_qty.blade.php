@extends('layouts.app_admin')

@section('title')
{{ 'index' }}
@endsection

@section('content')
<div class="main-content-part">
    <div class="main-content-padd">
        <div class="title-w-arrow">
            <h1 class="mr20">Quantity</h1>

        </div>
        <div class="city-sec">
            <div class="row">
                <div class="col-md-12" style="display:none">

                </div>
            </div>
        </div>

        <div class="common-table-sec">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-header">
                        <h3>Quantity List</h3>
                        <div class="droup-right" style="display:none">
                            <div class="droupdown-select">

                            </div>
                        </div>
                    </div>
                    <div class="table-border-style">
                        <div class="table-responsive">
                            <table class="table" id="kiosk_table">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>product</th>
                                        <th>Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php $i =1; ?>
                                        @foreach ($qty as $key => $value)  
                                        @if($value->qty < 20)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$value->name}}</td>
                                        <td>{{$value->qty}}</td>
                                    </tr>
                                    <?php $i++; ?>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection