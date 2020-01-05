@extends('Admin::layouts.master')

@section('title', 'Dashboard')
@section('pageTitle', 'Dashboard')

@section('menuLink')
    <ol class="breadcrumb">
        <li>Dashboard</li>
    </ol>
    <style>
        .progress-bar-striped, .progress-striped .progress-bar {
            background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.40) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.40) 50%, rgba(255, 255, 255, 0.40) 75%, transparent 75%, transparent) !important;
            background-size: 15px 15px !important;
        }

        .primary {
            background-color: rgb(122, 111, 190) !important;
        }

        .success {
            background-color: rgb(34, 186, 160) !important;
        }

        .warning {
            background-color: rgb(246, 212, 51) !important;
        }

        .info {
            background-color: rgb(18, 175, 203) !important;
        }

        .danger {
            background-color: rgb(242, 86, 86) !important;
        }

        .group {
            background-color: #e1e4ea;
            margin: 0 0 50px;
            padding: 10px 5px 0;
        }
    </style>
@endsection

@section('content')
    @if(empty($data))
        <div style="text-align: center">
            <h2 class="">Currently, Dashboard data not available due to under processing....</h2><br>
        </div>
    @else
        <div class="row">
            {{--for Users--}}
            <div class="group">
                <div class="info-box-icon">
                    <h2><i class="icon-users"></i> Users Info</h2>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p class="counter">{{$data['allUser']}}</p>
                                    <span class="info-box-title">All Users</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="icon-users"></i>
                                </div>
                                <div class="info-box-progress">
                                    <div class="progress progress-xs progress-squared bs-n">
                                        <div class="progress-bar progress-bar-striped active success" role="progressbar"
                                             style="width:{{$data['percentageActiveUser']}}%"></div>
                                        <div class="progress-bar progress-bar-striped active warning" role="progressbar"
                                             style="width:{{$data['percentageInactiveUser']}}%"></div>
                                        <div class="progress-bar progress-bar-striped active danger" role="progressbar"
                                             style="width:{{$data['percentageDeletedUser']}}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p class="counter">{{$data['activeUser']}}</p>
                                    <span class="info-box-title">Active Users</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="icon-user"></i>
                                </div>
                                <div class="info-box-progress">
                                    <div class="progress progress-xs progress-squared bs-n">
                                        <div class="progress-bar progress-bar-striped active success" role="progressbar"
                                             aria-valuenow="{{$data['percentageActiveUser']}}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             style="width: {{$data['percentageActiveUser']}}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p class="counter">{{$data['inactiveUser']}}</p>
                                    <span class="info-box-title">Pending Users</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="icon-user"></i>
                                </div>
                                <div class="info-box-progress">
                                    <div class="progress progress-xs progress-squared bs-n">
                                        <div class="progress-bar progress-bar-striped active warning" role="progressbar"
                                             aria-valuenow="{{$data['percentageInactiveUser']}}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             style="width: {{$data['percentageInactiveUser']}}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p class="counter">{{$data['deletedUser']}}</p>
                                    <span class="info-box-title">Deleted Users</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="icon-user"></i>
                                </div>
                                <div class="info-box-progress">
                                    <div class="progress progress-xs progress-squared bs-n">
                                        <div class="progress-bar progress-bar-striped active danger" role="progressbar"
                                             aria-valuenow="{{$data['percentageDeletedUser']}}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             style="width: {{$data['percentageDeletedUser']}}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--for Products--}}
            <div class="group">
                <div class="info-box-icon">
                    <h2><i class="icon-basket"></i> Product Info</h2>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p class="counter">{{$data['allProduct']}}</p>
                                    <span class="info-box-title">All Products</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="icon-basket"></i>
                                </div>
                                <div class="info-box-progress">
                                    <div class="progress progress-xs progress-squared bs-n">
                                        <div class="progress-bar progress-bar-striped active success" role="progressbar"
                                             style="width:{{$data['percentageActiveProduct']}}%"></div>
                                        <div class="progress-bar progress-bar-striped active warning" role="progressbar"
                                             style="width:{{$data['percentageInactiveProduct']}}%"></div>
                                        <div class="progress-bar progress-bar-striped active danger" role="progressbar"
                                             style="width:{{$data['percentageDeletedProduct']}}%"></div>
                                        <div class="progress-bar progress-bar-striped active primary" role="progressbar"
                                             style="width:{{$data['percentageUpcomingProduct']}}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p class="counter">{{$data['activeProduct']}}</p>
                                    <span class="info-box-title">Active Products</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="icon-basket"></i>
                                </div>
                                <div class="info-box-progress">
                                    <div class="progress progress-xs progress-squared bs-n">
                                        <div class="progress-bar progress-bar-striped active success" role="progressbar"
                                             aria-valuenow="{{$data['percentageActiveProduct']}}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             style="width: {{$data['percentageActiveProduct']}}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p class="counter">{{$data['inactiveProduct']}}</p>
                                    <span class="info-box-title">Pending Products</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="icon-basket"></i>
                                </div>
                                <div class="info-box-progress">
                                    <div class="progress progress-xs progress-squared bs-n">
                                        <div class="progress-bar progress-bar-striped active warning" role="progressbar"
                                             aria-valuenow="{{$data['percentageInactiveProduct']}}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             style="width: {{$data['percentageInactiveProduct']}}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p class="counter">{{$data['deletedProduct']}}</p>
                                    <span class="info-box-title">Deleted Products</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="icon-basket"></i>
                                </div>
                                <div class="info-box-progress">
                                    <div class="progress progress-xs progress-squared bs-n">
                                        <div class="progress-bar progress-bar-striped active danger" role="progressbar"
                                             aria-valuenow="{{$data['percentageDeletedProduct']}}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             style="width: {{$data['percentageDeletedProduct']}}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p class="counter">{{$data['upcomingProduct']}}</p>
                                    <span class="info-box-title">Upcoming Products</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="icon-basket"></i>
                                </div>
                                <div class="info-box-progress">
                                    <div class="progress progress-xs progress-squared bs-n">
                                        <div class="progress-bar progress-bar-striped active primary" role="progressbar"
                                             aria-valuenow="{{$data['percentageUpcomingProduct']}}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             style="width: {{$data['percentageUpcomingProduct']}}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--for Orders--}}
            <div class="group">
                <div class="info-box-icon">
                    <h2><i class="icon-briefcase"></i> Order Info</h2>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p class="counter">{{$data['allOrders']}}</p>
                                    <span class="info-box-title">All Orders</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="icon-briefcase"></i>
                                </div>
                                <div class="info-box-progress">
                                    <div class="progress progress-xs progress-squared bs-n">
                                        <div class="progress-bar progress-bar-striped active warning" role="progressbar"
                                             style="width:{{$data['percentagePendingOrders']}}%"></div>
                                        <div class="progress-bar progress-bar-striped active primary" role="progressbar"
                                             style="width:{{$data['percentageProcessedOrders']}}%"></div>
                                        <div class="progress-bar progress-bar-striped active info" role="progressbar"
                                             style="width:{{$data['percentageDispatchedOrder']}}%"></div>
                                        <div class="progress-bar progress-bar-striped active success" role="progressbar"
                                             style="width:{{$data['percentageDeliveredOrder']}}%"></div>
                                        <div class="progress-bar progress-bar-striped active danger" role="progressbar"
                                             style="width:{{$data['percentageCanceledOrder']}}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p class="counter">{{$data['pendingOrders']}}</p>
                                    <span class="info-box-title">Pending Orders</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="icon-briefcase"></i>
                                </div>
                                <div class="info-box-progress">
                                    <div class="progress progress-xs progress-squared bs-n">
                                        <div class="progress-bar  progress-bar-striped active warning"
                                             role="progressbar"
                                             aria-valuenow="{{$data['percentagePendingOrders']}}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             style="width: {{$data['percentagePendingOrders']}}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p class="counter">{{$data['processedOrders']}}</p>
                                    <span class="info-box-title">Processed Orders</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="icon-briefcase"></i>
                                </div>
                                <div class="info-box-progress">
                                    <div class="progress progress-xs progress-squared bs-n">
                                        <div class="progress-bar progress-bar-striped active primary" role="progressbar"
                                             aria-valuenow="{{$data['percentageProcessedOrders']}}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             style="width: {{$data['percentageProcessedOrders']}}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p class="counter">{{$data['dispatchedOrder']}}</p>
                                    <span class="info-box-title">Dispatched Orders</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="icon-briefcase"></i>
                                </div>
                                <div class="info-box-progress">
                                    <div class="progress progress-xs progress-squared bs-n">
                                        <div class="progress-bar progress-bar-striped active info" role="progressbar"
                                             aria-valuenow="{{$data['percentageDispatchedOrder']}}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             style="width: {{$data['percentageDispatchedOrder']}}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p class="counter">{{$data['deliveredOrder']}}</p>
                                    <span class="info-box-title">Delivered Orders</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="icon-briefcase"></i>
                                </div>
                                <div class="info-box-progress">
                                    <div class="progress progress-xs progress-squared bs-n">
                                        <div class="progress-bar progress-bar-striped active success" role="progressbar"
                                             aria-valuenow="{{$data['percentageDeliveredOrder']}}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             style="width: {{$data['percentageDeliveredOrder']}}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p class="counter">{{$data['canceledOrder']}}</p>
                                    <span class="info-box-title">Canceled Orders</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="icon-briefcase"></i>
                                </div>
                                <div class="info-box-progress">
                                    <div class="progress progress-xs progress-squared bs-n">
                                        <div class="progress-bar progress-bar-striped active danger" role="progressbar"
                                             aria-valuenow="{{$data['percentageCanceledOrder']}}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             style="width: {{$data['percentageCanceledOrder']}}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--for Payments--}}
            <div class="group">
                <div class="info-box-icon">
                    <h2><i class="fa fa-money"></i> Transaction Info</h2>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p>Rs <span class="counter">{{$data['allPayments']}}</span></p>
                                    <span class="info-box-title">All Transaction Money</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="fa fa-money"></i>
                                </div>
                                <div class="info-box-progress">
                                    <div class="progress progress-xs progress-squared bs-n">
                                        <div class="progress-bar progress-bar-striped active warning" role="progressbar"
                                             style="width:{{$data['percentagePendingPayment']}}%"></div>
                                        <div class="progress-bar progress-bar-striped active success" role="progressbar"
                                             style="width:{{$data['percentageSuccessPayment']}}%"></div>
                                        <div class="progress-bar progress-bar-striped active primary" role="progressbar"
                                             style="width:{{$data['percentageReturnedPayment']}}%"></div>
                                        <div class="progress-bar progress-bar-striped active danger" role="progressbar"
                                             style="width:{{$data['percentageFailedPayment']}}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p>Rs <span class="counter">{{$data['pendingPayment']}}</span></p>
                                    <span class="info-box-title">Pending Transaction Money</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="fa fa-money"></i>
                                </div>
                                <div class="info-box-progress">
                                    <div class="progress progress-xs progress-squared bs-n">
                                        <div class="progress-bar progress-bar-striped active warning" role="progressbar"
                                             aria-valuenow="{{$data['percentagePendingPayment']}}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             style="width: {{$data['percentagePendingPayment']}}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p>Rs <span class="counter">{{$data['successPayment']}}</span></p>
                                    <span class="info-box-title">Success Transaction Money</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="fa fa-money"></i>
                                </div>
                                <div class="info-box-progress">
                                    <div class="progress progress-xs progress-squared bs-n">
                                        <div class="progress-bar progress-bar-striped active success" role="progressbar"
                                             aria-valuenow="{{$data['percentageSuccessPayment']}}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             style="width: {{$data['percentageSuccessPayment']}}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p>Rs <span class="counter">{{$data['returnedPayment']}}</span></p>
                                    <span class="info-box-title">Returned Transaction Money</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="fa fa-money"></i>
                                </div>
                                <div class="info-box-progress">
                                    <div class="progress progress-xs progress-squared bs-n">
                                        <div class="progress-bar progress-bar-striped active primary" role="progressbar"
                                             aria-valuenow="{{$data['percentageReturnedPayment']}}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             style="width: {{$data['percentageReturnedPayment']}}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p>Rs <span class="counter">{{$data['failedPayment']}}</span></p>
                                    <span class="info-box-title">Failed Transaction Money</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="fa fa-money"></i>
                                </div>
                                <div class="info-box-progress">
                                    <div class="progress progress-xs progress-squared bs-n">
                                        <div class="progress-bar progress-bar-striped active danger" role="progressbar"
                                             aria-valuenow="{{$data['percentageFailedPayment']}}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             style="width:{{$data['percentageFailedPayment']}}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('bodyScript')
    <script type="text/javascript">
        $(document).ready(function () {
            //for activate the side menu
            $('#dashboard').addClass('active');
        });
    </script>
@endsection