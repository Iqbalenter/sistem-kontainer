<!-- Retrieval Form -->
<div class="w-full mx-auto">
    <form action="{{ route('retrieval.store') }}" method="POST" class="w-full mx-auto">
        @csrf
        <div class="mb-5">
            <label for="container_number" class="block mb-2 text-sm font-medium text-black dark:text-black">No Peti Kemas</label>
            <input type="text" id="container_number" name="container_number" placeholder="No Peti Kemas" class="bg-white-50 border border-white-300 text-white-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-black-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
        </div>
        <div class="mb-5">
            <label for="container_name" class="block mb-2 text-sm font-medium text-black dark:text-black">Nama Peti Kemas</label>
            <input type="text" id="container_name" name="container_name" placeholder="TANTO, MAERSK" class="bg-white-50 border border-white-300 text-white-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-black-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
        </div>
        <div class="mb-5">
            <label for="license_plate" class="block mb-2 text-sm font-medium text-black dark:text-black">Nomor Plat Kendaraan</label>
            <input type="text" id="license_plate" name="license_plate" placeholder="Nomor Plat Kendaraan" class="bg-white-50 border border-white-300 text-white-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-black-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
        </div>
        <div class="mb-5">
            <label for="retrieval_date" class="block mb-2 text-sm font-medium text-black dark:text-black">Tanggal Pengambilan</label>
            <input type="date" id="retrieval_date" name="retrieval_date" class="bg-white-50 border border-white-300 text-white-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-black-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
        </div>
        <div class="flex justify-center">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit Retrieval Request</button>
        </div>
    </form>

    @if ($errors->any())
        <div class="mt-4 p-4 bg-red-100 rounded-lg">
            <ul class="list-disc list-inside text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="mt-4 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mt-4 p-4 bg-red-100 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif
</div>
