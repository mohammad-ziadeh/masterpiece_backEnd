<section class="mainBody">
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
                    <li><a href="/">Home</a></li>
                    <li><a href="{{ route('tables') }}">Tables</a></li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <li><a :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </a></li>
                    </form>

                </ul>
            </div>

            <div class="footer-section">
                <h4 style="font-size: x-large; font-style: normal;">Links</h4>
                <ul>
                    <li><a href="#">Link 1</a></li>
                    <li><a href="#">Link 2</a></li>
                    <li><a href="#">Link 3</a></li>
                    <li><a href="#">Link 4</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4 style="font-size: x-large; font-style: normal;">Support</h4>
                <ul>
                    <li><a href="#">Terms and Conditions</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li> 
                        <a href="https://wa.me/+962791318735" target="_blank" class="whatsapp-button">
                            Contact US &nbsp;  <i class="fa-brands fa-whatsapp" style="font-size: large"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="social-media">
            <a href="#" class="fac"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="X"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-google"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
            <a href="#"><i class="fab fa-github"></i></a>
        </div>
    </footer>

    <div class="copyright">
        &copy; 2025 Copyright: <a href="#">LMC</a>
    </div>
</section>
