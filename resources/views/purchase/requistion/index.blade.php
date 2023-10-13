 <x-layouts.app title="Requistion List">
     <div class="container-fluid mt-5">
         <div class="card">
             <div class="card-body">
                 <div class="d-flex justify-content-between">
                     <h3>Purchase Requistion </h3>
                     <div class="d-flex gap-5">
                        <div>
                            <a href="{{ asset('csv/Purchase/Requistions.xlsx') }}" class="btn btn-danger" download>Download
                                sample</a>
                        </div>
                        <form id="csv-form" action="{{ route('purchase.requistions.import-excel') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="requistions_csv" id="requistions_csv" style="display: none;">
                            <label for="requistions_csv" class="btn btn-secondary float-end mr-5 mb-3">Import
                                Excel</label>
                            <button type="submit" class="btn btn-secondary float-end mr-5 mb-3"
                                style="display: none;">button</button>
                        </form>
                        <a href="{{ route('purchase.requistions.create') }}" class="btn btn-primary float-end mr-5 mb-3">Add
                            New</a>
                     </div>
                 </div>
                 <table class="table table-bordered text-center table-hover">
                     <thead class="table-dark">
                         <tr>
                             <td>#</td>
                             <td>Code</td>
                             <td>Vendor</td>
                             <td>Actions</td>
                         </tr>
                     </thead>
                     <tbody>
                         @forelse ($requistions as $requistion)
                             <tr>
                                 <td>{{ $loop->iteration }}</td>
                                 <td>{{ $requistion->id }}</td>
                                 <td>{{ $requistion->vendor->account_title }}</td>
                                 <td class="d-flex justify-content-center gap-5">
                                     <a href="{{ route('purchase.requistions.edit', $requistion->id) }}">
                                         <i class="fa fa-edit"></i>
                                     </a>
                                     <a href="{{ route('purchase.requistions.show', $requistion->id) }}">
                                         <i class="fa fa-eye"></i>
                                     </a>
                                     <form action="{{ route('purchase.requistions.destroy', $requistion->id) }}"
                                         class="d-inline" method="POST">
                                         @csrf
                                         @method('DELETE')
                                         <button type="submit" class="bg-transparent border-0 text-danger">
                                             <i class="fa fa-trash"></i>
                                         </button>
                                     </form>
                                 </td>
                             </tr>
                         @empty
                             <tr class="text-center">
                                 <td colspan="5" class="text-danger">No requistions found!</td>
                             </tr>
                         @endforelse
                     </tbody>
                 </table>
                 <div>
                    {{ $requistions->links() }}
                 </div>
             </div>
         </div>
     </div>
     @push('scripts')
        <script>
            $('input[name="requistions_csv"]').change(function() {
                $('#csv-form').submit();
            });
        </script>
    @endpush
 </x-layouts.app>
