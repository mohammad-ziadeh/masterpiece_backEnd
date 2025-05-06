<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Badges Earned by {{ $user->name }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                @if($awards->isEmpty())
                    <p>This user has not earned any badges yet.</p>
                @else
                    <table class="table-auto w-full border">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">Badge</th>
                                <th class="border px-4 py-2">Title</th>
                                <th class="border px-4 py-2">Earned At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($awards as $award)
                                <tr>
                                    <td class="border px-4 py-2">
                                        <img src="{{ asset('storage/' . $award->badge->image_url) }}" width="50" alt="{{ $award->badge->title }}">
                                    </td>
                                    <td class="border px-4 py-2">{{ $award->badge->title }}</td>
                                    <td class="border px-4 py-2">{{ $award->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                <a href="{{ route('users.index') }}" class=" btn btn-secondary" style="margin-top: 20px">
                   Back
                </a>
            </div>
           
        </div>
    </div>
</x-app-layout>
