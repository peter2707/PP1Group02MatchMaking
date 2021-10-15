/* Description: Custom JS file */

/* Navigation*/
// Collapse the navbar by adding the top-nav-collapse class

window.onscroll = function() {
    scrollFunction();
    scrollFunctionBTT(); // back to top button
};

window.onload = function() {
    scrollFunction();
};

function toggleAddUser() {
    if (document.getElementById('admin').checked) {
        document.getElementById('admin-form').style.display = '';
        document.getElementById('employer-form').style.display = 'none';
        document.getElementById('job-seeker-form').style.display = 'none';
    } else if (document.getElementById('employer').checked) {
        document.getElementById('admin-form').style.display = 'none';
        document.getElementById('employer-form').style.display = '';
        document.getElementById('job-seeker-form').style.display = 'none';
    } else if (document.getElementById('job-seeker').checked) {
        document.getElementById('admin-form').style.display = 'none';
        document.getElementById('employer-form').style.display = 'none';
        document.getElementById('job-seeker-form').style.display = '';
    }
}

function toggleRegister() {
    if (document.getElementById('employer').checked) {
        document.getElementById('employer-form').style.display = '';
        document.getElementById('job-seeker-form').style.display = 'none';
    } else if (document.getElementById('job-seeker').checked) {
        document.getElementById('employer-form').style.display = 'none';
        document.getElementById('job-seeker-form').style.display = '';
    }
}

function scrollFunction() {
    if (document.documentElement.scrollTop > 30) {
        document.getElementById("navbarExample").classList.add("top-nav-collapse");
    } else if (document.documentElement.scrollTop < 30) {
        document.getElementById("navbarExample").classList.remove("top-nav-collapse");
    }
}

// Navbar on mobile
let elements = document.querySelectorAll(".nav-link:not(.dropdown-toggle)");

for (let i = 0; i < elements.length; i++) {
    elements[i].addEventListener("click", () => {
        document.querySelector(".offcanvas-collapse").classList.toggle("open");
    });
}

document.querySelector(".navbar-toggler").addEventListener("click", () => {
    document.querySelector(".offcanvas-collapse").classList.toggle("open");
});

// Hover on desktop
function toggleDropdown(e) {
    const _d = e.target.closest(".dropdown");
    let _m = document.querySelector(".dropdown-menu", _d);

    setTimeout(
        function() {
            const shouldOpen = _d.matches(":hover");
            _m.classList.toggle("show", shouldOpen);
            _d.classList.toggle("show", shouldOpen);

            _d.setAttribute("aria-expanded", shouldOpen);
        },
        e.type === "mouseleave" ? 300 : 0
    );
}

// On hover
const dropdownCheck = document.querySelector('.dropdown');

if (dropdownCheck !== null) {
    document.querySelector(".dropdown").addEventListener("mouseleave", toggleDropdown);
    document.querySelector(".dropdown").addEventListener("mouseover", toggleDropdown);

    // On click
    document.querySelector(".dropdown").addEventListener("click", (e) => {
        const _d = e.target.closest(".dropdown");
        let _m = document.querySelector(".dropdown-menu", _d);
        if (_d.classList.contains("show")) {
            _m.classList.remove("show");
            _d.classList.remove("show");
        } else {
            _m.classList.add("show");
            _d.classList.add("show");
        }
    });
}


/* Card Slider - Swiper */
var cardSlider = new Swiper('.card-slider', {
    autoplay: {
        delay: 4000,
        disableOnInteraction: false
    },
    loop: true,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev'
    }
});


/* Image Slider - Swiper */
var imageSlider = new Swiper('.image-slider', {
    autoplay: {
        delay: 3000,
        disableOnInteraction: false
    },
    loop: true,
    spaceBetween: 50,
    slidesPerView: 5,
    breakpoints: {
        // when window is <= 575px
        575: {
            slidesPerView: 1,
            spaceBetween: 10
        },
        // when window is <= 767px
        767: {
            slidesPerView: 2,
            spaceBetween: 20
        },
        // when window is <= 991px
        991: {
            slidesPerView: 3,
            spaceBetween: 20
        },
        // when window is <= 1199px
        1199: {
            slidesPerView: 4,
            spaceBetween: 20
        },

    }
});


/* Back To Top Button */
// Get the button
myButton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
function scrollFunctionBTT() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        myButton.style.display = "block";
    } else {
        myButton.style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0; // for Safari
    document.documentElement.scrollTop = 0; // for Chrome, Firefox, IE and Opera
}

