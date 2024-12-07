@extends('frontend')

@section('title', 'Power Gym - Home')

@section('content')

    <section id="hero" >
    
    <div id="hero-slider">
      <div class="hero-slide-item" style="background-image:url('https://i0.wp.com/connectthewatts.com/wp-content/uploads/sites/11/2021/03/silofit-1-scaled-1.jpg');">
        <div class="hero-slider-marketing">
          <a href="#" class="youtube-button"><span class="fa fa-play"></span></a>
          <h2>Get Strong. Power Gym.</h2>
          <a href="{{ route('membership.store') }}">Explore</a>


        </div>
      </div>

      <div class="hero-slide-item" style="background-image:url('https://www.trainaway.fit/wp-content/uploads/2019/08/tartu6-1-e1566570527629.jpg');">
        <div class="hero-slider-marketing">
          <a href="#" class="youtube-button"><span class="fa fa-play"></span></a>
          <h2>Fit Starts Here.</h2>
          <a href="{{ route('membership.store') }}">Join Us</a>
        </div>
      </div>

      <div class="hero-slide-item" style="background-image:url('https://images.pexels.com/photos/1552252/pexels-photo-1552252.jpeg?cs=srgb&dl=pexels-leon-ardho-1552252.jpg&fm=jpg');">
        <div class="hero-slider-marketing">
          <a href="" class="youtube-button"><span class="fa fa-play"></span></a>
          <h2>Power Up!</h2>
          <a href="{{ route('membership.store') }}">See How</a>


        </div>
      </div>
    </div>
  </section>


    <section id="features" class="animated-section" style="background-image: url('https://i.pinimg.com/originals/4f/42/ff/4f42ffa0e11543bea178d0c1cb312c90.jpg');">
    <div class="flex container">
      <div class="box">
        
        <div class="feature-info-container">
          <div class="icon">
          <i class="fas fa-dumbbell"></i>

          </div>
          <h4>Amazing Setting</h4>
<p>Our gym features state-of-the-art equipment, spacious workout areas, and a motivating atmosphere to help you achieve your fitness goals. Whether you're looking to build muscle, increase endurance, or just stay active, our facilities cater to all levels of fitness enthusiasts.</p>

        </div>
      </div>

      <div class="box">
        
        <div class="feature-info-container">
          <div class="icon">
          <i class="fas fa-user"></i>
          </div>
          <h4>Best Trainers</h4>
<p>Our certified trainers are passionate about your success and dedicated to guiding you on your fitness journey. With personalized training plans, nutritional advice, and continuous support, they ensure you're equipped to meet and surpass your fitness goals.</p>

        </div>
      </div>

      <div class="box">
        
        <div class="feature-info-container">
          <div class="icon">
          <i class="fas fa-utensils"></i>
          </div>
          <h4>Diet Plans</h4>
<p>Unlock your full potential with our tailored diet plans designed to fuel your fitness journey. Whether your goal is weight loss, muscle gain, or improved health, our expert nutritionists craft personalized meal strategies that complement your workout regime and dietary preferences.</p>

        </div>
      </div>
    </div>
  </section>
  <script>
document.addEventListener('DOMContentLoaded', function() {
  var form = document.getElementById('bmi-form');
  var loader = document.querySelector('.loader-5');
  var resultContainer = document.getElementById('bmi-result');

  form.addEventListener('submit', function(event) {
    event.preventDefault();

    // Show the loader
    loader.style.display = 'inline-block';
    resultContainer.innerHTML = ''; // Clear previous results

    // Delay calculation to simulate loading
    setTimeout(function() {
      var age = document.getElementById('age').value;
      var height = document.getElementById('height').value;
      var weight = document.getElementById('weight').value;

      if (height <= 0 || weight <= 0) {
        resultContainer.innerHTML = `<p>Please enter valid height and weight values.</p>`;
      } else {
        var bmi = calculateBMI(weight, height);
        var resultText = getBMICategory(bmi);
        resultContainer.innerHTML = `<p>Your BMI is ${bmi}. ${resultText}</p>`;
      }

      // Hide the loader
      loader.style.display = 'none';
    }, 5000);
  });

  function calculateBMI(weight, height) {
    return (weight / ((height / 100) * (height / 100))).toFixed(2);
  }

  function getBMICategory(bmi) {
    if (bmi < 16) return "Severely underweight - It's crucial to seek advice from healthcare professionals to understand and address the underlying causes.";
    if (bmi >= 16 && bmi < 18.5) return "Underweight - It's recommended to eat a balanced diet and consult a healthcare provider to gain weight healthily.";
    if (bmi >= 18.5 && bmi < 22) return "Normal weight - You're doing great maintaining a healthy weight! Keep up with your balanced diet and regular exercise.";
    if (bmi >= 22 && bmi <= 24.9) return "Normal weight, closer to overweight - You're at the higher end of the healthy weight range. Consider monitoring your diet and exercise to maintain your weight.";
    if (bmi >= 25 && bmi < 27) return "Overweight - You're slightly over the ideal weight range. Consider adopting healthier eating habits and increasing physical activity.";
    if (bmi >= 27 && bmi <= 29.9) return "Overweight, closer to obesity - It's advisable to take steps towards a healthier lifestyle through improved diet and more exercise to prevent obesity.";
    if (bmi >= 30 && bmi < 35) return "Obesity, Class I - It's important to consult a healthcare provider for advice on achieving a healthier weight through diet and exercise.";
    if (bmi >= 35 && bmi < 40) return "Obesity, Class II - Significant health risks are associated with this weight. Professional guidance on diet and exercise is recommended.";
    return "Obesity, Class III - Extremely high health risks are present. Immediate medical intervention is essential for health improvement.";
  }


});
</script>

