@include('layout.header')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><b>{{ $inventory->itemname }}</b><i>({{ $inventory->serial }})</i></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Update {{ $inventory->serial }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">

                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('inventory.update', $inventory->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <div class="col-3">
                                <label for="serial">Serial Number</label>
                                <input type="text" name="serial" id="serial" class="form-control" readonly
                                    value="{{ old('serial', $inventory->serial) }}">
                            </div>
                            <div class="col-6">
                                <label for="barcodeImage">Barcode</label>
                                <div class="card">
                                    <div class="card-body"
                                        style="background-color: white; display: flex; justify-content: center; align-items: center; height: 100%;">
                                        <img id="barcodeImage" src="{{ url('barcode/') . '/' . $inventory->serial }}"
                                            alt="Barcode" style="max-height: 80px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-3">
                                <label for="status">Item Status</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="" hidden>Select Status</option>
                                    <option value="Good" {{ $inventory->status == 'Good' ? 'selected' : '' }}>Good
                                    </option>
                                    <option value="Bad" {{ $inventory->status == 'Bad' ? 'selected' : '' }}>Bad
                                    </option>
                                    <option value="Damage" {{ $inventory->status == 'Damage' ? 'selected' : '' }}>
                                        Damage
                                    </option>
                                </select>
                            </div>
                            <div class="col-3">
                                <label for="placelocated">Area Located</label>
                                <select name="placelocated" id="placelocated" class="form-control" required>
                                    <option value="" hidden>Select Area</option>
                                    @foreach (App\Models\Area::all() as $data)
                                        <option value="{{ $data->area }}"
                                            {{ $inventory->placelocated == $data->area ? 'selected' : '' }}>
                                            {{ $data->area }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3">
                                <label for="category">Category</label>
                                <select name="category" id="category" class="form-control" required>
                                    <option value="" hidden>Select Category</option>
                                    @foreach (App\Models\Category::all() as $data)
                                        <option value="{{ $data->category }}"
                                            {{ $inventory->category == $data->category ? 'selected' : '' }}>
                                            {{ $data->category }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-4">
                                <label for="itemname">Item Name</label>
                                <input type="text" name="itemname" id="itemname" class="form-control"
                                    value="{{ old('itemname', $inventory->itemname) }}" required>
                            </div>
                            <div class="col-4">
                                <label for="receivedby">Received By</label>
                                <input type="text" name="receivedby" id="receivedby" class="form-control"
                                    value="{{ old('receivedby', $inventory->receivedby) }}" required>
                            </div>
                            <div class="col-4">
                                <label for="receivedfrom">Received From</label>
                                <input type="text" name="receivedfrom" id="receivedfrom" class="form-control"
                                    value="{{ old('receivedfrom', $inventory->receivedfrom) }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description">Item Description</label>
                            <textarea name="description" id="description" class="form-control" required>{{ old('description', $inventory->description) }}</textarea>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary">Update Item</button>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
        </div><!--/. container-fluid -->
    </section>
</div>
<!-- /.content-wrapper -->

@include('layout.footer')
