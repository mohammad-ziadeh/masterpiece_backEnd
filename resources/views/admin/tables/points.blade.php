<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl " style="color: #3b1e54; margin-bottom: 20px;">
            {{ $user->name }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" style="overflow: hidden;">
        <div class="p-4 sm:p-8 bg-white" style="margin-top: 20px; ">
            <div class="flex flex-col items-center justify-center">
                <div class="score-container text-center">
                    <h3 class="text-lg font-semibold text-purple-200 mb-2">Current weekly score</h3>
                    <div class="score-counter  font-bold  mb-4" style="color: #3b1e54; font-size: 35px;"
                        x-data="{ score: 0, target: {{ $user->weekly_points }} }" x-init="setTimeout(() => {
                            let interval = setInterval(() => {
                                if (score < target) {
                                    score = score + Math.ceil(target / 20);
                                    if (score > target) score = target;
                                } else {
                                    clearInterval(interval);
                                }
                            }, 50);
                        }, 500);" x-text="score">
                        0
                    </div>
                </div>
            </div>

            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                Back
            </a>
        </div>



    </div>
</x-app-layout>
