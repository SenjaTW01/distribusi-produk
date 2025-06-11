@extends('layouts.app')

@section('content')

<div class="min-h-screen w-full flex items-center justify-center bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 py-12 px-4 sm:px-6 lg:px-8">
    <div class="absolute inset-0 bg-pattern opacity-10"></div>
    
    <div class="w-full max-w-md relative z-10">
        <!-- Logo dan Judul -->
        <div class="text-center mb-8">
            <div class="mx-auto h-16 w-16 rounded-full bg-white flex items-center justify-center shadow-lg mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-white tracking-tight mb-1">Distribusi Produk</h2>
            <p class="text-indigo-200 text-sm">Masuk untuk mengelola distribusi produk</p>
        </div>
        
        <!-- Card Login -->
        <div class="bg-white backdrop-filter backdrop-blur-xl bg-opacity-95 rounded-2xl shadow-2xl overflow-hidden transform transition-all hover:scale-[1.01] duration-300">
            <!-- Form Login -->
            <div class="p-8">
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <!-- Email Field -->
                    <div class="mb-6">
                        <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <input type="email" class="pl-10 block w-full border-0 p-4 rounded-xl text-gray-900 bg-gray-50 focus:ring-2 focus:ring-indigo-500 shadow-inner @error('email') border-red-500 @enderror"
                                id="email" name="email" value="{{ old('email') }}" placeholder="nama@example.com" required autofocus>
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="password" class="pl-10 block w-full border-0 p-4 rounded-xl text-gray-900 bg-gray-50 focus:ring-2 focus:ring-indigo-500 shadow-inner @error('password') border-red-500 @enderror"
                                id="password" name="password" placeholder="••••••••" required>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox" class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded-md">
                            <label for="remember" class="ml-2 block text-sm text-gray-700">Ingat Saya</label>
                        </div>
                    </div>

                    <!-- Login Button -->
                    <div>
                        <button type="submit" class="group relative w-full flex justify-center py-4 px-4 border border-transparent text-sm font-medium rounded-xl text-white bg-gradient-to-r from-indigo-600 to-blue-500 hover:from-indigo-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-indigo-300 group-hover:text-indigo-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-sm text-indigo-200">
                © 2023 Distribusi Produk. All rights reserved.
            </p>
        </div>
    </div>
</div>

<!-- Script untuk menambahkan pattern background -->
<script>
    // Menambahkan pattern background
    document.addEventListener('DOMContentLoaded', function() {
        const bgPattern = document.createElement('div');
        bgPattern.classList.add('bg-pattern');
        document.querySelector('.min-h-screen').appendChild(bgPattern);
    });
</script>
@endsection