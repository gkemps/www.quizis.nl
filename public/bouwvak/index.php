<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>200 Squares with Prizes</title>
    <style>
        body {
            display: flex;
            flex-wrap: wrap;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .square {
            width: 10%;
            height: 30px;
            box-sizing: border-box;
            border: 1px solid #333;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            font-size: 1.5rem;
            cursor: pointer;
            background: url('brick.jfif');
            background-size: cover;
            color: white;
        }

        .green {
            background: url('brick_bw.jpg');
        }

        .red {
            background: url('brick_bw.jpg');
        }

        .yellow {
            background: url('brick_bw.jpg');
        }

        #countdown {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 20rem;
            color: yellow;
            display: none;
        }

        #confetti-canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        #controls {
            z-index: 10;
        }

        button {
            padding: 1rem 2rem;
            font-size: 1.5rem;
            cursor: pointer;
            margin: 0 1rem;
        }

        #congrats-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 20;
        }

        #sorry-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 20;
        }

        #congrats-modal h1 {
            margin: 0;
            font-size: 2rem;
        }

        #congrats-modal p {
            margin: 1rem 0;
            font-size: 1.25rem;
        }

        #close-modal {
            padding: 0.5rem 1rem;
            font-size: 1rem;
            cursor: pointer;
            background: #333;
            color: white;
            border: none;
            border-radius: 5px;
        }

        .drum-roll-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            visibility: hidden;
            opacity: 0;
            transition: visibility 0s, opacity 0.5s ease-in-out;
        }

        .drum-roll-overlay.active {
            visibility: visible;
            opacity: 1;
        }

        .drum-roll {
            font-size: 3rem;
            animation: drum-roll-animation 0.3s infinite;
        }

        @keyframes drum-roll-animation {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }
        }
    </style>
</head>

