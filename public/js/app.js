$(document).ready(function () {
    function getLoc() {
        $.ajax({
            url: '/fetch-google-api',
            method: 'GET',
            success: function (response) {
                const apiKey = response.api_key;
                const locationsAvailable = $('#locationList');

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        const latlng = `${lat},${lng}`;

                        $.ajax({
                            url: `https://maps.googleapis.com/maps/api/geocode/json?latlng=${latlng}&key=${apiKey}`,
                            method: 'GET',
                            dataType: 'json',
                            success: function (data) {
                                const results = data.results;
                                locationsAvailable.empty();

                                let locality = 'N/A';
                                let administrativeAreaLevel2 = 'N/A';

                                if (results.length > 0) {
                                    results.forEach((result) => {
                                        const addressComponents = result.address_components;

                                        // Check for postal_code in this address component
                                        const postalCodeComponent = addressComponents.find(comp => comp.types.includes('postal_code'));
                                        if (postalCodeComponent) {
                                            postalCode = postalCodeComponent.long_name; // Update postalCode if found
                                        }

                                        // Get locality and administrative area level 2
                                        const localityComponent = addressComponents.find(comp => comp.types.includes('locality'));
                                        if (localityComponent) {
                                            locality = localityComponent.long_name;
                                        }
                                        const administrativeAreaComponent = addressComponents.find(comp => comp.types.includes('administrative_area_level_2'));
                                        if (administrativeAreaComponent) {
                                            administrativeAreaLevel2 = administrativeAreaComponent.long_name;
                                        }
                                    });

                                    $('#sCity').val(locality);
                                    $('#sState').val(administrativeAreaLevel2);
                                } else {
                                    locationsAvailable.append('<div>No results found.</div>');
                                }
                            },
                            error: function () {
                                alert('Error fetching location data. Please check your API key and network connection.');
                            }
                        });
                    }, function (error) {
                        alert('Error getting location: ' + error.message);
                    });
                } else {
                    alert('Geolocation is not supported by this browser.');
                }
            },
            error: function (err) {
                console.error('Error fetching API key:', err);
            }
        });
    }

    getLoc();

    $("#signupContainer, #user-details, #signUp, .screen").hide();

    $("#showSignup").click(function (e) {
        e.preventDefault();
        $("#loginContainer").fadeOut(300, function () {
            $("#signupContainer").fadeIn(300);
        });
    });

    $("#showLogin").click(function (e) {
        e.preventDefault();
        $("#signupContainer").fadeOut(300, function () {
            $("#loginContainer").fadeIn(300);
        });
    });
    let delayTimer;

    $('#sUsername').on('input', function () {
        clearTimeout(delayTimer);

        delayTimer = setTimeout(function () {
            var username = $('#sUsername').val();
            var udata = {
                username: username,
                switch: 1,
            };
            validateIfExist(udata);

        }, 1000);
    });

    $('#sEmail').on('input', function () {
        clearTimeout(delayTimer);

        delayTimer = setTimeout(function () {
            var email = $('#sEmail').val();
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailPattern.test(email)) {
                $('#sEmail').css('border', '2px solid red');
            } else {
                $('#sEmail').css('border', '');

                var udata = {
                    email: email,
                    switch: 2,
                };
                validateIfExist(udata);
            }

        }, 1000);
    });


    function validateIfExist(udata) {
        $.ajax({
            url: '/check-if-exist',
            type: 'GET',
            data: udata,
            success: function (response) {
                if (udata.switch === 1) {
                    if (response.exists) {
                        $('#sUsername').css('border', '2px solid red');
                        alert('Username already exists.');
                    } else {
                        $('#sUsername').css('border', '');
                    }
                } else if (udata.switch === 2) {
                    if (response.exists) {
                        $('#sEmail').css('border', '2px solid red');
                        alert('Email already exists.');
                    } else {
                        $('#sEmail').css('border', '');
                    }
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }


    $('#sPass, #sConPass, #sName, #sUsername, #sEmail').on('input', function () {
        var password = $('#sPass').val();
        var confirmPassword = $('#sConPass').val();
        var sName = $('#sName').val();
        var sUsername = $('#sUsername').val();
        var sEmail = $('#sEmail').val();

        if (password === confirmPassword && password.length >= 8 && sName && sUsername && sEmail) {
            $("#user-details, #signUp").fadeIn(300);
            $('#passInfo').hide();
        } else {
            $("#user-details, #signUp").fadeOut(300);
            $('#passInfo').show();
        }
    });

    $('#sTele').on('input', function () {
        clearTimeout(delayTimer);
        var Tele = $('#sTele').val();
        delayTimer = setTimeout(function () {
            if (Tele.length != 11) {
                $('#sTele').css('border', '2px solid red');
            } else {
                $('#sTele').css('border', '');
            }
        }, 1000);
    });

    $('#signUp').click(function () {

        var sdata = {
            name: $('#sName').val(),
            username: $('#sUsername').val(),
            email: $('#sEmail').val(),
            password: $('#sPass').val(),
            telephone: $('#sTele').val(),
            addressLine1: $('#sAddr1').val(),
            addressLine2: $('#sAddr2').val(),
            city: $('#sCity').val(),
            state: $('#sState').val(),
            zip: $('#sZip').val()
        };
        console.log(sdata);
        var emptyFields = [];

        if (!sdata.name) emptyFields.push('Name');
        if (!sdata.username) emptyFields.push('Username');
        if (!sdata.email) emptyFields.push('Email');
        if (!sdata.password) emptyFields.push('Password');
        if (!sdata.telephone) emptyFields.push('Telephone');
        if (!sdata.addressLine1) emptyFields.push('Address Line 1');
        if (!sdata.city) emptyFields.push('City');
        if (!sdata.state) emptyFields.push('State');
        if (!sdata.zip) emptyFields.push('Zip Code');

        if (emptyFields.length > 0) {
            alert('Please fill in the following fields: ' + emptyFields.join(', '));
        } else {
            $(".screen").fadeIn(300);

            $.ajax({
                url: '/sign-up',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: sdata,
                success: function (response) {
                    $(".screen").fadeOut(300);
                    if (response.redirect) {
                        window.location.href = response.redirect; // Redirect to dashboard
                    } else {
                        alert(response.message); // Display success message
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        alert('Validation failed:\n' + errorMessages.join('\n'));
                    } else {
                        // Handle non-validation errors
                        var response = xhr.responseJSON;
                        alert('Error: ' + response.message);
                    }
                }
            });
        }
    });
});

// document.addEventListener("contextmenu", function (e) {
//     e.preventDefault();
// });

// document.addEventListener("keydown", function (e) {
//     if (e.key === "F12") {
//         e.preventDefault();
//     }
// });
