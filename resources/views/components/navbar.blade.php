<nav class="bg-blue-400 p-2">
  <div class="max-w-screen-xl mx-auto px-4 flex items-center justify-between h-16">
    <!-- Logo -->
    <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
      <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" />
      <span class="text-2xl font-semibold text-white">PT GATE INDONESIA</span>
    </a>

    <!-- Authentication Button -->
    <div class="flex items-center space-x-4">
      @guest
        <!-- Jika user belum login -->
        <a href="{{ route('login') }}" class="py-2 text-xl font-semibold px-4 text-white hover:bg-blue-600 rounded transition">
          Login
        </a>
      @else
        <!-- Jika user sudah login -->
        <div class="flex items-center space-x-4">
          <!-- Tampilkan nama user dan role -->
          <span class="text-white font-medium">
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