<body>
    <canvas id="confetti-canvas"></canvas>
    <div class="drum-roll-overlay" id="drumRollOverlay">
        <div class="drum-roll">🥁</div>
    </div>
    <div id="congrats-modal">
        <h1>Gefeliciteerd!</h1>
        <p>Je hebt gewonnen: <span id="prize"></span>!</p>
        <p><small><span id="prize_descr"></span></small></p>
        <button id="close-modal">Close</button>
    </div>
    <div id="sorry-modal">
        <h1>Helaas!</h1>
        <p>Je hebt geen prijs gewonnen!</p>
        <button id="close-sorry-modal">Close</button>
    </div>
    <div id="countdown">3</div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch('prizes.php?action=check')
                .then(response => response.json())
                .then(data => {
                    for (let i = 1; i <= 200; i++) {
                        const square = document.createElement("div");
                        square.classList.add("square");
                        square.textContent = i;
                        if (data[i].status == 'win') {
                            square.classList.add("green");
                            square.textContent = "🥳";
                            square.setAttribute("title", data[i].id + ": " + data[i].prize + ' (' + data[i].opened + ')');
                        } else if (data[i].status == 'lose') {
                            square.classList.add("red");
                            square.textContent = "❌";
                            square.setAttribute("title", data[i].id + ": " + ' ' + data[i].opened);
                        }
                        square.addEventListener("click", function () {
                            if (square.classList.contains("green") || square.classList.contains("red")) {
                                return; // Do nothing if the square has already been opened
                            }
                            if (confirm(`Weet je zeker dat je baksteen ${i} wil openen?`)) {
                                square.classList.add("yellow");
                                let countdown = 3;
                                const countdownElement = document.getElementById('countdown');
                                countdownElement.style.display = 'none';
                                triggerDrumRoll();
                                const interval = setInterval(() => {
                                    countdownElement.textContent = countdown;
                                    countdown--;
                                    if (countdown < 0) {
                                        clearInterval(interval);
                                        countdownElement.style.display = 'none';
                                        fetch(`prizes.php?action=open&id=${i}`)
                                            .then(response => response.json())
                                            .then(result => {
                                                square.classList.remove("yellow");
                                                if (result.status == 'already_opened') {
                                                    if (result.result == 'win') {
                                                        square.classList.add("green");
                                                        square.textContent = "🥳";
                                                    } else {
                                                        square.classList.add("red");
                                                        square.textContent = "❌";
                                                    }
                                                } else if (result.status == 'opened') {
                                                    if (result.result == 'win') {
                                                        square.classList.add("green");
                                                        square.textContent = "🥳";
                                                        startConfetti(result.prize, result.desc);
                                                    } else {
                                                        square.classList.add("red");
                                                        square.textContent = "❌";
                                                        showSorryModal();
                                                    }
                                                }
                                            });
                                    }
                                }, 1000);
                            }
                        });
                        document.body.appendChild(square);
                    }
                });
        });
    </script>

    <script>
        const startButton = document.getElementById('confetti-button');
        const stopButton = document.getElementById('stop-button');
        const canvas = document.getElementById('confetti-canvas');
        const context = canvas.getContext('2d');
        const modal = document.getElementById('congrats-modal');
        const prize = document.getElementById('prize');
        const prizeDescr = document.getElementById('prize_descr');
        const closeModalButton = document.getElementById('close-modal');

        let confettiElements = [];
        let animationFrameId;

        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }

        function createConfetti() {
            const confettiCount = 300;
            confettiElements = [];
            for (let i = 0; i < confettiCount; i++) {
                confettiElements.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height,
                    r: Math.random() * 10 + 5,
                    d: Math.random() * confettiCount,
                    color: `hsl(${Math.random() * 360}, 100%, 50%)`,
                    tilt: Math.random() * 10 - 5,
                    tiltAngleIncremental: Math.random() * 0.07 + 0.05,
                    tiltAngle: 0
                });
            }
        }

        function drawConfetti() {
            context.clearRect(0, 0, canvas.width, canvas.height);
            confettiElements.forEach((confetti) => {
                context.beginPath();
                context.lineWidth = confetti.r / 2;
                context.strokeStyle = confetti.color;
                context.moveTo(confetti.x + confetti.tilt + confetti.r / 4, confetti.y);
                context.lineTo(confetti.x + confetti.tilt, confetti.y + confetti.tilt + confetti.r / 4);
                context.stroke();
            });

            updateConfetti();
        }

        function updateConfetti() {
            confettiElements.forEach((confetti, index) => {
                confetti.tiltAngle += confetti.tiltAngleIncremental;
                confetti.y += (Math.cos(confetti.d) + 3 + confetti.r / 2) / 2;
                confetti.tilt = Math.sin(confetti.tiltAngle - index / 3) * 15;

                if (confetti.y > canvas.height) {
                    confettiElements[index] = {
                        ...confetti,
                        x: Math.random() * canvas.width,
                        y: -10,
                        tilt: Math.random() * 10 - 5,
                    };
                }
            });
        }

        function animateConfetti() {
            drawConfetti();
            animationFrameId = requestAnimationFrame(animateConfetti);
        }

        function startConfetti(myPrize, myPrizeDescr) {
            createConfetti();
            animateConfetti();
            prize.textContent = myPrize;
            prizeDescr.textContent = myPrizeDescr;
            modal.style.display = 'block';
        }

        function stopConfetti() {
            cancelAnimationFrame(animationFrameId);
            context.clearRect(0, 0, canvas.width, canvas.height);
        }

        function showSorryModal() {
            const sorryModal = document.getElementById('sorry-modal');
            const closeSorryModalButton = document.getElementById('close-sorry-modal');
            sorryModal.style.display = 'block';
            closeSorryModalButton.addEventListener('click', () => {
                sorryModal.style.display = 'none';
            });
        }

        closeModalButton.addEventListener('click', () => {
            modal.style.display = 'none';
            stopConfetti();
        });

        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();
    </script>

    <script>
        // script.js
        function triggerDrumRoll() {
            const drumRollOverlay = document.getElementById('drumRollOverlay');

            // Function to show drum roll animation
            function showDrumRoll() {
                drumRollOverlay.classList.add('active');

                // Hide the drum roll animation after 3 seconds
                setTimeout(() => {
                    drumRollOverlay.classList.remove('active');
                }, 3000);
            }

            // Example usage: Show drum roll animation on page load
            showDrumRoll();
        }

    </script>
</body>

</html>