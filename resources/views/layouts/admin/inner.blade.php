<!doctype html>
<html lang="en">

<!-- Mirrored from demos.creative-tim.com/material-dashboard/examples/table.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 06 May 2017 11:10:31 GMT -->
<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Material Dashboard by Creative Tim | Free Material Bootstrap Admin</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS     -->
    <link href="{{asset('material-dashboard/assets/css/bootstrap.min.css')}}" rel="stylesheet" />

    <!--  Material Dashboard CSS    -->
    <link href="{{asset('material-dashboard/assets/css/material-dashboard.css')}}" rel="stylesheet"/>
    <link href="{{asset('css/web.css')}}" rel="stylesheet"/>

    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="{{asset('material-dashboard/assets/css/demo.css')}}" rel="stylesheet" />

    <script src="{{asset('material-dashboard/assets/js/jquery-3.1.0.min.js')}}" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <link href="{{asset('css/theme.dataTables.min.css')}}" rel="stylesheet">

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>

    <!--     Fonts and icons     -->
    <link href="{{asset('material-dashboard/maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>

    @yield('css')
</head>

<body>

<div class="wrapper">
    <div class="sidebar" data-color="purple" data-image="../assets/img/sidebar-1.jpg">
        <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"
        Tip 2: you can also add an image using data-image tag

        -->

        <div class="logo">
            <span href="#" class="simple-text">
                BIBLE ADMIN
            </span>

            <div style="text-align: center">
                <a href="/admin/logout" >
                    <i class="material-icons">lock</i>
                    <span style="color:#9c27b0">logout</span>
                </a>
            </div>

        </div>




        <div class="sidebar-wrapper">
            <ul class="nav">


                <li @if(request()->segment(2)=="dashboard")class="active" @endif>
                    <a href="/admin/dashboard">
                        <i class="material-icons">dashboard</i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li @if(request()->segment(2)=="manage-category")class="active" @endif>
                    <a href="/admin/manage-category">
                        <i class="material-icons">person</i>
                        <p>Manage Category</p>
                    </a>
                </li>
                
                <li @if(request()->segment(2)=="manage-prayer")class="active" @endif>
                    <a href="/admin/manage-prayer">
                        <i class="material-icons">person</i>
                        <p>Manage Prayer</p>
                    </a>
                </li>
                <li @if(request()->segment(2)=="manage-dates")class="active" @endif>
                    <a href="/admin/manage-dates">
                        <i class="material-icons">person</i>
                        <p>Manage Dates</p>
                    </a>
                </li>
                <li @if(request()->segment(2)=="manage-users")class="active" @endif>
                                    <a href="/admin/manage-users">
                                        <i class="material-icons">person</i>
                                        <p>Manage Users</p>
                                    </a>
                                </li>
                </ul>
        </div>
    </div>
<!-- content -->
    <div class="main-panel">
        <div class="alertBox">
            @if (session('validation'))
                <div class="alert alert-danger">
                    <?php $data = \Session::get('validation');  ?>

                    @foreach($data->getMessages() as $this_error)
                        <p> <strong> {{$this_error[0]}} </strong></p>
                    @endforeach
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    <p>  <strong>  {{ session('success') }} </strong></p>

                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    <p>  <strong>  {{ session('error') }} </strong></p>

                </div>
            @endif
        </div>
 
        @yield('content')
    </div>
<!-- <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>
                        <li>
                            <a href="#">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Company
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Portfolio
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Blog
                            </a>
                        </li>
                    </ul>
                </nav>
                <p class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script> <a href="http://www.creative-tim.com/">Creative Tim</a>, made with love for a better web
                </p>
            </div>
        </footer> -->
</div>
<!-- Eof content -->
<!-- <div class="fixed-plugin">
    <div class="dropdown">
        <a href="#" data-toggle="dropdown">
            <i class="fa fa-cog fa-2x"> </i>
        </a>
        <ul class="dropdown-menu">
            <li class="header-title"> Sidebar Filters</li>
            <li class="adjustments-line">
                <a href="javascript:void(0)" class="switch-trigger">
                    <div class="text-center">
                        <span class="badge filter badge-purple active" data-color="purple"></span>
                        <span class="badge filter badge-blue" data-color="blue"></span>
                        <span class="badge filter badge-green" data-color="green"></span>
                        <span class="badge filter badge-orange" data-color="orange"></span>
                        <span class="badge filter badge-red" data-color="red"></span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li class="header-title">Images</li>
            <li class="active">
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                    <img src="{{asset('material-dashboard/assets/img/sidebar-1.jpg')}}">
                </a>
            </li>
            <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                    <img src="{{asset('material-dashboard/assets/img/sidebar-2.jpg')}}">
                </a>
            </li>
            <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                    <img src="{{asset('material-dashboard/assets/img/sidebar-3.jpg')}}">
                </a>
            </li>
            <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                    <img src="{{asset('material-dashboard/assets/img/sidebar-4.jpg')}}">
                </a>
            </li>


        </ul>
    </div>
</div> -->
 
</body>

<!--   Core JS Files   -->
<script src="{{asset('material-dashboard/assets/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('material-dashboard/assets/js/material.min.js')}}" type="text/javascript"></script>

<!--  Charts Plugin -->
<script src="{{asset('material-dashboard/assets/js/chartist.min.js')}}"></script>

<!--  Notifications Plugin    -->
<script src="{{asset('material-dashboard/assets/js/bootstrap-notify.js')}}"></script>

<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

<!-- Material Dashboard javascript methods -->
<script src="{{asset('material-dashboard/assets/js/material-dashboard.js')}}"></script>

<!--   Sharrre Library    -->
<script src="{{asset('material-dashboard/assets/js/jquery.sharrre.js')}}"></script>

<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="{{asset('material-dashboard/assets/js/demo.js')}}"></script>

<script>
    $( document ).ready(function() {
        setTimeout(function(){
           $(".alertBox").slideUp();
        }, 8000);

     $.extend( true, $.fn.dataTable.defaults, {
            "searching": false,
            "ordering": false,
             "scrollY": "300px",
             "scrollCollapse": true,
            } );   
    });
</script>

@yield('js')

</html>