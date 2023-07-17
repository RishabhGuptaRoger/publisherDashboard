<div>
    <h2>Documents for {{ $company->company_name }}</h2>

    <!-- Display Session Messages -->
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    @if($isOpen)
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">{{ $mode == 'edit' ? 'Edit Document' : 'Add Document' }}</h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-primary"
                            wire:click.prevent="{{ $mode == 'edit' ? 'updateDoc' : 'storeDoc' }}">
                        {{ $mode == 'edit' ? 'Update' : 'Save' }}
                    </button>&nbsp;&nbsp;
                    <button type="button" class="btn btn-sm btn-light" wire:click.prevent="closeModal">
                        Close
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="start_date" class="text-gray-700 text-sm font-bold mb-2">Start Date:</label>
                            <input type="date" class="form-control form-control @error('start_date') is-invalid @enderror"
                                   placeholder="Start Date" wire:model.defer="start_date"/>
                            @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="end_date" class="text-gray-700 text-sm font-bold mb-2">End Date:</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                   placeholder="End Date"
                                   wire:model.defer="end_date"/>
                            @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="geos" class="text-gray-700 text-sm font-bold mb-2">Geos:</label>
                        <select class="form-control @error('geos') is-invalid @enderror" wire:model.defer="geos">
                            <option value="all">All</option>
                            <option value="algeria">Algeria</option>
                            <option value="bahrain">Bahrain</option>
                            <option value="cyprus">Cyprus</option>
                            <option value="egypt">Egypt</option>
                            <option value="greece">Greece</option>
                            <option value="indonesia">Indonesia</option>
                            <option value="iraq">Iraq</option>
                            <option value="jordan">Jordan</option>
                            <option value="ksa">KSA</option>
                            <option value="kuwait">Kuwait</option>
                            <option value="nepal">Nepal</option>
                            <option value="nigeria">Nigeria</option>
                            <option value="oman">Oman</option>
                            <option value="palestine">Palestine</option>
                            <option value="poland">Poland</option>
                            <option value="qatar">Qatar</option>
                            <option value="sweden">Sweden</option>
                            <option value="thailand">Thailand</option>
                            <option value="uae">UAE</option>
                        </select>
                            @error('geos')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror

                        <!-- File upload component -->
                        @if ($uploadSuccessful)
                            <div class="alert alert-success">
                                File uploaded successfully!
                            </div>
                        @endif

                        <div class="form-group">
                            <div wire:loading class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <div class="border p-3 rounded mb-3" style="height: 120px; position: relative;">
                                <i class="fas fa-cloud-upload-alt fa-3x text-primary" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></i>
                                <h4 class="text-center mt-2">Drop files here or click to upload.</h4>
                                <input type="file" wire:model.defer="file" class="custom-file-input" id="fileInput" style="opacity: 0; position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                            </div>
                            @error('file')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                </form>
            </div>
        </div>
    @endif
    @if(!$isOpen)

    <button wire:click="openModals" type="button" class="btn btn-primary" data-bs-toggle="modal">
        Add Document
    </button>
    @endif
    <table class="table">
        <thead>
        <tr class="fw-bold fs-6 text-gray-800">
            <th>Start Date</th>
            <th>End Date</th>
            <th>Geos</th>
            <th>File</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($docs as $doc)
            <tr>
                <td>{{ $doc->start_date }}</td>
                <td>{{ $doc->end_date }}</td>
                <td>{{ $doc->geos }}</td>
                <td>
                    @if($doc->file_path)
                    <a href="//{{ Storage::url($doc->file_path) }}" target="_blank">View File</a>
                    @endif
                </td>
                <td>
                    <button type="button" wire:click.prevent="edit({{ $doc->id }})" class="btn btn-primary btn-sm">
                        Edit
                    </button>
                    <button type="button" wire:click.prevent="delete({{ $doc->id }})"
                            class="btn btn-danger btn-sm ml-2">Delete
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $docs->links() }}
</div>
