<div class="table-responsive">
    @if($isOpen)
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Add Advertiser</h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-light" wire:click.prevent="closeModal">
                        Close
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-4">
                        <label for="name" class="text-gray-700 text-sm font-bold mb-2">Name:</label>
                        <input type="text" class="form-control form-control-solid" placeholder="Name" wire:model="name"/>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="text-gray-700 text-sm font-bold mb-2">Email:</label>
                        <input type="email" class="form-control" placeholder="name@example.com" wire:model="email"/>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-light" wire:click.prevent="store">
                    Save
                </button>
            </div>
        </div>
    @endif
    <button wire:click="openModals()" type="button" class="btn btn-primary" data-bs-toggle="modal">
        Add Advertiser
    </button>
    <table class="table mb-10">
        <thead>
        <tr class="fw-bold fs-6 text-gray-800">
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($advertisers as $advertiser)
            <tr>
                <td>{{ $advertiser->name }}</td>
                <td>{{ $advertiser->email }}</td>
                <td>
                    <button type="button" wire:click.prevent="edit({{ $advertiser->id }})"
                            class="btn btn-primary btn-sm">Edit
                    </button>
                    <button type="button" wire:click.prevent="delete({{ $advertiser->id }})"
                            class="btn btn-danger btn-sm ml-2">Delete
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $advertisers->links() }}

</div>
