@php
    $breadcrumbs = \App\Helpers\StudentBreadcrumbsHelper::generateBreadcrumbs(Route::currentRouteName());
@endphp
<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between;">
            <h2 class="font-semibold text-xl" style="color: #3b1e54; margin-bottom: 20px;">
                {{ $task->name }}
            </h2>
            <button class="btn btn-success" onclick="startTour()">Start Tour</button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg"
                data-intro="Here you will see all the needed information's that you need about the task" data-step="1">
                <div class="product-img" data-intro="Here you will see the task pdf (if there is)" data-step="2">
                    @if ($task->pdf_path)
                        <iframe src="{{ asset('storage/' . $task->pdf_path) }}" width="100%" height="100%"
                            style="border-radius: 7px 0 0 7px;"></iframe>
                    @else
                        <div class="flex items-center justify-center h-full text-gray-400">
                            No PDF Available
                        </div>
                    @endif
                </div>
                <div class="product-info" data-intro="Here are the information's" data-step="3">
                    <div class="product-text">
                        <h1><b>Task name:</b> {{ $task->name }}</h1>
                        <h2 style="margin-top: 20px"><b>Submitted by:</b> {{ $task->submittedBy->name ?? 'unknown' }}
                        </h2>
                        <h2><b>The deadline:</b> <mark style="background-color: yellow">
                                {{ $task->due_date }}</mark> </h2>
                        <h2 style="margin: 0%; margin-left: 38px;"><b>Description:</b> </h2>
                        <p>{{ $task->description }}</p>
                    </div>

                </div>
                <a href="{{ route('submissions.index') }}" class="btn btn-secondary mt-3 d-block d-sm-none">Back</a>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="margin-top: 40px">
            <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg" style="padding: 20px"
                data-intro="Here you will see all of your previous submissions to this task" data-step="4">
                @if ($submissions->isEmpty())
                    <p class="text-gray-500">No submissions yet.</p>
                @else
                    @foreach ($submissions as $submission)
                        <ul style="list-style: none; padding-left: 0;">
                            @if ($submission->pdf_path)
                                <li
                                    style="margin: 10px 0; padding: 10px; border: 1px solid #ccc; border-radius: 8px; display: flex; justify-content: space-between;">
                                    <strong style="margin-right: 10px">Assignment file:</strong>
                                    <a href="{{ asset('storage/' . $submission->pdf_path) }}" target="_blank"
                                        class="text-blue-600 hover:underline">
                                        {{ basename($submission->pdf_path) }}
                                    </a>
                                </li>
                            @endif
                            <li
                                style="margin: 10px 0; padding: 10px; border: 1px solid #ccc; border-radius: 8px; display: flex; justify-content: space-between;">
                                <strong>
                                    @if (Str::contains($submission->answer, 'https://'))
                                        <a href="{{ $submission->answer }}"
                                            target="_blank">{{ $submission->answer }}</a>
                                    @else
                                        {{ $submission->answer }}
                                    @endif
                                </strong>
                                @if ($submission->created_at <= $task->due_date)
                                    <div style="color: gray; font-weight: bold;">Due by:
                                        {{ \Carbon\Carbon::parse($submission->created_at)->format('d M Y h:i A') }}
                                    </div>
                                @else
                                    <div style="color: red; font-weight: bold;">Overdue:
                                        {{ \Carbon\Carbon::parse($submission->created_at)->format('d M Y h:i A') }}
                                    </div>
                                @endif
                            </li>
                        </ul>
                        <div class="hr-container">
                            <span>★★★</span>
                        </div>
                    @endforeach

                @endif
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="margin-top: 40px">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6"
                data-intro="Here is where you upload your submission, if you submit something wrong or have another answer (just send new submission)"
                data-step="5">
                <h3 class="font-bold text-xl mb-4" style="color: #3b1e54;">Submit Your Answer</h3>
                <form action="{{ route('studentSubmissions.submitAnswer', $task->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="answer" class="block font-medium mb-2" style="color: #3b1e54;">Your Answer</label>
                        <input type="text" name="answer" id="answer"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                            placeholder="Write your answer here" required />
                    </div>

                    <div class="mb-4">
                        <label for="pdf_path" class="block font-medium mb-2" style="color: #3b1e54;">Upload PDF
                            (Optional)</label>
                        <input type="file" name="pdf_path" id="pdf_path"
                            class="w-full border border-gray-300 rounded-md file:mr-4 file:py-2 file:px-4
                                      file:rounded-md file:border-0 file:bg-[#3b1e54] file:text-white
                                      hover:file:bg-[#2f1642]" />
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Submit Answer
                    </button>
                </form>
            </div>
            <a href="{{ route('studentSubmissions') }}" class=" btn btn-secondary" style="margin-top: 20px">
                Back
            </a>
        </div>
    </div>

    <style>
        .product-img {
            float: left;
            height: 570px;
            width: 50%;
        }

        .product-img img {
            border-radius: 7px 0 0 7px;
        }

        .product-info {
            float: left;
            height: 520px;
            width: 50%;
            border-radius: 0 7px 10px 7px;
            background-color: #ffffff;
        }

        .product-text {
            height: 300px;
            width: 100%;
        }

        .product-text h1 {
            margin: 0 0 0 38px;
            padding-top: 52px;
            font-size: 34px;

        }


        .product-text h2 {
            margin: 0 0 20px 38px;
            font-size: 16px;
            font-weight: 400;
        }

        .product-text p {
            height: 200px;
            margin: 0 0 0 38px;
            line-height: 1.7em;
            overflow: scroll;
            overflow-x: hidden;
        }


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



        @media (max-width: 768px) {
            .wrapper {
                width: 100%;
                height: auto;
                margin: 0 auto;
                border-radius: 7px;
            }

            .product-img,
            .product-info {
                float: none;
                width: 100%;
                height: auto;
            }

            .product-text {
                width: 100%;
            }

            .product-price-btn {
                width: 100%;
            }

            .namesList {
                font-size: small;
            }
        }
    </style>


    <script>
        function startTour() {
            introJs().start();
        }
    </script>
</x-app-layout>
