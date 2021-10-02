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




// add field row
$("#addRow").click(function() {
    var html = '';
    html += '<div id="inputFormRow">';
    html += '<div class="input-group mb-3">';
    html += '<input type="text" name="title[]" class="form-control m-input" placeholder="Enter title" autocomplete="off">';
    html += '<div class="input-group-append">';
    html += '<button id="removeRow" type="button" class="btn btn-danger">Remove</button>';
    html += '</div>';
    html += '</div>';

    $('#newRow').append(html);
});

// remove row
$(document).on('click', '#removeRow', function() {
    $(this).closest('#inputFormRow').remove();
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

var fieldSelect = $('#job-seeker-form-field');
$.each(fieldOptions, function(val, text) {
    fieldSelect.append(
        $('<option></option>').val(text).html(text)
    );

});

//show match div
function showFindMatchForm() {
    var jobmatch = document.getElementById("jobmatch");
    if (jobmatch.classList.contains('h-show')) {
        jobmatch.classList.remove('h-show');
        document.getElementById("findMatchBtn").innerText = "Find Match";
        document.getElementById("positionInput").disabled = true;
        document.getElementById("match-salary-field").disabled = true;
        document.getElementById("match-location-field").disabled = true;
        document.getElementById("job-type-field").disabled = true;
        document.getElementById("matchBtn").disabled = true;
    } else {
        jobmatch.classList.add('h-show');
        document.getElementById("findMatchBtn").innerHTML = "<i class='fa fa-chevron-up' aria-hidden='true'></i>";
        document.getElementById("positionInput").disabled = false;
        document.getElementById("match-salary-field").disabled = false;
        document.getElementById("match-location-field").disabled = false;
        document.getElementById("job-type-field").disabled = false;
        document.getElementById("matchBtn").disabled = false;
    }
}

function showNewPostForm() {
    var newpost = document.getElementById("newpost");
    if (newpost.classList.contains('h-show')) {
        newpost.classList.remove('h-show');
        document.getElementById("newPostBtn").innerText = "New Post";
        document.getElementById("positionInput").disabled = true;
        document.getElementById("descriptionTextArea").disabled = true;
        document.getElementById("requirementsTextArea").disabled = true;
        document.getElementById("contactInput").disabled = true;
        document.getElementById("match-salary-field").disabled = true;
        document.getElementById("match-location-field").disabled = true;
        document.getElementById("job-type-field").disabled = true;
        document.getElementById("postBtn").disabled = true;
    } else {
        newpost.classList.add('h-show');
        document.getElementById("newPostBtn").innerHTML = "<i class='fa fa-chevron-up' aria-hidden='true'></i>";
        document.getElementById("positionInput").disabled = false;
        document.getElementById("match-salary-field").disabled = false;
        document.getElementById("match-location-field").disabled = false;
        document.getElementById("job-type-field").disabled = false;
        document.getElementById("postBtn").disabled = false;
        document.getElementById("descriptionTextArea").disabled = false;
        document.getElementById("requirementsTextArea").disabled = false;
        document.getElementById("contactInput").disabled = false;
    }
}