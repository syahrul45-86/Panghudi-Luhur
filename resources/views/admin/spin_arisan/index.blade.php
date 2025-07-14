@extends('admin.layouts.master')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spin Wheel Arisan</title>
    <style>
        .center-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            width: 100%;
            padding: 20px; /* Added padding for mobile */
        }

        #chart {
            width: 80vw; /* Changed to relative width */
            height: 80vw; /* Changed to relative height */
            max-width: 500px; /* Maximum width */
            max-height: 500px; /* Maximum height */
            position: relative;
        }

        #spin-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 15vw; /* Changed to relative width */
            height: 15vw; /* Changed to relative height */
            max-width: 80px; /* Maximum width */
            max-height: 80px; /* Maximum height */
            background-color: #f1c40f;
            border: 2px solid #e67e22;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            cursor: pointer;
            z-index: 10;
        }

        #arrow {
            position: absolute;
            top: 50%;
            right: -5%; /* Adjusted for responsiveness */
            transform: translateY(-50%) rotate(180deg);
            z-index: 10;
            width: 0;
            height: 0;
            border-top: 10px solid transparent; /* Adjusted for smaller screens */
            border-bottom: 10px solid transparent; /* Adjusted for smaller screens */
            border-left: 15px solid #e74c3c; /* Adjusted for smaller screens */
        }

        #winner-display {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        #winner-display h1 {
            font-size: 5vw; /* Responsive font size */
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 0 0 20px #ff0, 0 0 40px #ff0, 0 0 60px #ff0;
        }

        #winner-display button {
            padding: 10px 20px;
            font-size: 4vw; /* Responsive font size */
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #winner-display button:hover {
            background-color: #218838;
        }

        .confetti {
            position: fixed;
            top: 0;
            left: 50%;
            width: 10px;
            height: 10px;
            background-color: red;
            border-radius: 50%;
            animation: fall linear infinite;
        }
                /* Button styles */
        .button {
            margin-top: 10px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff; /* Bootstrap primary color */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%; /* Make buttons full width */
            max-width: 300px; /* Set a maximum width */
        }

        .button:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }
        @keyframes fall {
            0% {
                transform: translateX(0) translateY(0);
                opacity: 1;
            }
            100% {
                transform: translateX(calc(-50vw + 100px)) translateY(100vh);
                opacity: 0;
            }
        }

        /* Media Queries for specific screen sizes */
        @media (max-width: 450px) {
            #winner-display h1 {
                font-size: 6vw; /* Adjusted for smaller screens */
            }

            #winner-display button {
                font-size: 5vw; /* Adjusted for smaller screens */
            }

            #spin-button {
                width: 20vw; /* Adjusted for smaller screens */
                height: 20vw; /* Adjusted for smaller screens */
            }

            #chart {
                width: 90vw; /* Adjusted for smaller screens */
                height: 90vw; /* Adjusted for smaller screens */
            }
        }

        @media (max-width: 400px) {
            #winner-display h1 {
                font-size: 7vw; /* Further adjusted for even smaller screens */
            }

            #winner-display button {
                font-size: 6vw; /* Further adjusted for even smaller screens */
            }

            #spin-button {
                width: 25vw; /* Further adjusted for even smaller screens */
                height: 25vw; /* Further adjusted for even smaller screens */
            }

            #chart {
                width: 95vw; /* Further adjusted for even smaller screens */
                height: 95vw; /* Further adjusted for even smaller screens */
            }
        }

    </style>
