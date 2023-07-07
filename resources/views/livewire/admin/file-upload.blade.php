<div>
    @if ($uploadSuccessful)
        <div class="alert alert-success">
            File uploaded successfully!
        </div>
    @endif

    <div>
        <form class="form" wire:submit.prevent="save">
            <div class="form-group">
                <div wire:loading class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>

                <div class="border p-3 rounded mb-3" style="height: 120px; position: relative;">
                    <i class="fas fa-cloud-upload-alt fa-3x text-primary" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></i>
                    <h4 class="text-center mt-2">Drop files here and click save to upload.</h4>
                    <input type="file" wire:model="file" class="custom-file-input" id="fileInput" style="opacity: 0; position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                </div>

                @error('file')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
