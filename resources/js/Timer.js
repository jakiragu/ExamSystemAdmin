let Interval;

// Ensure `paused` is stored properly in localStorage
if (localStorage.getItem("paused") === null) {
    localStorage.setItem("paused", "false");
}

function startTimer() {
    let existingEndTime = localStorage.getItem("examEnd");

    if (existingEndTime && Date.now() < parseInt(existingEndTime)) {
        console.log("Timer already running. Resuming...");
        resumeTimer(); // If already running, resume it
        return;
    }

    console.log("Starting a new timer...");
    let endTime = Date.now() + (60 * 1000); // Set exam duration (1 minute for testing)
    localStorage.setItem("examEnd", endTime);
    localStorage.setItem("paused", "false"); // Ensure paused is false
    localStorage.setItem("running", "true");
    updateTimer();
}

function pauseTimer() {
    console.log("Pausing the timer...");
    localStorage.setItem("paused", "true");
    clearInterval(Interval);

    let EndTime = localStorage.getItem("examEnd");
    if (!EndTime) return;

    let timeLeft = parseInt(EndTime) - Date.now();
    localStorage.setItem("timeLeft", timeLeft);
    localStorage.removeItem("examEnd"); // Remove running timer

    displayTime(timeLeft);
}
function resetTimer(){
    localStorage.removeItem("examEnd");
    localStorage.removeItem("paused");
    localStorage.removeItem("timeLeft");
    localStorage.removeItem("running");
    document.getElementById("timer").innerHTML = "00:00:00";  
}
function adjustTimer(Hours,Minutes){
    localStorage.removeItem("examEnd");
    localStorage.removeItem("paused");
    let time=(parseInt(Hours)*60*60*1000)+(parseInt(Minutes)*60*1000);
    let endTime = parseInt(Date.now()) + time; 
    localStorage.setItem("examEnd", endTime);
    localStorage.setItem("paused", "false");
    updateTimer();
}

function resumeTimer() {
    console.log("Resuming the timer...");
    localStorage.setItem("paused", "false");

    let timeLeft = localStorage.getItem("timeLeft");
    if (!timeLeft) {
        console.log("No paused time found, starting fresh.");
        startTimer(); 
        return;
    }

    let EndTime = Date.now() + parseInt(timeLeft);
    localStorage.setItem("examEnd", EndTime);
    localStorage.removeItem("timeLeft"); 

    updateTimer();
}

function updateTimer() {
    clearInterval(Interval); 

    let EndTime = localStorage.getItem("examEnd");
    if (!EndTime || localStorage.getItem("paused") === "true") {
        console.log("Timer is paused or not started.");
        return;
    }

    Interval = setInterval(() => {
        let CurrentTime = Date.now();
        let timeLeft = EndTime - CurrentTime;

        if (timeLeft <= 0) {
            clearInterval(Interval);
            alert("Time's Up!");
            //localStorage.removeItem("examEnd");
            resetTimer();
            document.getElementById("timer").innerHTML = "00:00:00";
            return;
        }

        displayTime(timeLeft);
    }, 1000);
}

function togglePauseResumeTimer() {
    if (localStorage.getItem("paused") === "true") {
        resumeTimer();
    } else {
        pauseTimer();
    }
}
function multiStart(){
    if(localStorage.getItem("running") === "true"){
        return;
    }
    startTimer();
}

function displayTime(timeLeft) {
    let hours = Math.floor(timeLeft / 3600000);
    let minutes = Math.floor((timeLeft % 3600000) / 60000);
    let seconds = Math.floor((timeLeft % 60000) / 1000);

    document.getElementById("timer").innerHTML = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
}

// Ensure timer updates on page reload
document.addEventListener('DOMContentLoaded', function () {
    let existingEndTime = localStorage.getItem("examEnd");
    let pausedState = localStorage.getItem("paused") === "true";
    let timeLeft = localStorage.getItem("timeLeft");

    if (pausedState && timeLeft) {
        console.log("Restoring paused time...");
        displayTime(timeLeft);
    } else if (existingEndTime && Date.now() < parseInt(existingEndTime) && !pausedState) {
        console.log("Resuming running timer...");
        updateTimer();
    }
});

// Handle Laravel Echo Events
window.Echo.channel('Timer')
    .listen('StartTimer', () => {
        console.log('StartTimer event received.');
        multiStart();
    })
    .listen('PauseTimer', () => {
        console.log('PauseTimer event received.');
        togglePauseResumeTimer();
    })
    .listen('ResumeTimer', () => {
        console.log('ResumeTimer event received.');
        resumeTimer();
    })
    .listen('ResetTimer', () => {
        console.log('ResetTimer event received.');
        resetTimer();
    })  
    .listen('AdjustTimer', (e) => {
        adjustTimer(e.Hours,e.Minutes);
    });