//add rich text editor
CKEDITOR.replace('descriptionTextArea', {
    extraPlugins: 'editorplaceholder',
    editorplaceholder: 'Job Descriptions...',
    height: "150px"
});

CKEDITOR.replace('requirementsTextArea', {
    extraPlugins: 'editorplaceholder',
    editorplaceholder: 'Job requirements...',
    height: "150px"
});


//register dropdown (carreer field)
var fieldOptions = {
    val1: 'Accounting',
    val2: 'Administration',
    val3: 'Advertising',
    val4: 'Agriculture',
    val5: 'Arts & Media',
    val6: 'Banking & Financial Services',
    val7: 'Customer Service',
    val8: 'Community',
    val9: 'Construction',
    val10: 'Consulting',
    val11: 'Design & Architecture',
    val12: 'Education & Training',
    val13: 'Engineering',
    val14: 'Government & Defence',
    val15: 'Healthcare & Medical',
    val16: 'Hospitality & Tourism',
    val17: 'Human Resource',
    val18: 'Information Technology',
    val19: 'Insurance',
    val20: 'Marketing',
    val21: 'Mineral Resource',
    val22: 'Real Estate & Property',
    val23: 'Retail & Consumer Products',
    val24: 'Science & Technology',
    val25: 'Sport & Recreation',
    val26: 'Trades & Services'
};

var fieldSelect = $('#fieldOfExpertise-form');
$.each(fieldOptions, function(val, text) {
    fieldSelect.append(
        $('<option></option>').val(text).html(text)
    );

});


//find match and post job salary drop down
var salaryOptions = {
    val1: '$25-$30/hr',
    val2: '$30-$35/hr',
    val3: '$35-$40/hr',
    val4: '$40-$45/hr',
    val5: '$45-$50/hr',
    val6: '$50-$55/hr',
    val7: '$55-$60/hr',
    val8: '$60/hr or more'
};

var salarySelect = $('#salary-field');
$.each(salaryOptions, function(val, text) {
    salarySelect.append(
        $('<option></option>').val(text).html(text)
    );

});

//find match and post job location drop down
var locationOptions = {
    val1: 'New South Wales',
    val2: 'Queensland',
    val3: 'Northern Territory',
    val4: 'Western Australia',
    val5: 'South Australia',
    val6: 'Victoria',
    val7: 'Australian Capital Territory',
    val8: 'Tasmania'
};

var locationSelect = $('#location-field');
$.each(locationOptions, function(val, text) {
    locationSelect.append(
        $('<option></option>').val(text).html(text)
    );

});


//find match and post job type drop down
var jobOptions = {
    val1: 'Full Time',
    val2: 'Part Time',
    val3: 'Casual',
    val4: 'Contract'
};

var jobSelect = $('#job-type-field');
$.each(jobOptions, function(val, text) {
    jobSelect.append(
        $('<option></option>').val(text).html(text)
    );

});


//year field drop down
var yearOptions = {
    val1: 'Less than a year',
    val2: '1 - 3 Years',
    val3: '3 - 5 Years',
    val4: '5 - 7 Years',
    val5: '7 - 9 Years',
    val6: '10 years or more'
};

var yearSelect = $('#skill-year-field');
$.each(yearOptions, function(val, text) {
    yearSelect.append(
        $('<option></option>').val(text).html(text)
    );

});

var yearSelect = $('#career-year-field');
$.each(yearOptions, function(val, text) {
    yearSelect.append(
        $('<option></option>').val(text).html(text)
    );

});

jSuites.calendar(document.getElementById('calendar'), {
    type: 'year-month-picker',
    format: 'MMM-YYYY',
    validRange: ['1900-01-01', '2021-12-31']
});


//show match div
function showFindMatchForm() {
    var jobmatch = document.getElementById("jobmatch");
    if (jobmatch.classList.contains('h-show')) {
        jobmatch.classList.remove('h-show');
        document.getElementById("findMatchBtn").innerHTML = "<i class='fa fa-search' aria-hidden='true'></i>";
        document.getElementById("positionInput").disabled = true;
        document.getElementById("salary-field").disabled = true;
        document.getElementById("location-field").disabled = true;
        document.getElementById("job-type-field").disabled = true;
        document.getElementById("matchBtn").disabled = true;
    } else {
        jobmatch.classList.add('h-show');
        document.getElementById("findMatchBtn").innerHTML = "<i class='fa fa-chevron-up' aria-hidden='true'></i>";
        document.getElementById("positionInput").disabled = false;
        document.getElementById("salary-field").disabled = false;
        document.getElementById("location-field").disabled = false;
        document.getElementById("job-type-field").disabled = false;
        document.getElementById("matchBtn").disabled = false;
    }
}

