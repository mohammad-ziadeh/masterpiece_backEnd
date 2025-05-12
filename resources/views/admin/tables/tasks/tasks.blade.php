@php
    $breadcrumbs = \App\Helpers\BreadcrumbsHelper::generateBreadcrumbs(Route::currentRouteName());
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl " style="color: #3b1e54; margin-bottom: 20px;">
            {{ __('Tasks') }}
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
                    <div class="card" data-intro="This is the Tasks management table" data-step="1">
                        <div class="card-body">

                            {{-- Start Filters --}}
                            <form method="GET" action="{{ route('tasks.index') }}" class="mb-3">
                                <div class="row"
                                    data-intro="These are the filters, here u can filter the Tasks according to there Name and Activity"
                                    data-step="2">

                                    <div class="col-md-2">
                                        <input type="text" name="name" class="form-control"
                                            style="border-radius: 5px" placeholder="Search Task"
                                            value="{{ request('name') }}">
                                    </div>

                                    <div class="col-md-2">
                                        <select name="deleted" class="form-control">
                                            <option value="">Active Tasks</option>
                                            <option value="only" {{ request('deleted') == 'only' ? 'selected' : '' }}>
                                                Deleted Tasks</option>
                                            <option value="with" {{ request('deleted') == 'with' ? 'selected' : '' }}>
                                                All Tasks</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 ">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </form>
                            {{-- End Filters --}}

                            {{-- Create button --}}
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <button type="button" class="btn btn-success mb-3" data-toggle="modal"
                                    data-intro="Here u can add new task" data-step="3" data-target="#createTaskModal">
                                    Add New Task
                                </button>
                                @if (request()->get('deleted') == 'only')
                                    <form action="{{ route('tasks.emptyDeleted') }}" method="POST"
                                        onclick="confirmPerDeleteAll('all')" id="perDeleteAll">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger">Delete All</button>
                                    </form>
                                @endif
                            </div>
                            {{-- End Create button --}}


                            <div class="table-responsive">
                                <table class="table table-bordered border-primary">
                                    <thead>
                                        <tr>
                                            <th title="Press reset to reset "><button type="button"
                                                    data-intro="Here u can change the order of the showed tasks to desc"
                                                    data-step="4"
                                                    style="border: 0px; background-color: transparent; margin-left: 5px;"
                                                    id="sortButton"># ↓</button></th>
                                            <th>Task Name</th>
                                            <th>Due Date</th>
                                            <th>Created At</th>
                                            <th data-intro="Here u can see the full description of the task from the file it self to all the assigned students"
                                                data-step="5">Details</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tasks as $task)
                                            <tr>
                                                <td> {{ $task->id }}</td>
                                                <td>{{ $task->name }}</td>
                                                <td>{{ $task->due_date }}</td>
                                                <td>{{ $task->created_at->format('Y-m-d') }}</td>
                                                <td>
                                                    <a href="{{ route('tasks.show', $task->id) }}"
                                                        class="btn btn-secondary">
                                                        View
                                                    </a>
                                                </td>
                                                <td>

                                                    {{-- Soft del And edit --}}

                                                    @if (!$task->trashed())
                                                        <div data-intro="Here u can Edit the tasks information or Delete the tasks (Deleting here will not be permanent here)"
                                                            data-step="6">
                                                            <button type="button" class="btn btn-primary"
                                                                data-toggle="modal"
                                                                data-target="#editTaskModal{{ $task->id }}">
                                                                Edit
                                                            </button>
                                                            <form id="delete-form-{{ $task->id }}"
                                                                action="{{ route('tasks.destroy', $task->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-danger"
                                                                    onclick="confirmDelete({{ $task->id }})"
                                                                    title="Temporarily Remove">
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                    {{-- end Soft del And edit --}}

                                                    {{-- Restore and delete permanently --}}
                                                    @if ($task->trashed())
                                                        <div data-intro="Here u can Restore deleted tasks or Deleting tasks permanently"
                                                            data-step="1">
                                                            <form action="{{ route('tasks.restore', $task->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                <button type="submit" class="btn btn-warning"
                                                                    title="Restore the Task">Restore</button>
                                                            </form>
                                                            <form
                                                                action="{{ route('tasks.deletePermanently', $task->id) }}"
                                                                method="POST" style="display:inline;"
                                                                id="perDelete-form-{{ $task->id }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-danger"
                                                                    title="Delete Permanently"
                                                                    onclick="confirmPerDelete({{ $task->id }})">Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                    {{-- end Restore and delete permanently --}}
                                                </td>
                                            </tr>
                                            {{-- Edit Task --}}
                                            <div class="modal fade" id="editTaskModal{{ $task->id }}"
                                                tabindex="-1" role="dialog"
                                                aria-labelledby="editTaskModalLabel{{ $task->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <form action="{{ route('tasks.update', $task->id) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="form-group">
                                                                    <label for="name">Name</label>
                                                                    <input type="text" id="name"
                                                                        class="form-control" name="name"
                                                                        value="{{ $task->name }}" required>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="pdf">Choose a file (should be
                                                                        pdf)</label>
                                                                    <input type="file" accept=".pdf"
                                                                        name="pdf" id="pdf"
                                                                        class="form-control">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="taskDueDate">Due Date</label>
                                                                    <input type="datetime-local" class="form-control"
                                                                        min="{{ date('Y-m-d\TH:i') }}"
                                                                        name="due_date" id="taskDueDate" required
                                                                        value="{{ $task->due_date }}">
                                                                </div>

                                                                <label for="taskDescription">Description</label>
                                                                @php $inputId = 'desc_' . $task->id; @endphp
                                                                <textarea class="form-control " name="description" maxlength="1000" oninput="updateCounter(this)"
                                                                    id="{{ $inputId }}" id="taskDescription" rows="3">
                                                                            {{ $task->description }}
                                                                </textarea>
                                                                <small id="{{ $inputId }}-counter"
                                                                    style="text-align: right; color: gray;">
                                                                    {{ strlen($task->description ?? '') }} / 1000
                                                                </small>



                                                                <div class="form-group">
                                                                    <label for="assigned_to">Assign to Students</label>
                                                                    <div class="checkbox-list"
                                                                        id="checkboxList_{{ $task->id }}"
                                                                        style="max-height: 200px; overflow-y: auto; padding-right: 10px;">
                                                                        <button type="button" class="btn btn-primary"
                                                                            id="selectAllBtn_{{ $task->id }}">Select
                                                                            All</button>

                                                                        @foreach ($students as $student)
                                                                            <div class="form-check">
                                                                                <input type="checkbox"
                                                                                    name="assigned_to[]"
                                                                                    id="assigned_to_{{ $student->id }}"
                                                                                    value="{{ $student->id }}"
                                                                                    class="form-check-input"
                                                                                    @if ($task->students->contains('id', $student->id)) checked @endif>
                                                                                <label
                                                                                    for="assigned_to_{{ $student->id }}"
                                                                                    class="form-check-label">
                                                                                    {{ $student->name }}
                                                                                </label>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>

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
                                            {{-- End Edit Task   --}}
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-center mt-3">
                                {{ $tasks->links('pagination::bootstrap-4') }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createTaskModal" tabindex="-1" role="dialog"
        aria-labelledby="createTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="taskName">Task Name</label>
                            <input type="text" class="form-control" name="name" id="taskName" required>
                        </div>

                        <div class="form-group">
                            <label for="taskDescription">Description</label>
                            @php $inputId = 'desc_new'; @endphp
                            <textarea class="form-control" maxlength="1000" oninput="updateCounter2(this)" id="{{ $inputId }}"
                                name="description" required></textarea>
                            <small id="{{ $inputId }}-2counter" style="text-align: right; color: gray;">0 /
                                1000</small>
                        </div>

                        <div class="form-group">
                            <label for="pdf">Choose a file (should be PDF)</label>
                            <input type="file" accept=".pdf" name="pdf" id="pdf"
                                class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="taskDueDate">Due Date</label>
                            <input type="datetime-local" class="form-control" min="{{ date('Y-m-d\TH:i') }}"
                                name="due_date" id="taskDueDate" required>
                        </div>

                        <div class="form-group">
                            <div style="display: flex; justify-content: space-between;">
                                <label for="assigned_to">Assign to Students:</label>
                                <button type="button" class="btn btn-primary" style="margin-bottom: 10px"
                                    id="selectAllBtn2">Select
                                    All</button>
                            </div>

                            <div class="checkbox-list2"
                                style="max-height: 200px; overflow-y: auto; padding-right: 10px;">


                                @foreach ($students as $student)
                                    @if ($tasks->isNotEmpty())
                                        <div class="form-check">

                                            <input type="checkbox" name="assigned_to[]"
                                                id="assigned_to_{{ $student->id }}" value="{{ $student->id }}"
                                                class="form-check-input"
                                                @if ($task->students->contains('id', $student->id)) checked @endif>
                                            <label for="assigned_to_{{ $student->id }}" class="form-check-label">
                                                {{ $student->name }}
                                            </label>
                                        </div>
                                    @else
                                        <h3>no data</h3>
                                    @endif
                                @endforeach
                            </div>
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

    {{-- End Create Task Modal  --}}


    {{-- Styles --}}
    <style>
        #sortButton:hover {
            color: #b775f0;
        }
    </style>
    {{-- Style --}}



    {{-- JavaScript  --}}
    <script>
        document.getElementById('sortButton').addEventListener('click', function() {
            window.location.href = "{{ route('tasks.index') }}?sort=desc";
        });


        // Confirm delete SweetAlerts
        function confirmDelete(taskId) {
            Swal.fire({
                title: "Are you sure?",
                text: "You will delete this task",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + taskId).submit();
                }
            });
        }

        function confirmPerDelete(taskId) {
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
                    document.getElementById('perDelete-form-' + taskId).submit();
                }
            });
        }

        function confirmPerDeleteAll(message) {
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
                    document.getElementById('perDeleteAll').submit();
                }
            });
        }


        // Success and error message up under nav
        setTimeout(function() {
            $('#successMessage').fadeOut('slow');
            $('#errorMessage').fadeOut('slow');
        }, 3000);
    </script>

    {{-- select all checkboxes --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllButtons = document.querySelectorAll('button[id^="selectAllBtn_"]');

            selectAllButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const taskId = button.id.split('_')[1];
                    const checkboxContainer = document.getElementById('checkboxList_' + taskId);
                    const checkboxes = checkboxContainer.querySelectorAll('input[type="checkbox"]');

                    let allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);

                    checkboxes.forEach(checkbox => {
                        checkbox.checked = !allChecked;
                    });

                    button.textContent = allChecked ? 'Select All' : 'Deselect All';
                });
            });

            const selectAllBtnCreate = document.getElementById('selectAllBtn2');
            const checkboxesCreate = document.querySelectorAll('.checkbox-list2 input[type="checkbox"]');

            if (selectAllBtnCreate) {
                selectAllBtnCreate.addEventListener('click', function() {
                    let allChecked = Array.from(checkboxesCreate).every(checkbox => checkbox.checked);

                    checkboxesCreate.forEach(checkbox => {
                        checkbox.checked = !allChecked;
                    });

                    selectAllBtnCreate.textContent = allChecked ? 'Select All' : 'Deselect All';
                });
            }
        });
    </script>

    {{-- end select all checkboxes --}}


    <script>
        function updateCounter(input) {
            const counter = document.getElementById(input.id + '-counter');
            counter.textContent = `${input.value.length} / ${input.maxLength}`;
        }

        function updateCounter2(input) {
            const counter = document.getElementById(input.id + '-2counter');
            counter.textContent = `${input.value.length} / ${input.maxLength}`;
        }
    </script>
    <script>
        function startTour() {
            introJs().start();
        }
    </script>

</x-app-layout>
