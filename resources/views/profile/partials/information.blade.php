<section>
    <header
        style="display: flex; flex-direction: column; align-items: center; justify-content: center; margin-top: 10px;">
        <h1 class="text-lg " style="color: #3b1e54; font-size: x-large;">
            {{ __('General Information') }}
        </h1>

        <h3 class="mt-1 " style="color: #9b7ebd">
            {{ __('Here are all your Information') }}
        </h3>
    </header>

    <div>
        @if (auth()->user()->role === 'student')
            <div style="display: flex; justify-content: space-around;  margin-top: 40px; ">
                <form action="{{ route('users.updateAvatar', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')


                    @if (!empty(Auth::user()->avatar) && file_exists(public_path('storage/' . $user->avatar)))
                        <label for="avatarInput" style="cursor: pointer;"
                            data-intro="Here you can change you avatar to what ever you want. Be creative *_*"
                            data-step="2">
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="rounded-circle"
                                style="width: 155px; height: 155px; object-fit: cover;" title="Click to change avatar">
                        </label>
                    @else
                        @if (Auth::user()->gender == 'male')
                            <label for="avatarInput" style="cursor: pointer;"
                                data-intro="Here you can change you avatar to what ever you want. Be creative *_*"
                                data-step="2">
                                <img src="{{ asset('images/maleAvatar.png') }}" alt="Avatar" class="rounded-circle"
                                    style="width: 155px; height: 155px; object-fit: cover;"
                                    title="Click to change avatar">
                            </label>
                        @elseif (Auth::user()->gender == 'female')
                            <label for="avatarInput" style="cursor: pointer;"
                                data-intro="Here you can change you avatar to what ever you want. Be creative *_*"
                                data-step="2">
                                <img src="{{ asset('images/femalAvatar.png') }}" alt="Avatar" class="rounded-circle"
                                    style="width: 155px; height: 155px; object-fit: cover;"
                                    title="Click to change avatar">
                            </label>
                        @else
                            <label for="avatarInput" style="cursor: pointer;"
                                data-intro="Here you can change you avatar to what ever you want. Be creative *_*"
                                data-step="2">
                                <img src="{{ asset('images/maleAvatar.png') }}" alt="Avatar" class="rounded-circle"
                                    style="width: 155px; height: 155px; object-fit: cover;"
                                    title="Click to change avatar">
                            </label>
                        @endif

                    @endif


                    <input type="file" name="avatar" id="avatarInput" class="d-none" onchange="this.form.submit()">
                </form>
                @php
                    $groupedAwards = $awards->groupBy('badge_id');
                @endphp

                <div style="display: flex; gap: 30px; margin-top: 40px; justify-content: center; flex-wrap: wrap;"
                    data-intro="Here are all of you achievements that you have managed to get till now" data-step="3">
                    @foreach ($groupedAwards as $badgeId => $group)
                        @php
                            $badge = $group->first()->badge;
                            $count = $group->count();
                        @endphp

                        <div style="position: relative; width: 100px; height: 100px;">
                            <img src="{{ asset('storage/' . $badge->image_url) }}" alt="{{ $badge->title }}"
                                style="width: 100px; height: 100px; object-fit: contain; border-radius: 8px;">

                            @if ($count > 1)
                                <div
                                    style="position: absolute; top: -35px; right: -30px; width: 90px; height: 90px; pointer-events: none;">
                                    @if ($count < 10)
                                        <dotlottie-player
                                            src="https://lottie.host/ed6e33ae-009f-4d64-9d5e-0509750f8895/2BxHd1fBv0.lottie"
                                            background="transparent" speed="1" style="width: 90px; height: 90px"
                                            loop autoplay></dotlottie-player>
                                    @elseif ($count <= 15)
                                        <dotlottie-player
                                            src="https://lottie.host/806a2d89-4e5a-4455-8144-c21731e50e61/ZjnvPccFTY.lottie"
                                            background="transparent" speed="1" style="width: 90px; height: 90px"
                                            loop autoplay></dotlottie-player>
                                    @else
                                        <dotlottie-player
                                            src="https://lottie.host/b251df9b-5519-475e-811f-e5b7dc598355/b5Xu3gn2II.lottie"
                                            background="transparent" speed="1" style="width: 90px; height: 90px"
                                            loop autoplay></dotlottie-player>
                                    @endif

                                    @if ($count < 10)
                                        <span
                                            style="position: absolute; top: 35px; left: 39px; font-weight: bold; color: white; user-select: none;"
                                            class="fire-count-number">
                                            {{ $count }}
                                        </span>
                                    @elseif ($count <= 15)
                                        <span
                                            style="position: absolute; top: 35px; left: 39px; font-weight: bold; color: #3b1e54; user-select: none;"
                                            class="fire-count-number">
                                            {{ $count }}
                                        </span>
                                    @else
                                        <span
                                            style="position: absolute; top: 35px; left: 39px; font-weight: bold; color: white; user-select: none;"
                                            class="fire-count-number">
                                            {{ $count }}
                                        </span>
                                    @endif
                                </div>
                            @endif

                        </div>
                    @endforeach
                </div>

            </div>
        @else
            <div style="display:flex; justify-content: center; margin-top: 50px;">
                <form action="{{ route('users.updateAvatar', $user->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')


                    @if (!empty(Auth::user()->avatar) && file_exists(public_path('storage/' . $user->avatar)))
                        <label for="avatarInput" style="cursor: pointer;">
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="rounded-circle"
                                style="width: 155px; height: 155px; object-fit: cover;" title="Click to change avatar">
                        </label>
                    @else
                        @if (Auth::user()->gender == 'male')
                            <label for="avatarInput" style="cursor: pointer;">
                                <img src="{{ asset('images/maleAvatar.png') }}" alt="Avatar" class="rounded-circle"
                                    style="width: 155px; height: 155px; object-fit: cover;"
                                    title="Click to change avatar">
                            </label>
                        @elseif (Auth::user()->gender == 'female')
                            <label for="avatarInput" style="cursor: pointer;">
                                <img src="{{ asset('images/femalAvatar.png') }}" alt="Avatar" class="rounded-circle"
                                    style="width: 155px; height: 155px; object-fit: cover;"
                                    title="Click to change avatar">
                            </label>
                        @else
                            <label for="avatarInput" style="cursor: pointer;">
                                <img src="{{ asset('images/maleAvatar.png') }}" alt="Avatar"
                                    class="rounded-circle" style="width: 155px; height: 155px; object-fit: cover;"
                                    title="Click to change avatar">
                            </label>
                        @endif

                    @endif


                    <input type="file" name="avatar" id="avatarInput" class="d-none"
                        onchange="this.form.submit()">
                </form>
            </div>

        @endif

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
            <h3 style=" font-size: large;">Gender: </h3>
            <h3 style=" font-size: large; font-weight: bold;">{{ Auth::user()->gender }}</h3>
        </div>
        <div class="hr-container">
            <span>★★★</span>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <h3 style=" font-size: large;">City: </h3>
            <h3 style=" font-size: large; font-weight: bold;">{{ Auth::user()->city }}</h3>
        </div>
        <div class="hr-container">
            <span>★★★</span>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <h3 style=" font-size: large;">Phone:</h3>
            <h3 style=" font-size: large;">{{ Auth::user()->phone }}</h3>
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

    <style>
        @media (max-width: 768px) {
            .fire-count-number {
                font-size: 1.6rem;
                top: 26px;
                left: 33px;
            }
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
    </style>
    <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
</section>