<section id="bmi-calculator" class="animated-section" style="background-color: black; color: white;">
  <div class="container">
    <h3 style="color: red;">Calculate Your BMI</h3>
    <form id="bmi-form">
      <div class="form-group">
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required>
      </div>
      <div class="form-group">
        <label for="height">Height (in cm):</label>
        <input type="number" id="height" name="height" required>
      </div>
      <div class="form-group">
        <label for="weight">Weight (in kg):</label>
        <input type="number" id="weight" name="weight" required>
      </div>
      <button type="submit" style="background-color: red; color: white;">Calculate BMI</button>
    </form>
    <!-- Loader is initially hidden and shown when form is submitted -->
    <div><span class="loader-5"></span></div>
    <div id="bmi-result" style="margin-top: 20px;"></div>
  </div>
</section>

<section id="services" class="animated-section" style="background-image: url('https://images.unsplash.com/photo-1597773150796-e5c14ebecbf5?q=80&w=1000&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8ZGFyayUyMGJsdWV8ZW58MHx8MHx8fDA%3D'); background-repeat: no-repeat; background-size: cover;">

  <h3>Services</h3>
  <div class="flex container">
    <div class="box">
      <img src="https://hips.hearstapps.com/hmg-prod/images/gettyimages-495506158-1528304491.jpg" alt="Dumbbell Icon" />
      <h4>Pilates</h4>
      <p>State-of-the-art Pilates classes tailored to your fitness level. Strengthen your core, improve flexibility, and enhance overall well-being.</p>
    </div>

    <div class="box">
      <img src="https://assets.gqindia.com/photos/5cdc0e49d0e160243a100354/1:1/w_1080,h_1080,c_limit/weight-workout.jpg" alt="Weightlifting Icon" />
      <h4>Free Lifting</h4>
      <p>Unleash your strength with free lifting sessions. Build muscle, increase endurance, and achieve your fitness goals with expert guidance.</p>
    </div>

    <div class="box">
      <img src="https://static.nike.com/a/images/f_auto/dpr_3.0,cs_srgb/h_484,c_limit/a4baaac3-01f0-4cf4-bad7-036a30f664bf/les-trois-meilleures-postures-de-yoga-pour-gagner-en-force-selon-les-experts.jpg" alt="Yoga Icon" />
      <h4>Yoga</h4>
      <p>Discover inner peace and balance with our yoga classes. Enhance flexibility, reduce stress, and foster holistic well-being.</p>
    </div>

    <div class="box">
      <img src="https://hips.hearstapps.com/hmg-prod/images/shot-of-a-sporty-young-man-doing-plank-exercises-at-royalty-free-image-1702313402.jpg?crop=0.668xw:1.00xh;0.145xw,0&resize=640:*" alt="Spinning Icon" />
      <h4>Spinning</h4>
      <p>Elevate your cardio fitness with spinning sessions. Burn calories, improve cardiovascular health, and experience the thrill of indoor cycling.</p>
    </div>
  </div>

  <a href="{{ route('membership.store') }}">See all services </a>

