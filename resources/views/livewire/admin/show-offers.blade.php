<div>
    <h2>Offers for {{ $user->name }}</h2>
    @if($isOpen)
        <div class="card shadow-sm">
            <div class="card-header">
                <div wire:loading class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <h3 class="card-title">{{ $mode == 'edit' ? 'Edit Offer' : 'Add Offer' }}</h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-primary"
                            wire:click.prevent="{{ $mode == 'edit' ? 'updateOffer' : 'storeOffer' }}">
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
                        <label for="name" class="text-gray-700 text-sm font-bold mb-2">Name:</label>
                        <input type="text" class="form-control form-control @error('name') is-invalid @enderror"
                               placeholder="Name" wire:model="name"/>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="geo" class="text-gray-700 text-sm font-bold mb-2">Geo:</label>
                        <input type="text" class="form-control @error('geo') is-invalid @enderror" placeholder="Geo"
                               wire:model="geo"/>
                        @error('geo')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="payout" class="text-gray-700 text-sm font-bold mb-2">Payout:</label>
                        <input type="number" class="form-control @error('payout') is-invalid @enderror"
                               placeholder="Payout" wire:model="payout"/>
                        @error('payout')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </form>
            </div>
        </div>
    @endif
    <button wire:click="openModals" type="button" class="btn btn-primary" data-bs-toggle="modal">
        Add Offer
    </button>
    <table class="table">
        <thead>
        <tr class="fw-bold fs-6 text-gray-800">
            <th>Name</th>
            <th>Geo</th>
            <th>Payout</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($offers as $offer)
            <tr>
                <td>{{ $offer->name }}</td>
                <td>{{ $offer->geo }}</td>
                <td>{{ $offer->payout }}</td>
                <td>
                    <button type="button" wire:click.prevent="edit({{ $offer->id }})" class="btn btn-primary btn-sm">
                        Edit
                    </button>
                    <button type="button" wire:click.prevent="delete({{ $offer->id }})"
                            class="btn btn-danger btn-sm ml-2">Delete
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $offers->links() }}
</div>
