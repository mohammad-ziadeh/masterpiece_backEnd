@php
    $breadcrumbs = \App\Helpers\BreadcrumbsHelper::generateBreadcrumbs(Route::currentRouteName());
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl" style="color: #3b1e54; margin-bottom: 20px;">
            {{ __('Assign Badge') }}
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
        <div class="p-4 sm:p-8 bg-white" style="margin-top: 20px; border-radius: 8px;"
            data-intro="Here is the place where u assign Badges to the students" data-step="1">
            <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;"
                data-intro="Here you will see all the existing badges with there Image, Title and Description."
                data-step="2">
                @foreach ($badges as $badge)
                    <div class="badgeCard">
                        <img class="badgeImg" src="{{ asset('storage/' . $badge->image_url) }}"
                            alt="{{ $badge->title }}" width="90">
                        <strong>{{ $badge->title }}</strong>
                        <p style="padding: 10px; text-align: center;">{{ $badge->description ?? '—' }}</p>
                    </div>
                @endforeach
            </div>
            <h3 class="text-xl font-semibold mb-4 mt-6 text-center">Assign a Badge to a Student</h3>

            <form action="{{ route('badges.assign') }}" method="POST"
                data-intro="Here is where u assign each student with the badge that here deserve according to his weekly points"
                data-step="3">
                @csrf
                <div style="display: flex; gap: 10px ;justify-content: space-between; flex-wrap: wrap; width: 100%;">
                    <div class="mb-3"
                        data-intro="Here you will select the student, they are sorted descending according to their weekly points and you will see their weekly points beside them."
                        data-step="4">
                        <label for="user_id" class="form-label">Select Student:</label>
                        <select name="user_id" id="user_id"
                            class="form-select rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                            style="width:90%" required>
                            <option value="">-- Choose a Student --</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">
                                    {{ $student->name }} ({{ $student->weekly_points }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <span class="arrow-right"></span>

                    <div class="mb-3"
                        data-intro="Here you will select the suitable badge for the student that you have selected"
                        data-step="5">
                        <label for="badge_id" class="form-label">Select Badge:</label>
                        <select name="badge_id" id="badge_id"
                            class="form-select w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                            required>
                            <option value="">-- Choose a Badge --</option>
                            @foreach ($badges as $badge)
                                <option value="{{ $badge->id }}">
                                    {{ $badge->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="mt-4" style="display: flex; justify-content: center;">
                    <button type="submit" class="btn btn-primary" style="background-color: #3b1e54; color: white;"
                        data-intro="After selecting click here to assign the badge to the student." data-step="6">
                        Assign Badge
                    </button>
                </div>
            </form>
            <div style="display:flex; justify-content: end;">
                <a class="btn btn-success" href="{{ route('badges.create') }}"
                    data-intro="If you got new idea for a badge or want to add more badges u can do it by clicking here."
                    data-step="7">create new badge</a>
            </div>

        </div>
    </div>


    <style>
        .arrow-right {
            position: relative;
            margin-right: 85px
        }

        .arrow-right::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            border: solid black;
            border-width: 0 4px 4px 0;
            padding: 10px;
            transform: translateY(-50%) rotate(-45deg);
        }

        .badgeImg:hover {
            transform: scale(1.2);
            transition: transform 0.3s ease-in-out;
        }

        .badgeImg {
            margin-bottom: 10px
        }

        .badgeCard {
            flex: 0 0 calc(33.333% - 10px);
            display: flex;
            flex-direction: column;
            align-items: center;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 8px;
            box-sizing: border-box;
        }

        @media (max-width: 768px) {
            p {
                font-size: 12px;
            }

            strong {
                font-size: 14px;
            }

            .badgeCard {
                flex: 0 0 100%;
            }

            .arrow-right {
                position: relative;
                margin-right: 20px
            }
        }
    </style>
    <script>
        function startTour() {
            introJs().start();
        }
    </script>
</x-app-layout>
