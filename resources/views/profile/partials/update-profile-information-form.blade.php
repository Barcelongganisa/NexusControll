<section class="card p-4">
    <div class="card-body">
        <h5 class="card-title">Profile Information</h5>
        <p class="text-muted">Update your account's profile information and email address.</p>

        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <!-- Profile Picture Upload -->
            <div class="mb-3 text-center">
                <label for="profile_picture" class="form-label">Profile Picture</label>
                <div>
                    <img id="profile-preview" 
                         src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('/images/user.png') }}" 
                         class="rounded-circle mb-2" 
                         width="120" 
                         alt="User Image">
                </div>
                <input type="file" class="form-control" name="profile_picture" id="profile_picture" accept="image/*">
                @error('profile_picture') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <!-- Name Field -->
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required autofocus>
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <!-- Email Field -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mb-3">
                    <p class="text-warning small">
                        Your email address is unverified. 
                        <button form="send-verification" class="btn btn-link p-0">Click here to resend verification.</button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="text-success small">A new verification link has been sent to your email address.</p>
                    @endif
                </div>
            @endif

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</section>