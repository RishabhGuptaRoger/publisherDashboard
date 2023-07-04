<div class="table-responsive">
    @if($isOpen)
        @include('livewire.admin.create')
    @endif
    <button wire:click="openModal()" type="button" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#kt_modal_1">
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
