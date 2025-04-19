<div class="body">
  <div class="main">
    <div id="header">
      <h1>Ranking</h1>
      <button class="share">
        <i class="ph ph-share-network"></i>
      </button>
    </div>
    <div id="leaderboard">
      <div class="ribbon"></div>
      <table>
        @foreach ($topUsers as $index => $user)
          <tr>
            <td class="number">{{ $index + 1 }}</td>
            <td class="name">{{ $user->name }}</td>
            <td class="points">
              {{ $user->weekly_points }}
              @if ($index === 0)
                <img class="gold-medal" src="https://github.com/malunaridev/Challenges-iCodeThis/blob/master/4-leaderboard/assets/gold-medal.png?raw=true" alt="gold medal"/>
              @endif
            </td>
          </tr>
        @endforeach
      </table>
    </div>
  </div>
</div>
