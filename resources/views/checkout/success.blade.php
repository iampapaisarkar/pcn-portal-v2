<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Payment Success</title>
  <link href="{{ asset('admin/dist-assets/css/themes/lite-purple.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('admin/dist-assets/css/plugins/perfect-scrollbar.min.css') }}" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-9">
                <div class="card">
                    <div class="card-body border-1">
                        <div class="row mb-3">
                            <div class="col-3 col-md-2 col-lg-2 d-flex align-items-center">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
                                <circle style="fill:#25AE88;" cx="25" cy="25" r="25"/>
                                <polyline style="fill:none;stroke:#FFFFFF;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" points="
                                38,15 22,33 12,25 "/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                            </div>
                            <div class="col-9 col-md-10 col-lg-10 d-flex flex-column justify-content-center">
                                <h2>Your payment successfully received</h2>
                                <h5 class="text-muted">Please be patient, we will contact you soon</h5>

                                <div class="mt-3">
                                <h5 class="text-muted">Order ID: <strong>{{$order->order_id}}</strong></h5>
                                    <h5 class="text-muted">Name: <strong>{{$order->user->firstname . ' ' . $order->user->lastname }}</strong></h5>
                                    <h5 class="text-muted">Email: <strong>{{$order->user->email}}</strong></h5>
                                    <h5 class="text-muted">Service Type: <strong>{{$order->service->description}}</strong></h5>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <a href="{{ route('meptp-application-status') }}" class="btn btn-primary btn-rounded w-100">View Status</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
