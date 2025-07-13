<!DOCTYPE html>
<html>
<head>
    <title>Laporan Retrieval</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #38bdf8;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #38bdf8;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }
        .filter-info {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #38bdf8;
        }
        .filter-info strong {
            color: #38bdf8;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }
        th {
            background-color: #38bdf8;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .status {
            padding: 3px 8px;
            border-radius: 3px;
            color: white;
            font-size: 10px;
            font-weight: bold;
        }
        .status-pending {
            background-color: #fbbf24;
        }
        .status-approved {
            background-color: #10b981;
        }
        .status-rejected {
            background-color: #ef4444;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .summary-item {
            text-align: center;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            flex: 1;
            margin: 0 5px;
        }
        .summary-item h3 {
            margin: 0;
            color: #38bdf8;
        }
        .summary-item p {
            margin: 5px 0 0 0;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN RETRIEVAL CONTAINER</h1>
        <p>PELINDO - Sistem Manajemen Kontainer</p>
        <p>Tanggal Cetak: {{ date('d F Y') }}</p>
    </div>

    <div class="filter-info">
        <strong>Filter: </strong>{{ $filterText }}
    </div>

    <div class="summary">
        <div class="summary-item">
            <h3>{{ $retrievals->where('status', 'pending')->count() }}</h3>
            <p>Pending</p>
        </div>
        <div class="summary-item">
            <h3>{{ $retrievals->where('status', 'approved')->count() }}</h3>
            <p>Approved</p>
        </div>
        <div class="summary-item">
            <h3>{{ $retrievals->where('status', 'rejected')->count() }}</h3>
            <p>Rejected</p>
        </div>
        <div class="summary-item">
            <h3>{{ $retrievals->count() }}</h3>
            <p>Total</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Container Number</th>
                <th>Container Name</th>
                <th>License Plate</th>
                <th>Retrieval Date</th>
                <th>Status</th>
                <th>Notes</th>
                <th>Request Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($retrievals as $index => $retrieval)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $retrieval->container_number }}</td>
                    <td>{{ $retrieval->container_name }}</td>
                    <td>{{ $retrieval->license_plate }}</td>
                    <td>{{ $retrieval->retrieval_date->format('d/m/Y') }}</td>
                    <td>
                        <span class="status status-{{ $retrieval->status }}">
                            {{ ucfirst($retrieval->status) }}
                        </span>
                    </td>
                    <td>{{ $retrieval->notes ?? '-' }}</td>
                    <td>{{ $retrieval->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #666;">Tidak ada data retrieval</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini digenerate otomatis oleh sistem pada {{ date('d F Y H:i:s') }}</p>
    </div>
</body>
</html> 