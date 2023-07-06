<div>
    <h2>Documents for {{ $user->name }}</h2>
    @if($isOpen)
        <div class="card shadow-sm">
            <div class="card-header">
                <div wire:loading class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
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
                    <div class="mb-4">
                        <label for="start_date" class="text-gray-700 text-sm font-bold mb-2">Start Date:</label>
                        <input type="date" class="form-control form-control @error('start_date') is-invalid @enderror"
                               placeholder="Start Date" wire:model="start_date"/>
                        @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="end_date" class="text-gray-700 text-sm font-bold mb-2">End Date:</label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" placeholder="End Date"
                               wire:model="end_date"/>
                        @error('end_date')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="geos" class="text-gray-700 text-sm font-bold mb-2">Geos:</label>
                        <input type="text" class="form-control @error('geos') is-invalid @enderror"
                               placeholder="Geos" wire:model="geos"/>
                        @error('geos')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </form>
            </div>
        </div>
    @endif
    <button wire:click="openModals" type="button" class="btn btn-primary" data-bs-toggle="modal">
        Add Document
    </button>
    <table class="table">
        <thead>
        <tr class="fw-bold fs-6 text-gray-800">
            <th>Start Date</th>
            <th>End Date</th>
            <th>Geos</th>
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
