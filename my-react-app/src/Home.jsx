import React from 'react';
import { Link } from 'react-router-dom';
import './Home.css'; // Import custom CSS

// Import images (replace with actual paths after downloading)
import logo from './assets/logo.png';
import slider1 from './assets/slider1.jpg';
import slider2 from './assets/slider2.jpg';
import slider3 from './assets/slider3.jpg';
import doctor1 from './assets/doctor1.jpg';
import doctor2 from './assets/doctor2.jpg';

const Home = () => {
  return (
    <div className="home-page" id="home">
      {/* Header */}
      <header className="header bg-light py-3">
        <div className="container d-flex justify-content-between align-items-center">
          <div className="logo">
            <img src={logo} alt="HealthCare Clinic Logo" className="logo-img" />
            
          </div>
          <nav className="navbar navbar-expand-lg">
            <ul className="navbar-nav">
              <li className="nav-item"><Link className="nav-link" to="/">Home</Link></li>
              <li className="nav-item"><Link className="nav-link" to="/about">About Us</Link></li>
              <li className="nav-item"><Link className="nav-link" to="/#services">Medical Services</Link></li>
              <li className="nav-item"><Link className="nav-link" to="/appointment">Appointment</Link></li>
              <li className="nav-item"><Link className="nav-link" to="/contact">Contact Us</Link></li>
            </ul>
          </nav>
          <div className="header-actions">
            <a href="http://localhost/my-react-app/back-end/login.php" className="btn-login">Login</a>
          </div>
        </div>
      </header>

      {/* Image Slider */}
      <section className="slider">
        <div id="carouselExample" className="carousel slide" data-bs-ride="carousel">
          <div className="carousel-inner">
            <div className="carousel-item active">
              <img src={slider1} className="d-block w-100" alt="Clinic Interior" />
            </div>
            <div className="carousel-item">
              <img src={slider2} className="d-block w-100" alt="Doctors Team" />
            </div>
            <div className="carousel-item">
              <img src={slider3} className="d-block w-100" alt="Medical Facilities" />
            </div>
          </div>
          <button className="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span className="carousel-control-prev-icon" aria-hidden="true"></span>
          </button>
          <button className="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span className="carousel-control-next-icon" aria-hidden="true"></span>
          </button>
        </div>
      </section>

      {/* Welcome Message */}
      <section className="welcome text-center py-5 bg-primary text-white" id="about">
        <div className="container">
          <h2>Welcome to HealthCare Clinic</h2>
          <p>Your well-being, our priority.</p>
        </div>
      </section>

      {/* Short Introduction */}
      <section className="introduction py-5" id="services">
        <div className="container">
          <div className="row">
            <div className="col-md-4">
              <h3>Mission</h3>
              <p>To provide compassionate, high-quality healthcare services to our community, ensuring every patient receives personalized care.</p>
            </div>
            <div className="col-md-4">
              <h3>Services</h3>
              <p>We offer a wide range of medical services including general medicine, cardiology, pediatrics, and more. See our services page for details.</p>
            </div>
            <div className="col-md-4">
              <h3>Experience</h3>
              <p>With over 20 years of experience, our team of expert doctors and staff are dedicated to your health and recovery.</p>
            </div>
          </div>
        </div>
      </section>

      {/* Appointment Button */}
      <section className="appointment-cta text-center py-4 bg-light" id="appointment">
        <div className="container">
          <Link to="/appointment" className="btn btn-primary btn-lg">Book an Appointment</Link>
        </div>
      </section>

      {/* Testimonials */}
      <section className="testimonials py-5">
        <div className="container">
          <h3 className="text-center mb-4">Patient Testimonials</h3>
          <div className="row">
            <div className="col-md-6">
              <div className="testimonial-card p-3 border rounded">
                <img src={doctor1} alt="Patient 1" className="testimonial-img mb-2" />
                <p>"Excellent care and friendly staff. Highly recommend!"</p>
                <cite>- Doctor Aissaini</cite>
              </div>
            </div>
            <div className="col-md-6">
              <div className="testimonial-card p-3 border rounded">
                <img src={doctor2} alt="Patient 2" className="testimonial-img mb-2" />
                <p>"The doctors here are top-notch. My family trusts them completely."</p>
                <cite>- Doctor Bousetta</cite>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Footer (Basic, as per context) */}
      <footer className="footer bg-dark text-white py-3" id="contact">
        <div className="container text-center">
          <p>&copy; 2025 HealthCare Clinic. All rights reserved.</p>
          <p>Address: 123 Health St, Constantine, Algeria | Phone: (+213) 5-6122-7819 | Email: info@healthcareclinic.com</p>
          <p>Emergency Hotline: (+213) 5-3356-7891</p>
          <div className="social-links">
            <a href="#" className="text-white me-3">Facebook</a>
            <a href="#" className="text-white me-3">Twitter</a>
            <a href="#" className="text-white">Instagram</a>
          </div>
        </div>
      </footer>
    </div>
  );
};

export default Home;