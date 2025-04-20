<section class="card p-4">
    <div class="card-body">
        <h5 class="card-title">Create a New User</h5>
        <p class="text-muted">
            You can create a new user account by filling in the required details. Ensure that the email and password meet the required criteria.
        </p>

        <div class="text-center">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createUserModal">
                Create User
            </button>
        </div>
    </div>
</section>

<!-- Modal for Creating User -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"> <!-- Added class here -->
        <div class="modal-content glassmorph"> <!-- Apply glassmorph effect -->
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Create New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Username" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">User Role</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="" disabled selected>Select a role</option>
                            <option value="admin">Admin</option>
                            <option value="employee">Employee</option>
                        </select>
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary ms-2">Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
