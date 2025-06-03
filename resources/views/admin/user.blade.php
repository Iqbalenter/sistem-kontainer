@extends('layouts.app')

@section('content')
    @include('components.admin_side')
    
    <!-- Main Content -->
    @include('components.users')

    @push('scripts')
    <script>
        // Fungsi untuk membuka modal tambah user
        document.getElementById('addUserBtn').addEventListener('click', function() {
            document.getElementById('modalTitle').textContent = 'Tambah User Baru';
            document.getElementById('userForm').reset();
            document.getElementById('userId').value = '';
            document.getElementById('password').required = true;
        });

        // Fungsi untuk edit user
        document.querySelectorAll('.edit-user').forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-user-id');
                document.getElementById('modalTitle').textContent = 'Edit User';
                document.getElementById('password').required = false;
                
                fetch(`/admin/user/${userId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('userId').value = data.id;
                        document.getElementById('name').value = data.name;
                        document.getElementById('email').value = data.email;
                        document.getElementById('role').value = data.role;
                    });
            });
        });

        // Handle form submission
        document.getElementById('userForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const userId = document.getElementById('userId').value;
            const method = userId ? 'PUT' : 'POST';
            const url = userId ? `/admin/user/${userId}` : '/admin/user';

            fetch(url, {
                method: method,
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    location.reload();
                }
            });
        });

        // Fungsi untuk delete user
        function deleteUser(id) {
            if(confirm('Apakah Anda yakin ingin menghapus user ini?')) {
                fetch(`/admin/user/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        location.reload();
                    }
                });
            }
        }

        // Fungsi pencarian
        document.getElementById('table-search').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('tbody tr');
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchText) ? '' : 'none';
            });
        });
    </script>
    @endpush
@endsection 