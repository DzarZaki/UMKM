<footer class="footer-modern">
    <div class="container">
        <div class="row g-5">
            <div class="col-md-4">
                <h3 class="footer-title">About Us</h3>
                <p class="footer-text">
                    We are passionate storytellers dedicated to capturing the essence of your most precious moments. 
                    With years of experience and an eye for detail, we transform fleeting instances into timeless memories.
                </p>
            </div>
            
            <div class="col-md-4">
                <h3 class="footer-title">Contact</h3>
                <p class="footer-text">
                    Tlogo RT.1/RW.27 Ambarketawang<br>
                    Gamping, Sleman, DIY<br><br>
                    <a href="mailto:contact@dzarproject.com" class="footer-link">contact@dzarproject.com</a><br>
                    Instagram: @dzargrad, @dzarlathuf<br>
                    Partnership: @halupimakeup, @shalmamakeup_
                </p>
            </div>
            
            <div class="col-md-4">
                <h3 class="footer-title">Get In Touch</h3>
                <!-- <form action="{{ route('contact.store') }}" method="POST", id = "waForm">  -->
                    <form id="waForm">
                    @csrf 
                    <input type="text" id="name" placeholder="Name" class="form-modern" required>
                    <input type="email" id="email" placeholder="Email" class="form-modern" required>
                    <input type="tel" id="whatsapp" placeholder="WhatsApp" class="form-modern" required>
                    <textarea id="message" placeholder="Message" class="form-modern" rows="3"></textarea>
                    <button type="submit" class="btn-submit">SEND MESSAGE</button>
                </form>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2025 DZAR PROJECT. ALL RIGHTS RESERVED.</p>
        </div>
    </div>
</footer>