function showNewPostForm() {
    var newpost = document.getElementById("newpost");
    if (newpost.classList.contains('h-show')) {
        newpost.classList.remove('h-show');
        document.getElementById("newPostBtn").innerHTML = "<i class='fa fa-paper-plane' aria-hidden='true'></i>";
        document.getElementById("positionInput").disabled = true;
        document.getElementById("fieldOfExpertise-form").disabled = true;
        document.getElementById("descriptionTextArea").disabled = true;
        document.getElementById("requirementsTextArea").disabled = true;
        document.getElementById("contactInput").disabled = true;
        document.getElementById("salary-field").disabled = true;
        document.getElementById("location-field").disabled = true;
        document.getElementById("job-type-field").disabled = true;
        document.getElementById("postBtn").disabled = true;
    } else {
        newpost.classList.add('h-show');
        document.getElementById("newPostBtn").innerHTML = "<i class='fa fa-chevron-up' aria-hidden='true'></i>";
        document.getElementById("positionInput").disabled = false;
        document.getElementById("fieldOfExpertise-form").disabled = false;
        document.getElementById("salary-field").disabled = false;
        document.getElementById("location-field").disabled = false;
        document.getElementById("job-type-field").disabled = false;
        document.getElementById("postBtn").disabled = false;
        document.getElementById("descriptionTextArea").disabled = false;
        document.getElementById("requirementsTextArea").disabled = false;
        document.getElementById("contactInput").disabled = false;
    }
}

function edit() {
    var inputField = document.querySelectorAll("#linkedinLink, #githubLink, #twitterLink, #instagramLink, #facebookLink");
    for (var i = 0; i < inputField.length; i++) {
        inputField[i].disabled = false;
    }
    document.getElementById("editInputLink").style.display = 'none';
    document.getElementById("cancelInputLink").style.display = '';
    document.getElementById("doneInputLink").style.display = '';
}

function cancel() {
    var inputField = document.querySelectorAll("#linkedinLink, #githubLink, #twitterLink, #instagramLink, #facebookLink");
    for (var i = 0; i < inputField.length; i++) {
        inputField[i].disabled = true;
    }
    document.getElementById("editInputLink").style.display = '';
    document.getElementById("cancelInputLink").style.display = 'none';
    document.getElementById("doneInputLink").style.display = 'none';
}

function addSkill() {
    document.getElementById("skillForm").style.display = '';
    document.getElementById("cancelSkillBtn").style.display = '';
    document.getElementById("addSkillBtn").style.display = 'none';
}

function cancelSkill() {
    document.getElementById("skillForm").style.display = 'none';
    document.getElementById("cancelSkillBtn").style.display = 'none';
    document.getElementById("addSkillBtn").style.display = '';
}

function addEducation() {
    document.getElementById("educationForm").style.display = '';
    document.getElementById("cancelEducationBtn").style.display = '';
    document.getElementById("addEducationBtn").style.display = 'none';
}

function cancelEducation() {
    document.getElementById("educationForm").style.display = 'none';
    document.getElementById("cancelEducationBtn").style.display = 'none';
    document.getElementById("addEducationBtn").style.display = '';
}

function addCareer() {
    document.getElementById("careerForm").style.display = '';
    document.getElementById("cancelCareerBtn").style.display = '';
    document.getElementById("addCareerBtn").style.display = 'none';
}

function cancelCareer() {
    document.getElementById("careerForm").style.display = 'none';
    document.getElementById("cancelCareerBtn").style.display = 'none';
    document.getElementById("addCareerBtn").style.display = '';
}

//active link detect

// $(document).ready(function() {
//     $("[href]").each(function() {
//         if (this.href == window.location.href) {
//             $(this).addClass("linkActive");
//         } else {
//             $(this).addClass("linkInactive");
//         }
//     });
// });




//window show alert when accept cookies
// window.addEventListener("cookieAlertAccept", function() {
//     alert("cookies accepted")
// })