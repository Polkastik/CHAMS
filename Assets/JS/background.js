let balls = document.querySelectorAll('.ball');

balls.forEach(function (ball) {
    let dx = Math.random() * 2 - 1;
    let dy = Math.random() * 2 - 1;
    // Use current position or default to 0
    let startX = parseInt(ball.style.left) || 0;
    let startY = parseInt(ball.style.top) || 0;
    moveBall(ball, startX, startY, dx, dy);
});

function moveBall(ball, x, y, dx, dy) {
    let speed = 1.5;

    function changeDirectionIfNecessary(x, y) {
        let rect = ball.getBoundingClientRect();
        // Look at the window size instead of a div
        let canvasWidth = window.innerWidth;
        let canvasHeight = window.innerHeight;
        let overflow = 100; 

        if (x < -overflow || x > canvasWidth - rect.width + overflow) {
            dx = -dx;
        }
        if (y < -overflow || y > canvasHeight - rect.height + overflow) {
            dy = -dy;
        }
        return { dx, dy };
    }

    function draw() {
        x += dx * speed;
        y += dy * speed;

        // Use translate3d to force hardware acceleration
        ball.style.transform = `translate3d(${x}px, ${y}px, 0)`;

        let directions = changeDirectionIfNecessary(x, y);
        dx = directions.dx;
        dy = directions.dy;

        requestAnimationFrame(draw);
    }

    draw();
}

// performance test
let start = performance.now();
let frames = 0;

function checkPerformance() {
    frames++;
    let now = performance.now();
    if (now >= start + 1000) {
        if (frames < 40) {
            console.warn("Low FPS detected. Simplifying background for performance.");
            document.querySelector('.ball').style.filter = "none";
            document.querySelector('.ball').style.opacity = "0.2";
        }
        return;
    }
    requestAnimationFrame(checkPerformance);
}

checkPerformance();