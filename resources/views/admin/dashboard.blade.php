
@extends('layouts.admin.inner')
@section('content')


        <nav class="navbar navbar-transparent navbar-absolute">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

            </div>
        </nav>

        <div class="content">
            <h3></h3>
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
                            
                        </div>
                    </div>
 
                </div>


            </div>
        </div>

       


@stop




