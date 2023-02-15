@extends('layouts.app_admin')

@section('title')
{{ 'index' }}
@endsection

@section('content')
<div class="main-content-part">
    <div class="main-content-padd">
        <div class="title-w-arrow">
            <h1 class="mr20">Kiosk</h1>

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
                        <h3>Kiosk List</h3>
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
                                        <th>Kiosk_id</th>
                                        <th>Kios Name</th>
                                        <th>Location</th>
                                        <th>City</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php $i =1; ?>
                                        @foreach ($kiosk as $key => $value)  
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$value->kiosk_id}}</td>
                                        <td>{{$value->kiosk_name}}</td>
                                        <td>{{$value->outlet_location_name}}</td>
                                        <td>{{$value->city_name}}</td>
                                        <td><a href="{{ route('admin.dashboard.kiosk_qty',$value->id)}}"><img src="{{ asset('theme/images/view.png') }}" /></a></td>
                                    </tr>
                                    <?php $i++; ?>
                                       
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