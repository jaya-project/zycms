<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0044)http://www.jq22.com/demo/jQuery-40420160406/ -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=GBK">

<title>404</title>
<style type="text/css">
html,body{overflow:hidden;background:#000;padding:0px;margin:0px;width:100%;height:100%}img{max-width:100%;vertical-align:middle;border:0;-ms-interpolation-mode:bicubic}a{color:white;text-decoration:none;border-bottom:none}a:hover{color:white;text-decoration:none}h1{background:-webkit-linear-gradient(#5f5287,#8b7cb9);font-family:"proxima nova","Roboto","helvetica",Arial,sans-serif;-webkit-background-clip:text;-webkit-text-fill-color:transparent;font-size:34px;font-weight:bold;letter-spacing:-2px;line-height:50px}h2{color:white;font-family:"proxima nova","Roboto","helvetica",Arial,sans-serif;font-size:24px;font-weight:normal;.opacity(50)}h1 a,h2 a{color:#fff}.fullScreen{height:100%}a.logo{position:absolute;bottom:50px;right:50px;width:250px;text-decoration:none;border-bottom:none}img.rotating{position:absolute;left:50%;top:50%;margin-left:-256px;margin-top:-256px;-webkit-transition:opacity 2s ease-in;-moz-transition:opacity 2s ease-in;-o-transition:opacity 2s ease-in;-ms-transition:opacity 2s ease-in;transition:opacity 2s ease-in}@-webkit-keyframes rotating{from{-webkit-transform:rotate(0deg)}to{-webkit-transform:rotate(360deg)}}@-moz-keyframes rotating{from{-moz-transform:rotate(0deg)}to{-moz-transform:rotate(360deg)}}@-o-keyframes rotating{from{-o-transform:rotate(0deg)}to{-o-transform:rotate(360deg)}}@-ms-keyframes rotating{from{-ms-transform:rotate(0deg)}to{-ms-transform:rotate(360deg)}}.rotating{-webkit-animation:rotating 120s linear infinite;-moz-animation:rotating 120s linear infinite}div.pagenotfound-text{position:absolute;bottom:100px;left:65%}.header{font-size:13rem;font-weight:700;margin:20% 40% 20% 40%;text-shadow:0px 3px 0px #7f8c8d;text-align:center;position:absolute}
</style>
</head>
<body>
<!-- 代码 开始 -->
<div class="fullScreen" id="fullScreen">


    <h2 class="header rotating">404</h2>
    <canvas id="canvas2d" width="2560" height="495"></canvas>
    <div class="pagenotfound-text">
    <h2><a href="/">抱歉!您请求的页面找不到!</a> <span id='countdown'>5</span>秒后回到首页</h2>

    </div>
</div>
<!-- 代码 结束 -->
<script type="text/javascript">
  (function () {
 var timeLeft = 5, cinterval;
 var timeDec = function (){
  timeLeft--;
  document.getElementById('countdown').innerHTML = timeLeft+'';

  if(timeLeft === 0){
   clearInterval(cinterval);
   location.href = '/'; // index page here
  }
 };

 cinterval = setInterval(timeDec, 1000);
})();
</script>
<script type="text/javascript">

    eval(function(p,a,c,k,e,r){e=function(c){return(c<62?'':e(parseInt(c/62)))+((c=c%62)>35?String.fromCharCode(c+29):c.toString(36))};if('0'.replace(0,e)==0){while(c--)r[e(c)]=k[c];k=[function(e){return r[e]||e}];e=function(){return'([46-9a-hj-np-wzA-Z]|1\\w)'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('a m=7(x,y,n){4.x=x;4.y=y;4.J=y/x;4.K=0;4.t=c.Y(c.L()*n,1)};m.d.distanceTo=7(Z,11){p c.sqrt(c.12(Z-4.x,2)+c.12(11-4.y,2))};m.d.13=7(x,y,n){m.apply(4,arguments);p 4};a u={14:7(v,w,z,A,n){a M=u.N(v,w,z,A);p O m(M.x,M.y,n)},N:7(v,w,z,A){p{x:c.15((c.L()*z)+v),y:c.15((c.L()*A)+w)}}};a e=7(17){4.f=document.getElementById(17);4.B=4.f.getElementsByTagName(\'j\')[0];4.j=4.B.getContext(\'2d\');4.8=4.f.P;4.9=4.f.Q;4.q=[]};e.d.18=7(){a i,6,C,D;E(i=0;i<4.g;i++){6=4.q[i];D=c.min(6.t,c.R(6.t/6.J));6.x+=(6.x>0)?D:-D;6.y=6.J*6.x;6.K+=6.t/19;k((c.R(6.x)>4.8/2)||(c.R(6.y)>4.9/2)){C=u.N(-4.8/10,-4.9/10,4.8/5,4.9/5);6.13(C.x,C.y,4.r)}}};e.d.1a=7(){a i,6;4.j.1b="1c(0, 0, 0, .5)";4.j.1d(0,0,4.8,4.9);E(i=0;i<4.g;i++){6=4.q[i];4.j.1b="1c(188, 213, 236, "+6.K+")";4.j.1d(6.x+4.8/2,6.y+4.9/2,2,2)}};e.d.S=7(l){a 1e=l-(4.T||0);b.h(4.S.F(4));k(1e>=30||!4.T){4.T=l;4.18();4.1a()}};e.d.1f=7(8,9){4.8=4.B.8=8||4.f.P;4.9=4.B.9=9||4.f.Q};e.d.U=7(l){a 1g=l-(4.V||0),8,9;b.h(4.U.F(4));k(1g>=1h||!4.V){4.V=l;8=4.f.P;9=4.f.Q;k(4.1i!==8||4.1j!==9){4.1i=8;4.1j=9;4.1f(8,9)}}};e.d.1k=7(g){a i;E(i=0;i<4.g;i++){4.q.push(u.14(-4.8/2,-4.9/2,4.8,4.9,4.r))}b.h(4.S.F(4));b.h(4.U.F(4))};e.d.1l=7(g,r){4.g=g||19;4.r=r||3;4.1k(4.g)};(7(){a W=0;a s=[\'ms\',\'moz\',\'webkit\',\'o\'];E(a x=0;x<s.length&&!b.h;++x){b.h=b[s[x]+\'RequestAnimationFrame\'];b.X=b[s[x]+\'CancelAnimationFrame\']||b[s[x]+\'CancelRequestAnimationFrame\']}k(!b.h)b.h=7(1m,element){a G=O Date().getTime();a H=c.Y(0,16-(G-W));a I=b.setTimeout(7(){1m(G+H)},H);W=G+H;p I};k(!b.X)b.X=7(I){clearTimeout(I)}}());a q=O e(\'fullScreen\').1l(1h,3);',[],85,'||||this||star|function|width|height|var|window|Math|prototype|StarField|container|numStars|requestAnimationFrame||canvas|if|elapsedTime|Star|maxSpeed||return|starField|maxStarSpeed|vendors|speed|BigBang|minX|minY|||maxX|maxY|canvasElem|randomLoc|increment|for|bind|currTime|timeToCall|id|slope|opacity|random|coords|getRandomPosition|new|offsetWidth|offsetHeight|abs|_renderFrame|prevFrameTime|_watchCanvasSize|prevCheckTime|lastTime|cancelAnimationFrame|max|originX||originY|pow|resetPosition|getRandomStar|floor||containerId|_updateStarField|100|_renderStarField|fillStyle|rgba|fillRect|timeSinceLastFrame|_adjustCanvasSize|timeSinceLastCheck|333|oldWidth|oldHeight|_initScene|render|callback'.split('|'),0,{}))
</script>

</body></html>