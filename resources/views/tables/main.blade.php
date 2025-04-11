@php
    $breadcrumbs = \App\Helpers\BreadcrumbsHelper::generateBreadcrumbs(Route::currentRouteName());
@endphp

<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl " style="color: #3b1e54; margin-bottom: 20px;">
        {{ __('Tables') }}
    </h2>
    <ul class="breadcrumbs">
        @foreach ($breadcrumbs as $breadcrumb)
            <li>
                <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
            </li>
        @endforeach
    </ul>
</x-slot>

    <div class="ag-format-container">
        <div class="ag-courses_box">

          <div class="ag-courses_item">
            <a href="{{ route('users.index') }}" class="ag-courses-item_link">
              <div class="ag-courses-item_bg"></div>
      
              <div class="ag-courses-item_title">
                Users Table
              </div>
      
              <div class="ag-courses-item_date-box">
                Start:
                <span class="ag-courses-item_date">
                  30.11.2022
                </span>
              </div>
            </a>
          </div>


          <div class="ag-courses_item">
            <a href="{{ route('tasks.index') }}" class="ag-courses-item_link">
              <div class="ag-courses-item_bg"></div>
      
              <div class="ag-courses-item_title">
                Tasks Table
              </div>
      
              <div class="ag-courses-item_date-box">
                Start:
                <span class="ag-courses-item_date">
                  30.11.2022
                </span>
              </div>
            </a>
          </div>


          <div class="ag-courses_item">
            <a href="{{ route('attendance.index') }}" class="ag-courses-item_link">
              <div class="ag-courses-item_bg"></div>
      
              <div class="ag-courses-item_title">
                Attendance Table
              </div>
      
              <div class="ag-courses-item_date-box">
                Start:
                <span class="ag-courses-item_date">
                  30.11.2022
                </span>
              </div>
            </a>
          </div>


          <div class="ag-courses_item">
            <a href="#" class="ag-courses-item_link">
              <div class="ag-courses-item_bg"></div>
      
              <div class="ag-courses-item_title">
                Motion Design
              </div>
      
              <div class="ag-courses-item_date-box">
                Start:
                <span class="ag-courses-item_date">
                  30.11.2022
                </span>
              </div>
            </a>
          </div>


          <div class="ag-courses_item">
            <a href="#" class="ag-courses-item_link">
              <div class="ag-courses-item_bg"></div>
      
              <div class="ag-courses-item_title">
                Motion Design
              </div>
      
              <div class="ag-courses-item_date-box">
                Start:
                <span class="ag-courses-item_date">
                  30.11.2022
                </span>
              </div>
            </a>
          </div>


          <div class="ag-courses_item">
            <a href="#" class="ag-courses-item_link">
              <div class="ag-courses-item_bg"></div>
      
              <div class="ag-courses-item_title">
                Motion Design
              </div>
      
              <div class="ag-courses-item_date-box">
                Start:
                <span class="ag-courses-item_date">
                  30.11.2022
                </span>
              </div>
            </a>
          </div>


          <div class="ag-courses_item">
            <a href="#" class="ag-courses-item_link">
              <div class="ag-courses-item_bg"></div>
      
              <div class="ag-courses-item_title">
                Motion Design
              </div>
      
              <div class="ag-courses-item_date-box">
                Start:
                <span class="ag-courses-item_date">
                  30.11.2022
                </span>
              </div>
            </a>
          </div>


          <div class="ag-courses_item">
            <a href="#" class="ag-courses-item_link">
              <div class="ag-courses-item_bg"></div>
      
              <div class="ag-courses-item_title">
                Motion Design
              </div>
      
              <div class="ag-courses-item_date-box">
                Start:
                <span class="ag-courses-item_date">
                  30.11.2022
                </span>
              </div>
            </a>
          </div>


          <div class="ag-courses_item">
            <a href="#" class="ag-courses-item_link">
              <div class="ag-courses-item_bg"></div>
      
              <div class="ag-courses-item_title">
                Motion Design
              </div>
      
              <div class="ag-courses-item_date-box">
                Start:
                <span class="ag-courses-item_date">
                  30.11.2022
                </span>
              </div>
            </a>
          </div>
      
        </div>
      </div>

</x-app-layout>