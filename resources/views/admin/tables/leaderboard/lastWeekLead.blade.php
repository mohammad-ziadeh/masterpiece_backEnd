<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Last Week's Leaderboard</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Rank</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Last Week Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                            <tr>
                                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                <td class="border px-4 py-2 flex items-center" style="display: flex; align-items: center;">
                                    @if (!empty($user->avatar) && file_exists(public_path('storage/' . $user->avatar)))
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                                            style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; margin-right: 20px;">
                                    @else
                                        <img src="{{ asset('images/' . ($user->gender === 'female' ? 'femalAvatar.png' : 'maleAvatar.png')) }}"
                                            alt="Default Avatar"
                                            style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; margin-right: 20px;">
                                    @endif
                                    {{ $user->name }}
                                </td>
                                <td class="border px-4 py-2">{{ $user->last_week_points }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <a href="{{ route('leaderBoard.index') }}" class="btn btn-secondary mt-4">
                    Back
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
