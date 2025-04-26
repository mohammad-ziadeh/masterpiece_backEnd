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

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" style="overflow: hidden;">
        <div class="p-4 sm:p-8 bg-white" style="margin-top: 20px; ">

            <div class="row">
                <div class="col grid-margin stretch-card">
                    <div class="card" data-intro="This is the Tasks management table" data-step="1">
                        <div class="card-body">
                            <button type="button" id="showStudentsBtn"
                                    class="btn btn-secondary"  >Show Assigned Students</button>
                            <div class="wrapper">
                                <div class="product-img">
                                    @if ($task->pdf_path)
                                        <iframe src="{{ asset('storage/' . $task->pdf_path) }}" width="100%"
                                            height="100%" style="border-radius: 7px 0 0 7px;"></iframe>
                                    @else
                                        <div class="flex items-center justify-center h-full text-gray-400">
                                            No PDF Available
                                        </div>
                                    @endif
                                </div>
                                <div class="product-info">
                                    <div class="product-text">
                                        <h1><b>Task name:</b> {{ $task->name }}</h1>
                                        <h2 style="margin-top: 20px"><b>Submitted by:</b> {{ $task->submittedBy->name }}</h2>
                                        <h2><b>The deadline:</b> <mark style="background-color: yellow"> {{ $task->due_date }}</mark> </h2>
                                        <h2 style="margin: 0%; margin-left: 38px;"><b>Description:</b> </h2>
                                        <p>{{ $task->description }}</p>
                                    </div>
    
                                </div>
                               
                            </div>
                            <a href="{{ route('tasks.index') }}" class=" btn btn-primary" >
                                <button type="button">Back to tasks table</button>
                            </a>
                        </div>
                        
                    </div>
                </div>
                <div id="studentsList" class="col mt-4 p-4 bg-gray-100 rounded-lg" style="overflow-x: hidden; overflow: scroll; height: 600px;">
                    <h3 class="text-lg font-bold text-purple-800 mb-2">Assigned Students:</h3>
                    @if ($task->students->isNotEmpty()) 
                        <ul >
                            @foreach ($task->students as $student)
                                <li class="namesList">{{ $student->name }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-600">No students assigned yet.</p>
                    @endif
                </div>
                
            </div>
        </div>
      
        <style>
            body {
                background-color: #fdf1ec;
            }

            .wrapper {
                height: 470px;
                width: 800px;
                margin: 50px auto;
                border-radius: 7px 7px 7px 7px;
                -webkit-box-shadow: 0px 14px 32px 0px rgba(0, 0, 0, 0.15);
                -moz-box-shadow: 0px 14px 32px 0px rgba(0, 0, 0, 0.15);
                box-shadow: 0px 14px 32px 0px rgba(0, 0, 0, 0.15);
            }

            .product-img {
                float: left;
                height: 470px;
                width: 400px;
            }

            .product-img img {
                border-radius: 7px 0 0 7px;
            }

            .product-info {
                float: left;
                height: 420px;
                width: 327px;
                border-radius: 0 7px 10px 7px;
                background-color: #ffffff;
            }

            .product-text {
                height: 300px;
                width: 327px;
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

            span {
                display: inline-block;
                height: 50px;
                font-size: 34px;
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

                .namesList{
                    font-size: small;
                }
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const btn = document.getElementById('showStudentsBtn');
                const list = document.getElementById('studentsList');
        
                btn.addEventListener('click', function () {
                    list.classList.toggle('hidden');
                });
            });
        </script>

<script>
    function startTour() {
        introJs().start();
    }
</script>
</x-app-layout>
