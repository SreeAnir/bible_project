
@extends('layouts.admin.inner')
@section('content')
<div class="row">
<h3 class="title">Dashboard </h3>
</div>
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
                                <i class="large  material-icons">account_box</i>
                            </div>
                            <div class="card-content">
                                <p class="category">Users</p>
                                <h3 class="title">{{$data['user_count']}}</h3>
                            </div>
                             
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header" data-background-color="red">
                                <i class="large  material-icons">assignment</i>
                            </div>
                            <div class="card-content">
                                <p class="category">Categories</p>
                                <h3 class="title">{{$data['category_count']}}</h3>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header" data-background-color="green">
                                <i class="large material-icons">store</i>
                            </div>
                            <div class="card-content">
                                <p class="category">Prayers</p>
                                <h3 class="title">{{$data['prayer_count']}}</h3>
                            </div>
                             
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header" data-background-color="red">
                                <i class="large material-icons">content_paste</i>
                            </div>
                            <div class="card-content">
                                <p class="category">Bible Date</p>
                                <h3 class="title">{{$data['date_count']}}</h3>
                            </div>
                            
                        </div>
                    </div>
 
                </div>


            </div>

                
               <div class="card card-nav-tabs">
  <div class="card-header card-header-success">
    Welcome
  </div>
  <div class="card-body">
    <blockquote class="blockquote mb-0">
      <p>This is a Dummy Page.Please add your Data.</p>
      <footer class="blockquote-footer"> <cite title="Source Title">Developer</cite></footer>
    </blockquote>
  </div>
</div>

       


@stop




