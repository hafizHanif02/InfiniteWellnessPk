<x-layouts.app title="Edit New Requisition">
    @push('styles')
        <link nonce="{{ csp_nonce() }}" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
    {{-- {{ dd($requistion) }} --}}
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Edit Purchase Requisition</h3>
           
            </div>
            <div class="card-body">
                <form action="{{ route('purchase.requisitions.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mb-5">
                        <div class="col-md-4">
                            <label for="requistion_id" class="form-label">Product Order # <sup class="text-danger">*</sup></label>
                            <input type="text" name="requistion_id" value="{{ ($requistion_id ? $requistion_id : 95000) + 1 }}" id="requistion_id" class="form-control" readonly title="Product order number">
                            @error('remarks')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="manufacturer_id" class="form-label">Manufacturers <sup class="text-danger">*</sup></label>
                            <select name="manufacturer_id" id="manufacturer_id" class="form-control" title="Manufactuter">
                                <option value="" selected disabled>Select Manufacturer</option>
                                @forelse ($manufacturers as $manufacturer)
                                    <option value="{{ $manufacturer->id }}">{{ $manufacturer->company_name }}</option>
                                @empty
                                    <option value="" class="text-danger">No manufacturer found!</option>
                                @endforelse
                            </select>
                            @error('manufacturer_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="vendor_id" class="form-label">Vendor <sup class="text-danger">*</sup></label>
                            <select name="vendor_id" id="vendor_id" class="form-control" title="Vendor">
                                <option value="" selected disabled>Select Vendor</option>
                                @forelse ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}">{{ $vendor->account_title }}</option>
                                @empty
                                    <option value="" class="text-danger">No vendor found!</option>
                                @endforelse
                            </select>
                            @error('vendor_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <label for="remarks" class="form-label">Remarks</label>
                            <input type="text" name="remarks" id="remarks" class="form-control" value="{{ old('remarks', $requistion->remarks) }}" placeholder="Enter your remarks" title="Remarks" readonly>
                            @error('remarks')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="delivery_date" class="form-label">Delivery Date</label>
                            <input type="date" name="delivery_date" id="delivery_date" class="form-control" value="{{ old('delivery_date', $requistion->delivery_date) }}" placeholder="Enter Delivery Date" title="Delivery date" readonly>
                            @error('delivery_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="document" class="form-label">Import Products</label>
                        <input type="file" name="document" id="document" class="form-control" title="Import products">
                        @error('document')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="product_id" class="form-label">(Generic Formula) Product <sup class="text-danger">*</sup></label>
                        <div class="row">
                            <div class="col-md-10">
                                <select name="product_id[]" id="product_id" class="form-control" multiple>
                                    <option value="" selected disabled>Select Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">({{ $product->generic->formula }}) {{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <button type="button" id="add-btn" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </div>
                    <!-- Rest of your form fields -->

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <!-- Table header and body here -->
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-5">
                        <button type="submit" class="btn btn-primary ms-3">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- Your JavaScript scripts here -->
    @endpush
</x-layouts.app>
