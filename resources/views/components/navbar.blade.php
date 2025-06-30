<nav class="bg-white p-2 shadow-md">
  <div class="max-w-screen-xl mx-auto px-4 flex items-center justify-between h-16">
    <!-- Logo -->
    <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
      <img src="{{ asset('storage/pelindo-removebg-preview.png') }}" class="h-8" alt="Flowbite Logo" />
      <span class="text-2xl font-semibold" style="color: #0475bc;">PELINDO</span>
    </a>

    <!-- Authentication Button -->
    <div class="flex items-center space-x-4">
      @guest
        <!-- Jika user belum login -->
        <a href="{{ route('login') }}" class="py-2 text-xl font-semibold px-4 hover:bg-blue-100 rounded transition" style="color: #0475bc;">
          Login
        </a>
      @else
        <!-- Jika user sudah login -->
        <div class="flex items-center space-x-4">
          <!-- Tampilkan nama user dan role -->
          <span class="font-medium" style="color: #0475bc;">
            Halo, {{ Auth::user()->name }} 
          </span>
          
          <!-- Logout Button -->
          <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="py-2 text-lg font-semibold px-4 text-white hover:bg-red-600 bg-red-500 rounded transition">
              Logout
            </button>
          </form>
        </div>
      @endguest
    </div>
  </div>
</nav>