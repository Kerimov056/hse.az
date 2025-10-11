@extends('layouts.app')

<!-- Start Header Section -->
<header class="td_site_header td_style_1 td_type_2 td_sticky_header td_medium td_heading_color">
  <div class="td_top_header td_heading_bg td_white_color">
    <div class="container">
      <div class="td_top_header_in">
        <div class="td_top_header_left">
          <ul class="td_header_contact_list td_mp_0 td_normal">
            <li>
              <img src="{{ asset('assets/img/icons/call.svg') }}" alt="">
              <span>Call: <a href="tel:99066789768">990 66789 768</a></span>
            </li>
            <li>
              <img src="{{ asset('assets/img/icons/envlop.svg') }}" alt="">
              <span>Email: <a href="mailto:support@educat.com">support@educat.com</a></span>
            </li>
          </ul>
        </div>
        <div class="td_top_header_right">
          <span>
            <a href="signin.html">Login</a> / 
            <a href="signup.html">Register</a>
          </span>
          <a href="#" class="td_btn td_style_1 td_medium">
            <span class="td_btn_in td_white_color td_accent_bg">
              <span>Apply Now</span>
              <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg> 
            </span>             
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="td_main_header">
    <div class="container">
      <div class="td_main_header_in">
        <div class="td_main_header_left">
          <a class="td_site_branding td_accent_color" href="index.html">
            <svg width="142" height="50" viewBox="0 0 142 50" fill="none" xmlns="http://www.w3.org/2000/svg">
              <!-- SVG Content Omitted for Brevity -->
            </svg>
          </a>
          <div class="td_header_category_wrap position-relative">
            <button class="td_header_dropdown_btn td_medium td_heading_color">
              <img src="{{ asset('assets/img/icons/menu-square.svg') }}" alt="" class="td_header_dropdown_btn_icon">
              <span>All Category</span>
              <span class="td_header_dropdown_btn_tobble_icon td_center">
                <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M9 4.99997C9 4.99997 6.05404 1.00001 4.99997 1C3.94589 0.999991 1 5 1 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg> 
              </span>                 
            </button>
            <ul class="td_header_dropdown_list td_mp_0">
              <li><a href="courses-grid-view.html">Data Science</a></li>
              <li><a href="courses-grid-view.html">Design</a></li>
              <li><a href="courses-grid-with-sidebar.html">Development</a></li>
              <li><a href="courses-grid-view.html">Architecture</a></li>
              <li><a href="courses-grid-with-sidebar.html">Life Style</a></li>
              <li><a href="courses-grid-with-sidebar.html">Marketing</a></li>
              <li><a href="courses-grid-with-sidebar.html">Photography</a></li>
              <li><a href="courses-grid-with-sidebar.html">Motivation</a></li>
            </ul>
          </div>
        </div>

        <div class="td_main_header_right">
          <nav class="td_nav">
            <div class="td_nav_list_wrap">
              <div class="td_nav_list_wrap_in">
                <ul class="td_nav_list">
                  <li class="menu-item-has-children">
                    <a href="index.html">Home</a>
                    <ul>
                      <li><a href="index.html">University</a></li>
                      <li><a href="home-v2.html">Online Educations</a></li>
                      <li><a href="home-v3.html">Education</a></li>
                      <li><a href="home-v4.html">Kindergarten</a></li>
                      <li><a href="home-v5.html">Modern Language</a></li>
                      <li><a href="home-v6.html">Al-Quran Learning</a></li>
                      <li><a href="home-v7.html">Motivation Speaker</a></li>
                      <li><a href="home-v8.html">Kitchen Coach</a></li>
                    </ul>
                  </li>
                  <li class="menu-item-has-children">
                    <a href="products.html">Courses</a>
                    <ul>
                      <li><a href="courses-grid-view.html">Courses Grid View</a></li>
                      <li><a href="courses-list-view.html">Courses List View</a></li>
                      <li><a href="courses-grid-with-sidebar.html">Courses Grid With Sidebar</a></li>
                      <li><a href="course-details.html">Course Details</a></li>
                    </ul>
                  </li>
                  <li><a href="about.html">About</a></li>
                  <li class="menu-item-has-children td_mega_menu">
                    <a href="#">Pages</a>
                    <ul class="td_mega_wrapper">
                      <li class="menu-item-has-children">
                        <h4>Inner Pages</h4>
                        <ul>
                          <li><a href="event.html">Upcoming Event</a></li>
                          <li><a href="event-details.html">Event Details</a></li>
                          <li><a href="team-members.html">Team Members</a></li>
                          <li><a href="team-member-details.html">Team Details</a></li>
                        </ul>
                      </li>
                      <li class="menu-item-has-children">
                        <h4>Inner Pages</h4>
                        <ul>
                          <li><a href="students-registrations.html">Students Registrations</a></li>
                          <li><a href="instructor-registrations.html">Instructor Registrations</a></li>
                          <li><a href="signup.html">Signup</a></li>
                          <li><a href="signin.html">Signin</a></li>
                        </ul>
                      </li>
                      <li class="menu-item-has-children">
                        <h4>Shop Pages</h4>
                        <ul>
                          <li><a href="faqs.html">Faqs</a></li>
                          <li><a href="cart.html">Cart</a></li>
                          <li><a href="checkout.html">Checkout</a></li>
                          <li><a href="error.html">Error</a></li>
                        </ul>
                      </li>
                    </ul>
                  </li>
                  <li class="menu-item-has-children">
                    <a href="#">Blogs</a>
                    <ul>
                      <li><a href="blog.html">Blogs</a></li>
                      <li><a href="blog-with-sidebar.html">Blog With Sidebar</a></li>
                      <li><a href="blog-details.html">Blog Details</a></li>
                    </ul>
                  </li>
                  <li><a href="contact.html">Contact</a></li>
                </ul>
              </div>
            </div>
          </nav>

          <div class="td_hero_icon_btns position-relative">
            <div class="position-relative">
              <button class="td_circle_btn td_center td_search_tobble_btn" type="button">
                <img src="{{ asset('assets/img/icons/search_2.svg') }}" alt="">                                     
              </button>
              <div class="td_header_search_wrap">
                <form action="#" class="td_header_search">
                  <input type="text" class="td_header_search_input" placeholder="Search For Anything">
                  <button class="td_header_search_btn td_center">
                    <img src="{{ asset('assets/img/icons/search_2.svg') }}" alt="">
                  </button>
                </form>
              </div>
            </div>
            <button class="td_circle_btn td_center td_wishlist_btn" type="button">
              <img src="{{ asset('assets/img/icons/love.svg') }}" alt="">
              <span class="td_circle_btn_label">0</span>
            </button>
            <button class="td_circle_btn td_center" type="button">
              <img src="{{ asset('assets/img/icons/cart.svg') }}" alt="">  
              <span class="td_circle_btn_label">0</span>                                                       
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
<!-- End Header Section -->



