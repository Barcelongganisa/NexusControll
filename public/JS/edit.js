 document.getElementById('profile_picture').addEventListener('change', function(event) {
        const file = event.target.files[0]; // Get the selected file
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile-preview').src = e.target.result; // Update image preview
            };
            reader.readAsDataURL(file); // Read the file as a Data URL
        }
    });

