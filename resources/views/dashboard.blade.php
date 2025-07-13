@include('layout.header')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <!-- Success, Error, and Validation Messages -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-3 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-box"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Items</span>
                            <span class="info-box-number">
                                @php
                                    $count = \App\Models\Inventory::count();
                                @endphp
                                {{ $count }}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-3 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-thumbs-up"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Good</span>
                            <span class="info-box-number">
                                @php
                                    $count = \App\Models\Inventory::where('status', 'Good')->count();
                                @endphp
                                {{ $count }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-4 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-down"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Bad</span>
                            <span class="info-box-number">
                                @php
                                    $count = \App\Models\Inventory::where('status', 'Bad')->count();
                                @endphp
                                {{ $count }}</span></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-4 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-house-damage"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Damaged</span>
                            <span class="info-box-number">
                                @php
                                    $count = \App\Models\Inventory::where('status', 'Damage')->count();
                                @endphp
                                {{ $count }}</span>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>

            <div class="row">
                <div class="card col-12 col-md-4 mx-auto mt-4">
                    <div class="card-body">
                        <!-- Search Form -->
                        <form method="GET" action="{{ route('admin.search') }}" id="searchForm">
                            <input type="text" name="serial" id="serial" placeholder="Scan Serial"
                                class="form-control" autofocus autocomplete="off">
                        </form>
                    </div>
                </div>

                <div class="card col-12 col-md-8 mx-auto mt-4">
                    <h3 class="mt-2 mb-2">Please Scan Your Barcode</h3>
                    <div class="card-body">
                        @if (isset($inventory))
                            <label for="" class="h4 mb-3">Item Details</label>
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <!-- Item Serial -->
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <h5 class="text-bold">Item Serial: <span
                                                    class="text-muted">{{ $inventory->serial }}</span></h5>
                                        </div>
                                    </div>

                                    <!-- Item Name, Status, and Category -->
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <h5>Item Name: <p class="text-muted">{{ $inventory->itemname }}</p>
                                            </h5>
                                        </div>
                                        <div class="col-md-4">
                                            <h5>Item Status: <p class="text-muted">{{ $inventory->status }}</p>
                                            </h5>
                                        </div>
                                        <div class="col-md-4">
                                            <h5>Item Category: <p class="text-muted">{{ $inventory->category }}</p>
                                            </h5>
                                        </div>
                                    </div>

                                    <!-- Received From and Received By -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <h5>Received From: <p class="text-muted">
                                                    {{ $inventory->receivedfrom }}</span></p>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Received By: <p class="text-muted">{{ $inventory->receivedby }}</p>
                                            </h5>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="row">
                                        <div class="col-12">
                                            <h5>Description:</h5>
                                            <p class="text-muted">{{ $inventory->description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning" role="alert">
                                No item found with the given serial number.
                            </div>
                        @endif
                    </div>
                </div>

            </div>
            <!-- /.row -->
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@include('layout.footer')
<script>
    // Automatically submit the form when the scanner inputs a serial
    document.getElementById('serial').addEventListener('input', function() {
        document.getElementById('searchForm').submit();
    });
</script>
