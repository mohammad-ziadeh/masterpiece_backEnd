@php
    $breadcrumbs = \App\Helpers\BreadcrumbsHelper::generateBreadcrumbs(Route::currentRouteName());
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl" style="color: #3b1e54; margin-bottom: 20px;">
            {{ __('Announcements') }}
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

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" style="overflow: hidden;">
        <div class="p-4 sm:p-8 bg-white"
            style="margin-top: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <h3 class="font-bold text-lg mb-4" style="color: #3b1e54;">Create New Announcement</h3>
            <form action="{{ route('announcements.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" required
                                placeholder="Add title here." style="border-radius: 5px">
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="body">Message</label>
                            <textarea name="body" class="form-control rich-text" rows="5" required></textarea>
                            @error('body')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4"
                        style="background-color: #9b7ebd; color: #eeeeee; border-radius: 8px; padding: 0px 10px 0 10px;">
                        <button type="button" class="btn" id="selectAllBtn2"
                            style="margin-bottom: 20px;margin-top: 20px;color:#eeeeee; background-color: #3b1e54;">Select
                            All</button>
                        <div class="form-group checkbox-list2"
                            style="max-height: 400px; overflow-y: auto; padding-right: 10px; scrollbar-width: none; -ms-overflow-style: none;">
                            @foreach ($students as $student)
                                <div class="form-check">
                                    <input type="checkbox" name="user_ids[]" value="{{ $student->id }}"
                                        class="form-check-input">
                                    <label class="form-check-label">{{ $student->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Send Announcement</button>
            </form>



        </div>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" style="overflow: hidden;">
        <div class="p-4 sm:p-8 bg-white"
            style="margin-top: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <h3 class="font-bold text-lg mb-4" style="color: #3b1e54;">Existing
                Announcements</h3>
            @forelse ($announcements as $announcement)
                <div class="card mb-3 position-relative d-flex flex-row"
                    style="border-left: 5px solid #3b1e54; background-color: #f9f9f9; border-radius: 8px;">
                    <div class="card-body col-md-8">
                        <h1 style="font-size: 34px" class="card-title font-bold">{{ $announcement->title }}</h1>
                        <div class="card-text announcement-body">
                            {!! $announcement->body !!}
                            <div class="hr-container">
                                <span>★★★</span>
                            </div>
                            <div style="display: flex; justify-content: space-around;">
                                <div style="font-size: large; font-weight: bold; color: #3b1e54;">Published At:
                                {{ $announcement->created_at }}</div>
                            <div style="font-size: large; font-weight: bold; color: #3b1e54;">Published By:
                                {{ $announcement->creator?->name }}</div>
                            </div>
                            
                        </div>
                        <div class="position-absolute" style="top: 10px; right: 10px;">
                            <button class="btn btn-sm btn-warning" data-toggle="modal"
                                data-target="#editAnnouncementModal{{ $announcement->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form id="perDelete-form-{{ $announcement->id }}"
                                action="{{ route('announcements.destroy', $announcement) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button type="button" class="btn btn-sm btn-danger"
                                onclick="confirmPerDelete({{ $announcement->id }})">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4 p-3"
                        style="max-height: 250px; overflow-y: auto; border-left: 1px solid #ddd; margin-top: 10px;">
                        <strong>Assigned Students:</strong>
                        <ul class="list-unstyled mt-2 mb-0">
                            @foreach ($announcement->users as $user)
                                <li>{{ $user->name }}</li>
                            @endforeach
                        </ul>

                    </div>


                </div>


                {{-- // {{Edit announcements}} // --}}
                <div class="modal fade" id="editAnnouncementModal{{ $announcement->id }}" tabindex="-1"
                    aria-labelledby="editAnnouncementLabel{{ $announcement->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="{{ route('announcements.update', $announcement) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editAnnouncementLabel{{ $announcement->id }}">
                                        Edit
                                        Announcement</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group mb-3">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" class="form-control"
                                            value="{{ old('title', $announcement->title) }}" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="body">Message</label>
                                        <textarea name="body" class="form-control rich-text" rows="5">{{ old('body', $announcement->body) }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Assign to Students</label>
                                        <div class="checkbox-list" id="checkboxList_{{ $announcement->id }}"
                                            style="max-height: 200px; overflow-y: auto; padding-right: 10px;">
                                            <button type="button" class="btn btn-primary"
                                                id="selectAllBtn_{{ $announcement->id }}">Select All</button>
                                            @foreach ($students as $student)
                                                <div class="form-check">
                                                    <input type="checkbox" name="user_ids[]"
                                                        value="{{ $student->id }}" class="form-check-input"
                                                        {{ $announcement->users->contains('id', $student->id) ? 'checked' : '' }}>
                                                    <label class="form-check-label">{{ $student->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- // {{ End Edit announcements}} // --}}
            @empty
                <p class="text-muted">No announcements yet.</p>
            @endforelse
        </div>
    </div>



    {{-- //{{tinymce}}// --}}
    <script src="https://cdn.tiny.cloud/1/ixz84n4ps84qx8fi9gl66lk86nu1ujpl53f2sk393ngqyh2l/tinymce/6/tinymce.min.js "
        referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: '.rich-text',
            plugins: [
                'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'link', 'lists',
                'searchreplace', 'table', 'visualblocks', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | bold italic underline strikethrough | link image media table | bullist numlist | emoticons charmap | removeformat',
            menubar: false,
            height: 400,
            max_chars: 15000,
            setup: function(editor) {
                editor.on('change', function() {
                    editor.save();
                });
            }
        });
    </script>

    <script>
        document.querySelector('form')?.addEventListener('submit', function() {
            tinymce.triggerSave();
        });
    </script>

    {{-- //{{ End tinymce }}// --}}

    <style>
        .hr-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px 0;
        }

        .hr-container::before,
        .hr-container::after {
            content: "";
            flex: 1;
            border-bottom: 2px solid #ccc;
            margin: 0 10px;
        }

        .hr-container span {
            font-size: 18px;
            color: #3b1e54;
        }
    </style>
    <script>
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
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllButtons = document.querySelectorAll('button[id^="selectAllBtn_"]');
            selectAllButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const taskId = this.id.split('_')[1];
                    const container = document.getElementById('checkboxList_' + taskId);
                    const checkboxes = container.querySelectorAll('.form-check-input');
                    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                    checkboxes.forEach(cb => {
                        cb.checked = !allChecked;
                    });
                    this.textContent = allChecked ? 'Select All' : 'Deselect All';
                });
            });

            const selectAllBtnCreate = document.getElementById('selectAllBtn2');
            const checkboxesCreate = document.querySelectorAll('.checkbox-list2 .form-check-input');
            if (selectAllBtnCreate && checkboxesCreate.length > 0) {
                selectAllBtnCreate.addEventListener('click', function() {
                    const allChecked = Array.from(checkboxesCreate).every(cb => cb.checked);
                    checkboxesCreate.forEach(cb => {
                        cb.checked = !allChecked;
                    });
                    this.textContent = allChecked ? 'Select All' : 'Deselect All';
                });
            }
        });
    </script>
</x-app-layout>