</head>
<body>
    <div class="center-container">
        <div id="chart">
            <div id="arrow"></div>
            <div id="spin-button">SPIN</div>
        </div>
        <div id="input-names">
            <form id="name-form">
                <label for="names">Masukkan Nama (pisahkan dengan koma):</label><br>
                <input type="text" id="names" name="names" placeholder="Contoh: Ali, Budi, Siti" style="width: 80%; max-width: 300px; padding: 10px; margin-top: 10px;">
                <button type="button" id="generate-wheel" style="margin-top: 10px; padding: 10px 20px; font-size: 16px;">Buat Roda</button>
            </form>
            <button id="reset-names" style="margin-top: 10px; padding: 10px 20px; font-size: 16px;">Reset Daftar Nama</button>
        </div>
    </div>

    <div id="winner-display">
        <h1 id="winner-name"></h1>
        <button id="close-winner">Tutup</button>
    </div>

    <script src="https://d3js.org/d3.v3.min.js"></script>
    <script>
        let svg, container, vis, pie, arc, oldrotation = 0, rotation = 0, picked = 0, oldpick = [];
        const color = d3.scale.category20();

        function createWheel(names) {
            if (svg) {
                svg.remove();
                oldrotation = 0;
                rotation = 0;
                oldpick = [];
            }

            const data = names.map((name, index) => ({ label: name, value: index + 1 }));

            const w = 500;
            const h = 500;
            const r = Math.min(w, h) / 2;

            svg = d3.select('#chart')
            .append("svg")
            .data([data])
            .attr("viewBox", `0 0 ${w} ${h}`)
            .attr("preserveAspectRatio", "xMidYMid meet");


            container = svg.append("g")
                .attr("class", "chartholder")
                .attr("transform", `translate(${w / 2}, ${h / 2})`);

            vis = container.append("g");

            pie = d3.layout.pie().sort(null).value(() => 1);
            arc = d3.svg.arc().outerRadius(r);

            const arcs = vis.selectAll("g.slice")
                .data(pie)
                .enter()
                .append("g")
                .attr("class", "slice");

            arcs.append("path")
                .attr("fill", (d, i) => color(i))
                .attr("d", arc);

            arcs.append("text").attr("transform", function (d) {
                d.innerRadius = 0;
                d.outerRadius = r;
                d.angle = (d.startAngle + d.endAngle) / 2;
                return `rotate(${(d.angle * 180 / Math.PI - 90)})translate(${d.outerRadius - 10})`;
            })
                .attr("text-anchor", "end")
                .text((d, i) => data[i].label);

            document.getElementById('spin-button').addEventListener('click', spin);

            function spin() {
                document.getElementById('spin-button').removeEventListener('click', spin);

                if (oldpick.length === data.length) {
                    alert("Semua nama sudah dipilih!");
                    return;
                }

                const ps = 360 / data.length;
                const rng = Math.floor((Math.random() * 1440) + 360);
                rotation = (Math.round(rng / ps) * ps);

                picked = Math.round(data.length - (rotation % 360) / ps);
                picked = picked >= data.length ? (picked % data.length) : picked;

                if (oldpick.indexOf(picked) !== -1) {
                    spin();
                    return;
                } else {
                    oldpick.push(picked);
                }

                rotation += 90 - Math.round(ps / 2);
                vis.transition()
                    .duration(3000)
                    .attrTween("transform", rotTween)
                    .each("end", function () {
                        d3.select(".slice:nth-child(" + (picked + 1) + ") path")
                            .attr("fill", "#111");

                        const updatedNames = data.filter((_, i) => i !== picked).map(d => d.label);
                        localStorage.setItem('arisanNames', JSON.stringify(updatedNames));

                        displayWinner(data[picked].label);
                        document.getElementById('spin-button').addEventListener('click', spin);
                    });
            }

            function rotTween() {
                const i = d3.interpolate(oldrotation % 360, rotation);
                return function (t) {
                    return `rotate(${i(t)})`;
                };
            }
        }

        function displayWinner(name) {
            const winnerDisplay = document.getElementById('winner-display');
            const winnerName = document.getElementById('winner-name');
            winnerName.textContent = `Selamat ${name}! 🎉`;
            winnerDisplay.style.display = 'flex';

            for (let i = 0; i < 100; i++) {
                createConfetti();
            }
        }

        function createConfetti() {
            const confetti = document.createElement('div');
            confetti.className = 'confetti';
            confetti.style.left = `${Math.random() * 100}vw`;
            confetti.style.backgroundColor = `hsl(${Math.random() * 360}, 100%, 50%)`;
            confetti.style.animationDuration = `${Math.random() * 3 + 2}s`;

            document.body.appendChild(confetti);
            setTimeout(() => confetti.remove(), 5000);
        }

        document.getElementById('generate-wheel').addEventListener('click', () => {
            const namesInput = document.getElementById('names').value;
            if (!namesInput.trim()) {
                alert("Masukkan setidaknya satu nama!");
                return;
            }
            const names = namesInput.split(',').map(name => name.trim());
            localStorage.setItem('arisanNames', JSON.stringify(names));
            createWheel(names);
        });

        document.getElementById('reset-names').addEventListener('click', () => {
            localStorage.removeItem('arisanNames');
            alert("Daftar nama telah direset!");
            location.reload();
        });

        document.getElementById('close-winner').addEventListener('click', () => {
            const winnerDisplay = document.getElementById('winner-display');
            winnerDisplay.style.display = 'none';
        });

        window.addEventListener('load', () => {
            const savedNames = localStorage.getItem('arisanNames');
            if (savedNames) {
                const names = JSON.parse(savedNames);
                document.getElementById('names').value = names.join(', ');
                createWheel(names);
            }
        });
    </script>
</body>
</html>
@endsection