<!-- Start Page Heading Section -->
<section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble" data-src="{{ asset('assets/img/others/page_heading_bg.jpg') }}">
  <div class="container">
    <div class="td_page_heading_in">
      <h1 class="td_white_color td_fs_48 td_mb_10">Contact</h1>
      <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active">Contact</li>
      </ol>
    </div>
  </div>
  <div class="td_page_heading_shape_1 position-absolute td_hover_layer_3"></div>
  <div class="td_page_heading_shape_2 position-absolute td_hover_layer_5"></div>
  <div class="td_page_heading_shape_3 position-absolute">
    <img src="{{ asset('assets/img/others/page_heading_shape_3.svg') }}" alt="">
  </div>
  <div class="td_page_heading_shape_4 position-absolute">
    <img src="{{ asset('assets/img/others/page_heading_shape_4.svg') }}" alt="">
  </div>
  <div class="td_page_heading_shape_5 position-absolute">
    <img src="{{ asset('assets/img/others/page_heading_shape_5.svg') }}" alt="">
  </div>
  <div class="td_page_heading_shape_6 position-absolute td_hover_layer_3"></div>
</section>
<!-- End Page Heading Section -->


<!-- Start Contact Section -->
<section>
  <div class="td_height_120 td_height_lg_80"></div>
 
  <!-- Bura elave -->
  
