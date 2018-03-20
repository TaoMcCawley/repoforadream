// Variables
var piano = Synth.createInstrument('piano');
var songContent = "";        // Tracks which notes are played by tracking keys pressed
var recording = false;       // Flag for recording status
var typing = false;          // Flag so notes aren't played while inputting song name
var song = [];               // Holds array of notes to be played
var notes = [];              // Holds array of notes that are timed using the setTime method
var down = {};               // Tracks which keys have been pressed so that the user can't hold down the key and must release to
                             // play another note, whether or not its the same note
var upper = lower + 1; // Higher octave being played

Synth.setSampleRate(20000); // Loads notes a little faster

// Custom Functions
// Sets up the notes to play at appropriate times
function setTime(index, setOctave, note) {
    notes[index] = setTimeout(function () {
        piano.play(note, setOctave);
        $('.lower[value="' + note + '"]').removeClass('btn-light btn-dark').addClass("btn-success");
        if (index == song.length - 1) {
            $("#play").removeClass("active");
        }
    }, index * 500);
    notes[index * 2] = setTimeout(function () {
        $('.lower[value="' + note + '"]').mouseup();
    }, index * 500 + 500);
}

$(".note").mousedown(function () {
    var note = $(this);
    note.removeClass('btn-light btn-dark');
    note.addClass("btn-success");

    if (note.attr('class').search("lower") < 0) {
        piano.play(note.attr('value'), upper);
        if (recording) {
            songContent += upper + note.attr('value') + " ";
        }
    } else {
        piano.play(note.attr('value'), lower);
        if (recording) {
            songContent += lower + note.attr('value') + " ";
        }
    }
});

$(".song").click(function () {
    var saved = $(this).attr('value');
    song = saved.split(" ");
    $("#play").addClass("active");
    for (var i = 0; i < song.length; i++) {
        var note = song[i];
        setTime(i, note.substr(0, 1), note.substr(1));
    }
});

$(document).keydown(function (event) {
    var key = String.fromCharCode(event.keyCode);

    if (isNaN(key)) {
        key = String.fromCharCode(event.keyCode + 32);
    }

    if (down[key] == null && !typing) {
        down[key] = true;
        $("#" + key).mousedown();
    }
});

$(document).keypress(function (event) {
    var key = String.fromCharCode(event.keyCode);

    if (key == '-' && lower > 1) {
        lower--;
        upper--;
    }
    else if (key == '+' && upper < 7) {
        lower++;
        upper++;
    }
});

$(document).keyup(function (event) {
    var key = String.fromCharCode(event.keyCode);
    if (isNaN(key)) {
        key = String.fromCharCode(event.keyCode + 32);
    }

    down[key] = null;
    $("#" + key).mouseup();
});

$(".note").mouseup(function () {
    var className;
    if ($(this).val().length == 2) {
        className = 'note btn btn-dark';
    } else {
        className = 'note btn btn-light';
    }

    $(this).removeClass("btn btn-success");
    $(this).addClass(className);
});

$("#record").click(function () {
    recording = !recording;
    if(songContent != "" && recording && confirm("Do you wish to start a new recording?")){
        songContent = "";
    }
    if (recording) {
        alert("Recording has begun!");
        $(this).addClass("active");
    } else {
        alert("Recording has ended!");
        $(this).removeClass("active");
    }
});

$("#play").click(function () {
    song = songContent.trim().split(" ");
    if (songContent != "") {
        $(this).addClass("active");
    }
    for (var i = 0; i < song.length; i++) {
        var note = song[i];
        setTime(i, note.substr(0, 1), note.substr(1));
    }
});


$("#stop").click(function () {
    for (var i = 0; i < notes.length; i++) {
        clearInterval(notes[i]);
    }
    $("#play").removeClass("active");
});

$("#savesong").click(function () {
    var name = $('#songName').val();

    if (name != "" && songContent != "" && loggedIn) {
        $.post("savesong", {song: songContent.trim(), name: name}, function (result, status) {
            if (status == "success") {
                var results = result.split(":");
                alert("Success! " + results[0] + " was saved!");
                $("#savedSongs").append("<li class='list-group-item'><button class='song btn' value='" + songContent + "'>" + name + "</button></li>");
            } else {
                alert("Whoops! Looks like something went wrong!");
            }
        });
    } else {
        var alertMsg = "";
        if (songContent == "") {
            alertMsg += "Saving empty songs is not allowed.\n";
        }
        if (name == "") {
            alertMsg += "Every song must have a name.";
        }
        if (!loggedIn) {
            alertMsg = "Sign up for an account in order to save songs!";
        }

        alert(alertMsg);
    }
});

$("#songName").focus(function () {
    typing = true;
});

$("#songName").blur(function () {
    typing = false;
});