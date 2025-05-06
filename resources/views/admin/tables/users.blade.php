@php
    $breadcrumbs = \App\Helpers\BreadcrumbsHelper::generateBreadcrumbs(Route::currentRouteName());
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl " style="color: #3b1e54; margin-bottom: 20px;">
            {{ __('Users') }}
        </h2>
        <div style="display: flex; justify-content: space-between;">
            <ul class="breadcrumbs">
                @foreach ($breadcrumbs as $breadcrumb)
                    <li>
                        <a style="color: #3b1e54;" href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
                    </li>
                @endforeach
            </ul>
            <button class="btn btn-success" onclick="startTour()">Start Tour</button>
        </div>
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
                    <div class="card" data-intro="This is the Users management table" data-step="1">
                        <div class="card-body">

                            <form method="GET" action="{{ route('users.index') }}" class="mb-3">
                                <div class="row"
                                    data-intro="These are the filters, here u can filter the users according to there Name, Role, and Activity"
                                    data-step="2">

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

                                    <div class="col-md-2" data-toggle="modal"
                                        data-intro="By changing to Deleted Users u can see the all the soft deleted users"
                                        data-step="4">
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
                                data-intro="Here u can add new user" data-step="4" data-target="#createUserModal">
                                Add New User
                            </button>

                            <div class="table-responsive">
                                <table class="table table-bordered border-primary">
                                    <thead>
                                        <tr>
                                            <th><button type="button"
                                                    data-intro="Here u can change the order of the showed users to desc"
                                                    data-step="5"
                                                    style="border: 0px; background-color: transparent; margin-left: 5px;"
                                                    id="sortButton">
                                                    # ↓
                                                </button></th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Joining Date</th>
                                            <th>Points and Badges</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                @if ($user->role == 'admin')
                                                    <td style="background-color: #3b1e54; color: #EEEEEE;">{{ ucfirst($user->role) }}</td>
                                                    @elseif ($user->role == 'trainer')
                                                        <td style="background-color: #D4BEE4;">{{ ucfirst($user->role) }}</td>
                                                        @else
                                                        <td style="background-color: #EEEEEE;">{{ ucfirst($user->role) }}</td>
                                                @endif
                                                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                                <td data-intro="Here u can see the students points that they have earned for the last week and all the badges that they have earned"
                                                    data-step="6">
                                                    @if ($user->role == 'student')
                                                        <a href="{{ route('points', $user->id) }}"
                                                            class="btn btn-info">Points</a>
                                                            <a href="{{ route('users.badges', $user->id) }}" class="btn btn-info">
                                                                Badges
                                                            </a>
                                                    @else
                                                    Excluded from points
                                                    @endif
                                                    
                                                </td>
                                                <td>
                                                    {{-- Soft del And edit --}}
                                                    @if (!$user->trashed())
                                                        <div data-intro="Here u can Edit the user information or Delete the user (Deleting here will not be permanent here)"
                                                            data-step="7">
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
                                                        </div>
                                                    @endif
                                                    {{-- End Soft del And edit --}}

                                                    {{-- Restore and permanently del --}}
                                                    @if ($user->trashed())
                                                        <div data-intro="Here u can Restore deleted users or Deleting users permanently"
                                                            data-step="1">
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
                                                        </div>
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
                                                                        @if (auth()->check() && auth()->user()->role === 'admin')
                                                                        <option value="admin"
                                                                        {{ $user->role == 'admin' ? 'selected' : '' }}>
                                                                        Admin</option>
                                                                        <option value="trainer"
                                                                        {{ $user->role == 'trainer' ? 'selected' : '' }}>
                                                                        Trainer</option>
                                                                        @endif
                                                                        <option value="student"
                                                                            {{ $user->role == 'student' ? 'selected' : '' }}>
                                                                            Student</option>
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
                                @if (auth()->check() && auth()->user()->role === 'admin')
                                <option value="admin">Admin</option>
                                <option value="trainer">Trainer</option>
                                @endif
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
    <script>
        function startTour() {
            introJs().start();
        }
    </script>
</x-app-layout>
