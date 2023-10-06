<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *,
*::before,
*::after {
  box-sizing: border-box;
}

body {
  margin: 0;
  background: #0d0d0d;
}

.ball {
  --delay: 0s;
  --size: 0.4;
  --speed: 20s;

  aspect-ratio: 1;
  width: calc(150% * var(--size));

  background: linear-gradient(259.53deg, #0a3fff 6.53%, #f55f0a 95.34%);
  filter: blur(10vw);

  border-radius: 50%;

  position: absolute;
  top: 0;
  left: 0;

  animation: loop var(--speed) infinite linear;
  animation-delay: var(--delay);
  transform-origin: 50% 50%;

  opacity: 0.6;
}

@keyframes loop {
  0% {
    transform: translate3D(0%, 51%, 0) rotate(0deg);
  }
  5% {
    transform: translate3D(8%, 31%, 0) rotate(18deg);
  }
  10% {
    transform: translate3D(22%, 13%, 0) rotate(36deg);
  }
  15% {
    transform: translate3D(40%, 2%, 0) rotate(54deg);
  }
  20% {
    transform: translate3D(46%, 21%, 0) rotate(72deg);
  }
  25% {
    transform: translate3D(50%, 47%, 0) rotate(90deg);
  }
  30% {
    transform: translate3D(53%, 80%, 0) rotate(108deg);
  }
  35% {
    transform: translate3D(59%, 98%, 0) rotate(125deg);
  }
  40% {
    transform: translate3D(84%, 89%, 0) rotate(144deg);
  }
  45% {
    transform: translate3D(92%, 68%, 0) rotate(162deg);
  }
  50% {
    transform: translate3D(99%, 47%, 0) rotate(180deg);
  }
  55% {
    transform: translate3D(97%, 21%, 0) rotate(198deg);
  }
  60% {
    transform: translate3D(80%, 7%, 0) rotate(216deg);
  }
  65% {
    transform: translate3D(68%, 25%, 0) rotate(234deg);
  }
  70% {
    transform: translate3D(59%, 41%, 0) rotate(251deg);
  }
  75% {
    transform: translate3D(50%, 63%, 0) rotate(270deg);
  }
  80% {
    transform: translate3D(38%, 78%, 0) rotate(288deg);
  }
  85% {
    transform: translate3D(21%, 92%, 0) rotate(306deg);
  }
  90% {
    transform: translate3D(3%, 79%, 0) rotate(324deg);
  }
  100% {
    transform: translate3D(0%, 51%, 0) rotate(360deg);
  }
}

.glow-container {
  overflow-x: hidden;
  overflow-y: hidden;
  position: fixed;

  width: 100%;
  min-height: 100vh;
}

    </style>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;800&display=swap");

:root {
--bg: #000000;
--clr-1: #00c2ff;
--clr-2: #33ff8c;
--clr-3: #ffc640;
--clr-4: #e54cff;

--blur: 1rem;
--fs: clamp(3rem, 8vw, 7rem);
--ls: clamp(-1.75px, -0.25vw, -3.5px);
}

body {
min-height: 100vh;
display: grid;
place-items: center;
/* background-color: var(--bg); */
color: #fff;
font-family: "Inter", "DM Sans", Arial, sans-serif;
}

*,
*::before,
*::after {
font-family: inherit;
box-sizing: border-box;
}

.content {
text-align: center;
}

.title {
font-size: var(--fs);
font-weight: 800;
letter-spacing: var(--ls);
position: relative;
overflow: hidden;
/* background: var(--bg); */
margin: 0;
}

.subtitle {
}

.aurora {
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
z-index: 2;
mix-blend-mode: darken;
pointer-events: none;
}

.aurora__item {
overflow: hidden;
position: absolute;
width: 60vw;
height: 60vw;
background-color: var(--clr-1);
border-radius: 37% 29% 27% 27% / 28% 25% 41% 37%;
filter: blur(var(--blur));
mix-blend-mode: overlay;
}

.aurora__item:nth-of-type(1) {
top: -50%;
animation: aurora-border 6s ease-in-out infinite,
aurora-1 12s ease-in-out infinite alternate;
}

.aurora__item:nth-of-type(2) {
background-color: var(--clr-3);
right: 0;
top: 0;
animation: aurora-border 6s ease-in-out infinite,
aurora-2 12s ease-in-out infinite alternate;
}

.aurora__item:nth-of-type(3) {
background-color: var(--clr-2);
left: 0;
bottom: 0;
animation: aurora-border 6s ease-in-out infinite,
aurora-3 8s ease-in-out infinite alternate;
}

.aurora__item:nth-of-type(4) {
background-color: var(--clr-4);
right: 0;
bottom: -50%;
animation: aurora-border 6s ease-in-out infinite,
aurora-4 24s ease-in-out infinite alternate;
}

@keyframes aurora-1 {
0% {
top: 0;
right: 0;
}

50% {
top: 100%;
right: 75%;
}

75% {
top: 100%;
right: 25%;
}

100% {
top: 0;
right: 0;
}
}

@keyframes aurora-2 {
0% {
top: -50%;
left: 0%;
}

60% {
top: 100%;
left: 75%;
}

85% {
top: 100%;
left: 25%;
}

100% {
top: -50%;
left: 0%;
}
}

@keyframes aurora-3 {
0% {
bottom: 0;
left: 0;
}

40% {
bottom: 100%;
left: 75%;
}

65% {
bottom: 40%;
left: 50%;
}

100% {
bottom: 0;
left: 0;
}
}

@keyframes aurora-4 {
0% {
bottom: -50%;
right: 0;
}

50% {
bottom: 0%;
right: 40%;
}

90% {
bottom: 50%;
right: 25%;
}

100% {
bottom: -50%;
right: 0;
}
}

@keyframes aurora-border {
0% {
border-radius: 37% 29% 27% 27% / 28% 25% 41% 37%;
}

25% {
border-radius: 47% 29% 39% 49% / 61% 19% 66% 26%;
}

50% {
border-radius: 57% 23% 47% 72% / 63% 17% 66% 33%;
}

75% {
border-radius: 28% 49% 29% 100% / 93% 20% 64% 25%;
}

100% {
border-radius: 37% 29% 27% 27% / 28% 25% 41% 37%;
}
}

</style>
</head>
<body>
    <div class="glow-container">
        <div class="ball"></div>
        <div class="ball" style="--delay:-12s;--size:0.35;--speed:25s;"></div>
        <div class="ball" style="--delay:-10s;--size:0.3;--speed:15s;"></div>
    </div>
    <div class="content">
        <h1 class="title">Sarah Alrayyes
          <div class="aurora">
            <div class="aurora__item"></div>
            <div class="aurora__item"></div>
            <div class="aurora__item"></div>
            <div class="aurora__item"></div>
          </div>
        </h1>
        <h3 class="subtitle">Hope your day is as lovely as you are.</h3>
        <h4>😊 حضرت الإعلامية 😊</h4>
      </div>

      <script>  
        const redirectInterval = 30 * 1000; 
        var url = "{{request()->getSchemeAndHttpHost()}}/today-appointments";

        function redirectToYouTube() {
            window.location.href = url;
        }
        setTimeout(redirectToYouTube, redirectInterval);
    </script>

</body>
</html>