<section class="card p-4">
    <div class="card-body">
        <h5 class="card-title text-danger">Delete Account</h5>
        <p class="text-muted">
            Select an account to delete. Once deleted, all resources and data will be permanently removed.
        </p>

        <div class="text-center">
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                Delete Account
            </button>
        </div>
    </div>
</section>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"> <!-- Added this class -->
        <div class="modal-content glassmorph"> <!-- Apply glassmorph effect -->
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="confirmDeleteModalLabel">Are you sure?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted">
                    Once deleted, this account and all its resources will be permanently removed. Select a user and confirm the deletion.
                </p>

                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <!-- User Selection Dropdown -->
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Select Account</label>
                        <select id="user_id" name="user_id" class="form-control" required>
                            <option value="">-- Select User --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Password Confirmation -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Admin Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password">
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger ms-2">Delete Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