<style>
  :root{
    --bg:#ffffff;
    --text:#0f172a;
    --muted:#64748b;
    --line:#e5e7eb;
    --accent:#e31b23;
    --card:#ffffff;
    --shadow:0 10px 30px rgba(2,6,23,.06);
    --radius:14px;
  }
  *{box-sizing:border-box}
  body{
    margin:0;
    font-family: ui-sans-serif,system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Arial,Apple Color Emoji,Segoe UI Emoji;
    color:var(--text);
    background:var(--bg);
    line-height:1.55;
  }
  .wrap{max-width:1180px;margin:48px auto;padding:0 20px}

  /* Titles */
  .section-title{
    font-size:32px; font-weight:800; margin:0 0 18px;
  }
  .subtitle{
    font-size:13px; letter-spacing:.08em; text-transform:uppercase; color:var(--muted);
    display:inline-flex; align-items:center; gap:10px; margin-bottom:6px;
  }
  .subtitle .bar{
    width:46px; height:2px; background:var(--accent); display:inline-block; border-radius:2px;
  }

  /* Grid */
  .grid{
    display:grid; grid-template-columns: 1.05fr .95fr; gap:40px; align-items:start;
  }
  @media (max-width: 960px){
    .grid{grid-template-columns:1fr; gap:28px}
  }

  /* Left: contact details */
  .details{
    background:var(--card); border:1px solid var(--line); border-radius:var(--radius);
    padding:24px 22px; box-shadow:var(--shadow);
  }
  .list{margin:0; padding:0; list-style:none}
  .row{
    display:flex; gap:14px; align-items:flex-start;
    padding:1px 6px; border-top:1px dashed var(--line);
  }
  .row:first-child{border-top:none}
  .icon{
    width:22px; height:22px; flex:0 0 22px; margin-top:2px;
    background: radial-gradient(10px 10px at 60% 40%, #fff 40%, #ffd1d3 41%) , var(--accent);
    -webkit-mask: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24"><path d="M4.293 11.293a1 1 0 0 0 0 1.414l4.95 4.95a1 1 0 0 0 1.414 0l9.05-9.05a1 1 0 1 0-1.414-1.414L10 15.086l-4.243-4.243a1 1 0 0 0-1.464.45Z"/></svg>') center/contain no-repeat;
            mask: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24"><path d="M4.293 11.293a1 1 0 0 0 0 1.414l4.95 4.95a1 1 0 0 0 1.414 0l9.05-9.05a1 1 0 1 0-1.414-1.414L10 15.086l-4.243-4.243a1 1 0 0 0-1.464.45Z"/></svg>') center/contain no-repeat;
  }
  .row strong{display:block; font-weight:700; margin-bottom:2px}
  .row a{color:#0ea5e9; text-decoration:none}
  .row a:hover{text-decoration:underline}
  .muted{color:var(--muted)}

  /* Right: form */
  .form{
    background:var(--card); border:1px solid var(--line); border-radius:var(--radius);
    padding:24px; box-shadow:var(--shadow);
  }
  .form h2{margin:0 0 10px; font-size:32px}
  .fields{display:grid; grid-template-columns:1fr 1fr; gap:4px}
  .fields .full{grid-column:1 / -1}
  .input, .textarea{
    width:100%; border:1px solid var(--line); border-radius:10px; padding:14px 14px;
    font-size:15px; outline:none; background:#fff;
    transition:border-color .2s, box-shadow .2s;
  }
  .input:focus, .textarea:focus{
    border-color:#fecaca;
    box-shadow:0 0 0 4px rgba(227,27,35,.08);
  }
  .textarea{min-height:160px; resize:vertical}
  .btn{
    margin-top:14px; display:inline-flex; align-items:center; justify-content:center;
    padding:12px 28px; border:none; border-radius:10px; background:var(--accent); color:#fff;
    font-weight:700; cursor:pointer; transition:transform .05s ease, filter .15s ease;
  }
  .btn:hover{filter:brightness(.95)}
  .btn:active{transform:translateY(1px)}
</style>

  <div class="wrap">
    <!-- LEFT TITLE -->
    <div class="subtitle">
      TELEPHONE AND EMAIL <span class="bar"></span>
    </div>
    <h1 class="section-title">Contact details</h1>

    <div class="grid">
      <!-- LEFT: DETAILS -->
      <div class="details">
        <ul class="list">
          <li class="row">
            <span class="icon" aria-hidden="true"></span>
            <div>
              <strong>Telephone:</strong>
              <a href="tel:+994512067288">(+994) 51-206-72-88</a>
            </div>
          </li>

          <li class="row">
            <span class="icon" aria-hidden="true"></span>
            <div>
              <strong>For general inquiries:</strong>
              <a href="mailto:info@hse.az">info@hse.az</a>
            </div>
          </li>

          <li class="row">
            <span class="icon" aria-hidden="true"></span>
            <div>
              <strong>For purchasing training courses and getting information about them:</strong>
              <a href="mailto:training@hse.az">training@hse.az</a>
            </div>
          </li>

          <li class="row">
            <span class="icon" aria-hidden="true"></span>
            <div>
              <strong>For exam / assessment results of courses:</strong>
              <a href="mailto:customerservice@hse.az">customerservice@hse.az</a>
            </div>
          </li>

          <li class="row">
            <span class="icon" aria-hidden="true"></span>
            <div>
              <strong>Shopping for other products:</strong>
              <a href="mailto:shopping@hse.az">shopping@hse.az</a>
            </div>
          </li>

          <li class="row">
            <span class="icon" aria-hidden="true"></span>
            <div>
              <strong>Address:</strong>
              <span class="muted">
                Tbilisi Avenue 22, "Europe Hotel" 2nd Floor, Room 106, Baku, Azerbaijan, AZ1078
              </span>
            </div>
          </li>
        </ul>
      </div>

      <!-- RIGHT: FORM -->
      <div>
        <div class="subtitle">
          ONLINE CONTACT FORM <span class="bar"></span>
        </div>
        <div class="form">
          <h2>Message to us</h2>

     <form method="POST" action="{{ route('contact.send') }}" id="contactForm" novalidate>
  @csrf
  <div class="fields">
    <input class="input" name="full_name" type="text" placeholder="Name and surname" required />
    <input class="input" name="email"     type="email" placeholder="Email" required />
    <input class="input full" name="phone" type="text"  placeholder="+994" />
    <input class="input full" name="topic" type="text"  placeholder="Topic" />
    <textarea class="textarea full" name="message" placeholder="Your message" required></textarea>

    {{-- Honeypot üçün (istəsən) --}}
    {{-- <input type="text" name="website" style="display:none"> --}}
  </div>

  <button style="background-color:#e31b23;color:white" class="btn" type="submit">
    <span class="btn-text">Send</span>
    <span class="btn-spinner" style="display:none;margin-left:8px;">⏳</span>
  </button>
</form>

<script>
document.getElementById('contactForm')?.addEventListener('submit', function(){
  const btn = this.querySelector('.btn');
  const text = this.querySelector('.btn-text');
  const spin = this.querySelector('.btn-spinner');
  btn.disabled = true; if (text && spin){ text.style.opacity=.8; spin.style.display='inline-block'; }
});
</script>

        </div>
      </div>
    </div>
  </div>



  <div class="td_height_120 td_height_lg_80"></div>
  <div class="td_map">
    <iframe id="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d96652.27317354927!2d-74.33557928194516!3d40.79756494697628!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c3a82f1352d0dd%3A0x81d4f72c4435aab5!2sTroy+Meadows+Wetlands!5e0!3m2!1sen!2sbd!4v1563075599994!5m2!1sen!2sbd" allowfullscreen=""></iframe>
  </div>
</section>
<!-- End Contact Section -->

