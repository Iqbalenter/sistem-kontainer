<form action="{{ route('login') }}" method="POST" class="w-full mx-auto">
  @csrf
  <div class="mb-5">
    <label for="email" class="block mb-2 text-sm font-medium text-black-900 dark:text-black">Your email</label>
    <input type="email" name="email" id="email" class="bg-white-50 border border-white-300 text-white-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-black-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@example.com" required value="{{ old('email') }}" />
    @error('email')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
  </div>
  <div class="mb-5">
    <label for="password" class="block mb-2 text-sm font-medium text-black-900 dark:text-black">Your password</label>
    <input type="password" name="password" id="password" class="bg-white-50 border border-white-300 text-white-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-black-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
    @error('password')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
  </div>
  <div class="flex items-start mb-5">
    <div class="flex items-center h-5">
      <input id="remember" name="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" />
    </div>
    <label for="remember" class="ms-2 text-sm font-medium text-white-900 dark:text-white-300">Remember me</label>
  </div>
  <div class="flex justify-center">
    <button type="submit" class="w-1/2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        Login
    </button>
  </div>
</form>
