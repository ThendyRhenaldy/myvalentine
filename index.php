<?php
session_start();

$tanggal_jadian = "2025-08-24"; // GANTI SESUAI TANGGAL KALIAN

$start_date = new DateTime($tanggal_jadian);
$today = new DateTime();
$diff = $today->diff($start_date)->days;

if(isset($_POST['login'])){
    if($_POST['tanggal'] === $tanggal_jadian){
        $_SESSION['valentine_login'] = true;
    } else {
        $error = "Hehehe salah 😝 Coba ingat lagi yaaa ❤️";
    }
}

if(isset($_GET['logout'])){
    session_destroy();
    header("Location: index.php");
    exit();
}

if(isset($_GET['open'])){
    $_SESSION['opened']=true;
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Valentine 💖</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{
font-family:'Poppins',sans-serif;
min-height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:linear-gradient(135deg,#ff9a9e,#fad0c4,#ffdde1);
background-size:400% 400%;
animation:gradientMove 10s ease infinite;
padding:20px;
overflow-x:hidden;
}
body.dark{
background:linear-gradient(135deg,#1e1e2f,#2c2c54,#3a3a6b);
color:#f1f1f1;
}
@keyframes gradientMove{
0%{background-position:0% 50%;}
50%{background-position:100% 50%;}
100%{background-position:0% 50%;}
}

/* Floating Hearts */
.heart{
position:fixed;
bottom:-50px;
color:white;
animation:floatUp linear infinite;
z-index:0;
}
@keyframes floatUp{
to{transform:translateY(-110vh);opacity:0;}
}

/* Card */
.card{
background:rgba(255,255,255,0.18);
backdrop-filter:blur(15px);
padding:30px 20px;
border-radius:25px;
width:95%;
max-width:420px;
text-align:center;
color:white;
box-shadow:0 15px 40px rgba(0,0,0,0.2);
position:relative;
z-index:1;
}
body.dark .card{
background:rgba(0,0,0,0.4);
}

input{
width:100%;
padding:12px;
border-radius:50px;
border:none;
margin-bottom:15px;
text-align:center;
}

button{
background:white;
color:#ff6b81;
border:none;
padding:10px 16px;
border-radius:50px;
cursor:pointer;
font-weight:600;
margin:5px;
}

/* Toggle buttons */
.toggle-btn,.music-btn{
position:fixed;
top:15px;
width:45px;
height:45px;
border-radius:50%;
border:none;
background:white;
cursor:pointer;
z-index:10;
}
.toggle-btn{right:15px;}
.music-btn{left:15px;}

/* Slider */
.slider{
position:relative;
width:100%;
max-height:280px;
overflow:hidden;
border-radius:15px;
margin:10px 0;
}
.slides{
display:flex;
transition:transform 0.5s ease;
}
.slides img{
width:100%;
flex-shrink:0;
object-fit:cover;
max-height:280px;
}

/* Slide buttons */
.slide-btn{
position:absolute;
top:50%;
transform:translateY(-50%);
background:rgba(255,255,255,0.8);
border:none;
width:35px;
height:35px;
border-radius:50%;
cursor:pointer;
font-size:18px;
font-weight:bold;
}
.slide-btn.left{left:10px;}
.slide-btn.right{right:10px;}

/* Capy images */
.capy{
position:absolute;
width:150px;
max-width:30vw;
z-index:2;
}
.capy.left{left:-30px;bottom:-30px;}
.capy.right{right:-45px;top:-30px;}

.bubu{
    width:120px;
}

/* Envelope */
.envelope-wrapper{text-align:center;color:white;}
.envelope{
position:relative;
width:260px;
height:170px;
margin:auto;
cursor:pointer;
perspective:1000px;
}
.envelope-body{
position:absolute;
width:100%;
height:100%;
background:#fff;
border-radius:12px;
box-shadow:0 20px 40px rgba(0,0,0,0.3);
}
.envelope-flap{
position:absolute;
width:100%;
height:100%;
background:#ff6b81;
clip-path: polygon(0 0, 50% 60%, 100% 0);
transform-origin:top;
transition:transform 0.8s ease;
z-index:3;
}
.envelope.open .envelope-flap{transform:rotateX(180deg);}
.letter{
position:absolute;
width:90%;
height:120px;
background:#fff0f3;
left:5%;
bottom:-130px;
border-radius:10px;
display:flex;
justify-content:center;
align-items:center;
font-weight:600;
color:#ff6b81;
transition:0.8s ease;
}
.envelope.open .letter{bottom:25px;}
.seal{
position:absolute;
width:55px;
height:55px;
background:#ff4d6d;
border-radius:50%;
top:55px;
left:50%;
transform:translateX(-50%);
display:flex;
justify-content:center;
align-items:center;
color:white;
font-size:22px;
z-index:4;
}

/* Clean Print Card */
#printCard{
display:none;
width:600px;
padding:40px;
background:white;
color:#333;
text-align:center;
border-radius:20px;
}
#printCard img{
width:100%;
border-radius:15px;
margin-bottom:20px;
}
</style>
</head>

<body>

<audio id="bgMusic" loop>
<source src="music.mp3" type="audio/mpeg">
</audio>

<button class="music-btn" onclick="toggleMusic()">🎵</button>
<button class="toggle-btn" onclick="toggleDark()">🌙</button>

<script>
function toggleMusic(){
let music=document.getElementById("bgMusic");
if(music.paused){music.play();}
else{music.pause();}
}
function toggleDark(){document.body.classList.toggle("dark");}

// floating hearts
for(let i=0;i<25;i++){
let heart=document.createElement("div");
heart.classList.add("heart");
heart.innerHTML="❤";
heart.style.left=Math.random()*100+"%";
heart.style.animationDuration=(5+Math.random()*5)+"s";
heart.style.fontSize=(15+Math.random()*20)+"px";
document.body.appendChild(heart);
}
</script>

<?php if(!isset($_SESSION['opened'])): ?>

<div class="envelope-wrapper">
<h2 style="margin-bottom:20px;">For My Bubu 💌</h2>
<img src="bubududu1.gif" class="bubu">
<div class="envelope" onclick="openEnvelope(this)">
<div class="envelope-body"></div>
<div class="envelope-flap"></div>
<div class="seal">❤</div>
<div class="letter">From your Dudu 💌</div>
</div>
</div>

<script>
function openEnvelope(el){
el.classList.add("open");
setTimeout(()=>{window.location.href="?open=1";},1200);
}
</script>

<?php elseif(!isset($_SESSION['valentine_login'])): ?>

<div class="card">
<h1>Masukkan Tanggal Jadian 💖</h1>
<?php if(isset($error)) echo "<p>$error</p>"; ?>
<form method="POST">
<input type="date" name="tanggal" required>
<button type="submit" name="login">Masuk 💌</button>
</form>
</div>

<?php else: ?>

<div class="card" id="valentineCard">

<script>
window.onload=function(){
document.getElementById("bgMusic").play();
}
</script>

<img src="capybara.png" class="capy right">
<img src="bubududu1.gif" class="capy left">

<h1>Happy Valentine Sayang 💖</h1>

<div class="slider">
<div class="slides" id="slides">
<img src="foto1.jpg">
<img src="foto2.jpg">
<img src="foto3.jpg">
</div>

<button class="slide-btn left" onclick="prevSlide()">❮</button>
<button class="slide-btn right" onclick="nextSlide()">❯</button>
</div>

<p>
We’ve been together for <b><?php echo $diff; ?> days</b>🤍<br>
And every single one of them has meant more to me because of you.  
Thank you for walking this journey with me. Happy Valentine, I Love You 💕
</p>

<button onclick="downloadClean()">Download Clean Card 💌</button>
<br><br>
<a href="?logout" style="color:white;font-size:12px;">Masukin kertas ke Amplop</a>

</div>

<!-- CLEAN CARD -->
<div id="printCard">
<h1>Happy Valentine 💖</h1>
<img src="foto1.jpg">
<p>
We’ve been together for <b><?php echo $diff; ?> days</b>🤍<br>
And every single one of them has meant more to me because of you.  
Thank you for walking this journey with me. Happy Valentine, I Love You 💕
</p>
</div>

<script>
let index=0;
const slides=document.getElementById("slides");
const total=slides.children.length;
let autoSlide;

function showSlide(){
slides.style.transform="translateX(-"+(index*100)+"%)";
}
function nextSlide(){
index=(index+1)%total;
showSlide();
resetAuto();
}
function prevSlide(){
index=(index-1+total)%total;
showSlide();
resetAuto();
}
function startAuto(){
autoSlide=setInterval(()=>{
index=(index+1)%total;
showSlide();
},4000);
}
function resetAuto(){
clearInterval(autoSlide);
startAuto();
}
startAuto();

function downloadClean(){
const card=document.getElementById("printCard");
card.style.display="block";
html2canvas(card).then(canvas=>{
let link=document.createElement("a");
link.download="Capybara-Valentine.png";
link.href=canvas.toDataURL();
link.click();
card.style.display="none";
});
}
</script>

<?php endif; ?>

</body>
</html>
