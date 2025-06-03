<!-- First row - 3 columns -->
<div class="grid grid-cols-3 gap-4 mb-4">
    <!-- Card 1 - Inbound Containers Today -->
    <div class="bg-blue-700 text-white p-6 relative">
        <p class="font-bold text-lg">{{ $inboundToday }}</p>
        <p class="mt-1 text-sm">Inbound Containers Today</p>
        <i class="fas fa-boxes absolute bottom-4 right-4 text-white text-xl"></i>
    </div>
    <!-- Card 2 - Awaiting Confirmation -->
    <div class="bg-red-600 text-white p-6 relative">
        <p class="font-bold text-lg">{{ $awaitingConfirmation }}</p>
        <p class="mt-1 text-sm">Containers Awaiting Confirmation</p>
        <i class="fas fa-truck absolute bottom-4 right-4 text-white text-xl"></i>
    </div>
    <!-- Card 3 - Outbound Today -->
    <div class="bg-red-600 text-white p-6 relative">
        <p class="font-bold text-lg">{{ $outboundToday }}</p>
        <p class="mt-1 text-sm">Retrieval of Container Today</p>
        <i class="fas fa-boxes absolute bottom-4 right-4 text-white text-xl"></i>
    </div>
    <!-- Card 4 - Block A -->
    <div class="bg-blue-700 text-white p-6 relative">
        <p class="font-bold text-lg">{{ $containersPerBlock['A'] ?? 0 }}</p>
        <p class="mt-1 text-sm">Block A</p>
        <i class="fas fa-boxes absolute bottom-4 right-4 text-white text-xl"></i>
    </div>
    <!-- Card 5 - Block B -->
    <div class="bg-red-600 text-white p-6 relative">
        <p class="font-bold text-lg">{{ $containersPerBlock['B'] ?? 0 }}</p>
        <p class="mt-1 text-sm">Block B</p>
        <i class="fas fa-boxes absolute bottom-4 right-4 text-white text-xl"></i>
    </div>
    <!-- Card 6 - Block C -->
    <div class="bg-red-600 text-white p-6 relative">
        <p class="font-bold text-lg">{{ $containersPerBlock['C'] ?? 0 }}</p>
        <p class="mt-1 text-sm">Block C</p>
        <i class="fas fa-boxes absolute bottom-4 right-4 text-white text-xl"></i>
    </div>
    <!-- Card 7 - Block D -->
    <div class="bg-blue-700 text-white p-6 relative">
        <p class="font-bold text-lg">{{ $containersPerBlock['D'] ?? 0 }}</p>
        <p class="mt-1 text-sm">Block D</p>
        <i class="fas fa-boxes absolute bottom-4 right-4 text-white text-xl"></i>
    </div>
    <!-- Card 8 - Block E -->
    <div class="bg-red-600 text-white p-6 relative">
        <p class="font-bold text-lg">{{ $containersPerBlock['E'] ?? 0 }}</p>
        <p class="mt-1 text-sm">Block E</p>
        <i class="fas fa-boxes absolute bottom-4 right-4 text-white text-xl"></i>
    </div>
    <!-- Card 9 - Total Users -->
    <div class="bg-red-600 text-white p-6 relative">
        <p class="font-bold text-lg">{{ $totalUsers }}</p>
        <p class="mt-1 text-sm">Total Users</p>
        <i class="fas fa-user absolute bottom-4 right-4 text-white text-xl"></i>
    </div>
</div>