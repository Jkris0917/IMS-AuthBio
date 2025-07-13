@include('layout.header')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Item List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Item List</li>
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
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
                            Add Item
                        </button>
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>Barcode Img</th>
                                <th>Serial No.</th>
                                <th>Item Name</th>
                                <th>Description</th>
                                <th>Place Located</th>
                                <th>Received By</th>
                                <th>Received From</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inventories as $data)
                                <tr>
                                    <td><img src="{{ route('barcode.generate', $data->serial) }}" alt="Barcode"
                                            style="max-height: 80px; width:150px;height:100%"></td>
                                    <td>{{ $data->serial }}</td>
                                    <td>{{ $data->itemname }}</td>
                                    <td>{{ $data->description }}</td>
                                    <td>{{ $data->placelocated }}</td>
                                    <td>{{ $data->receivedby }}</td>
                                    <td>{{ $data->receivedfrom }}</td>
                                    <td>{{ $data->status }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                                id="dropdownMenuButton{{ $data->id }}" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu"
                                                aria-labelledby="dropdownMenuButton{{ $data->id }}">
                                                <a class="dropdown-item"
                                                    href="{{ route('inventory.edit', $data->id) }}">Edit</a>
                                                <form action="{{ route('inventory.destroy', $data->id) }}"
                                                    method="POST" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="dropdown-item text-danger">Delete</button>
                                                </form>
                                                <button class="dropdown-item"
                                                    onclick="downloadBarcode('{{ route('barcode.generate', $data->serial) }}', '{{ $data->serial }}')">Download</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div><!--/. container-fluid -->
    </section>
</div>
<!-- /.content-wrapper -->

@include('layout.footer')

<!-- Add Area Modal -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Item</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('inventory.store') }}" method="post">
                    @csrf
                    <div class="form-group row">
                        <div class="col-3">
                            <label for="">Serial Number</label>
                            <input type="text" name="serial" id="serial" class="form-control" required
                                autocomplete="off" readonly value="{{ old('serial', $serial ?? '') }}">
                        </div>
                        <div class="col-6">
                            <label for="">Barcode</label>
                            <div class="card">
                                <div class="card-body"
                                    style="background-color: white; display: flex; justify-content: center; align-items: center; height: 100%;">
                                    <img id="barcodeImage" src="" alt="Barcode" style="max-height: 80px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            <label for="">Item Status</label>
                            <select name="status" id="status" class="form-control" required autocomplete="off">
                                <option value="" hidden selected>Select Status</option>
                                <option value="Good">Good</option>
                                <option value="Bad">Bad</option>
                                <option value="Damage">Damage</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="">Area Located</label>
                            <select name="placelocated" id="placelocated" class="form-control" required
                                autocomplete="off">
                                <option value="" hidden selected>Select Area</option>
                                @foreach (App\Models\Area::all() as $data)
                                    <option value="{{ $data->area }}">{{ $data->area }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="">Category</label>
                            <select name="category" id="category" class="form-control" required autocomplete="off">
                                <option value="" hidden selected>Select Category</option>
                                @foreach (App\Models\Category::all() as $data)
                                    <option value="{{ $data->category }}">{{ $data->category }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-4">
                            <label for="">Item Name</label>
                            <input type="text" name="itemname" id="itemname" class="form-control" required
                                autocomplete="off">
                        </div>
                        <div class="col-4">
                            <label for="">Received By</label>
                            <input type="text" name="receivedby" id="receivedby" class="form-control" required
                                autocomplete="off">
                        </div>
                        <div class="col-4">
                            <label for="">Received From</label>
                            <input type="text" name="receivedfrom" id="receivedfrom" class="form-control"
                                required autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="">Item Description</label>
                        <textarea name="description" id="description" class="form-control" required autocomplete="off" cols="5"
                            rows="5"></textarea>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Item</button>
                    </div>
                </form>

                <script>
                    // Serial number generator
                    function generateSerial() {
                        const letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                        let randomLetters = "";
                        for (let i = 0; i < 5; i++) {
                            randomLetters += letters.charAt(Math.floor(Math.random() * letters.length));
                        }
                        return "ITEM-" + randomLetters;
                    }

                    // Set the serial on page load and generate barcode
                    document.addEventListener("DOMContentLoaded", function() {
                        let serial = generateSerial();
                        document.getElementById("serial").value = serial;

                        // Update the barcode image source with the generated serial
                        let barcodeImage = document.getElementById("barcodeImage");
                        barcodeImage.src = "{{ url('barcode/') }}/" + serial;
                    });
                </script>
                <script>
                    function downloadBarcode(imageUrl, serial) {
                        const canvas = document.createElement('canvas');
                        const ctx = canvas.getContext('2d');
                        const img = new Image();

                        img.crossOrigin = "anonymous"; // Avoid CORS issues
                        img.onload = function() {
                            const padding = 20;
                            const width = img.width + padding * 2;
                            const height = img.height + 50 + padding * 2; // extra space for text + padding

                            canvas.width = width;
                            canvas.height = height;

                            // Fill background white
                            ctx.fillStyle = "#FFFFFF";
                            ctx.fillRect(0, 0, canvas.width, canvas.height);

                            // Draw the barcode image centered
                            ctx.drawImage(img, padding, padding);

                            // Draw the serial number below the barcode
                            ctx.fillStyle = "#000000";
                            ctx.font = "20px Arial";
                            ctx.textAlign = "center";
                            ctx.fillText(serial, width / 2, img.height + padding + 35);

                            // Trigger download
                            const link = document.createElement('a');
                            link.download = serial + '.png';
                            link.href = canvas.toDataURL();
                            link.click();
                        };

                        img.src = imageUrl;
                    }
                </script>
