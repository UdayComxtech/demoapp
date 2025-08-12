<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Solar System Animation</title>
<style>
    * {
        margin: 0;
        padding: 0;
    }
    body {
        overflow: hidden;
        background: #222831;
        color: white;
        font-family: Arial, sans-serif;
    }
    canvas {
        display: block;
    }
    h1 {
        position: absolute;
        bottom: 0;
        width: 100%;
        text-align: center;
        font-size: 24px;
        color: #000;
        background: ghostwhite;
        font-family: monospace;
        font-weight: lighter;
        padding: 5px 0;
    }
    h1 img {
        height: 30px;
        vertical-align: middle;
    }
    small {
        font-size: x-small;
        display: block;
    }

    /* Mobile adjustments */
    @media (max-width: 768px) {
        h1 {
            font-size: 18px;
            padding: 8px;
        }
        h1 img {
            height: 20px;
        }
        small {
            font-size: 10px;
        }
        canvas{
            width: 100%;
            height: 100%;
        }
    }
</style>
</head>
<body>
<canvas id="solarSystem"></canvas>
<h1>
    Website under maintenance by 
    <span style="white-space: nowrap;">
        <img src="https://comxtech.com/wp-content/uploads/2019/03/Comxtech-logo.png" alt="Comxtech Logo">
    </span>
    <br><small>developer@comxtech.com</small>
</h1>
<script>
const canvas = document.getElementById("solarSystem");
const ctx = canvas.getContext("2d");

function resizeCanvas() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
}
resizeCanvas();
window.addEventListener("resize", resizeCanvas);

// Stars
let stars = [];
function initStars() {
    stars = [];
    for (let i = 0; i < 2000; i++) {
        stars.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            r: Math.random() * 2
        });
    }
}
initStars();

function drawStars() {
    ctx.fillStyle = "#FFFDF6";
    stars.forEach(star => {
        ctx.beginPath();
        ctx.arc(star.x, star.y, star.r, 0, Math.PI * 2);
        ctx.fill();
    });
}

// Scale factor for mobile
function scaleFactor() {
    return window.innerWidth < 768 ? 0.6 : 1;
}

const planets = [
    { name: "Mercury", color: "gray", radius: 10, distance: 60, speed: 0.02 },
    { name: "Venus", color: "orange", radius: 15, distance: 100, speed: 0.015 },
    { name: "Comxsoftech", color: "#3C9EE7", radius: 20, distance: 150, speed: 0.01, label: true },
    { name: "Mars", color: "red", radius: 12, distance: 200, speed: 0.008 },
    { name: "Jupiter", color: "#FFD700", radius: 25, distance: 250, speed: 0.006 },
    { name: "Saturn", color: "#D2B48C", radius: 22, distance: 300, speed: 0.005 }
];
let planetAngles = new Array(planets.length).fill(0);

// Bug asteroid
let bug = { distance: 400, angle: 0, speed: 0.009 };

function drawSolarSystem() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    drawStars();

    let centerX = canvas.width / 2;
    let centerY = canvas.height / 2;
    let scale = scaleFactor();

    // Sun
    ctx.beginPath();
    ctx.arc(centerX, centerY, 30 * scale, 0, Math.PI * 2);
    ctx.fillStyle = "yellow";
    ctx.fill();

    planets.forEach((planet, index) => {
        planetAngles[index] += planet.speed;
        let orbitTilt = 0.3;
        let x = centerX + planet.distance * scale * Math.cos(planetAngles[index]);
        let y = centerY + planet.distance * scale * Math.sin(planetAngles[index]) * Math.cos(orbitTilt);

        // Orbit
        ctx.beginPath();
        ctx.ellipse(centerX, centerY, planet.distance * scale, planet.distance * scale * Math.cos(orbitTilt), 0, 0, Math.PI * 2);
        ctx.strokeStyle = "rgba(255,255,255,0.2)";
        ctx.stroke();

        // Planet
        ctx.beginPath();
        ctx.arc(x, y, planet.radius * scale, 0, Math.PI * 2);
        ctx.fillStyle = planet.color;
        ctx.fill();

        if (planet.label) {
            ctx.fillStyle = "white";
            ctx.font = `${14 * scale}px monospace`;
            ctx.textAlign = "center";
            ctx.fillText(planet.name, x, y - planet.radius * scale - 10);
        }
    });

    // Bug asteroid
    bug.angle += bug.speed;
    let bugX = centerX + bug.distance * scale * Math.cos(bug.angle);
    let bugY = centerY + bug.distance * scale * Math.sin(bug.angle) * Math.cos(0.2);

    ctx.beginPath();
    ctx.arc(bugX, bugY, 6 * scale, 0, Math.PI * 2);
    ctx.fillStyle = "#A9A9A9";
    ctx.fill();
    ctx.fillStyle = "white";
    ctx.font = `${12 * scale}px Arial`;
    ctx.textAlign = "center";
    ctx.fillText("bug", bugX, bugY - 10);
}

function animate() {
    drawSolarSystem();
    requestAnimationFrame(animate);
}
animate();
</script>
</body>
</html>