</section>



  <section id="trainers" class="animated-section">
    <h5>The Best</h5>
    <h3>Trainers Equipment</h3>
    <div class="container">
      <div id="trainers-slider">
        <div class="trainer-slider-item">
          <img src="https://shop.lifefitness.com/cdn/shop/products/Rubber-Hex-Dumbbell-L_1_1800x1800_78ea050c-4f5a-4e8a-bdae-a664272eac80_1200x1200.jpg?v=1619710214"  />
          <h4>Basics Easy Grip Workout</h4>
          <p>Dumbbell</p>
        </div>

        <div class="trainer-slider-item">
          <img src="https://i5.walmartimages.com/seo/Body-Sport-Cast-Iron-Vinyl-Coated-Kettlebells-45-lb-Gray-Kettlebell-for-Weight-Lifting-Strength-Training_7451d948-41a1-45fc-8929-bd564a9b47cc.a68ba549510e896b45168b85141a9920.jpeg" />
          <h4>Kettlebell</h4>
          <p>Vinyl Coated Cast</p>
          <p> Iron</p>
        </div>

        <div class="trainer-slider-item">
          <img src="https://shop.lifefitness.com/cdn/shop/products/c1-upright-bike-track-2.0-callout-1000x1000_1200x1200.jpg?v=1700249874"/>
          <h4>SQUATZ</h4>
          <p>Stationary Cycling Bike Exerciser</p>
        </div>

        <div class="trainer-slider-item">
          <img src="https://shop.lifefitness.com/cdn/shop/products/Rubber-Hex-Dumbbell-L_1_1800x1800_78ea050c-4f5a-4e8a-bdae-a664272eac80_1200x1200.jpg?v=1619710214" />
          <h4>Basics Easy Grip Workout</h4>
          <p>Dumbbell</p>
        </div>

        <div class="trainer-slider-item">
          <img src="https://i5.walmartimages.com/seo/Body-Sport-Cast-Iron-Vinyl-Coated-Kettlebells-45-lb-Gray-Kettlebell-for-Weight-Lifting-Strength-Training_7451d948-41a1-45fc-8929-bd564a9b47cc.a68ba549510e896b45168b85141a9920.jpeg"/>
          <h4>Kettlebell</h4>
          <p>Vinyl Coated Cast</p>
          <p> Iron</p>
        </div>

        <div class="trainer-slider-item">
          <img src="https://shop.lifefitness.com/cdn/shop/products/c1-upright-bike-track-2.0-callout-1000x1000_1200x1200.jpg?v=1700249874" />
          <h4>SQUATZ</h4>
          <p>Stationary Cycling Bike Exerciser</p>
        </div>
      </div>
    </div>
  </section>
  
  <section id="schedule-services" class="animated-section">
    <div class="flex container">
      <div class="upcoming-classes-box">
        <strong>NEXT</strong>
        <h4>Upcoming Classes</h4>
        <table>
          <tr>
            
            <td>Gym Fitness</td>
            <td>11:00 - 12:00</td>
          </tr>

          <tr>
            
            <td>Pilates</td>
            <td>12:00 - 1:00</td>
          </tr>

          <tr>
            
            <td>Spinning</td>
            <td>1:00 - 2:00</td>
          </tr>

          <tr>
            
            <td>Yoga</td>
            <td>2:00 - 3:00</td>
          </tr>

          <tr>
            
            <td>Zumba</td>
            <td>3:00 - 4:00</td>
          </tr>

          <tr>
            
            <td>Cardio Kickbox</td>
            <td>4:00 - 5:00</td>
          </tr>
        </table>
      </div>

      <div class="membership-cards-box">
        <div class="inner-container">
          <strong>NEXT</strong>
          <h4>Membership Deals</h4>
          <h2>25% <span>Discount</span></h2>
        </div>
      </div>

      <div class="personal-trainer-box">
        <strong>BECOME A</strong>
        <h4>Personal Trainer</h4>
        <p>Become a Personal Trainer and turn your passion for fitness into a fulfilling career. Inspire and empower individuals to achieve their health goals. Transform lives through personalized training and expert guidance.</p>
        <a href="{{ route('membership.store') }}">Fill form</a>

      </div>
    </div>
  </section>



  <div id="search-container">
    <span id="search-container-hide" class="fa fa-times"></span>
    <h3>Search</h3>
    <div class="search-container-input">
      <input type="text" name="search" placeholder="Search this site" />
      <button>Search</button>
    </div>
  </div>

  <div id="video-frame">
    <span id="video-frame-hide" class="fa fa-times"></span>
    <div class="video-frame-container">
      <div class="video-frame-scaler">
          <iframe id="embed-video" src="https://www.youtube.com/watch?v=d1YBv2mWll0&ab_channel=Sordiway" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>
    </div>
  </div>
  <section id="contact" class="animated-section" style="background-image: url('https://wallpapers.com/images/hd/blue-and-red-background-1920-x-1080-4vewvjh3l7zxso7z.jpg');">
  <footer>
    <div class="footer-container">
      <div id="footer-logo" class="top-gym-logo">
        <a href="#">Power<br/>Gym</a>
      </div>

      <nav>
        <ul>
            <li><a class="smooth-scroll-link" href="/">Home</a></li>
            <li><a class="smooth-scroll-link" href="#features">Training</a></li>
            <li><a class="smooth-scroll-link" href="{{ route('events.eventshow') }}" class="{{ request()->is('events.eventshow') ? 'active' : '' }}">Evenement</a></li>
            <li><a class="smooth-scroll-link" href="#trainers">Products</a></li>
            <li><a class="smooth-scroll-link" href="#footer">Contacts</a></li>
            <li>
        </ul>
      </nav>

      <div class="mailing-list">
        <input type="text" placeholder="YOUR EMAIL" />
        <button><a href="{{route('membership.store')}}">Fill form and join us</a></button>
      </div>


      <ul class="social-icons">
        <li><a href="#"><span class="fab fa-pinterest"></span></a></li>
        <li><a href="#"><span class="fab fa-facebook"></span></a></li>
        <li><a href="#"><span class="fab fa-twitter"></span></a></li>
        <li><a href="#"><span class="fab fa-youtube"></span></a></li>
        <li><a href="#"><span class="fab fa-behance"></span></a></li>
      </ul>

      <img src="https://onclickwebdesign.com/wp-content/uploads/footer-icon.png" class="bicep" alt="Bicep flex icon" />
    </div>
  </footer>
  </section>
@endsection
