@php
    $breadcrumbs = \App\Helpers\BreadcrumbsHelper::generateBreadcrumbs(Route::currentRouteName());
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl" style="color: #3b1e54; margin-bottom: 20px;">
            {{ __('Spinning Wheel') }}
        </h2>
        <div style="display: flex; justify-content: space-between;">
            <ul class="breadcrumbs">
                @foreach ($breadcrumbs as $breadcrumb)
                    <li>
                        <a style="color: #3b1e54;" href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </x-slot>

    <script src="https://cdn.tailwindcss.com"></script>

    <div class="spinning-wheel-container">

        <div class="flex flex-col sm:flex-row gap-4 sm:gap-8 items-center mb-6 px-20">
            <input id="nameInput" type="text" placeholder="Enter participant name"
                class="flex-1 p-3 rounded-lg text-black border focus:ring-2 focus:ring-indigo-400 outline-none w-full sm:w-auto">
            <button onclick="addName()"
                class="btn font-bold px-4 py-2 rounded-lg transition w-full sm:w-auto text-white"
                style="background-color: #3b1e54">
                Add
            </button>

        </div>

        <div class="flex flex-col sm:flex-row gap-8 sm:gap-16 items-center justify-center px-4">

            <div class="relative w-full sm:w-[465px] mx-auto mb-8 sm:mb-0">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 z-20">
                    <div style="border-top-color: #3b1e54"
                        class="w-0 h-0 
                           border-l-[30px] border-r-[30px] border-t-[40px] 
                           border-l-transparent border-r-transparent 
                           drop-shadow-xl">
                    </div>
                </div>
                <canvas id="wheel" width="450" height="450"
                    class="shadow-lg shadow-black border-8 border-indigo-500 rounded-full mx-auto"></canvas>
                <div style="display: flex; justify-content: center; margin-top: 30px;">
                    <button onclick="spinWheel()" style="background-color: #9b7ebd; "
                        class="btn font-bold text-white px-4 py-2 rounded-lg transition w-full sm:w-auto">
                        Spin
                    </button>
                </div>

            </div>

            <div class="flex-1 w-full sm:w-[200px]" id="ListContainer">
                <h2 class="text-lg font-semibold mb-2 ml-3">Participants</h2>
                <ul id="nameList" class="space-y-2 max-h-72 overflow-y-auto pr-2"></ul>
            </div>
        </div>

        <audio id="spinSound" src="/spin.mp3" preload="auto"></audio>
    </div>

    <div id="winnerModal" class="fixed inset-0 bg-black bg-opacity-60 hidden justify-center items-center z-50">
        <div class="bg-white text-black rounded-xl p-8 max-w-md w-full text-center shadow-2xl">
            <h2 class="text-3xl font-bold mb-4">🎉 Has been selected!!</h2>
            <p id="winnerName" class="text-xl font-semibold mb-6"></p>
            <button onclick="closeModal()"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-bold transition">
                Close
            </button>
        </div>
    </div>

    <div id="validationModal" class="fixed inset-0 bg-black bg-opacity-60 hidden justify-center items-center z-50">
        <div class="bg-white text-black rounded-xl p-8 max-w-md w-full text-center shadow-2xl">
            <h2 id="modalTitle" class="text-3xl font-bold mb-4">Validation Error</h2>
            <p id="modalMessage" class="text-xl font-semibold mb-6">Please add at least 2 participants.</p>
            <button onclick="closeModal()"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-bold transition">
                Close
            </button>
        </div>
    </div>

    <script>
        const segmentColors = ["#b3a3d0", "#674fa3", "#9482be"];
        const names = [];
        const canvas = document.getElementById('wheel');
        const ctx = canvas.getContext('2d');
        const spinSound = document.getElementById('spinSound');

        function drawWheel() {
            const total = names.length;
            const radius = canvas.width / 2;
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            if (total === 0) {
                ctx.fillStyle = '#eee';
                ctx.beginPath();
                ctx.arc(radius, radius, radius, 0, 2 * Math.PI);
                ctx.fill();
                ctx.fillStyle = '#333';
                ctx.font = '18px Arial';
                ctx.fillText('Add Participants', radius - 60, radius);
                return;
            }

            const angleStep = 2 * Math.PI / total;

            for (let i = 0; i < total; i++) {
                const angle = i * angleStep;
                ctx.beginPath();
                ctx.moveTo(radius, radius);

                ctx.arc(radius, radius, radius, angle, angle + angleStep);
                ctx.fillStyle = segmentColors[i % 3];
                ctx.fill();
                ctx.strokeStyle = "#eeeeee";
                ctx.lineWidth = 0.5;
                ctx.stroke();
                ctx.save();
                ctx.translate(radius, radius);
                ctx.rotate(angle + angleStep / 2);
                ctx.textAlign = "right";
                ctx.fillStyle = "#fff";
                ctx.font = "bold 16px Arial";
                ctx.fillText(names[i], radius - 10, 5);
                ctx.restore();
            }
        }

        function addName() {
            const input = document.getElementById('nameInput');
            const name = input.value.trim();
            if (name && !names.includes(name)) {
                names.push(name);
                input.value = '';
                updateList();
                drawWheel();
            }
        }

        function updateList() {
            const ul = document.getElementById('nameList');
            ul.innerHTML = '';
            names.forEach((name, index) => {
                const li = document.createElement('li');
                li.className =
                    "flex items-center justify-between bg-white/20 px-3 py-2 rounded-lg hover:bg-white/30 transition";
                li.innerHTML = `
                    <span>${name}</span>
                    <button onclick="removeName(${index})"
                            class="text-red-400 hover:text-red-500 transition font-bold">×</button>
                `;
                ul.appendChild(li);
            });
        }

        function removeName(index) {
            names.splice(index, 1);
            updateList();
            drawWheel();
        }

        function spinWheel() {
            if (names.length < 2) {
                showModal("Validation Error", "Please add at least 2 participants.");
                return;
            }

            const total = names.length;
            const segmentAngle = 360 / total;

            const randomIndex = Math.floor(Math.random() * total);
            const winningSegmentCenter = randomIndex * segmentAngle + segmentAngle / 2;

            const targetRotation = 360 * 5 + 270 - winningSegmentCenter;

            const duration = 4000;
            let start = null;

            function animate(timestamp) {
                if (!start) start = timestamp;
                const progress = timestamp - start;
                const rotation = easeOutCubic(progress / duration) * targetRotation;

                canvas.style.transform = `rotate(${rotation}deg)`;

                if (progress < duration) {
                    requestAnimationFrame(animate);
                } else {
                    showModal("🎉 Winner!", names[randomIndex]);
                }
            }

            requestAnimationFrame(animate);
        }

        function easeOutCubic(t) {
            return (--t) * t * t + 1;
        }

        function showModal(title, message) {
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalMessage').textContent = message;
            document.getElementById('validationModal').classList.remove('hidden');
            document.getElementById('validationModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('validationModal').classList.add('hidden');
            document.getElementById('validationModal').classList.remove('flex');
            document.getElementById('winnerModal').classList.add('hidden');
            document.getElementById('winnerModal').classList.remove('flex');
        }

        drawWheel();
    </script>

    <style>
        .spinning-wheel-container {
            background: #eeeeee;
            padding: 2rem;
            max-width: 100%;
            margin: 0 auto;
        }

        #wheel {
            transition: transform 0.5s ease-out;
            border-radius: 9999px;
            border: 8px solid #000000;
        }

        .spinning-wheel-container button:hover {
            transform: scale(1.05);
        }

        #nameList li {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 10px 20px;
            margin-bottom: 10px;
            border-radius: 8px;
            color: #fff;
        }

        #nameList li button {
            color: #E53E3E;
        }

        #ListContainer {
            background-color: #9b7ebd;
            color: #eeeeee;
            border-radius: 8px;
            padding: 0px 10px 0 10px;
        }

        #ListContainer li {
            color: #eeeeee;
        }

        @media (max-width: 640px) {
            .spinning-wheel-container {
                padding: 1rem;
            }

            #wheel {
                width: 100%;
                height: auto;
            }

            #ListContainer li {
                font-size: 16px
            }
        }
    </style>
</x-app-layout>
