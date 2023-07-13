<div class="table-responsive">
    <!-- Display Session Messages -->
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    @if($isOpen)
        <div class="card shadow-sm">
            <div class="card-header">
                <div wire:loading class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <h3 class="card-title">{{ $mode == 'edit' ? 'Edit Company Profile' : 'Add Company Profile' }}</h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-primary"
                            wire:click.prevent="store">
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
                        <input type="text"
                               class="form-control form-control-solid @error('company_name') is-invalid @enderror"
                               placeholder="Name" wire:model.defer="company_name"/>
                        @error('company_name')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="companyEmail" class="text-gray-700 text-sm font-bold mb-2">Company Email:</label>
                        <input type="email" class="form-control @error('company_email') is-invalid @enderror"
                               placeholder="Company Email" wire:model.defer="company_email"/>
                        @error('company_email')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="companyAddress" class="text-gray-700 text-sm font-bold mb-2">Company
                            Address:</label>
                        <input type="text" class="form-control @error('company_address') is-invalid @enderror"
                               placeholder="Company Address" wire:model.defer="company_address"/>
                        @error('company_address')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="contactPerson" class="text-gray-700 text-sm font-bold mb-2">Contact Person:</label>
                        <input type="text" class="form-control @error('contact_person') is-invalid @enderror"
                               placeholder="Contact Person" wire:model.defer="contact_person"/>
                        @error('contact_person')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="contactPersonEmail" class="text-gray-700 text-sm font-bold mb-2">Contact Person
                            Email</label>
                        <input type="email" class="form-control @error('contact_person_email') is-invalid @enderror"
                               placeholder="Contact Person Email" wire:model.defer="contact_person_email"/>
                        @error('contact_person_email')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="text-gray-700 text-sm font-bold mb-2">Role:</label>
                        <div>
                            <select name="relation" wire:model.defer="relation">
                                <option value="0">Advertiser</option>
                                <option value="1">Publisher</option>
                                <option value="2">Affiliate</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="companyNickname" class="text-gray-700 text-sm font-bold mb-2">Company
                            Nickname:</label>
                        <input type="text" class="form-control @error('company_nick_name') is-invalid @enderror"
                               placeholder="Company Nickname" wire:model.defer="company_nick_name"/>
                        @error('company_nick_name')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="contactPersonPhone" class="text-gray-700 text-sm font-bold mb-2">Contact Person
                            Phone:</label>
                        <input type="text" class="form-control @error('contactPersonPhone') is-invalid @enderror"
                               placeholder="Contact Person Phone" wire:model.defer="contact_person_phone_number"/>
                        @error('contactPersonPhone')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="onboardedBy" class="text-gray-700 text-sm font-bold mb-2">Onboarded By:</label>
                        <input type="text" class="form-control @error('onboardedBy') is-invalid @enderror"
                               placeholder="Onboarded By" wire:model.defer="onboarded_by"/>
                        @error('onboardedBy')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>


                    <div class="mb-4">
                        <label class="text-gray-700 text-sm font-bold mb-2">Payment Terms:</label>
                        <div>
                            <select name="paymentTerms" wire:model.defer="payment_terms">
                                <option value="prepaid">Prepaid</option>
                                <option value="days7">Postpaid - 7 days</option>
                                <option value="days15">Postpaid - 15 days</option>
                                <option value="days30">Postpaid - 30 days</option>
                                <option value="days60">Postpaid - 60 days</option>
                                <option value="days90">Postpaid - 90 days</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
    <button wire:click="openModals()" type="button" class="btn btn-primary" data-bs-toggle="modal" style="margin-top: 20px">
        Add Company
    </button>
    <table class="table table-striped table-bordered table-hover mb-10">
        <thead>
        <tr class="fw-bold fs-6 text-gray-800">
            <th>Approve</th>
            <th>Name</th>
            <th>Email</th>
            <th>Company Nickname</th>
            <th>Company Address</th>
            <th>Contact Person Email</th>
            <th>Relation</th>
            <th>Contact Person</th>
            <th>Contact Person Phone</th>
            <th>Onboarded By</th>
            <th>Payment Terms</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($companys as $advertiser)
            <tr>
                <td class="text-center">
                    <input type="checkbox" wire:click="toggleApproval({{ $advertiser->id }})"
                           @if($advertiser->is_approved) checked @endif>
                </td>
                <td>{{ $advertiser->company_name }}</td>
                <td>{{ $advertiser->company_email }}</td>
                <td>{{ $advertiser->company_nick_name }}</td>
                <td>{{ $advertiser->company_address }}</td>
                <td>{{ $advertiser->contact_person_email }}</td>
                <td>
                    @if ($advertiser->relation === 0)
                        Advertiser
                    @elseif ($advertiser->relation === 1)
                        Publisher
                    @elseif ($advertiser->relation === 2)
                        Affiliate
                    @endif
                </td>
                <td>{{ $advertiser->contact_person }}</td>
                <td>{{ $advertiser->contact_person_phone_number }}</td>
                <td>{{ $advertiser->onboarded_by }}</td>
                <td>{{ $advertiser->payment_terms }}</td>
                <td>
                    <div class="d-grid gap-2">
                        <button type="button" wire:click="edit({{ $advertiser->id }})" class="btn btn-light-primary">
                            Edit
                        </button>
                        <button type="button" wire:click.prevent="delete({{ $advertiser->id }})"
                                class="btn btn-light-danger">Delete
                        </button>
                        <a href="{{ route('admin.show-docs',$advertiser->id) }}" class="btn btn-light-info">Open
                            Docs</a>
                        <a href="{{ route('admin.show-offers', $advertiser->id) }}" class="btn btn-light-info">View
                            Offers</a>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


    {{ $companys->links() }}

</div>
