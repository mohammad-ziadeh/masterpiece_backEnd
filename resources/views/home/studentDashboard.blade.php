@php
    $breadcrumbs = \App\Helpers\BreadcrumbsHelper::generateBreadcrumbs(Route::currentRouteName());
@endphp
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl " style="color: #3b1e54; margin-bottom: 20px;">
            {{ __('Dashboard') }}
        </h2>
        <ul class="breadcrumbs">
            @foreach ($breadcrumbs as $breadcrumb)
                <li>
                    <a style="color: #3b1e54;" href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
                </li>
            @endforeach
        </ul>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg">


                <section class="section9">
        
                    <div class="sb">
                        <h2 style="font-weight:bold; font-size: x-large; text-align: center; color: #3b1e54;">Student Information</h2>
                        <h3 style="font-size: x-large; text-align: center; margin-top: 20px; ">
                            {{ Auth::user()->name }}</h3>
                        <div style="display: flex; justify-content: space-between;">
                            <h3 style=" font-size: large; margin-top: 30px;">ID:</h3>
                            <h3 style=" font-size: large; margin-top: 30px; font-weight: bold;">{{ Auth::user()->id }}
                            </h3>
                        </div>

                        <div class="hr-container">
                            <span>★★★</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <h3 style=" font-size: large;">Email: </h3>
                            <h3 style=" font-size: large; font-weight: bold;">{{ Auth::user()->email }}</h3>
                        </div>
                        <div class="hr-container">
                            <span>★★★</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <h3 style=" font-size: large;">Phone:</h3>
                            <h3 style=" font-size: large;">0791318735</h3>
                        </div>
                        <div class="hr-container">
                            <span>★★★</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <h3 style="font-size: large;">Joining Date:</h3>
                            <h3 style="font-size: large; font-weight: bold;">
                                {{ Auth::user()->created_at->format('d F Y') }}</h3>
                        </div>

                    </div>
                    <div class="sd">
                        <h2 style="font-weight:bold; font-size: x-large; text-align: center; margin-bottom: 60px; color: #3b1e54;">Student Attendance:</h2>
                        <div style="display: flex; justify-content: space-between;">
                            <h3 style=" font-size: large;">Justified Absence:</h3>
                            <h3 style=" font-size: large;">{{$userJustifyAbsent}}</h3>
                        </div>
                        <div class="hr-container">
                            <span>★★★</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <h3 style=" font-size: large;">Non-Justified Absence::</h3>
                            <h3 style=" font-size: large;">{{$userAbsent}}</h3>
                        </div>
                        <div class="hr-container">
                            <span>★★★</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <h3 style=" font-size: large;">Tardy:</h3>
                            <h3 style=" font-size: large;">{{$userLate}}</h3>
                        </div>

                    </div>
                    <div class="hd"></div>
                    <div class="mb"></div>
                    <div class="ft"></div>
                </section>

            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="margin-top: 40px">
            <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg">


            </div>

        </div>
    </div>
    <style>
        .section9 {
            width: 100%;
            height: 900px;
            gap: 15px;
            padding: 15px;


            display: grid;
            grid-template-columns: repeat(10, 1fr);
            grid-template-rows: repeat(12, 1fr);
            grid-template-areas:
                "sb sb sb sb ft ft ft hd hd hd"
                "sb sb sb sb ft ft ft hd hd hd"
                "sb sb sb sb ft ft ft hd hd hd"
                "sb sb sb sb ft ft ft hd hd hd"
                "sb sb sb sb mb mb mb mb mb mb"
                "sb sb sb sb mb mb mb mb mb mb"
                "sb sb sb sb mb mb mb mb mb mb"
                "sd sd sd sd mb mb mb mb mb mb"
                "sd sd sd sd mb mb mb mb mb mb"
                "sd sd sd sd mb mb mb mb mb mb"
                "sd sd sd sd mb mb mb mb mb mb"
                "sd sd sd sd mb mb mb mb mb mb"
        }

        .hd {
            grid-area: hd;

            border-radius: 5px;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
        }

        .sb {
            grid-area: sb;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
        }

        .sd {
            grid-area: sd;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
        }

        .mb {
            grid-area: mb;

            border-radius: 5px;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
        }


        .ft {
            grid-area: ft;

            border-radius: 5px;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
        }

        .hr-container {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin: 20px 0;
        }

        .hr-container::before,
        .hr-container::after {
            content: "";
            flex: 1;
            border-bottom: 2px solid var(--light-color);
            margin: 0 10px;
        }

        .hr-container span {
            font-size: 18px;
            /* Adjust size of the word */
            color: var(--primary-color);
        }
    </style>
</x-app-layout>
