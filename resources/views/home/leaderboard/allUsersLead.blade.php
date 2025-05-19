<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Full Leaderboard</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Rank</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Weekly Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                            <tr>
                                <td class="border px-4 py-2">
                                    <a
                                        href="{{ route('student-leaderboard.badge', $user->id) }}">{{ $index + 1 }}</a>
                                </td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('student-leaderboard.badge', $user->id) }}">
                                        {{ $user->name }}</a>
                                </td>
                                <td class="border px-4 py-2">
                                    <a
                                        href="{{ route('student-leaderboard.badge', $user->id) }}">{{ $user->weekly_points }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <a href="{{ route('student-leaderBoard.index') }}" class=" btn btn-secondary" style="margin-top: 20px">
                    Back
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
