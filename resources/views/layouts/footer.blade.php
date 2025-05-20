<section class="mainBody" style="margin-top: 20px">
    <br>
    <br>
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3 style="font-size: x-large; font-style: normal;">LMC</h3>
                <p>
                    Join our growing community of learners and educators. Share
                    insights, celebrate progress, and challenge yourself daily!
                </p>
            </div>

            <div class="footer-section">
                <h4 style="font-size: x-large; font-style: normal;">Navigate</h4>
                <ul>
                    @if (auth()->user()->role === 'admin' || auth()->user()->role === 'trainer')
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('profile.edit') }}">Home</a></li>
                        <li><a href="/spinner">Spinner</a></li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <li><a :href="route('logout')"
                                    onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </a></li>
                        </form>
                    @else
                        <li><a href="{{ route('studentDashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('profile.edit') }}">Profile</a></li>
                        <li><a href="/spinner">Spinner</a></li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <li><a :href="route('logout')"
                                    onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </a></li>
                        </form>
                    @endif

                </ul>
            </div>

            <div class="footer-section">
                <h4 style="font-size: x-large; font-style: normal;">Links</h4>
                <ul>
                    @if (auth()->user()->role === 'admin' || auth()->user()->role === 'trainer')
                        <li><a href="{{ route('users.index') }}">Users</a></li>
                        <li><a href="{{ route('tasks.index') }}">Tasks</a></li>
                        <li><a href="{{ route('attendance.index') }}">Attendance</a></li>
                        <li><a href="{{ route('submissions.index') }}">Submissions</a></li>
                    @else
                        <li><a href="{{ route('studentSubmissions') }}">Tasks</a></li>
                        <li><a href="{{ route('student-leaderBoard.index') }}">Leaderboard</a></li>
                        <li><a href="{{ route('announcements') }}">Announcements</a></li>
                    @endif

                </ul>
            </div>

            <div class="footer-section">
                <h4 style="font-size: x-large; font-style: normal;">Support</h4>
                <ul>
                    <li><a href="https://orange.jo/en/corporate/about-us" target="_blank">Terms and Conditions</a></li>
                    <li><a href="https://orange.jo/en/pages/legal" target="_blank">Privacy Policy</a></li>
                    <li>
                        <a href="https://wa.me/+962791318735" target="_blank" class="whatsapp-button">
                            Contact US &nbsp; <i class="fa-brands fa-whatsapp" style="font-size: large"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="social-media">
            <a href="https://www.facebook.com/OrangeJordan/" class="fac" target="_blank"><i class="fab fa-facebook-f"></i></a>
            <a href="https://x.com/OrangeJordan" class="X" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="https://orange.jo/en" target="_blank"><i class="fab fa-google"></i></a>
            <a href="https://www.instagram.com/orangejo" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://www.linkedin.com/company/orange-jordan" target="_blank"><i class="fab fa-linkedin-in"></i></a>
        </div>
    </footer>

    <div class="copyright">
        &copy; 2025 Copyright: <a href="#">LMC</a>
    </div>
</section>
