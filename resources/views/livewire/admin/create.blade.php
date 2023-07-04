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
