<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/index.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <script src="https://api-maps.yandex.ru/2.1/?lang=en_RU&amp;apikey=447827c2-69e1-432f-98d0-7a05bc34852c" type="text/javascript"></script>
    <script src="icon_customImage.js" type="text/javascript"></script>
    <title>Zangar-M</title>
</head>
<body>
    <div class="page">
        <header>
            <nav class="desktop">
                <ul>
                    <li><a href="#" id="brand">Zangar<span>-M</span></a></li>
                    <li class="menu active"><a href="#home">Home</a></li>
                    <li class="menu"><a href="#about">About</a></li>
                    <li class="menu"><a href="#courses">Courses</a></li>
                    <li class="menu"><a href="#">Contact</a></li>
                </ul>
                <ul class="right-side">
                    <li><a href="#"><i class="fa-solid fa-magnifying-glass fa-xs"></i></a></li>
                    <li><a href="#">EN</a></li>
                    <li><a href="#">
                        <div class="toggle">
                            <i class="fa-solid fa-sun fa-2xs"></i>
                            <i class="fa-solid fa-moon fa-2xs"></i>
                        </div>
                    </a></li>
                    <li class="quiz"><a href="/login"><i class="fa-solid fa-question fa-xs"></i> Quiz</a></li>
                </ul>
                
            </nav>

            <nav class="mobile-nav">
                <ul>
                    <li class="menu active"><a href="#home">Home</a></li>
                    <li class="menu"><a href="#about">About</a></li>
                    <li class="menu"><a href="#courses">Courses</a></li>
                    <li class="menu"><a href="#">Contact</a></li>
                </ul>
                <ul class="right-side">
                    <li><a href="#"><i class="fa-solid fa-magnifying-glass fa-xs"></i></a></li>
                    <li><a href="#">EN</a></li>
                    <li><a href="#">
                        <div class="toggle">
                            <i class="fa-solid fa-sun fa-2xs"></i>
                            <i class="fa-solid fa-moon fa-2xs"></i>
                        </div>
                    </a></li>
                    <li class="quiz"><a href="#"><i class="fa-solid fa-question fa-xs"></i> Quiz</a></li>
                </ul>
            </nav>
            <div class="mobile">
                <li><a href="#" id="brand">Zangar<span>-M</span></a></li>
                <i class="fa fa-bars fa-2x"></i>
            </div>
            
        </header>

        <main>
            <div class="home" id="home">
                <div class="info">
                    <h1>Reach your goal with us <br> <span> and step into a bright future</span></h1>

                    <p>Zangar-M is the best investment in education.You can take online
                        video tutorials on this site and perform tests to check your level of
                        knowledge.
                    </p>
                    <div class="courses">
                        <button class="more">LEARN MORE <i class="fa-solid fa-chevron-right"></i></button>
                    
                        <li class="mobile-quiz"><a href="#"><i class="fa-solid fa-question fa-xs"></i> Quiz</a></li>
                    </div>
                    
                </div>
                <div class="student">
                    <img src="{{ asset('images/student.png') }}" alt="">
                </div>
            </div>
            <div class="part_1">
                <div class="card">
                    <i class="fa-sharp fa-solid fa-circle-check fa-4x"></i>
                    <h3>Powerful Program</h3>
                    <p>Our programs are up-to-dote
                        with prevaling practices.
                    </p>
                    <i class="fa-solid fa-circle-arrow-right fa-3x"></i>
                </div>

                <div class="card">
                    <i class="fa-solid fa-circle-user fa-4x"></i>
                    <h3>24/7 Support</h3>
                    <p>Our programs are up-to-dote
                        with prevaling practices.
                    </p>
                    <i class="fa-solid fa-circle-arrow-right fa-3x"></i>
                </div>
                
                <div class="futures">
                    <h2>Our Best Fetures</h2>
                    <h2><span>Special For you</span></h2>
                    <p>Our programs are up-to-dote
                        with prevaling practices.
                    </p>
                    <button class="more">LEARN MORE <i class="fa-solid fa-chevron-right"></i></button>
                </div>
            </div>
            
            <div class="title_info">
                <P>Join our best course</P>
                <h2 class="title">COURSES</h2>
            </div>
            
            <div class="courses" id="courses">

                <div class="course_card">
                    <img src="{{ asset('images/1.jpg') }}" alt="Talipov Dastan">
                    <div class="course_info">
                        <h5 class="teacher_name">Talipov Dastan</h5>
                        <h4>Course of mathematics and mathematical literacy</h4>
                        <p>Mathematical Literacy for College Students 
                            is a one semester course for non-math and 
                            non-science majors integrating numeracy.
                        </p>
                        <button class="start_button"><a href="">START</a></button>
                    </div>
                </div>

                <div class="course_card">
                    <img src="{{ asset('images/2.jpeg') }}" alt="Abdulatipov Abdubosit">
                    <div class="course_info">
                        <h5 class="teacher_name">Abdulatipov Abdubosit</h5>
                        <h4>Physics</h4>
                        <p>Mathematical Literacy for College Students 
                            is a one semester course for non-math and 
                            non-science majors integrating numeracy.
                        </p>
                        <button class="start_button">START</button>

                    </div>
                </div>

                <div class="course_card">
                    <img src="{{ asset('images/3.jpg') }}" alt="Osmankulov Mirzahid">
                    <div class="course_info">
                        <h5 class="teacher_name">Osmankulov Mirzahid</h5>
                        <h4>Chemistry and Biology</h4>
                        <p>Mathematical Literacy for College Students 
                            is a one semester course for non-math and 
                            non-science majors integrating numeracy.
                        </p>
                        <button class="start_button">START</button>

                    </div>
                </div>
            </div>

            <div class="title_info" id="title">
                <P>Learn more about us</P>
                <h2 class="title">ABOUT OUR SCHOOL</h2>
            </div>

            <div class="about" id="about">
                <div class="about_school">
                    <img src="{{ asset('images/4.jpg') }}" alt="">
                    <div>
                        <h2 class="title">ABOUT OUR SCHOOL</h2>
                        <p>Most schools in our city are comprehensive. 
                            Ours is a lyceum so our pupils come from different parts of the city. 
                            The school holds over 1200 pupils and about 100 teachers. 
                            The classrooms for junior forms are on the ground floor. 
                            They look cosy. The walls are decorated with pictures and there are 
                            nice curtains on the large windows. I think, children feel at home here. 
                            The classrooms for senior students are on the upper floors. 
                            Our principal's office is on the ground floor. 
                            At the beginning of the corridor, on the right are gym and a workshop for girls, 
                            and on the left - workshop for boys. 
                            The library and the canteen are on the first floor. 
                            The computer class is on the first floor, too. 
                            It is very popular with our pupils, as many of them are fond of computer games. 
                            It's a pity we have no Assembly Hall and all school celebrations and 
                            gatherings are held in the gym. The school is rather well equipped. 
                            Tape recorders and record players are used at different lessons. 
                            Chemistry, physics and biology are taught in well-equipped labs. 
                            The students carry out experiments and make careful observations there. 
                            Our classes start at half past eight and are over at half past one. 
                            Some pupils live far from school so they have to get there by bus, 
                            by tram or by trolley-bus. My school is from Monday till Saturday 
                            so we have only one day off. If we had one more day off we would devote 
                            our spare time to entertainment, theatres, museums, sports and different 
                            hobby clubs.

                            The administration and staff are committed to providing a challenging and 
                            supportive learning environment where all students can succeed and reach their 
                            full potential. Every member participates in cycles of continuous learning and 
                            improvement that includes establishing high expectations, goal setting, planning, 
                            action and reflection. We develop a culture of excellence that includes a robust 
                            instructional program aligned to the Common Core State Standards (CCSS) 
                            with a focus on implementing Balanced Literacy through Reading and 
                            Writing Workshop, as well as by building language
                        </p>
                        <button class="more">LEARN MORE <i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                </div>

                <div class="about_school" id="hide">
                    <div>
                        <h2 class="title">ABOUT OUR SCHOOL</h2>
                        <p>Most schools in our city are comprehensive. 
                            Ours is a lyceum so our pupils come from different parts of the city. 
                            The school holds over 1200 pupils and about 100 teachers. 
                            The classrooms for junior forms are on the ground floor. 
                            They look cosy. The walls are decorated with pictures and there are 
                            nice curtains on the large windows. I think, children feel at home here. 
                            The classrooms for senior students are on the upper floors. 
                            Our principal's office is on the ground floor. 
                            At the beginning of the corridor, on the right are gym and a workshop for girls, 
                            and on the left - workshop for boys. 
                            The library and the canteen are on the first floor. 
                            The computer class is on the first floor, too. 
                            It is very popular with our pupils, as many of them are fond of computer games. 
                            It's a pity we have no Assembly Hall and all school celebrations and 
                            gatherings are held in the gym. The school is rather well equipped. 
                            Tape recorders and record players are used at different lessons. 
                            Chemistry, physics and biology are taught in well-equipped labs. 
                            The students carry out experiments and make careful observations there. 
                            Our classes start at half past eight and are over at half past one. 
                            Some pupils live far from school so they have to get there by bus, 
                            by tram or by trolley-bus. My school is from Monday till Saturday 
                            so we have only one day off. If we had one more day off we would devote 
                            our spare time to entertainment, theatres, museums, sports and different 
                            hobby clubs.

                            The administration and staff are committed to providing a challenging and 
                            supportive learning environment where all students can succeed and reach their 
                            full potential. Every member participates in cycles of continuous learning and 
                            improvement that includes establishing high expectations, goal setting, planning, 
                            action and reflection. We develop a culture of excellence that includes a robust 
                            instructional program aligned to the Common Core State Standards (CCSS) 
                            with a focus on implementing Balanced Literacy through Reading and 
                            Writing Workshop, as well as by building language
                        </p>
                        <button class="more">LEARN MORE <i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                    <img src="images/school.jpg" alt="">
                </div>
            </div>
        </main>

        <footer>
            <h2>Contact us</h2>
            <div class="contact">
                <div>
                    <div class="visitka">
                        <i class="fa-sharp fa-solid fa-mobile-screen-button fa-2x"></i>
                        <p>PHONE</p>
                        <p>Office: +7 (747) 432 06 06</p>
                        <p>School ad: +7 (747) 432 06 06</p>
                    </div>

                    <div class="visitka">
                        <i class="fa-solid fa-envelope fa-2x"></i>
                        <p>EMAIL</p>
                        <p>190103326@stu.sdu.edu.kz</p>
                        <p>abdulatipov0101@gmail.com</p>
                    </div>

                    <div class="visitka">
                        <i class="fa-solid fa-location-dot fa-2x"></i>
                        <p>ADDRESS</p>
                        <p>Turkestan region, Sauran district,</p>
                        <p>Zhuynek village, Kokterek street, No. 33</p>
                    </div>
                </div>

                <div class="map_mail">
                    <div class="map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8852.7025684622!2d68.26962382883166!3d43.42095901502262!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4200d9e3732b375d%3A0xe85646004315c50e!2z0JfQsNKj0pPQsNGAINC80LXQutGC0LXQsdGW!5e0!3m2!1sen!2skz!4v1676205671135!5m2!1sen!2skz" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>

                    <div class="mail">
                        <div id="div1">
                            <input type="text" placeholder="Your Name">
                            <input type="text" placeholder="Your Email">
                        </div>
                        <div>
                            <input type="text" placeholder="Subject">
                        </div>
                        <div>
                            <input type="text" name="Message" placeholder="Message" id="message">
                        </div>
                        <input type="button" value="SEND MESSAGE" id="button">
                    </div>
                </div>
            </div>

            <div class="fa">
                <i class="fa-brands fa-facebook fa-2x"></i>
                <i class="fa-brands fa-instagram fa-2x"></i>
                <i class="fa-brands fa-telegram fa-2x"></i>
                <i class="fa-brands fa-twitter fa-2x"></i>
            </div>
        </footer>
    </div>
   <script src="{{ asset('js/index.js') }}"></script>
</body>
</html>