@php
    $breadcrumbs = \App\Helpers\BreadcrumbsHelper::generateBreadcrumbs(Route::currentRouteName());
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl " style="color: #3b1e54; margin-bottom: 20px;">
            {{ __('Users') }}
        </h2>
        <ul class="breadcrumbs">
            @foreach ($breadcrumbs as $breadcrumb)
                <li>
                    <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
                </li>
            @endforeach
        </ul>
    </x-slot>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="successMessage">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorMessage">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" style="overflow: hidden;">
        <div class="p-4 sm:p-8 bg-white" style="margin-top: 20px; ">

            <div class="row">
                <div class="col grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">

                            <form method="GET" action="{{ route('users.index') }}" class="mb-3">
                                <div class="row">

                                    <div class="col-md-2">
                                        <input type="text" name="name" class="form-control"
                                            style="border-radius: 5px" placeholder="Search Name"
                                            value="{{ request('name') }}">
                                    </div>

                                    <div class="col-md-2">
                                        <select name="role" class="form-control">
                                            <option value="all">All Roles</option>

                                            <option value="student"
                                                {{ request('role') == 'student' ? 'selected' : '' }}>Student</option>
                                            <option value="trainer"
                                                {{ request('role') == 'trainer' ? 'selected' : '' }}>Trainer</option>
                                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>
                                                Admin</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <select name="deleted" class="form-control">
                                            <option value="">Active Users</option>
                                            <option value="only"
                                                {{ request('deleted') == 'only' ? 'selected' : '' }}>
                                                Deleted Users</option>
                                            <option value="with"
                                                {{ request('deleted') == 'with' ? 'selected' : '' }}>
                                                All Users</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 ">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </form>



                            <button type="button" class="btn btn-success mb-3" data-toggle="modal"
                                data-target="#createUserModal">
                                Add New User
                            </button>

                            <div class="table-responsive">
                                <table class="table table-bordered border-primary">
                                    <thead>
                                        <tr>
                                            <th><button type="button"
                                                    style="border: 0px; background-color: transparent; margin-left: 5px;"
                                                    id="sortButton">
                                                    # ↓
                                                </button></th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Joining Date</th>
                                            <th>Points</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ ucfirst($user->role) }}</td>
                                                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                                <td>
                                                    <a href="{{ route('tables.points', $user->id) }}"
                                                        class="btn btn-info">View Points</a>
                                                </td>
                                                <td>
                                                    {{-- Soft del And edit --}}
                                                    @if (!$user->trashed())
                                                        <button type="button" class="btn btn-primary"
                                                            data-toggle="modal"
                                                            data-target="#editUserModal{{ $user->id }}">
                                                            Edit
                                                        </button>
                                                        <form id="delete-form-{{ $user->id }}"
                                                            action="{{ route('users.destroy', $user->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger"
                                                                onclick="confirmDelete({{ $user->id }})"
                                                                title="Temporarily Remove">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    @endif
                                                    {{-- End Soft del And edit --}}

                                                    {{-- Restore and permanently del --}}
                                                    @if ($user->trashed())
                                                        <form action="{{ route('users.restore', $user->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-warning"
                                                                title="Restore the User">Restore</button>
                                                        </form>
                                                        <form
                                                            action="{{ route('users.deletePermanently', $user->id) }}"
                                                            method="POST" style="display:inline;"
                                                            id="perDelete-form-{{ $user->id }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger"
                                                                title="Delete Permanently"
                                                                onclick="confirmPerDelete({{ $user->id }})">Delete</button>
                                                        </form>
                                                    @endif
                                                    {{-- End Restore and permanently del --}}
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="editUserModal{{ $user->id }}"
                                                tabindex="-1" role="dialog"
                                                aria-labelledby="editUserModalLabel{{ $user->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <form action="{{ route('users.update', $user->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="form-group">
                                                                    <label for="name">Name</label>
                                                                    <input type="text" class="form-control"
                                                                        name="name" value="{{ $user->name }}"
                                                                        required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="email">Email</label>
                                                                    <input type="email" class="form-control"
                                                                        name="email" value="{{ $user->email }}"
                                                                        required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="role">Role</label>
                                                                    <select class="form-control" name="role"
                                                                        required>
                                                                        <option value="admin"
                                                                            {{ $user->role == 'admin' ? 'selected' : '' }}>
                                                                            Admin</option>
                                                                        <option value="student"
                                                                            {{ $user->role == 'student' ? 'selected' : '' }}>
                                                                            Student</option>
                                                                        <option value="trainer"
                                                                            {{ $user->role == 'trainer' ? 'selected' : '' }}>
                                                                            Trainer</option>
                                                                    </select>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Update</button>
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-center mt-3">
                                {{ $users->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog"
        aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-control" name="role" required>
                                <option value="student">Student</option>
                                <option value="admin">Admin</option>
                                <option value="trainer">Trainer</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Create</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Style --}}

    <style>
        #sortButton:focus {
            outline: none;
        }

        #sortButton:hover {
            color: #b775f0;

        }
    </style>
    {{-- Style --}}



    {{-- JavaScript  --}}
    <script>
        document.getElementById('sortButton').addEventListener('click', function() {
            window.location.href = "{{ route('users.index') }}?sort=desc";
        });

        function confirmDelete(userId) {
            Swal.fire({
                title: "Are you sure?",
                text: "You will delete this user",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + userId).submit();
                }
            });
        }

        function confirmPerDelete(userId) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('perDelete-form-' + userId).submit();
                }
            });
        }

        setTimeout(function() {
            $('#successMessage').fadeOut('slow');
            $('#errorMessage').fadeOut('slow');
        }, 3000);
    </script>
</x-app-layout>
