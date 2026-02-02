@extends('layouts.app')

@section('title', 'Edit Profile')
@section('header', 'Edit Profile')
@section('subtitle', 'Update your personal information')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Profile Card -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Header Section with Gradient -->
        <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 px-8 py-6">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center backdrop-blur-sm ring-4 ring-white ring-opacity-30">
                    <i class="fas fa-user-edit text-white text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white">Edit Your Profile</h2>
                    <p class="text-blue-100 text-sm mt-1">Keep your information up to date</p>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="p-8">
            <form method="POST" 
                  action="{{ route('users.update', Auth::id()) }}" 
                  enctype="multipart/form-data"
                  id="profileForm">
                @csrf
                @method('PUT')

                <!-- Profile Image Section -->
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        <i class="fas fa-image text-blue-600 mr-2"></i>Profile Picture
                    </label>
                    <div class="flex items-start space-x-6">
                        <!-- Current/Preview Image -->
                        <div class="relative group">
                            <div class="w-32 h-32 rounded-2xl overflow-hidden ring-4 ring-gray-200 transition-all group-hover:ring-blue-400">
                                @if(Auth::user()->image)
                                    <img id="imagePreview" 
                                         src="{{ asset('storage/' . Auth::user()->image) }}" 
                                         alt="Profile" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div id="imagePreview" class="w-full h-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                                        <span class="text-white font-bold text-4xl">
                                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-2xl transition-all flex items-center justify-center opacity-0 group-hover:opacity-100">
                                <i class="fas fa-camera text-white text-2xl"></i>
                            </div>
                        </div>

                        <!-- Upload Button and Info -->
                        <div class="flex-1">
                            <div class="relative">
                                <input type="file" 
                                       name="image" 
                                       id="imageInput" 
                                       accept="image/jpeg,image/png,image/jpg"
                                       class="hidden">
                                <label for="imageInput" 
                                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all cursor-pointer shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                    <i class="fas fa-upload mr-2"></i>
                                    Choose New Photo
                                </label>
                            </div>
                            <div class="mt-3 space-y-1">
                                <p class="text-sm text-gray-600">
                                    <i class="fas fa-info-circle text-blue-500 mr-1"></i>
                                    Allowed formats: JPG, JPEG, PNG
                                </p>
                                <p class="text-sm text-gray-600">
                                    <i class="fas fa-weight text-blue-500 mr-1"></i>
                                    Maximum size: 2 MB
                                </p>
                                <p id="selectedFileName" class="text-sm text-green-600 font-medium hidden">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    <span></span>
                                </p>
                            </div>
                            @error('image')
                                <p class="text-red-500 text-sm mt-2">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 my-8"></div>

                <!-- Personal Information Section -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        Personal Information
                    </h3>

                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   name="name" 
                                   id="name"
                                   value="{{ old('name', Auth::user()->name) }}"
                                   class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('name') border-red-500 @enderror"
                                   placeholder="Enter your full name"
                                   required>
                        </div>
                        @error('name')
                            <p class="text-red-500 text-sm mt-2">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" 
                                   name="email" 
                                   id="email"
                                   value="{{ old('email', Auth::user()->email) }}"
                                   class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('email') border-red-500 @enderror"
                                   placeholder="your.email@example.com"
                                   required>
                        </div>
                        @error('email')
                            <p class="text-red-500 text-sm mt-2">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            New Password <span class="text-gray-500 text-xs">(Leave blank to keep current)</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" 
                                   name="password" 
                                   id="password"
                                   class="w-full pl-11 pr-12 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('password') border-red-500 @enderror"
                                   placeholder="Enter new password (min. 8 characters)">
                            <button type="button" 
                                    onclick="togglePassword('password')"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600">
                                <i class="fas fa-eye" id="password-icon"></i>
                            </button>
                        </div>
                        <div class="mt-2 flex items-start space-x-2">
                            <i class="fas fa-info-circle text-blue-500 text-sm mt-0.5"></i>
                            <p class="text-xs text-gray-600">
                                Password must be at least 8 characters long. Use a mix of letters, numbers, and symbols for better security.
                            </p>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-sm mt-2">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="border-t border-gray-200 my-8"></div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('users.dashboard') }}" 
                       class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Cancel
                    </a>
                    
                    <button type="submit" 
                            class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <i class="fas fa-save mr-2"></i>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Additional Information Card -->
    <div class="mt-6 bg-blue-50 rounded-2xl p-6 border border-blue-100">
        <div class="flex items-start space-x-4">
            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-shield-alt text-blue-600"></i>
            </div>
            <div>
                <h4 class="font-semibold text-gray-800 mb-2">Account Security</h4>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Your password is encrypted and secure</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>We'll never share your personal information</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>All changes are logged for security purposes</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Image preview functionality
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const selectedFileName = document.getElementById('selectedFileName');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            // Validate file size (2MB = 2097152 bytes)
            if (file.size > 2893 * 1024) {
                alert('File size exceeds 2 MB. Please choose a smaller file.');
                imageInput.value = '';
                return;
            }

            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                alert('Invalid file type. Please choose a JPG, JPEG, or PNG image.');
                imageInput.value = '';
                return;
            }

            // Show file name
            selectedFileName.classList.remove('hidden');
            selectedFileName.querySelector('span').textContent = file.name;

            // Preview image
            const reader = new FileReader();
            reader.onload = function(e) {
                if (imagePreview.tagName === 'IMG') {
                    imagePreview.src = e.target.result;
                } else {
                    // Replace div with img
                    const newImg = document.createElement('img');
                    newImg.id = 'imagePreview';
                    newImg.src = e.target.result;
                    newImg.alt = 'Profile Preview';
                    newImg.className = 'w-full h-full object-cover';
                    imagePreview.parentNode.replaceChild(newImg, imagePreview);
                }
            };
            reader.readAsDataURL(file);
        }
    });

    // Toggle password visibility
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + '-icon');
        
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Form validation before submit
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;

        if (name.length < 3) {
            e.preventDefault();
            alert('Name must be at least 3 characters long.');
            document.getElementById('name').focus();
            return;
        }

        if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
            e.preventDefault();
            alert('Please enter a valid email address.');
            document.getElementById('email').focus();
            return;
        }

        if (password && password.length < 8) {
            e.preventDefault();
            alert('Password must be at least 8 characters long.');
            document.getElementById('password').focus();
            return;
        }

        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
    });

    // Prevent accidental navigation
    let formChanged = false;
    const formInputs = document.querySelectorAll('#profileForm input');
    
    formInputs.forEach(input => {
        input.addEventListener('change', () => {
            formChanged = true;
        });
    });

    window.addEventListener('beforeunload', (e) => {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // Reset flag when form is submitted
    document.getElementById('profileForm').addEventListener('submit', () => {
        formChanged = false;
    });
</script>
@endpush

@push('styles')
<style>
    /* Custom input focus effects */
    input:focus {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    /* Smooth image transitions */
    #imagePreview {
        transition: all 0.3s ease;
    }

    /* Button hover effects */
    button:hover:not(:disabled), label[for="imageInput"]:hover {
        transform: translateY(-2px);
    }

    button:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    /* Error input shake animation */
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }

    .border-red-500 {
        animation: shake 0.5s;
    }
</style>
@endpush