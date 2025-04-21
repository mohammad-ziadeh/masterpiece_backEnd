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
                        <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
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
                                            <th data-intro="Here u can check the tasks pdf and view it by clicking on the eye icon"
                                                data-step="5">Task file</th>
                                            <th data-intro="Here u can see the full description of the task by clicking on the down arrow icon"
                                                data-step="6">Description</th>
                                            <th>Due Date</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tasks as $task)
                                            <tr>
                                                <td> {{ $task->id }}</td>
                                                <td>{{ $task->name }}</td>
                                                <td>
                                                    @if ($task->pdf_path)
                                                        <button title="See the PDF"
                                                            style="margin-left:35%; border:0px;background-color:transparent"
                                                            data-toggle="modal"
                                                            data-target="#showPdf{{ $task->id }}">
                                                            <i style="font-size: large;" class="fa fa-eye"></i>
                                                        </button>
                                                    @else
                                                        No file available
                                                    @endif
                                                </td>
                                                <td title="See the description" class="task-row"
                                                    data-id="{{ $task->id }}"><i style="margin-left:40%"
                                                        class="fa-solid fa-chevron-down"></i>
                                                </td>
                                                <td>{{ $task->due_date }}</td>
                                                <td>{{ $task->created_at->format('Y-m-d') }}</td>
                                                <td>

                                                    {{-- Soft del And edit --}}

                                                    @if (!$task->trashed())
                                                        <div data-intro="Here u can Edit the tasks information or Delete the tasks (Deleting here will not be permanent here)"
                                                            data-step="7">
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


                                            {{-- Task Description --}}
                                            <tr class="task-details" id="task-details-{{ $task->id }}"
                                                style="display:none;">
                                                <td colspan="7">
                                                    <strong>Task Description:</strong>
                                                    <p>{{ $task->description }}</p>
                                                </td>
                                            </tr>
                                            {{-- End Task Description --}}

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
                                                                    <input type="date" class="form-control"
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

                                            {{-- Show PDF Modal --}}
                                            @if ($task->pdf_path)
                                                <div class="modal fade" id="showPdf{{ $task->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="showPdfLabel{{ $task->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-body p-0">
                                                                <iframe id="pdfIframe"
                                                                    src="{{ asset('storage/' . $task->pdf_path) }}"
                                                                    width="100%" height="500px"
                                                                    style="border: none;"></iframe>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            {{-- End Show PDF Modal --}}
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

    <!-- Create Task Modal -->
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
                                name="description" id="taskDescription" required></textarea>
                            <small id="{{ $inputId }}-2counter" style="text-align: right; color: gray;">
                                0 / 1000
                            </small>
                        </div>
                        <div class="form-group">
                            <label for="pdf">Choose a file (should be pdf)</label>
                            <input type="file" accept=".pdf" name="pdf" id="pdf"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="taskDueDate">Due Date</label>
                            <input type="date" class="form-control" name="due_date" id="taskDueDate" required>
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



        // Expanded row js 
        $(document).ready(function() {
            $('.task-row').on('click', function() {
                var taskId = $(this).data('id');
                var detailsRow = $('#task-details-' + taskId);

                detailsRow.stop(true, true).slideToggle(10);
            });
        });
    </script>




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
