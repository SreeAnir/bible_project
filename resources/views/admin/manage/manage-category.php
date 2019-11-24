
@extends('layouts.admin.inner')
@section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header" data-background-color="orange">
                                <i class="material-icons">content_copy</i>
                            </div>
                            <div class="card-content">
                                <p class="category">Customers</p>
                                <h3 class="title">{{$data['attendence']}}</h3>
                            </div>
                             
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header" data-background-color="green">
                                <i class="material-icons">store</i>
                            </div>
                            <div class="card-content">
                                <p class="category">Vegetables</p>
                                <h3 class="title">{{$data['internals']}}</h3>
                            </div>
                             
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header" data-background-color="red">
                                <i class="material-icons">content_paste</i>
                            </div>
                            <div class="card-content">
                                <p class="category">Bookings</p>
                                <h3 class="title">{{$data['uploads']}}</h3>
                            </div>
                            {{--<div class="card-footer">--}}
                                {{--<div class="stats">--}}
                                    {{--<i class="material-icons">local_offer</i> Tracked from Github--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        </div>
                    </div>

                    {{--<div class="col-lg-3 col-md-6 col-sm-6">--}}
                        {{--<div class="card card-stats">--}}
                            {{--<div class="card-header" data-background-color="blue">--}}
                                {{--<i class="fa fa-twitter"></i>--}}
                            {{--</div>--}}
                            {{--<div class="card-content">--}}
                                {{--<p class="category">Followers</p>--}}
                                {{--<h3 class="title">+245</h3>--}}
                            {{--</div>--}}
                            {{--<div class="card-footer">--}}
                                {{--<div class="stats">--}}
                                    {{--<i class="material-icons">update</i> Just Updated--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>


            </div>
        </div>

       


@stop




