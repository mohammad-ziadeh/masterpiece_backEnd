<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $user->name }} ({{ $user->weekly_points }})
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
                @php
                    $groupedAwards = $awards->groupBy('badge_id');
                @endphp
                @if ($badges && count($groupedAwards))
                    <div style="display: flex; gap: 80px; margin-top: 40px; justify-content: center; flex-wrap: wrap;">
                        @foreach ($groupedAwards as $badgeId => $group)
                            @php
                                $badge = $group->first()->badge;
                                $count = $group->count();
                            @endphp

                            <div style="position: relative; width: 250px; height: 250px;">
                                <img src="{{ asset('storage/' . $badge->image_url) }}" alt="{{ $badge->title }}"
                                    style="width: 250px; height: 250px; object-fit: contain; border-radius: 8px;">

                                @if ($count > 1)
                                    <div
                                        style="position: absolute; top: -22px; right: -15px; width: 120px; height: 120px; pointer-events: none;">
                                        @if ($count < 10)
                                            <dotlottie-player
                                                src="https://lottie.host/ed6e33ae-009f-4d64-9d5e-0509750f8895/2BxHd1fBv0.lottie"
                                                background="transparent" speed="1"
                                                style="width: 120px; height: 120px" loop autoplay></dotlottie-player>
                                        @elseif ($count <= 15)
                                            <dotlottie-player
                                                src="https://lottie.host/806a2d89-4e5a-4455-8144-c21731e50e61/ZjnvPccFTY.lottie"
                                                background="transparent" speed="1"
                                                style="width: 120px; height: 120px" loop autoplay></dotlottie-player>
                                        @else
                                            <dotlottie-player
                                                src="https://lottie.host/b251df9b-5519-475e-811f-e5b7dc598355/b5Xu3gn2II.lottie"
                                                background="transparent" speed="1"
                                                style="width: 120px; height: 120px" loop autoplay></dotlottie-player>
                                        @endif

                                        @if ($count < 10)
                                            <span
                                                style="position: absolute; top: 55px; left: 55px; font-weight: bold; color: white; user-select: none;"
                                                class="fire-count-number">
                                                {{ $count }}
                                            </span>
                                        @elseif ($count <= 15)
                                            <span
                                                style="position: absolute; top: 55px; left: 52px; font-weight: bold; color: #3b1e54; user-select: none;"
                                                class="fire-count-number">
                                                {{ $count }}
                                            </span>
                                        @else
                                            <span
                                                style="position: absolute; top: 55px; left: 52px; font-weight: bold; color: white; user-select: none;"
                                                class="fire-count-number">
                                                {{ $count }}
                                            </span>
                                        @endif
                                    </div>
                                @endif

                            </div>
                        @endforeach
                    </div>
                @else
                    <h2 class="text-center text-lg font-semibold text-gray-600 mt-10">This student has no badges yet.
                    </h2>
                @endif
                                <a href="{{ route('student-leaderBoard.index') }}" class="btn btn-secondary mt-4">
                    Back
                </a>

            </div>
        </div>
    </div>
        <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>

</x-app-layout>
