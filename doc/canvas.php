
<!DOCTYPE html>
<html class="split chapter" lang="en-US-x-hixie"><title>4.8.11 The canvas element &mdash; HTML Standard</title><script>
   var loadTimer = new Date();
   var current_revision = "r" + "$Revision: 5974 $".substr(11);
   current_revision = current_revision.substr(0, current_revision.length - 2);
   var last_known_revision = current_revision;
   function getCookie(name) {
     var params = location.search.substr(1).split("&");
     for (var index = 0; index < params.length; index++) {
       if (params[index] == name)
         return "1";
       var data = params[index].split("=");
       if (data[0] == name)
         return unescape(data[1]);
     }
     var cookies = document.cookie.split("; ");
     for (var index = 0; index < cookies.length; index++) {
       var data = cookies[index].split("=");
       if (data[0] == name)
         return unescape(data[1]);
     }
     return null;
   }
   var currentAlert;
   var currentAlertTimeout;
   function showAlert(s, href) {
     if (!currentAlert) {
       currentAlert = document.createElement('div');
       currentAlert.id = 'alert';
       var x = document.createElement('button');
       x.textContent = '\u2573';
       x.onclick = closeAlert2;
       currentAlert.appendChild(x);
       currentAlert.appendChild(document.createElement('span'));
       currentAlert.onmousemove = function () {
         clearTimeout(currentAlertTimeout);
         currentAlert.className = '';
         currentAlertTimeout = setTimeout(closeAlert, 10000);
       }
       document.body.appendChild(currentAlert);
     } else {
       clearTimeout(currentAlertTimeout);
       currentAlert.className = '';
     }
     currentAlert.lastChild.textContent = s + ' ';
     if (href) {
       var link = document.createElement('a');
       link.href = href;
       link.textContent = href;
       currentAlert.lastChild.appendChild(link);
     }
     currentAlertTimeout = setTimeout(closeAlert, 10000);
   }
   function closeAlert() {
     clearTimeout(currentAlertTimeout);
     if (currentAlert) {
       currentAlert.className = 'closed';
       currentAlertTimeout = setTimeout(closeAlert2, 3000);
     }
   }
   function closeAlert2() {
     clearTimeout(currentAlertTimeout);
     if (currentAlert) {
       currentAlert.parentNode.removeChild(currentAlert);
       currentAlert = null;
     }
   }
   window.addEventListener('keydown', function (event) {
     if (event.keyCode == 27) {
       if (currentAlert)
         closeAlert2();
     } else {
       closeAlert();
     }
   }, false);
   window.addEventListener('scroll', function (event) {
     closeAlert();
   }, false);
   function load(script) {
     var e = document.createElement('script');
     e.setAttribute('src', 'http://www.whatwg.org/specs/web-apps/current-work/' + script + '?' + encodeURIComponent(location) + '&' + encodeURIComponent(document.referrer));
     document.body.appendChild(e);
   }
  </script><link href="/style/specification" rel="stylesheet"><link href="/images/icon" rel="icon"><style>
   .proposal { border: blue solid; padding: 1em; }
   .bad, .bad *:not(.XXX) { color: gray; border-color: gray; background: transparent; }
   #updatesStatus { display: none; }
   #updatesStatus.relevant { display: block; position: fixed; right: 1em; top: 1em; padding: 0.5em; font: bold small sans-serif; min-width: 25em; width: 30%; max-width: 40em; height: auto; border: ridge 4px gray; background: #EEEEEE; color: black; }
   div.head .logo { width: 11em; margin-bottom: 20em; }
   #configUI { position: absolute; z-index: 20; top: 10em; right: 0; width: 11em; padding: 0 0.5em 0 0.5em; font-size: small; background: gray; background: rgba(32,32,32,0.9); color: white; border-radius: 1em 0 0 1em; -moz-border-radius: 1em 0 0 1em; }
   #configUI p { margin: 0.75em 0; padding: 0.3em; }
   #configUI p label { display: block; }
   #configUI #updateUI, #configUI .loginUI { text-align: center; }
   #configUI input[type=button] { display: block; margin: auto; }
   #configUI :link, #configUI :visited { color: white; }
   #configUI :link:hover, #configUI :visited:hover { background: transparent; }
   #reviewer { position: fixed; bottom: 0; right: 0; padding: 0.15em 0.25em 0em 0.5em; white-space: nowrap; overflow: hidden; z-index: 30; background: gray; background: rgba(32,32,32,0.9); color: white; border-radius: 1em 0 0 0; -moz-border-radius: 1em 0 0 0; max-width: 90%; }
   #reviewer input { max-width: 50%; }
   #reviewer * { font-size: small; }
   #reviewer.off > :not(:first-child) { display: none; }
   #alert { position: fixed; top: 20%; left: 20%; right: 20%; font-size: 2em; padding: 0.5em; z-index: 40; background: gray; background: rgba(32,32,32,0.9); color: white; border-radius: 1em; -moz-border-radius: 1em; -webkit-transition: opacity 1s linear; }
   #alert.closed { opacity: 0; }
   #alert button { position: absolute; top: -1em; right: 2em; border-radius: 1em 1em 0 0; border: none; line-height: 0.9; color: white; background: rgb(64,64,64); font-size: 0.6em; font-weight: 900; cursor: pointer; }
   #alert :link, #alert :visited { color: white; }
   #alert :link:hover, #alert :visited:hover { background: transparent; }
   @media print { #configUI { display: none; } }
   .rfc2119 { font-variant: small-caps; text-shadow: 0 0 0.5em yellow; position: static; }
   .rfc2119::after { position: absolute; left: 0; width: 25px; text-align: center; color: yellow; text-shadow: 0.075em 0.075em 0.2em black; }
   .rfc2119.m\ust::after { content: '\2605'; }
   .rfc2119.s\hould::after { content: '\2606'; }
   [hidden] { display: none; }
  </style><style type="text/css">

   .applies thead th > * { display: block; }
   .applies thead code { display: block; }
   .applies tbody th { whitespace: nowrap; }
   .applies td { text-align: center; }
   .applies .yes { background: yellow; }

   .matrix, .matrix td { border: hidden; text-align: right; }
   .matrix { margin-left: 2em; }

   .dice-example { border-collapse: collapse; border-style: hidden solid solid hidden; border-width: thin; margin-left: 3em; }
   .dice-example caption { width: 30em; font-size: smaller; font-style: italic; padding: 0.75em 0; text-align: left; }
   .dice-example td, .dice-example th { border: solid thin; width: 1.35em; height: 1.05em; text-align: center; padding: 0; }

   td.eg { border-width: thin; text-align: center; }

   #table-example-1 { border: solid thin; border-collapse: collapse; margin-left: 3em; }
   #table-example-1 * { font-family: "Essays1743", serif; line-height: 1.01em; }
   #table-example-1 caption { padding-bottom: 0.5em; }
   #table-example-1 thead, #table-example-1 tbody { border: none; }
   #table-example-1 th, #table-example-1 td { border: solid thin; }
   #table-example-1 th { font-weight: normal; }
   #table-example-1 td { border-style: none solid; vertical-align: top; }
   #table-example-1 th { padding: 0.5em; vertical-align: middle; text-align: center; }
   #table-example-1 tbody tr:first-child td { padding-top: 0.5em; }
   #table-example-1 tbody tr:last-child td { padding-bottom: 1.5em; }
   #table-example-1 tbody td:first-child { padding-left: 2.5em; padding-right: 0; width: 9em; }
   #table-example-1 tbody td:first-child::after { content: leader(". "); }
   #table-example-1 tbody td { padding-left: 2em; padding-right: 2em; }
   #table-example-1 tbody td:first-child + td { width: 10em; }
   #table-example-1 tbody td:first-child + td ~ td { width: 2.5em; }
   #table-example-1 tbody td:first-child + td + td + td ~ td { width: 1.25em; }

   .apple-table-examples { border: none; border-collapse: separate; border-spacing: 1.5em 0em; width: 40em; margin-left: 3em; }
   .apple-table-examples * { font-family: "Times", serif; }
   .apple-table-examples td, .apple-table-examples th { border: none; white-space: nowrap; padding-top: 0; padding-bottom: 0; }
   .apple-table-examples tbody th:first-child { border-left: none; width: 100%; }
   .apple-table-examples thead th:first-child ~ th { font-size: smaller; font-weight: bolder; border-bottom: solid 2px; text-align: center; }
   .apple-table-examples tbody th::after, .apple-table-examples tfoot th::after { content: leader(". ") }
   .apple-table-examples tbody th, .apple-table-examples tfoot th { font: inherit; text-align: left; }
   .apple-table-examples td { text-align: right; vertical-align: top; }
   .apple-table-examples.e1 tbody tr:last-child td { border-bottom: solid 1px; }
   .apple-table-examples.e1 tbody + tbody tr:last-child td { border-bottom: double 3px; }
   .apple-table-examples.e2 th[scope=row] { padding-left: 1em; }
   .apple-table-examples sup { line-height: 0; }

   .details-example img { vertical-align: top; }

   #base64-table {
     white-space: nowrap;
     font-size: 0.6em;
     column-width: 6em;
     column-count: 5;
     column-gap: 1em;
     -moz-column-width: 6em;
     -moz-column-count: 5;
     -moz-column-gap: 1em;
     -webkit-column-width: 6em;
     -webkit-column-count: 5;
     -webkit-column-gap: 1em;
   }
   #base64-table thead { display: none; }
   #base64-table * { border: none; }
   #base64-table tbody td:first-child:after { content: ':'; }
   #base64-table tbody td:last-child { text-align: right; }

   #named-character-references-table {
     white-space: nowrap;
     font-size: 0.6em;
     column-width: 30em;
     column-gap: 1em;
     -moz-column-width: 30em;
     -moz-column-gap: 1em;
     -webkit-column-width: 30em;
     -webkit-column-gap: 1em;
   }
   #named-character-references-table > table > tbody > tr > td:first-child + td,
   #named-character-references-table > table > tbody > tr > td:last-child { text-align: center; }
   #named-character-references-table > table > tbody > tr > td:last-child:hover > span { position: absolute; top: auto; left: auto; margin-left: 0.5em; line-height: 1.2; font-size: 5em; border: outset; padding: 0.25em 0.5em; background: white; width: 1.25em; height: auto; text-align: center; }
   #named-character-references-table > table > tbody > tr#entity-CounterClockwiseContourIntegral > td:first-child { font-size: 0.5em; }

   .glyph.control { color: red; }

   @font-face {
     font-family: 'Essays1743';
     src: url('http://www.whatwg.org/specs/web-apps/current-work/fonts/Essays1743.ttf');
   }
   @font-face {
     font-family: 'Essays1743';
     font-weight: bold;
     src: url('http://www.whatwg.org/specs/web-apps/current-work/fonts/Essays1743-Bold.ttf');
   }
   @font-face {
     font-family: 'Essays1743';
     font-style: italic;
     src: url('http://www.whatwg.org/specs/web-apps/current-work/fonts/Essays1743-Italic.ttf');
   }
   @font-face {
     font-family: 'Essays1743';
     font-style: italic;
     font-weight: bold;
     src: url('http://www.whatwg.org/specs/web-apps/current-work/fonts/Essays1743-BoldItalic.ttf');
   }

  </style><style>
   .domintro:before { display: table; margin: -1em -0.5em -0.5em auto; width: auto; content: 'This box is non-normative. Implementation requirements are given below this box.'; color: black; font-style: italic; border: solid 2px; background: white; padding: 0 0.25em; }
  </style><link href="data:text/css," id="complete" rel="stylesheet" title="Complete specification"><link href="data:text/css,.impl%20{%20display:%20none;%20}%0Ahtml%20{%20border:%20solid%20yellow;%20}%20.domintro:before%20{%20display:%20none;%20}" id="author" rel="alternate stylesheet" title="Author documentation only"><link href="data:text/css,.impl%20{%20background:%20%23FFEEEE;%20}%20.domintro:before%20{%20background:%20%23FFEEEE;%20}" id="highlight" rel="alternate stylesheet" title="Highlight implementation requirements"><link href="status.css" rel="stylesheet"><script>
   var startedInit = 0;
   function init() {
     startedInit = 1;
     if (location.search == '?slow-browser')
       return;
     var configUI = document.createElement('div');
     configUI.id = 'configUI';
     document.body.appendChild(configUI);
     load('reviewer.js');
     if (document.documentElement.className == "" || document.documentElement.className == "split index")
       load('toc.js');
     load('styler.js');
     load('updater.js');
     load('dfn.js');
     load('status.js');
     if (getCookie('profile') == '1')
       document.getElementsByTagName('h2')[0].textContent += '; load: ' + (new Date() - loadTimer) + 'ms';
   }
   if (document.documentElement.className == "")
     setTimeout(function () {
       if (!startedInit)
         showAlert("Too slow? Try reading the multipage copy of the spec instead:", "http://whatwg.org/html");
     }, 6000);
  </script>
  <script src="link-fixup.js"></script>
  <link href="video.html" rel="prev" title="4.8.6 The video element">
  <link href="index.html#contents" rel="index" title="Table of contents">
  <link href="the-map-element.html" rel="next" title="4.8.12 The map element">
  <body class="draft" onload="fixBrokenLink(); init()"><header class="head" id="head"><p><a class="logo" href="http://www.whatwg.org/" rel="home"><img alt="WHATWG" height="101" src="/images/logo" width="101"></a></p>
   <hgroup><h1 class="allcaps">HTML</h1>
    <h2 class="no-num no-toc">现行标准 &mdash; 最近更新: 30 March 2011</h2>
   </hgroup></header><nav>
   
  <ol class="toc"><li><ol><li><ol><li><a href="the-canvas-element.html#the-canvas-element"><span class="secno">4.8.11 </span>canvas 元素</a>
      <ol><li><a href="the-canvas-element.html#2dcontext"><span class="secno">4.8.11.1 </span>2D context</a>
        <ol><li><a href="the-canvas-element.html#the-canvas-state"><span class="secno">4.8.11.1.1 </span>canvas状态</a>
            <li><a href="the-canvas-element.html#transformations"><span class="secno">4.8.11.1.2 </span>变形(Transformations)</a>
            <li><a href="the-canvas-element.html#compositing"><span class="secno">4.8.11.1.3 </span>混合(Compositing)</a>
            <li><a href="the-canvas-element.html#colors-and-styles"><span class="secno">4.8.11.1.4 </span>颜色和样式(Colors and styles)</a>
            <li><a href="the-canvas-element.html#line-styles"><span class="secno">4.8.11.1.5 </span>线型(Line styles)</a>
            <li><a href="the-canvas-element.html#shadows"><span class="secno">4.8.11.1.6 </span>阴影(Shadows)</a>
            <li><a href="the-canvas-element.html#simple-shapes-(rectangles)"><span class="secno">4.8.11.1.7 </span>简单形状-矩形(Simple shapes (rectangles))</a>
            <li><a href="the-canvas-element.html#complex-shapes-(paths)"><span class="secno">4.8.11.1.8 </span>复杂形状-路径(Complex shapes (paths))</a>
            <li><a href="the-canvas-element.html#focus-management-0"><span class="secno">4.8.11.1.9 </span>焦点管理(Focus management)</a>
            <li><a href="the-canvas-element.html#text-0"><span class="secno">4.8.11.1.10 </span>文字(Text)</a>
            <li><a href="the-canvas-element.html#images"><span class="secno">4.8.11.1.11 </span>图像(Images)</a>
            <li><a href="the-canvas-element.html#pixel-manipulation"><span class="secno">4.8.11.1.12 </span>像素级操作(Pixel manipulation)</a>
            <li><a href="the-canvas-element.html#drawing-model"><span class="secno">4.8.11.1.13 </span>绘制模型(Drawing model)</a>
            <li><a href="the-canvas-element.html#examples"><span class="secno">4.8.11.1.14 </span>例子(Examples)</a></ol>
          <li><a href="the-canvas-element.html#color-spaces-and-color-correction"><span class="secno">4.8.11.2 </span>颜色空间和颜色校正(Color spaces and color correction)</a>
          <li><a href="the-canvas-element.html#security-with-canvas-elements"><span class="secno">4.8.11.3 </span>canvas元素的安全措施(Security with <code>canvas</code> elements)</a></ol></ol></ol></ol></nav>

  <h4 id="the-canvas-element"><span class="secno">4.8.11 </span>The <dfn id="canvas"><code>canvas</code></dfn> element</h4>

  <dl class="element"><dt>Categories</dt>
   <dd><a href="content-models.html#flow-content">Flow content</a>.</dd>
   <dd><a href="content-models.html#phrasing-content">Phrasing content</a>.</dd>
   <dd><a href="content-models.html#embedded-content">Embedded content</a>.</dd>
   <dt>Contexts in which this element can be used:</dt>
   <dd>Where <a href="content-models.html#embedded-content">embedded content</a> is expected.</dd>
   <dt>Content model:</dt>
   <dd><a href="content-models.html#transparent">Transparent</a>.</dd>
   <dt>Content attributes:</dt>
   <dd><a href="elements.html#global-attributes">Global attributes</a></dd>
   <dd><code title="attr-canvas-width"><a href="#attr-canvas-width">width</a></code></dd>
   <dd><code title="attr-canvas-height"><a href="#attr-canvas-height">height</a></code></dd>
   <dt>DOM interface:</dt>
   <dd>
    <pre class="idl">interface <dfn id="htmlcanvaselement">HTMLCanvasElement</dfn> : <a href="elements.html#htmlelement">HTMLElement</a> {
           attribute unsigned long <a href="#dom-canvas-width" title="dom-canvas-width">width</a>;
           attribute unsigned long <a href="#dom-canvas-height" title="dom-canvas-height">height</a>;

  DOMString <a href="#dom-canvas-todataurl" title="dom-canvas-toDataURL">toDataURL</a>(in optional DOMString type, in any... args);<!--
  v5:
  void <span title="dom-canvas-toBlob">toBlob</span>(in <span>FileCallback</span>, in optional DOMString type, in any... args);-->

  object <a href="#dom-canvas-getcontext" title="dom-canvas-getContext">getContext</a>(in DOMString contextId, in any... args);
};</pre>
   </dd>
  </dl><p>The <code><a href="#the-canvas-element">canvas</a></code> element provides scripts with a
  resolution-dependent bitmap canvas, which can be used for rendering
  graphs, game graphics, or other visual images on the fly.</p>

  <p>Authors should not use the <code><a href="#the-canvas-element">canvas</a></code> element in a
  document when a more suitable element is available. For example, it
  is inappropriate to use a <code><a href="#the-canvas-element">canvas</a></code> element to render a
  page heading: if the desired presentation of the heading is
  graphically intense, it should be marked up using appropriate
  elements (typically <code><a href="sections.html#the-h1,-h2,-h3,-h4,-h5,-and-h6-elements">h1</a></code>) and then styled using CSS and
  supporting technologies such as XBL.</p>

  <p>When authors use the <code><a href="#the-canvas-element">canvas</a></code> element, they must also
  provide content that, when presented to the user, conveys
  essentially the same function or purpose as the bitmap canvas. This
  content may be placed as content of the <code><a href="#the-canvas-element">canvas</a></code>
  element. The contents of the <code><a href="#the-canvas-element">canvas</a></code> element, if any,
  are the element's <a href="content-models.html#fallback-content">fallback content</a>.</p>

  <p>In interactive visual media, if <a href="webappapis.html#concept-n-script" title="concept-n-script">scripting is enabled</a> for the
  <code><a href="#the-canvas-element">canvas</a></code> element, and if support for <code><a href="#the-canvas-element">canvas</a></code>
  elements has been enabled, the <code><a href="#the-canvas-element">canvas</a></code> element
  <a href="rendering.html#represents">represents</a> <a href="content-models.html#embedded-content">embedded content</a> consisting of
  a dynamically created image.</p>

  <p>In non-interactive, static, visual media, if the
  <code><a href="#the-canvas-element">canvas</a></code> element has been previously painted on (e.g. if
  the page was viewed in an interactive visual medium and is now being
  printed, or if some script that ran during the page layout process
  painted on the element), then the <code><a href="#the-canvas-element">canvas</a></code> element
  <a href="rendering.html#represents">represents</a> <a href="content-models.html#embedded-content">embedded content</a> with the
  current image and size. Otherwise, the element represents its
  <a href="content-models.html#fallback-content">fallback content</a> instead.</p>

  <p>In non-visual media, and in visual media if <a href="webappapis.html#concept-n-noscript" title="concept-n-noscript">scripting is disabled</a> for the
  <code><a href="#the-canvas-element">canvas</a></code> element or if support for <code><a href="#the-canvas-element">canvas</a></code>
  elements has been disabled, the <code><a href="#the-canvas-element">canvas</a></code> element
  <a href="rendering.html#represents">represents</a> its <a href="content-models.html#fallback-content">fallback content</a>
  instead.</p>

  <!-- CANVAS-FOCUS-FALLBACK -->
  <p>When a <code><a href="#the-canvas-element">canvas</a></code> element <a href="rendering.html#represents">represents</a>
  <a href="content-models.html#embedded-content">embedded content</a>, the user can still focus descendants
  of the <code><a href="#the-canvas-element">canvas</a></code> element (in the <a href="content-models.html#fallback-content">fallback
  content</a>). This allows authors to make an interactive canvas
  keyboard-focusable: authors should have a one-to-one mapping of
  interactive regions to focusable elements in the <a href="content-models.html#fallback-content">fallback
  content</a>.</p>

  <p>The <code><a href="#the-canvas-element">canvas</a></code> element has two attributes to control the
  size of the coordinate space: <dfn id="attr-canvas-width" title="attr-canvas-width"><code>width</code></dfn> and <dfn id="attr-canvas-height" title="attr-canvas-height"><code>height</code></dfn>. These
  attributes, when specified, must have values that are <a href="common-microsyntaxes.html#valid-non-negative-integer" title="valid non-negative integer">valid non-negative
  integers</a>. <span class="impl">The <a href="common-microsyntaxes.html#rules-for-parsing-non-negative-integers">rules for parsing
  non-negative integers</a> must be used to obtain their numeric
  values. If an attribute is missing, or if parsing its value returns
  an error, then the default value must be used instead.</span> The
  <code title="attr-canvas-width"><a href="#attr-canvas-width">width</a></code> attribute defaults to
  300, and the <code title="attr-canvas-height"><a href="#attr-canvas-height">height</a></code>
  attribute defaults to 150.</p>

  <p>The intrinsic dimensions of the <code><a href="#the-canvas-element">canvas</a></code> element equal
  the size of the coordinate space, with the numbers interpreted in
  CSS pixels. However, the element can be sized arbitrarily by a
  style sheet. During rendering, the image is scaled to fit this layout
  size.</p>

  <div class="impl">

  <p>The size of the coordinate space does not necessarily represent
  the size of the actual bitmap that the user agent will use
  internally or during rendering. On high-definition displays, for
  instance, the user agent may internally use a bitmap with two device
  pixels per unit in the coordinate space, so that the rendering
  remains at high quality throughout.</p>

  <p>When the <code><a href="#the-canvas-element">canvas</a></code> element is created, and subsequently
  whenever the <code title="attr-canvas-width"><a href="#attr-canvas-width">width</a></code> and <code title="attr-canvas-height"><a href="#attr-canvas-height">height</a></code> attributes are set (whether
  to a new value or to the previous value), the bitmap and any
  associated contexts must be cleared back to their initial state and
  reinitialized with the newly specified coordinate space
  dimensions.</p>

  <p>When the canvas is initialized, its bitmap must be cleared to
  transparent black.</p>

  <p>The <dfn id="dom-canvas-width" title="dom-canvas-width"><code>width</code></dfn> and
  <dfn id="dom-canvas-height" title="dom-canvas-height"><code>height</code></dfn> IDL
  attributes must <a href="urls.html#reflect">reflect</a> the respective content
  attributes of the same name, with the same defaults.</p>

  </div>

  <div class="example">
   <p>Only one square appears to be drawn in the following example:</p>
   <pre>  // canvas is a reference to a &lt;canvas&gt; element
  var context = canvas.getContext('2d');
  context.fillRect(0,0,50,50);
  canvas.setAttribute('width', '300'); // clears the canvas
  context.fillRect(0,100,50,50);
  canvas.width = canvas.width; // clears the canvas
  context.fillRect(100,0,50,50); // only this square remains</pre>
  </div>

  <hr><dl class="domintro"><dt><var title="">context</var> = <var title="">canvas</var> . <code title="dom-canvas-getContext"><a href="#dom-canvas-getcontext">getContext</a></code>(<var title="">contextId</var> [, ... ])</dt>

   <dd>

    <p>Returns an object that exposes an API for drawing on the
    canvas. The first argument specifies the desired API. Subsequent
    arguments are handled by that API.</p>

<!--2DCONTEXT-->

    <p>This specification defines the "<code title="canvas-context-2d"><a href="#canvas-context-2d">2d</a></code>" context below. There is also
    a specification that defines a "<code title="canvas-context-webgl">webgl</code>" context. <a href="references.html#refsWEBGL">[WEBGL]</a></p>

<!--2DCONTEXT-->

    <p>The list of defined contexts is given on the <a href="http://wiki.whatwg.org/wiki/CanvasContexts">WHATWG Wiki
    CanvasContexts page</a>. <a href="references.html#refsWHATWGWIKI">[WHATWGWIKI]</a>

    <p>Returns null if the given context ID is not supported or if the
    canvas has already been initialised with some other (incompatible)
    context type (e.g. trying to get a "<code title="canvas-context-2d"><a href="#canvas-context-2d">2d</a></code>" context after getting a
    "<code title="canvas-context-webgl">webgl</code>" context).</p>

   </dd>

  </dl><div class="impl">

  <p>A <code><a href="#the-canvas-element">canvas</a></code> element can have a <dfn id="primary-context">primary
  context</dfn>, which is the first context to have been obtained for
  that element. When created, a <code><a href="#the-canvas-element">canvas</a></code> element must not
  have a <a href="#primary-context">primary context</a>.</p>

  <p>The <dfn id="dom-canvas-getcontext" title="dom-canvas-getContext"><code>getContext(<var title="">contextId</var>, <var title="">args...</var>)</code></dfn>
  method of the <code><a href="#the-canvas-element">canvas</a></code> element, when invoked, must run
  the following steps:</p>

  <ol><li><p>Let <var title="">contextId</var> be the first argument to
   the method.</li>

   <li><p>If <var title="">contextId</var> is not the name of a
   context supported by the user agent, return null and abort these
   steps.</li>

   <li><p>If the element has a <a href="#primary-context">primary context</a> and that
   context's entry in the <a href="http://wiki.whatwg.org/wiki/CanvasContexts">WHATWG Wiki
   CanvasContexts page</a> does not list <var title="">contextId</var>
   as a context with which it is compatible, return null and abort
   these steps. <a href="references.html#refsWHATWGWIKI">[WHATWGWIKI]</a></li>

   <li><p>If the element does not have a <a href="#primary-context">primary context</a>,
   let the element's <a href="#primary-context">primary context</a> be <var title="">contextId</var>.</li>

   <li><p>If the <code title="dom-canvas-getContext"><a href="#dom-canvas-getcontext">getContext()</a></code> method has
   already been invoked on this element for the same <var title="">contextId</var>, return the same object as was returned
   that time, and abort these steps. The additional arguments are
   ignored.</li>

   <li><p><dfn id="getcontext-return" title="getContext-return">Return a new object for <var title="">contextId</var></dfn>, as defined by the specification
   given for <var title="">contextId</var>'s entry in the <a href="http://wiki.whatwg.org/wiki/CanvasContexts">WHATWG Wiki
   CanvasContexts page</a>. <a href="references.html#refsWHATWGWIKI">[WHATWGWIKI]</a></li>

  </ol><p>New context types may be registered in the <a href="http://wiki.whatwg.org/wiki/CanvasContexts">WHATWG Wiki
  CanvasContexts page</a>. <a href="references.html#refsWHATWGWIKI">[WHATWGWIKI]</a></p>

  <p>Anyone is free to edit the WHATWG Wiki CanvasContexts page at any
  time to add a new context type. These new context types must be
  specified with the following information:</p>

  <dl><dt>Keyword</dt>

   <dd><p>The value of <var title="">contextID</var> that will return
   the object for the new API.</dd>


   <dt>Specification</dt>

   <dd><p>A link to a formal specification of the context type's
   API. It could be another page on the Wiki, or a link to an external
   page. If the type does not have a formal specification, an informal
   description can be substituted until such time as a formal
   specification is available.</dd>


   <dt>Compatible with</dt>

   <dd><p>The list of context types that are compatible with this one
   (i.e. that operate on the same underlying bitmap). This list must
   be transitive and symmetric; if one context type is defined as
   compatible with another, then all types it is compatible with must
   be compatible with all types the other is compatible with.</dd>

  </dl><p>Vendors may also define experimental contexts using the syntax
  <code><var title="">vendorname</var>-<var title="">context</var></code>, for example,
  <code>moz-3d</code>. Such contexts should be registered in the
  WHATWG Wiki CanvasContexts page.</p>

  </div>

  <hr><dl class="domintro"><dt><var title="">url</var> = <var title="">canvas</var> . <code title="dom-canvas-toDataURL"><a href="#dom-canvas-todataurl">toDataURL</a></code>( [ <var title="">type</var>, ... ])</dt>

   <dd>

    <p>Returns a <a href="infrastructure.html#data-protocol" title="data protocol"><code title="">data:</code> URL</a> for the image in the canvas.</p>

    <p>The first argument, if provided, controls the type of the image
    to be returned (e.g. PNG or JPEG). The default is <code title="">image/png</code>; that type is also used if the given
    type isn't supported. The other arguments are specific to the
    type, and control the way that the image is generated, as given in
    the table below.</p>

   </dd>

   <!-- v5: toBlob -->

  </dl><div class="impl">

  <p>The <dfn id="dom-canvas-todataurl" title="dom-canvas-toDataURL"><code>toDataURL()</code></dfn> method
  must, when called with no arguments, return a <a href="infrastructure.html#data-protocol" title="data
  protocol"><code title="">data:</code> URL</a> containing a
  representation of the image as a PNG file. <a href="references.html#refsPNG">[PNG]</a> <a href="references.html#refsRFC2397">[RFC2397]</a></p>

<!--
  v5:
  void <span title="dom-canvas-toBlob">toBlob</span>(in <span>FileCallback</span>, in optional DOMString type, in any... args);
-->

  <p>If the canvas has no pixels (i.e. either its horizontal dimension
  or its vertical dimension is zero) then the method must return the
  string "<code title="">data:,</code>". (This is the shortest <a href="infrastructure.html#data-protocol" title="data protocol"><code title="">data:</code> URL</a>; it
  represents the empty string in a <code title="">text/plain</code>
  resource.)</p>

  <p>When the <code title="dom-canvas-toDataURL"><a href="#dom-canvas-todataurl">toDataURL(<var title="">type</var>)</a></code> method is called with one <em>or
  more</em> arguments, it must return a <a href="infrastructure.html#data-protocol" title="data
  protocol"><code title="">data:</code> URL</a> containing a
  representation of the image in the format given by <var title="">type</var>. The possible values are <a href="infrastructure.html#mime-type" title="MIME
  type">MIME types</a> with no parameters, for example
  <code>image/png</code>, <code>image/jpeg</code>, or even maybe
  <code>image/svg+xml</code> if the implementation actually keeps
  enough information to reliably render an SVG image from the
  canvas.</p>

  <p>For image types that do not support an alpha channel, the image
  must be composited onto a solid black background using the
  source-over operator, and the resulting image must be the one used
  to create the <a href="infrastructure.html#data-protocol" title="data protocol"><code title="">data:</code> URL</a>.</p>

  <p>Only support for <code>image/png</code> is required. User agents
  may support other types. If the user agent does not support the
  requested type, it must return the image using the PNG format.</p>

  <p>User agents must <a href="infrastructure.html#converted-to-ascii-lowercase" title="converted to ASCII
  lowercase">convert the provided type to ASCII lowercase</a>
  before establishing if they support that type and before creating
  the <a href="infrastructure.html#data-protocol" title="data protocol"><code title="">data:</code>
  URL</a>.</p>

  </div>

  <p class="note">When trying to use types other than
  <code>image/png</code>, authors can check if the image was really
  returned in the requested format by checking to see if the returned
  string starts with one of the exact strings "<code title="">data:image/png,</code>" or "<code title="">data:image/png;</code>". If it does, the image is PNG, and
  thus the requested type was not supported. (The one exception to
  this is if the canvas has either no height or no width, in which
  case the result might simply be "<code title="">data:,</code>".)</p>

  <div class="impl">

  <p>If the method is invoked with the first argument giving a type
  corresponding to one of the types given in the first column of the
  following table, and the user agent supports that type, then the
  subsequent arguments, if any, must be treated as described in the
  second cell of that row.</p>

  </div>

  <table><thead><tr><th> Type <th> Other arguments
   <tbody><tr><td> image/jpeg
     <td> The second argument<span class="impl">, if it</span> is a
     number in the range 0.0 to 1.0 inclusive<span class="impl">, must
     be</span> treated as the desired quality level. <span class="impl">If it is not a number or is outside that range, the
     user agent must use its default value, as if the argument had
     been omitted.</span>
  </table><div class="impl">

  <p>For the purposes of these rules, an argument is considered to be
  a number if it is converted to an IDL double value by the rules for
  handling arguments of type <code title="">any</code> in the Web IDL
  specification. <a href="references.html#refsWEBIDL">[WEBIDL]</a></p>

  <p>Other arguments must be ignored and must not cause the user agent
  to raise an exception. A future version of this specification will
  probably define other parameters to be passed to <code title="dom-canvas-toDataURL"><a href="#dom-canvas-todataurl">toDataURL()</a></code> to allow authors to
  more carefully control compression settings, image metadata,
  etc.</p>

  <!-- should we explicitly require the URL to be base64-encoded and
  not have any parameters, to ensure the same exact URL is generated
  in each browser? -->

  </div>

  <!--2DCONTEXT-->

  <div data-component="HTML Canvas 2D Context (editor: Ian Hickson)">

  <h5 id="2dcontext"><span class="secno">4.8.11.1 </span>The 2D context</h5>

  <!-- v2: we're on v4. suggestions for next version are marked v5. -->



  <p>This specification defines the <dfn id="canvas-context-2d" title="canvas-context-2d"><code>2d</code></dfn> context type, whose
  API is implemented using the <code><a href="#canvasrenderingcontext2d">CanvasRenderingContext2D</a></code>
  interface.</p>

  <div class="impl">

  <p>When the <code title="dom-canvas-getContext"><a href="#dom-canvas-getcontext">getContext()</a></code>
  method of a <code><a href="#the-canvas-element">canvas</a></code> element is to <a href="#getcontext-return" title="getContext-return">return a new object for the <var title="">contextId</var></a> <code title="canvas-context-2d"><a href="#canvas-context-2d">2d</a></code>, the user agent must return a
  new <code><a href="#canvasrenderingcontext2d">CanvasRenderingContext2D</a></code> object. Any additional
  arguments are ignored.</p>

  </div>

  <p>The 2D context represents a flat Cartesian surface whose origin
  (0,0) is at the top left corner, with the coordinate space having
  <var title="">x</var> values increasing when going right, and <var title="">y</var> values increasing when going down.</p>

  <pre class="idl">interface <dfn id="canvasrenderingcontext2d">CanvasRenderingContext2D</dfn> {

  // back-reference to the canvas
  readonly attribute <a href="#htmlcanvaselement">HTMLCanvasElement</a> <a href="#dom-context-2d-canvas" title="dom-context-2d-canvas">canvas</a>;

  // state
  void <a href="#dom-context-2d-save" title="dom-context-2d-save">save</a>(); // push state on state stack
  void <a href="#dom-context-2d-restore" title="dom-context-2d-restore">restore</a>(); // pop state stack and restore state
<!--
  // v5 we've also received requests for:
          attribute boolean <span title="dom-context-2d-forceHighQuality">forceHighQuality</span> // (default false)
  // when enabled, it would prevent the UA from falling back on lower-quality but faster rendering routines
  // useful e.g. for when an image manipulation app uses <canvas> both for UI previews and the actual work
-->
  // transformations (default transform is the identity matrix)
  void <a href="#dom-context-2d-scale" title="dom-context-2d-scale">scale</a>(in double x, in double y);
  void <a href="#dom-context-2d-rotate" title="dom-context-2d-rotate">rotate</a>(in double angle);
  void <a href="#dom-context-2d-translate" title="dom-context-2d-translate">translate</a>(in double x, in double y);
  void <a href="#dom-context-2d-transform" title="dom-context-2d-transform">transform</a>(in double a, in double b, in double c, in double d, in double e, in double f);
  void <a href="#dom-context-2d-settransform" title="dom-context-2d-setTransform">setTransform</a>(in double a, in double b, in double c, in double d, in double e, in double f);
<!--
  // v5 we've also received requests for:
  void skew(...);
  void reflect(...); // or mirror(...)
-->
  // compositing
           attribute double <a href="#dom-context-2d-globalalpha" title="dom-context-2d-globalAlpha">globalAlpha</a>; // (default 1.0)
           attribute DOMString <a href="#dom-context-2d-globalcompositeoperation" title="dom-context-2d-globalCompositeOperation">globalCompositeOperation</a>; // (default source-over)
<!--
  // v5 we've also received requests for:
  - turning off antialiasing to avoid seams when patterns are painted next to each other
    - might be better to overdraw?
    - might be better to just draw at a higher res then downsample, like for 3d?
  - nested layers
    - the ability to composite an entire set of drawing operations with one shadow all at once
      http://lists.whatwg.org/pipermail/whatwg-whatwg.org/2008-August/015567.html
-->
  // colors and styles
           attribute any <a href="#dom-context-2d-strokestyle" title="dom-context-2d-strokeStyle">strokeStyle</a>; // (default black)
           attribute any <a href="#dom-context-2d-fillstyle" title="dom-context-2d-fillStyle">fillStyle</a>; // (default black)
  <a href="#canvasgradient">CanvasGradient</a> <a href="#dom-context-2d-createlineargradient" title="dom-context-2d-createLinearGradient">createLinearGradient</a>(in double x0, in double y0, in double x1, in double y1);
  <a href="#canvasgradient">CanvasGradient</a> <a href="#dom-context-2d-createradialgradient" title="dom-context-2d-createRadialGradient">createRadialGradient</a>(in double x0, in double y0, in double r0, in double x1, in double y1, in double r1);
  <a href="#canvaspattern">CanvasPattern</a> <a href="#dom-context-2d-createpattern" title="dom-context-2d-createPattern">createPattern</a>(in <a href="embedded-content-1.html#htmlimageelement">HTMLImageElement</a> image, in DOMString repetition);
  <a href="#canvaspattern">CanvasPattern</a> <a href="#dom-context-2d-createpattern" title="dom-context-2d-createPattern">createPattern</a>(in <a href="#htmlcanvaselement">HTMLCanvasElement</a> image, in DOMString repetition);
  <a href="#canvaspattern">CanvasPattern</a> <a href="#dom-context-2d-createpattern" title="dom-context-2d-createPattern">createPattern</a>(in <a href="video.html#htmlvideoelement">HTMLVideoElement</a> image, in DOMString repetition);

  // line caps/joins
           attribute double <a href="#dom-context-2d-linewidth" title="dom-context-2d-lineWidth">lineWidth</a>; // (default 1)
           attribute DOMString <a href="#dom-context-2d-linecap" title="dom-context-2d-lineCap">lineCap</a>; // "butt", "round", "square" (default "butt")
           attribute DOMString <a href="#dom-context-2d-linejoin" title="dom-context-2d-lineJoin">lineJoin</a>; // "round", "bevel", "miter" (default "miter")
           attribute double <a href="#dom-context-2d-miterlimit" title="dom-context-2d-miterLimit">miterLimit</a>; // (default 10)

  // shadows
           attribute double <a href="#dom-context-2d-shadowoffsetx" title="dom-context-2d-shadowOffsetX">shadowOffsetX</a>; // (default 0)
           attribute double <a href="#dom-context-2d-shadowoffsety" title="dom-context-2d-shadowOffsetY">shadowOffsetY</a>; // (default 0)
           attribute double <a href="#dom-context-2d-shadowblur" title="dom-context-2d-shadowBlur">shadowBlur</a>; // (default 0)
           attribute DOMString <a href="#dom-context-2d-shadowcolor" title="dom-context-2d-shadowColor">shadowColor</a>; // (default transparent black)

  // rects
  void <a href="#dom-context-2d-clearrect" title="dom-context-2d-clearRect">clearRect</a>(in double x, in double y, in double w, in double h);
  void <a href="#dom-context-2d-fillrect" title="dom-context-2d-fillRect">fillRect</a>(in double x, in double y, in double w, in double h);
  void <a href="#dom-context-2d-strokerect" title="dom-context-2d-strokeRect">strokeRect</a>(in double x, in double y, in double w, in double h);

  // path API
  void <a href="#dom-context-2d-beginpath" title="dom-context-2d-beginPath">beginPath</a>();
  void <a href="#dom-context-2d-closepath" title="dom-context-2d-closePath">closePath</a>();
  void <a href="#dom-context-2d-moveto" title="dom-context-2d-moveTo">moveTo</a>(in double x, in double y);
  void <a href="#dom-context-2d-lineto" title="dom-context-2d-lineTo">lineTo</a>(in double x, in double y);
  void <a href="#dom-context-2d-quadraticcurveto" title="dom-context-2d-quadraticCurveTo">quadraticCurveTo</a>(in double cpx, in double cpy, in double x, in double y);
  void <a href="#dom-context-2d-beziercurveto" title="dom-context-2d-bezierCurveTo">bezierCurveTo</a>(in double cp1x, in double cp1y, in double cp2x, in double cp2y, in double x, in double y);
  void <a href="#dom-context-2d-arcto" title="dom-context-2d-arcTo">arcTo</a>(in double x1, in double y1, in double x2, in double y2, in double radius);
  void <a href="#dom-context-2d-rect" title="dom-context-2d-rect">rect</a>(in double x, in double y, in double w, in double h);
  void <a href="#dom-context-2d-arc" title="dom-context-2d-arc">arc</a>(in double x, in double y, in double radius, in double startAngle, in double endAngle, in optional boolean anticlockwise);
  void <a href="#dom-context-2d-fill" title="dom-context-2d-fill">fill</a>();
  void <a href="#dom-context-2d-stroke" title="dom-context-2d-stroke">stroke</a>();
  void <a href="#dom-context-2d-clip" title="dom-context-2d-clip">clip</a>();
  boolean <a href="#dom-context-2d-ispointinpath" title="dom-context-2d-isPointInPath">isPointInPath</a>(in double x, in double y);

  // focus management
  boolean <a href="#dom-context-2d-drawfocusring" title="dom-context-2d-drawFocusRing">drawFocusRing</a>(in <a href="infrastructure.html#element">Element</a> element, in double xCaret, in double yCaret, in optional boolean canDrawCustom);

  // text
           attribute DOMString <a href="#dom-context-2d-font" title="dom-context-2d-font">font</a>; // (default 10px sans-serif)
           attribute DOMString <a href="#dom-context-2d-textalign" title="dom-context-2d-textAlign">textAlign</a>; // "start", "end", "left", "right", "center" (default: "start")
           attribute DOMString <a href="#dom-context-2d-textbaseline" title="dom-context-2d-textBaseline">textBaseline</a>; // "top", "hanging", "middle", "alphabetic", "ideographic", "bottom" (default: "alphabetic")
  void <a href="#dom-context-2d-filltext" title="dom-context-2d-fillText">fillText</a>(in DOMString text, in double x, in double y, in optional double maxWidth);
  void <a href="#dom-context-2d-stroketext" title="dom-context-2d-strokeText">strokeText</a>(in DOMString text, in double x, in double y, in optional double maxWidth);<!-- v5DVT
  void <span title="dom-context-2d-fillVerticalText">fillVerticalText</span>(in DOMString text, in double x, in double y, in optional double maxHeight);
  void <span title="dom-context-2d-strokeVerticalText">strokeVerticalText</span>(in DOMString text, in double x, in double y, in optional double maxHeight); -->
  <a href="#textmetrics">TextMetrics</a> <a href="#dom-context-2d-measuretext" title="dom-context-2d-measureText">measureText</a>(in DOMString text);

  // drawing images
  void <a href="#dom-context-2d-drawimage" title="dom-context-2d-drawImage">drawImage</a>(in <a href="embedded-content-1.html#htmlimageelement">HTMLImageElement</a> image, in double dx, in double dy, in optional double dw, in double dh);
  void <a href="#dom-context-2d-drawimage" title="dom-context-2d-drawImage">drawImage</a>(in <a href="embedded-content-1.html#htmlimageelement">HTMLImageElement</a> image, in double sx, in double sy, in double sw, in double sh, in double dx, in double dy, in double dw, in double dh);
  void <a href="#dom-context-2d-drawimage" title="dom-context-2d-drawImage">drawImage</a>(in <a href="#htmlcanvaselement">HTMLCanvasElement</a> image, in double dx, in double dy, in optional double dw, in double dh);
  void <a href="#dom-context-2d-drawimage" title="dom-context-2d-drawImage">drawImage</a>(in <a href="#htmlcanvaselement">HTMLCanvasElement</a> image, in double sx, in double sy, in double sw, in double sh, in double dx, in double dy, in double dw, in double dh);
  void <a href="#dom-context-2d-drawimage" title="dom-context-2d-drawImage">drawImage</a>(in <a href="video.html#htmlvideoelement">HTMLVideoElement</a> image, in double dx, in double dy, in optional double dw, in double dh);
  void <a href="#dom-context-2d-drawimage" title="dom-context-2d-drawImage">drawImage</a>(in <a href="video.html#htmlvideoelement">HTMLVideoElement</a> image, in double sx, in double sy, in double sw, in double sh, in double dx, in double dy, in double dw, in double dh);

  // pixel manipulation
  <a href="#imagedata">ImageData</a> <a href="#dom-context-2d-createimagedata" title="dom-context-2d-createImageData">createImageData</a>(in double sw, in double sh);
  <a href="#imagedata">ImageData</a> <a href="#dom-context-2d-createimagedata" title="dom-context-2d-createImageData">createImageData</a>(in <a href="#imagedata">ImageData</a> imagedata);
  <a href="#imagedata">ImageData</a> <a href="#dom-context-2d-getimagedata" title="dom-context-2d-getImageData">getImageData</a>(in double sx, in double sy, in double sw, in double sh);
  void <a href="#dom-context-2d-putimagedata" title="dom-context-2d-putImageData">putImageData</a>(in <a href="#imagedata">ImageData</a> imagedata, in double dx, in double dy, in optional double dirtyX, in double dirtyY, in double dirtyWidth, in double dirtyHeight);
};

interface <dfn id="canvasgradient">CanvasGradient</dfn> {
  // opaque object
  void <a href="#dom-canvasgradient-addcolorstop" title="dom-canvasgradient-addColorStop">addColorStop</a>(in double offset, in DOMString color);
};

interface <dfn id="canvaspattern">CanvasPattern</dfn> {
  // opaque object
};

interface <dfn id="textmetrics">TextMetrics</dfn> {
  readonly attribute double <a href="#dom-textmetrics-width" title="dom-textmetrics-width">width</a>;
};

interface <dfn id="imagedata">ImageData</dfn> {
  readonly attribute unsigned long <a href="#dom-imagedata-width" title="dom-imagedata-width">width</a>;
  readonly attribute unsigned long <a href="#dom-imagedata-height" title="dom-imagedata-height">height</a>;
  readonly attribute <a href="#canvaspixelarray">CanvasPixelArray</a> <a href="#dom-imagedata-data" title="dom-imagedata-data">data</a>;
};

interface <dfn id="canvaspixelarray">CanvasPixelArray</dfn> {
  readonly attribute unsigned long <a href="#dom-canvaspixelarray-length" title="dom-canvaspixelarray-length">length</a>;
  <a href="#dom-canvaspixelarray-get" title="dom-CanvasPixelArray-get">getter</a> octet (in unsigned long index);
  <a href="#dom-canvaspixelarray-set" title="dom-CanvasPixelArray-set">setter</a> void (in unsigned long index, in octet value);
};</pre>

  <dl class="domintro"><dt><var title="">context</var> . <code title="dom-context-2d-canvas"><a href="#dom-context-2d-canvas">canvas</a></code></dt>

   <dd>

    <p>Returns the <code><a href="#the-canvas-element">canvas</a></code> element.</p>

   </dd>

  </dl><div class="impl">

  <p>The <dfn id="dom-context-2d-canvas" title="dom-context-2d-canvas"><code>canvas</code></dfn>
  attribute must return the <code><a href="#the-canvas-element">canvas</a></code> element that the
  context paints on.</p>

  <p>Except where otherwise specified, for the 2D context interface,
  any method call with a numeric argument whose value is infinite or a
  NaN value must be ignored.</p>

  <!--
   Philip Taylor wrote:
   > My experience with some 3d canvas code is that infinities come up in
   > naturally harmless places, e.g. having a function that scales by x then
   > translates by 1/x and wanting it to work when x=0 (which ought to draw
   > nothing, since anything it draws is zero pixels wide), and it's a bit
   > annoying to track down and fix those issues, so I'd probably like it if
   > they were harmless in canvas methods. Opera appears to silently not draw
   > anything if the transformation matrix is not finite, but Firefox throws
   > exceptions when passing in non-finite arguments.
  -->

  <p>Whenever the CSS value <code title="">currentColor</code> is used
  as a color in this API, the "computed value of the 'color' property"
  for the purposes of determining the computed value of the <code title="">currentColor</code> keyword is the computed value of the
  'color' property on the element in question at the time that the
  color is specified (e.g. when the appropriate attribute is set, or
  when the method is called; not when the color is rendered or
  otherwise used). If the computed value of the 'color' property is
  undefined for a particular case (e.g. because the element is not
  <a href="infrastructure.html#in-a-document">in a <code>Document</code></a>), then the "computed value
  of the 'color' property" for the purposes of determining the
  computed value of the <code title="">currentColor</code> keyword is
  fully opaque black. <a href="references.html#refsCSSCOLOR">[CSSCOLOR]</a></p>

  <p>In the case of <code title="dom-canvasgradient-addColorStop"><a href="#dom-canvasgradient-addcolorstop">addColorStop()</a></code> on
  <code><a href="#canvasgradient">CanvasGradient</a></code>, the "computed value of the 'color'
  property" for the purposes of determining the computed value of the
  <code title="">currentColor</code> keyword is always fully opaque
  black (there is no associated element). <a href="references.html#refsCSSCOLOR">[CSSCOLOR]</a></p>

  <p class="note">This is because <code><a href="#canvasgradient">CanvasGradient</a></code> objects
  are <code><a href="#the-canvas-element">canvas</a></code>-neutral &mdash; a
  <code><a href="#canvasgradient">CanvasGradient</a></code> object created by one
  <code><a href="#the-canvas-element">canvas</a></code> can be used by another, and there is therefore
  no way to know which is the "element in question" at the time that
  the color is specified.</p>

  </div>



  <h6 id="the-canvas-state"><span class="secno">4.8.11.1.1 </span>The canvas state</h6>

  <p>Each context maintains a stack of drawing states. <dfn id="drawing-state" title="drawing state">Drawing states</dfn> consist of:</p>

  <ul class="brief"><li>The current <a href="#transformations" title="dom-context-2d-transformation">transformation matrix</a>.</li>
   <li>The current <a href="#clipping-region">clipping region</a>.</li>
   <li>The current values of the following attributes: <code title="dom-context-2d-strokeStyle"><a href="#dom-context-2d-strokestyle">strokeStyle</a></code>, <code title="dom-context-2d-fillStyle"><a href="#dom-context-2d-fillstyle">fillStyle</a></code>, <code title="dom-context-2d-globalAlpha"><a href="#dom-context-2d-globalalpha">globalAlpha</a></code>, <code title="dom-context-2d-lineWidth"><a href="#dom-context-2d-linewidth">lineWidth</a></code>, <code title="dom-context-2d-lineCap"><a href="#dom-context-2d-linecap">lineCap</a></code>, <code title="dom-context-2d-lineJoin"><a href="#dom-context-2d-linejoin">lineJoin</a></code>, <code title="dom-context-2d-miterLimit"><a href="#dom-context-2d-miterlimit">miterLimit</a></code>, <code title="dom-context-2d-shadowOffsetX"><a href="#dom-context-2d-shadowoffsetx">shadowOffsetX</a></code>, <code title="dom-context-2d-shadowOffsetY"><a href="#dom-context-2d-shadowoffsety">shadowOffsetY</a></code>, <code title="dom-context-2d-shadowBlur"><a href="#dom-context-2d-shadowblur">shadowBlur</a></code>, <code title="dom-context-2d-shadowColor"><a href="#dom-context-2d-shadowcolor">shadowColor</a></code>, <code title="dom-context-2d-globalCompositeOperation"><a href="#dom-context-2d-globalcompositeoperation">globalCompositeOperation</a></code>, <code title="dom-context-2d-font"><a href="#dom-context-2d-font">font</a></code>, <code title="dom-context-2d-textAlign"><a href="#dom-context-2d-textalign">textAlign</a></code>, <code title="dom-context-2d-textBaseline"><a href="#dom-context-2d-textbaseline">textBaseline</a></code>.</li>
  </ul><p class="note">The current path and the current bitmap are not part
  of the drawing state. The current path is persistent, and can only
  be reset using the <code title="dom-context-2d-beginPath"><a href="#dom-context-2d-beginpath">beginPath()</a></code> method. The
  current bitmap is a property of the canvas, not the context.</p>

  <dl class="domintro"><dt><var title="">context</var> . <code title="dom-context-2d-save"><a href="#dom-context-2d-save">save</a></code>()</dt>

   <dd>

    <p>Pushes the current state onto the stack.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-restore"><a href="#dom-context-2d-restore">restore</a></code>()</dt>

   <dd>

    <p>Pops the top state on the stack, restoring the context to that state.</p>

   </dd>

  </dl><div class="impl">

  <p>The <dfn id="dom-context-2d-save" title="dom-context-2d-save"><code>save()</code></dfn>
  method must push a copy of the current drawing state onto the
  drawing state stack.</p>

  <p>The <dfn id="dom-context-2d-restore" title="dom-context-2d-restore"><code>restore()</code></dfn> method
  must pop the top entry in the drawing state stack, and reset the
  drawing state it describes. If there is no saved state, the method
  must do nothing.</p>

  <!-- v5
idea from Mihai:
> 5. Drawing states should be saveable with IDs, and for easier restoring.
>
> save(id)
> restore(id)
>
> If id is not provided, then save() works as defined now. The same for
> restore().
>
> Currently, it's not trivial to save and restore a specific state.
...and from Philip:
> I think a more convenient syntax would be:
>   var state = ctx.save();
>   ctx.restore(state);
> But how would it interact with normal calls to ctx.restore()?
  -->

  </div>


  <h6 id="transformations"><span class="secno">4.8.11.1.2 </span><dfn title="dom-context-2d-transformation">Transformations</dfn></h6>

  <p>The transformation matrix is applied to coordinates when creating
  shapes and paths.</p> <!-- conformance criteria for actual drawing
  are described in the various sections below -->

  <div class="impl">

  <p>When the context is created, the transformation matrix must
  initially be the identity transform. It may then be adjusted using
  the transformation methods.</p>

  <p>The transformations must be performed in reverse order. For
  instance, if a scale transformation that doubles the width is
  applied, followed by a rotation transformation that rotates drawing
  operations by a quarter turn, and a rectangle twice as wide as it is
  tall is then drawn on the canvas, the actual result will be a
  square.</p>

  </div>

  <dl class="domintro"><dt><var title="">context</var> . <code title="dom-context-2d-scale"><a href="#dom-context-2d-scale">scale</a></code>(<var title="">x</var>, <var title="">y</var>)</dt>

   <dd>

    <p>Changes the transformation matrix to apply a scaling transformation with the given characteristics.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-rotate"><a href="#dom-context-2d-rotate">rotate</a></code>(<var title="">angle</var>)</dt>

   <dd>

    <p>Changes the transformation matrix to apply a rotation transformation with the given characteristics. The angle is in radians.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-translate"><a href="#dom-context-2d-translate">translate</a></code>(<var title="">x</var>, <var title="">y</var>)</dt>

   <dd>

    <p>Changes the transformation matrix to apply a translation transformation with the given characteristics.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-transform"><a href="#dom-context-2d-transform">transform</a></code>(<var title="">a</var>, <var title="">b</var>, <var title="">c</var>, <var title="">d</var>, <var title="">e</var>, <var title="">f</var>)</dt>

   <dd>

    <p>Changes the transformation matrix to apply the matrix given by the arguments as described below.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-setTransform"><a href="#dom-context-2d-settransform">setTransform</a></code>(<var title="">a</var>, <var title="">b</var>, <var title="">c</var>, <var title="">d</var>, <var title="">e</var>, <var title="">f</var>)</dt>

   <dd>

    <p>Changes the transformation matrix <em>to</em> the matrix given by the arguments as described below.</p>

   </dd>

  </dl><div class="impl">

  <p>The <dfn id="dom-context-2d-scale" title="dom-context-2d-scale"><code>scale(<var title="">x</var>, <var title="">y</var>)</code></dfn> method must
  add the scaling transformation described by the arguments to the
  transformation matrix. The <var title="">x</var> argument represents
  the scale factor in the horizontal direction and the <var title="">y</var> argument represents the scale factor in the
  vertical direction. The factors are multiples.</p>

  <p>The <dfn id="dom-context-2d-rotate" title="dom-context-2d-rotate"><code>rotate(<var title="">angle</var>)</code></dfn> method must add the rotation
  transformation described by the argument to the transformation
  matrix. The <var title="">angle</var> argument represents a
  clockwise rotation angle expressed in radians.</p>

  <p>The <dfn id="dom-context-2d-translate" title="dom-context-2d-translate"><code>translate(<var title="">x</var>, <var title="">y</var>)</code></dfn> method must
  add the translation transformation described by the arguments to the
  transformation matrix. The <var title="">x</var> argument represents
  the translation distance in the horizontal direction and the <var title="">y</var> argument represents the translation distance in the
  vertical direction. The arguments are in coordinate space units.</p>

  <p>The <dfn id="dom-context-2d-transform" title="dom-context-2d-transform"><code>transform(<var title="">a</var>, <var title="">b</var>, <var title="">c</var>, <var title="">d</var>, <var title="">e</var>, <var title="">f</var>)</code></dfn> method must replace the current
  transformation matrix with the result of multiplying the current
  transformation matrix with the matrix described by:</p>

  </div>

  <table class="matrix"><tr><td><var title="">a</var></td>
    <td><var title="">c</var></td>
    <td><var title="">e</var></td>
   <tr><td><var title="">b</var></td>
    <td><var title="">d</var></td>
    <td><var title="">f</var></td>
   <tr><td>0</td>
    <td>0</td>
    <td>1</td>
   </table><p class="note">The arguments <var title="">a</var>, <var title="">b</var>, <var title="">c</var>, <var title="">d</var>, <var title="">e</var>, and <var title="">f</var> are sometimes called
  <var title="">m11</var>, <var title="">m12</var>, <var title="">m21</var>, <var title="">m22</var>, <var title="">dx</var>,
  and <var title="">dy</var> or <var title="">m11</var>, <var title="">m21</var>, <var title="">m12</var>, <var title="">m22</var>, <var title="">dx</var>, and <var title="">dy</var>. Care should be taken in particular with the order
  of the second and third arguments (<var title="">b</var> and <var title="">c</var>) as their order varies from API to API and APIs
  sometimes use the notation <var title="">m12</var>/<var title="">m21</var> and sometimes <var title="">m21</var>/<var title="">m12</var> for those positions.</p>

  <div class="impl">

  <p>The <dfn id="dom-context-2d-settransform" title="dom-context-2d-setTransform"><code>setTransform(<var title="">a</var>, <var title="">b</var>, <var title="">c</var>, <var title="">d</var>, <var title="">e</var>,
  <var title="">f</var>)</code></dfn> method must reset the current
  transform to the identity matrix, and then invoke the <code><a href="#dom-context-2d-transform" title="dom-context-2d-transform">transform</a>(<var title="">a</var>, <var title="">b</var>, <var title="">c</var>, <var title="">d</var>, <var title="">e</var>,
  <var title="">f</var>)</code> method with the same arguments.</p>

  </div>


  <h6 id="compositing"><span class="secno">4.8.11.1.3 </span>Compositing</h6>

  <dl class="domintro"><dt><var title="">context</var> . <code title="dom-context-2d-globalAlpha"><a href="#dom-context-2d-globalalpha">globalAlpha</a></code> [ = <var title="">value</var> ]</dt>

   <dd>

    <p>Returns the current alpha value applied to rendering operations.</p>

    <p>Can be set, to change the alpha value. Values outside of the
    range 0.0 .. 1.0 are ignored.</p>

   </dd>


   <dt><var title="">context</var> . <code title="dom-context-2d-globalCompositeOperation"><a href="#dom-context-2d-globalcompositeoperation">globalCompositeOperation</a></code> [ = <var title="">value</var> ]</dt>

   <dd>

    <p>Returns the current composition operation, from the list below.</p>

    <p>Can be set, to change the composition operation. Unknown values
    are ignored.</p>

   </dd>

  </dl><div class="impl">

  <p>All drawing operations are affected by the global compositing
  attributes, <code title="dom-context-2d-globalAlpha"><a href="#dom-context-2d-globalalpha">globalAlpha</a></code> and <code title="dom-context-2d-globalCompositeOperation"><a href="#dom-context-2d-globalcompositeoperation">globalCompositeOperation</a></code>.</p>

  <!-- conformance criteria for painting are described in the "drawing
  model" section below -->

  <p>The <dfn id="dom-context-2d-globalalpha" title="dom-context-2d-globalAlpha"><code>globalAlpha</code></dfn>
  attribute gives an alpha value that is applied to shapes and images
  before they are composited onto the canvas. The value must be in the
  range from 0.0 (fully transparent) to 1.0 (no additional
  transparency). If an attempt is made to set the attribute to a value
  outside this range, including Infinity and Not-a-Number (NaN)
  values, the attribute must retain its previous value. When the
  context is created, the <code title="dom-context-2d-globalAlpha"><a href="#dom-context-2d-globalalpha">globalAlpha</a></code> attribute must
  initially have the value 1.0.</p>

  <p>The <dfn id="dom-context-2d-globalcompositeoperation" title="dom-context-2d-globalCompositeOperation"><code>globalCompositeOperation</code></dfn>
  attribute sets how shapes and images are drawn onto the existing
  bitmap, once they have had <code title="dom-context-2d-globalAlpha"><a href="#dom-context-2d-globalalpha">globalAlpha</a></code> and the
  current transformation matrix applied. It must be set to a value
  from the following list. In the descriptions below, the source
  image, <var title="">A</var>, is the shape or image being rendered,
  and the destination image, <var title="">B</var>, is the current
  state of the bitmap.</p>

  </div>

  <dl><dt><dfn id="gcop-source-atop" title="gcop-source-atop"><code>source-atop</code></dfn></dt>

   <dd><var title="">A</var> atop <var title="">B</var>. <span class="note">Display the
   source image wherever both images are opaque. Display the
   destination image wherever the destination image is opaque but the
   source image is transparent. Display transparency elsewhere.</span></dd>

   <dt><dfn id="gcop-source-in" title="gcop-source-in"><code>source-in</code></dfn></dt>

   <dd><var title="">A</var> in <var title="">B</var>. <span class="note">Display the
   source image wherever both the source image and destination image
   are opaque. Display transparency elsewhere.</span></dd>

   <dt><dfn id="gcop-source-out" title="gcop-source-out"><code>source-out</code></dfn></dt>

   <dd><var title="">A</var> out <var title="">B</var>. <span class="note">Display the
   source image wherever the source image is opaque and the
   destination image is transparent. Display transparency
   elsewhere.</span></dd>

   <dt><dfn id="gcop-source-over" title="gcop-source-over"><code>source-over</code></dfn> (default)</dt>

   <dd><var title="">A</var> over <var title="">B</var>. <span class="note">Display the
   source image wherever the source image is opaque. Display the
   destination image elsewhere.</span></dd>


   <dt><dfn id="gcop-destination-atop" title="gcop-destination-atop"><code>destination-atop</code></dfn></dt>

   <dd><var title="">B</var> atop <var title="">A</var>. <span class="note">Same as <code title="gcop-source-atop"><a href="#gcop-source-atop">source-atop</a></code> but using the
   destination image instead of the source image and vice versa.</span></dd>

   <dt><dfn id="gcop-destination-in" title="gcop-destination-in"><code>destination-in</code></dfn></dt>

   <dd><var title="">B</var> in <var title="">A</var>. <span class="note">Same as <code title="gcop-source-in"><a href="#gcop-source-in">source-in</a></code> but using the destination
   image instead of the source image and vice versa.</span></dd>

   <dt><dfn id="gcop-destination-out" title="gcop-destination-out"><code>destination-out</code></dfn></dt>

   <dd><var title="">B</var> out <var title="">A</var>. <span class="note">Same as <code title="gcop-source-out"><a href="#gcop-source-out">source-out</a></code> but using the destination
   image instead of the source image and vice versa.</span></dd>

   <dt><dfn id="gcop-destination-over" title="gcop-destination-over"><code>destination-over</code></dfn></dt>

   <dd><var title="">B</var> over <var title="">A</var>. <span class="note">Same as <code title="gcop-source-over"><a href="#gcop-source-over">source-over</a></code> but using the
   destination image instead of the source image and vice versa.</span></dd>


<!-- no clear definition of this operator (doesn't correspond to a PorterDuff operator)
   <dt><dfn title="gcop-darker"><code>darker</code></dfn></dt>

   <dd><span class="note">Display the sum of the source image and destination image,
   with color values approaching 0 as a limit.</span></dd>
-->

   <dt><dfn id="gcop-lighter" title="gcop-lighter"><code>lighter</code></dfn></dt>

   <dd><var title="">A</var> plus <var title="">B</var>. <span class="note">Display the
   sum of the source image and destination image, with color values
   approaching 255 (100%) as a limit.</span></dd>


   <dt><dfn id="gcop-copy" title="gcop-copy"><code>copy</code></dfn></dt>

   <dd><var title="">A</var> (<var title="">B</var> is
   ignored). <span class="note">Display the source image instead of the destination
   image.</span></dd>


   <dt><dfn id="gcop-xor" title="gcop-xor"><code>xor</code></dfn></dt>

   <dd><var title="">A</var> xor <var title="">B</var>. <span class="note">Exclusive OR
   of the source image and destination image.</span></dd>


   <dt class="impl"><code><var title="">vendorName</var>-<var title="">operationName</var></code></dt>

   <dd class="impl">Vendor-specific extensions to the list of
   composition operators should use this syntax.</dd>

  </dl><div class="impl">

  <p>The operators in the above list must be treated as described by
  the Porter-Duff operator given at the start of their description
  (e.g. <var title="">A</var> over <var title="">B</var>). They are to
  be applied as part of the <a href="#drawing-model">drawing model</a>, at which point the
  <a href="#clipping-region">clipping region</a> is also applied. (Without a clipping
  region, these operators act on the whole bitmap with every
  operation.) <a href="references.html#refsPORTERDUFF">[PORTERDUFF]</a></p>

  <p>These values are all case-sensitive &mdash; they must be used
  exactly as shown. User agents must not recognize values that are not
  a <a href="infrastructure.html#case-sensitive">case-sensitive</a> match for one of the values given
  above.</p>

  <p>On setting, if the user agent does not recognize the specified
  value, it must be ignored, leaving the value of <code title="dom-context-2d-globalCompositeOperation"><a href="#dom-context-2d-globalcompositeoperation">globalCompositeOperation</a></code>
  unaffected.</p>

  <p>When the context is created, the <code title="dom-context-2d-globalCompositeOperation"><a href="#dom-context-2d-globalcompositeoperation">globalCompositeOperation</a></code>
  attribute must initially have the value
  <code>source-over</code>.</p>

  </div>


  <h6 id="colors-and-styles"><span class="secno">4.8.11.1.4 </span>Colors and styles</h6>

  <dl class="domintro"><dt><var title="">context</var> . <code title="dom-context-2d-strokeStyle"><a href="#dom-context-2d-strokestyle">strokeStyle</a></code> [ = <var title="">value</var> ]</dt>

   <dd>

    <p>Returns the current style used for stroking shapes.</p>

    <p>Can be set, to change the stroke style.</p>

    <p>The style can be either a string containing a CSS color, or a
    <code><a href="#canvasgradient">CanvasGradient</a></code> or <code><a href="#canvaspattern">CanvasPattern</a></code>
    object. Invalid values are ignored.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-fillStyle"><a href="#dom-context-2d-fillstyle">fillStyle</a></code> [ = <var title="">value</var> ]</dt>

   <dd>

    <p>Returns the current style used for filling shapes.</p>

    <p>Can be set, to change the fill style.</p>

    <p>The style can be either a string containing a CSS color, or a
    <code><a href="#canvasgradient">CanvasGradient</a></code> or <code><a href="#canvaspattern">CanvasPattern</a></code>
    object. Invalid values are ignored.</p>

   </dd>

  </dl><div class="impl">

  <!-- v5 feature requests:

   * Getting and setting colours by component to bypass the CSS value parsing.

     Either:
        context.fillStyle.red += 1;

     Or:
        var array = context.fillStyle;
        array[1] += 1;
        context.fillStyle = array;

   * A more performant way of setting colours in general, e.g.:

       context.setFillColor(r,g,b,a) // already supported by webkit

     Or:

       context.fillStyle = 0xRRGGBBAA; // set a 32bit int directly

   * fill rule for deciding between winding and even-odd algorithms.
     SVG has fill-rule: nonzero | evenodd
       http://www.w3.org/TR/SVG/painting.html#FillProperties

  -->

  <p>The <dfn id="dom-context-2d-strokestyle" title="dom-context-2d-strokeStyle"><code>strokeStyle</code></dfn>
  attribute represents the color or style to use for the lines around
  shapes, and the <dfn id="dom-context-2d-fillstyle" title="dom-context-2d-fillStyle"><code>fillStyle</code></dfn>
  attribute represents the color or style to use inside the
  shapes.</p>

  <p>Both attributes can be either strings,
  <code><a href="#canvasgradient">CanvasGradient</a></code>s, or <code><a href="#canvaspattern">CanvasPattern</a></code>s. On
  setting, strings must be <a href="infrastructure.html#parsed-as-a-css-color-value" title="parsed as a CSS <color>
  value">parsed as CSS &lt;color&gt; values</a> and the color
  assigned, and <code><a href="#canvasgradient">CanvasGradient</a></code> and
  <code><a href="#canvaspattern">CanvasPattern</a></code> objects must be assigned themselves. <a href="references.html#refsCSSCOLOR">[CSSCOLOR]</a> If the value is a string but
  cannot be <a href="infrastructure.html#parsed-as-a-css-color-value">parsed as a CSS &lt;color&gt; value</a>, or is
  neither a string, a <code><a href="#canvasgradient">CanvasGradient</a></code>, nor a
  <code><a href="#canvaspattern">CanvasPattern</a></code>, then it must be ignored, and the
  attribute must retain its previous value.</p>

  <p>When set to a <code><a href="#canvaspattern">CanvasPattern</a></code> or
  <code><a href="#canvasgradient">CanvasGradient</a></code> object, the assignment is
  <a href="infrastructure.html#live">live</a>, meaning that changes made to the object after the
  assignment do affect subsequent stroking or filling of shapes.</p>

  <p>On getting, if the value is a color, then the <a href="#serialization-of-a-color" title="serialization of a color">serialization of the color</a>
  must be returned. Otherwise, if it is not a color but a
  <code><a href="#canvasgradient">CanvasGradient</a></code> or <code><a href="#canvaspattern">CanvasPattern</a></code>, then the
  respective object must be returned. (Such objects are opaque and
  therefore only useful for assigning to other attributes or for
  comparison to other gradients or patterns.)</p>

  <p>The <dfn id="serialization-of-a-color">serialization of a color</dfn> for a color value is a
  string, computed as follows: if it has alpha equal to 1.0, then the
  string is a lowercase six-digit hex value, prefixed with a "#"
  character (U+0023 NUMBER SIGN), with the first two digits
  representing the red component, the next two digits representing the
  green component, and the last two digits representing the blue
  component, the digits being in the range 0-9 a-f (U+0030 to U+0039
  and U+0061 to U+0066). Otherwise, the color value has alpha less
  than 1.0, and the string is the color value in the CSS <code title="">rgba()</code> functional-notation format: the literal
  string <code title="">rgba</code> (U+0072 U+0067 U+0062 U+0061)
  followed by a U+0028 LEFT PARENTHESIS, a base-ten integer in the
  range 0-255 representing the red component (using digits 0-9, U+0030
  to U+0039, in the shortest form possible), a literal U+002C COMMA
  and U+0020 SPACE, an integer for the green component, a comma and a
  space, an integer for the blue component, another comma and space, a
  U+0030 DIGIT ZERO, if the alpha value is greater than zero then a
  U+002E FULL STOP (representing the decimal point), if the alpha
  value is greater than zero then one or more digits in the range 0-9
  (U+0030 to U+0039) representing the fractional part of the alpha
  value, and finally a U+0029 RIGHT PARENTHESIS.</p> <!-- if people
  complain this is unreadable, expand it into a <dl> with two nested
  <ol>s -->

  <p>When the context is created, the <code title="dom-context-2d-strokeStyle"><a href="#dom-context-2d-strokestyle">strokeStyle</a></code> and <code title="dom-context-2d-fillStyle"><a href="#dom-context-2d-fillstyle">fillStyle</a></code> attributes must
  initially have the string value <code title="">#000000</code>.</p>

  </div>

  <hr><p>There are two types of gradients, linear gradients and radial
  gradients, both represented by objects implementing the opaque
  <code><a href="#canvasgradient">CanvasGradient</a></code> interface.</p>

  <p id="interpolation">Once a gradient has been created (see below),
  stops are placed along it to define how the colors are distributed
  along the gradient. <span class="impl">The color of the gradient at
  each stop is the color specified for that stop. Between each such
  stop, the colors and the alpha component must be linearly
  interpolated over the RGBA space without premultiplying the alpha
  value to find the color to use at that offset. Before the first
  stop, the color must be the color of the first stop. After the last
  stop, the color must be the color of the last stop. When there are
  no stops, the gradient is transparent black.</span></p>

  <dl class="domintro"><dt><var title="">gradient</var> . <code title="dom-canvasgradient-addColorStop"><a href="#dom-canvasgradient-addcolorstop">addColorStop</a></code>(<var title="">offset</var>, <var title="">color</var>)</dt>

   <dd>

    <p>Adds a color stop with the given color to the gradient at the
    given offset. 0.0 is the offset at one end of the gradient, 1.0 is
    the offset at the other end.</p>

    <p>Throws an <code><a href="urls.html#index_size_err">INDEX_SIZE_ERR</a></code> exception if the offset
    is out of range. Throws a <code><a href="urls.html#syntax_err">SYNTAX_ERR</a></code> exception if the
    color cannot be parsed.</p>

   </dd>

   <dt><var title="">gradient</var> = <var title="">context</var> . <code title="dom-context-2d-createLinearGradient"><a href="#dom-context-2d-createlineargradient">createLinearGradient</a></code>(<var title="">x0</var>, <var title="">y0</var>, <var title="">x1</var>, <var title="">y1</var>)</dt>

   <dd>

    <p>Returns a <code><a href="#canvasgradient">CanvasGradient</a></code> object that represents a
    linear gradient that paints along the line given by the
    coordinates represented by the arguments.</p>

    <p>If any of the arguments are not finite numbers, throws a
    <code><a href="urls.html#not_supported_err">NOT_SUPPORTED_ERR</a></code> exception.</p>

   </dd>

   <dt><var title="">gradient</var> = <var title="">context</var> . <code title="dom-context-2d-createRadialGradient"><a href="#dom-context-2d-createradialgradient">createRadialGradient</a></code>(<var title="">x0</var>, <var title="">y0</var>, <var title="">r0</var>, <var title="">x1</var>, <var title="">y1</var>, <var title="">r1</var>)</dt>

   <dd>

    <p>Returns a <code><a href="#canvasgradient">CanvasGradient</a></code> object that represents a
    radial gradient that paints along the cone given by the circles
    represented by the arguments.</p>

    <p>If any of the arguments are not finite numbers, throws a
    <code><a href="urls.html#not_supported_err">NOT_SUPPORTED_ERR</a></code> exception. If either of the radii
    are negative, throws an <code><a href="urls.html#index_size_err">INDEX_SIZE_ERR</a></code> exception.</p>

   </dd>

  </dl><div class="impl">

  <p>The <dfn id="dom-canvasgradient-addcolorstop" title="dom-canvasgradient-addColorStop"><code>addColorStop(<var title="">offset</var>, <var title="">color</var>)</code></dfn>
  method on the <code><a href="#canvasgradient">CanvasGradient</a></code> interface adds a new stop
  to a gradient. If the <var title="">offset</var> is less than 0,
  greater than 1, infinite, or NaN, then an
  <code><a href="urls.html#index_size_err">INDEX_SIZE_ERR</a></code> exception must be raised. If the <var title="">color</var> cannot be <a href="infrastructure.html#parsed-as-a-css-color-value">parsed as a CSS &lt;color&gt;
  value</a>, then a <code><a href="urls.html#syntax_err">SYNTAX_ERR</a></code> exception must be
  raised. Otherwise, the gradient must have a new stop placed, at
  offset <var title="">offset</var> relative to the whole gradient,
  and with the color obtained by parsing <var title="">color</var> as
  a CSS &lt;color&gt; value. If multiple stops are added at the same
  offset on a gradient, they must be placed in the order added, with
  the first one closest to the start of the gradient, and each
  subsequent one infinitesimally further along towards the end point
  (in effect causing all but the first and last stop added at each
  point to be ignored).</p>

  <p>The <dfn id="dom-context-2d-createlineargradient" title="dom-context-2d-createLinearGradient"><code>createLinearGradient(<var title="">x0</var>, <var title="">y0</var>, <var title="">x1</var>,
  <var title="">y1</var>)</code></dfn> method takes four arguments
  that represent the start point (<var title="">x0</var>, <var title="">y0</var>) and end point (<var title="">x1</var>, <var title="">y1</var>) of the gradient. If any of the arguments to <code title="dom-context-2d-createLinearGradient"><a href="#dom-context-2d-createlineargradient">createLinearGradient()</a></code>
  are infinite or NaN, the method must raise a
  <code><a href="urls.html#not_supported_err">NOT_SUPPORTED_ERR</a></code> exception. Otherwise, the method must
  return a linear <code><a href="#canvasgradient">CanvasGradient</a></code> initialized with the
  specified line.</p>

  <p>Linear gradients must be rendered such that all points on a line
  perpendicular to the line that crosses the start and end points have
  the color at the point where those two lines cross (with the colors
  coming from the <a href="#interpolation">interpolation and
  extrapolation</a> described above). The points in the linear
  gradient must be transformed as described by the <a href="#transformations" title="dom-context-2d-transformation">current transformation
  matrix</a> when rendering.</p>

  <p>If <span title=""><var title="">x0</var>&nbsp;=&nbsp;<var title="">x1</var></span> and <span title=""><var title="">y0</var>&nbsp;=&nbsp;<var title="">y1</var></span>, then
  the linear gradient must paint nothing.</p>

  <p>The <dfn id="dom-context-2d-createradialgradient" title="dom-context-2d-createRadialGradient"><code>createRadialGradient(<var title="">x0</var>, <var title="">y0</var>, <var title="">r0</var>,
  <var title="">x1</var>, <var title="">y1</var>, <var title="">r1</var>)</code></dfn> method takes six arguments, the
  first three representing the start circle with origin (<var title="">x0</var>, <var title="">y0</var>) and radius <var title="">r0</var>, and the last three representing the end circle
  with origin (<var title="">x1</var>, <var title="">y1</var>) and
  radius <var title="">r1</var>. The values are in coordinate space
  units. If any of the arguments are infinite or NaN, a
  <code><a href="urls.html#not_supported_err">NOT_SUPPORTED_ERR</a></code> exception must be raised. If either
  of <var title="">r0</var> or <var title="">r1</var> are negative, an
  <code><a href="urls.html#index_size_err">INDEX_SIZE_ERR</a></code> exception must be raised. Otherwise,
  the method must return a radial <code><a href="#canvasgradient">CanvasGradient</a></code>
  initialized with the two specified circles.</p>

  <p>Radial gradients must be rendered by following these steps:</p>

  <ol><li><p>If <span title=""><var title="">x<sub>0</sub></var>&nbsp;=&nbsp;<var title="">x<sub>1</sub></var></span> and <span title=""><var title="">y<sub>0</sub></var>&nbsp;=&nbsp;<var title="">y<sub>1</sub></var></span> and <span title=""><var title="">r<sub>0</sub></var>&nbsp;=&nbsp;<var title="">r<sub>1</sub></var></span>, then the radial gradient must
   paint nothing. Abort these steps.</li>

   <li>

    <p>Let <span title="">x(<var title="">&omega;</var>)&nbsp;=&nbsp;(<var title="">x<sub>1</sub></var>-<var title="">x<sub>0</sub></var>)<var title="">&omega;</var>&nbsp;+&nbsp;<var title="">x<sub>0</sub></var></span></p>

    <p>Let <span title="">y(<var title="">&omega;</var>)&nbsp;=&nbsp;(<var title="">y<sub>1</sub></var>-<var title="">y<sub>0</sub></var>)<var title="">&omega;</var>&nbsp;+&nbsp;<var title="">y<sub>0</sub></var></span></p>

    <p>Let <span title="">r(<var title="">&omega;</var>)&nbsp;=&nbsp;(<var title="">r<sub>1</sub></var>-<var title="">r<sub>0</sub></var>)<var title="">&omega;</var>&nbsp;+&nbsp;<var title="">r<sub>0</sub></var></span></p>

    <p>Let the color at <var title="">&omega;</var> be the color at
    that position on the gradient (with the colors coming from the <a href="#interpolation">interpolation and extrapolation</a>
    described above).</p>

   </li>

   <li><p>For all values of <var title="">&omega;</var> where <span title="">r(<var title="">&omega;</var>)&nbsp;&gt;&nbsp;0</span>,
   starting with the value of <var title="">&omega;</var> nearest to
   positive infinity and ending with the value of <var title="">&omega;</var> nearest to negative infinity, draw the
   circumference of the circle with radius <span title="">r(<var title="">&omega;</var>)</span> at position (<span title="">x(<var title="">&omega;</var>)</span>, <span title="">y(<var title="">&omega;</var>)</span>), with the color at <var title="">&omega;</var>, but only painting on the parts of the
   canvas that have not yet been painted on by earlier circles in this
   step for this rendering of the gradient.</li>

  </ol><p class="note">This effectively creates a cone, touched by the two
  circles defined in the creation of the gradient, with the part of
  the cone before the start circle (0.0) using the color of the first
  offset, the part of the cone after the end circle (1.0) using the
  color of the last offset, and areas outside the cone untouched by
  the gradient (transparent black).</p>

  <p>The points in the radial gradient must be transformed as
  described by the <a href="#transformations" title="dom-context-2d-transformation">current
  transformation matrix</a> when rendering.</p>

  <p>Gradients must be painted only where the relevant stroking or
  filling effects requires that they be drawn.</p>

<!--
  <p>Support for actually painting gradients is optional. Instead of
  painting the gradients, user agents may instead just paint the first
  stop's color. However, <code
  title="dom-context-2d-createLinearGradient">createLinearGradient()</code>
  and <code
  title="dom-context-2d-createRadialGradient">createRadialGradient()</code>
  must always return objects when passed valid arguments.</p>
-->

  </div>

  <hr><p>Patterns are represented by objects implementing the opaque
  <code><a href="#canvaspattern">CanvasPattern</a></code> interface.</p>

  <dl class="domintro"><dt><var title="">pattern</var> = <var title="">context</var> . <code title="dom-context-2d-createPattern"><a href="#dom-context-2d-createpattern">createPattern</a></code>(<var title="">image</var>, <var title="">repetition</var>)</dt>

   <dd>

    <p>Returns a <code><a href="#canvaspattern">CanvasPattern</a></code> object that uses the given image
    and repeats in the direction(s) given by the <var title="">repetition</var> argument.</p>

    <p>The allowed values for <var title="">repetition</var> are <code title="">repeat</code> (both directions), <code title="">repeat-x</code> (horizontal only), <code title="">repeat-y</code> (vertical only), and <code title="">no-repeat</code> (neither). If the <var title="">repetition</var> argument is empty or null, the value
    <code title="">repeat</code> is used.</p>

    <p>If the first argument isn't an <code><a href="embedded-content-1.html#the-img-element">img</a></code>,
    <code><a href="#the-canvas-element">canvas</a></code>, or <code><a href="video.html#video">video</a></code> element, throws a
    <code><a href="urls.html#type_mismatch_err">TYPE_MISMATCH_ERR</a></code> exception. If the image has no
    image data, throws an <code><a href="urls.html#invalid_state_err">INVALID_STATE_ERR</a></code> exception. If
    the second argument isn't one of the allowed values, throws a
    <code><a href="urls.html#syntax_err">SYNTAX_ERR</a></code> exception. If the image isn't yet fully
    decoded, then the method returns null.</p>

   </dd>

  </dl><div class="impl">

  <p>To create objects of this type, the <dfn id="dom-context-2d-createpattern" title="dom-context-2d-createPattern"><code>createPattern(<var title="">image</var>, <var title="">repetition</var>)</code></dfn>
  method is used. The first argument gives the image to use as the
  pattern (either an <code><a href="embedded-content-1.html#htmlimageelement">HTMLImageElement</a></code>,
  <code><a href="#htmlcanvaselement">HTMLCanvasElement</a></code>, or <code><a href="video.html#htmlvideoelement">HTMLVideoElement</a></code>
  object). Modifying this image after calling the <code title="dom-context-2d-createPattern"><a href="#dom-context-2d-createpattern">createPattern()</a></code> method
  must not affect the pattern. The second argument must be a string
  with one of the following values: <code title="">repeat</code>,
  <code title="">repeat-x</code>, <code title="">repeat-y</code>,
  <code title="">no-repeat</code>. If the empty string or null is
  specified, <code title="">repeat</code> must be assumed. If an
  unrecognized value is given, then the user agent must raise a
  <code><a href="urls.html#syntax_err">SYNTAX_ERR</a></code> exception. User agents must recognize the
  four values described above exactly (e.g. they must not do case
  folding). Except as specified below, the method must return a
  <code><a href="#canvaspattern">CanvasPattern</a></code> object suitably initialized.</p>

  <p>The <var title="">image</var> argument is an instance of either
  <code><a href="embedded-content-1.html#htmlimageelement">HTMLImageElement</a></code>, <code><a href="#htmlcanvaselement">HTMLCanvasElement</a></code>, or
  <code><a href="video.html#htmlvideoelement">HTMLVideoElement</a></code>. If the <var title="">image</var> is
  null, the implementation must raise a <code><a href="urls.html#type_mismatch_err">TYPE_MISMATCH_ERR</a></code>
  exception.</p> <!-- drawImage() has an equivalent paragraph -->

  <p>If the <var title="">image</var> argument is an
  <code><a href="embedded-content-1.html#htmlimageelement">HTMLImageElement</a></code> object that is not <a href="embedded-content-1.html#img-good" title="img-good">fully decodable</a>, or if the <var title="">image</var> argument is an <code><a href="video.html#htmlvideoelement">HTMLVideoElement</a></code>
  object whose <code title="dom-media-readyState"><a href="video.html#dom-media-readystate">readyState</a></code>
  attribute is either <code title="dom-media-HAVE_NOTHING"><a href="video.html#dom-media-have_nothing">HAVE_NOTHING</a></code> or <code title="dom-media-HAVE_METADATA"><a href="video.html#dom-media-have_metadata">HAVE_METADATA</a></code>, then the
  implementation must return null.</p> <!-- drawImage() has an
  equivalent paragraph -->

  <p>If the <var title="">image</var> argument is an
  <code><a href="#htmlcanvaselement">HTMLCanvasElement</a></code> object with either a horizontal
  dimension or a vertical dimension equal to zero, then the
  implementation must raise an <code><a href="urls.html#invalid_state_err">INVALID_STATE_ERR</a></code>
  exception.</p>
  <!-- drawImage() has an equivalent paragraph -->

  <p>Patterns must be painted so that the top left of the first image
  is anchored at the origin of the coordinate space, and images are
  then repeated horizontally to the left and right (if the
  <code>repeat-x</code> string was specified) or vertically up and
  down (if the <code>repeat-y</code> string was specified) or in all
  four directions all over the canvas (if the <code>repeat</code>
  string was specified). The images are not scaled by this process;
  one CSS pixel of the image must be painted on one coordinate space
  unit. Of course, patterns must actually be painted only where the
  stroking or filling effect requires that they be drawn, and are
  affected by the current transformation matrix.</p>

  <p>If the original image data is a bitmap image, the value painted
  at a point in the area of the repetitions is computed by filtering
  the original image data. The user agent may use any filtering
  algorithm (for example bilinear interpolation or nearest-neighbor).
  When the filtering algorithm requires a pixel value from outside the
  original image data, it must instead use the value from wrapping the
  pixel's coordinates to the original image's dimensions. (That is,
  the filter uses 'repeat' behavior, regardless of the value of
  <var title="">repetition</var>.)
  <!-- drawImage() has a similar paragraph with different rules -->

  <p>When the <code title="dom-context-2d-createPattern"><a href="#dom-context-2d-createpattern">createPattern()</a></code> method
  is passed an animated image as its <var title="">image</var>
  argument, the user agent must use the poster frame of the animation,
  or, if there is no poster frame, the first frame of the
  animation.</p>
  <!-- drawImage() has an equivalent paragraph -->

  <p>When the <var title="">image</var> argument is an
  <code><a href="video.html#htmlvideoelement">HTMLVideoElement</a></code>, then the frame at the <a href="video.html#current-playback-position">current
  playback position</a> must be used as the source image, and the
  source image's dimensions must be the <a href="video.html#concept-video-intrinsic-width" title="concept-video-intrinsic-width">intrinsic width</a> and
  <a href="video.html#concept-video-intrinsic-height" title="concept-video-intrinsic-height">intrinsic height</a>
  of the <a href="video.html#media-resource">media resource</a> (i.e. after any aspect-ratio
  correction has been applied).</p>
  <!-- drawImage() has an equivalent paragraph -->

  <!--
   Requests for v5 features:
    * apply transforms to patterns, so you don't have to create
      transformed patterns manually by rendering them to an off-screen
      canvas then using that canvas as the pattern.
  -->

  </div>



  <h6 id="line-styles"><span class="secno">4.8.11.1.5 </span>Line styles</h6>

  <dl class="domintro"><dt><var title="">context</var> . <code title="dom-context-2d-lineWidth"><a href="#dom-context-2d-linewidth">lineWidth</a></code> [ = <var title="">value</var> ]</dt>

   <dd>

    <p>Returns the current line width.</p>

    <p>Can be set, to change the line width. Values that are not
    finite values greater than zero are ignored.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-lineCap"><a href="#dom-context-2d-linecap">lineCap</a></code> [ = <var title="">value</var> ]</dt>

   <dd>

    <p>Returns the current line cap style.</p>

    <p>Can be set, to change the line cap style.</p>

    <p>The possible line cap styles are <code>butt</code>,
    <code>round</code>, and <code>square</code>. Other values are
    ignored.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-lineJoin"><a href="#dom-context-2d-linejoin">lineJoin</a></code> [ = <var title="">value</var> ]</dt>

   <dd>

    <p>Returns the current line join style.</p>

    <p>Can be set, to change the line join style.</p>

    <p>The possible line join styles are <code>bevel</code>,
    <code>round</code>, and <code>miter</code>. Other values are
    ignored.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-miterLimit"><a href="#dom-context-2d-miterlimit">miterLimit</a></code> [ = <var title="">value</var> ]</dt>

   <dd>

    <p>Returns the current miter limit ratio.</p>

    <p>Can be set, to change the miter limit ratio. Values that are
    not finite values greater than zero are ignored.</p>

   </dd>

  </dl><div class="impl">

  <p>The <dfn id="dom-context-2d-linewidth" title="dom-context-2d-lineWidth"><code>lineWidth</code></dfn>
  attribute gives the width of lines, in coordinate space units. On
  getting, it must return the current value. On setting, zero,
  negative, infinite, and NaN values must be ignored, leaving the
  value unchanged; other values must change the current value to the
  new value.</p>

  <p>When the context is created, the <code title="dom-context-2d-lineWidth"><a href="#dom-context-2d-linewidth">lineWidth</a></code> attribute must
  initially have the value <code>1.0</code>.</p>

  <hr><p>The <dfn id="dom-context-2d-linecap" title="dom-context-2d-lineCap"><code>lineCap</code></dfn> attribute
  defines the type of endings that UAs will place on the end of
  lines. The three valid values are <code>butt</code>,
  <code>round</code>, and <code>square</code>. The <code>butt</code>
  value means that the end of each line has a flat edge perpendicular
  to the direction of the line (and that no additional line cap is
  added). The <code>round</code> value means that a semi-circle with
  the diameter equal to the width of the line must then be added on to
  the end of the line. The <code>square</code> value means that a
  rectangle with the length of the line width and the width of half
  the line width, placed flat against the edge perpendicular to the
  direction of the line, must be added at the end of each line.</p>

  <p>On getting, it must return the current value. On setting, if the
  new value is one of the literal strings <code>butt</code>,
  <code>round</code>, and <code>square</code>, then the current value
  must be changed to the new value; other values must ignored, leaving
  the value unchanged.</p>

  <p>When the context is created, the <code title="dom-context-2d-lineCap"><a href="#dom-context-2d-linecap">lineCap</a></code> attribute must
  initially have the value <code>butt</code>.</p>

  <hr><p>The <dfn id="dom-context-2d-linejoin" title="dom-context-2d-lineJoin"><code>lineJoin</code></dfn>
  attribute defines the type of corners that UAs will place where two
  lines meet. The three valid values are <code>bevel</code>,
  <code>round</code>, and <code>miter</code>.</p>

  <p>On getting, it must return the current value. On setting, if the
  new value is one of the literal strings <code>bevel</code>,
  <code>round</code>, and <code>miter</code>, then the current value
  must be changed to the new value; other values must be ignored,
  leaving the value unchanged.</p>

  <p>When the context is created, the <code title="dom-context-2d-lineJoin"><a href="#dom-context-2d-linejoin">lineJoin</a></code> attribute must
  initially have the value <code>miter</code>.</p>

  <hr><p>A join exists at any point in a subpath shared by two consecutive
  lines. When a subpath is closed, then a join also exists at its
  first point (equivalent to its last point) connecting the first and
  last lines in the subpath.</p>

  <p>In addition to the point where the join occurs, two additional
  points are relevant to each join, one for each line: the two corners
  found half the line width away from the join point, one
  perpendicular to each line, each on the side furthest from the other
  line.</p>

  <p>A filled triangle connecting these two opposite corners with a
  straight line, with the third point of the triangle being the join
  point, must be rendered at all joins. The <code title="dom-context-2d-lineJoin"><a href="#dom-context-2d-linejoin">lineJoin</a></code> attribute controls
  whether anything else is rendered. The three aforementioned values
  have the following meanings:</p>

  <p>The <code>bevel</code> value means that this is all that is
  rendered at joins.</p>

  <p>The <code>round</code> value means that a filled arc connecting
  the two aforementioned corners of the join, abutting (and not
  overlapping) the aforementioned triangle, with the diameter equal to
  the line width and the origin at the point of the join, must be
  rendered at joins.</p>

  <p>The <code>miter</code> value means that a second filled triangle
  must (if it can given the miter length) be rendered at the join,
  with one line being the line between the two aforementioned corners,
  abutting the first triangle, and the other two being continuations of
  the outside edges of the two joining lines, as long as required to
  intersect without going over the miter length.</p>

  <p>The miter length is the distance from the point where the join
  occurs to the intersection of the line edges on the outside of the
  join. The miter limit ratio is the maximum allowed ratio of the
  miter length to half the line width. If the miter length would cause
  the miter limit ratio to be exceeded, this second triangle must not
  be rendered.</p>

  <p>The miter limit ratio can be explicitly set using the <dfn id="dom-context-2d-miterlimit" title="dom-context-2d-miterLimit"><code>miterLimit</code></dfn>
  attribute. On getting, it must return the current value. On setting,
  zero, negative, infinite, and NaN values must be ignored, leaving
  the value unchanged; other values must change the current value to
  the new value.</p>

  <p>When the context is created, the <code title="dom-context-2d-miterLimit"><a href="#dom-context-2d-miterlimit">miterLimit</a></code> attribute must
  initially have the value <code>10.0</code>.</p>

  <!--
v5: dashed lines have been requested. Philip Taylor provides these
notes on what would need to be defined for dashed lines:
> I don't think it's entirely trivial to add, to the detail that's
> necessary in a specification. The common graphics APIs (at least
> Cairo, Quartz and java.awt.Graphics, and any SVG implementation) all
> have dashes specified by passing an array of dash lengths (alternating
> on/off), so that should be alright as long as you define what units
> it's measured in and what happens when you specify an odd number of
> values and how errors are handled and what happens if you update the
> array later. But after that, what does it do when stroking multiple
> subpaths, in terms of offsetting the dashes? When you use strokeRect,
> where is offset 0? Does moveTo reset the offset? How does it interact
> with lineCap/lineJoin? All the potential issues need test cases too,
> and the implementations need to make sure they handle any edge cases
> that the underlying graphics library does differently. (SVG Tiny 1.2
> appears to skip some of the problems by leaving things undefined and
> allowing whatever behavior the graphics library has.)

Another request has been for hairline width lines, that remain
hairline width with transform. ack Shaun Morris.
  -->

  </div>


  <h6 id="shadows"><span class="secno">4.8.11.1.6 </span><dfn>Shadows</dfn></h6>

  <p>All drawing operations are affected by the four global shadow
  attributes.</p>

  <dl class="domintro"><dt><var title="">context</var> . <code title="dom-context-2d-shadowColor"><a href="#dom-context-2d-shadowcolor">shadowColor</a></code> [ = <var title="">value</var> ]</dt>

   <dd>

    <p>Returns the current shadow color.</p>

    <p>Can be set, to change the shadow color. Values that cannot be parsed as CSS colors are ignored.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-shadowOffsetX"><a href="#dom-context-2d-shadowoffsetx">shadowOffsetX</a></code> [ = <var title="">value</var> ]</dt>
   <dt><var title="">context</var> . <code title="dom-context-2d-shadowOffsetY"><a href="#dom-context-2d-shadowoffsety">shadowOffsetY</a></code> [ = <var title="">value</var> ]</dt>

   <dd>

    <p>Returns the current shadow offset.</p>

    <p>Can be set, to change the shadow offset. Values that are not finite numbers are ignored.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-shadowBlur"><a href="#dom-context-2d-shadowblur">shadowBlur</a></code> [ = <var title="">value</var> ]</dt>

   <dd>

    <p>Returns the current level of blur applied to shadows.</p>

    <p>Can be set, to change the blur level. Values that are not finite numbers greater than or equal to zero are ignored.</p>

   </dd>

  </dl><div class="impl">

  <p>The <dfn id="dom-context-2d-shadowcolor" title="dom-context-2d-shadowColor"><code>shadowColor</code></dfn>
  attribute sets the color of the shadow.</p>

  <p>When the context is created, the <code title="dom-context-2d-shadowColor"><a href="#dom-context-2d-shadowcolor">shadowColor</a></code> attribute
  initially must be fully-transparent black.</p>

  <p>On getting, the <a href="#serialization-of-a-color" title="serialization of a
  color">serialization of the color</a> must be returned.</p>

  <p>On setting, the new value must be <a href="infrastructure.html#parsed-as-a-css-color-value">parsed as a CSS
  &lt;color&gt; value</a> and the color assigned. If the value
  cannot be parsed as a CSS &lt;color&gt; value then it must be
  ignored, and the attribute must retain its previous value. <a href="references.html#refsCSSCOLOR">[CSSCOLOR]</a></p>

  <p>The <dfn id="dom-context-2d-shadowoffsetx" title="dom-context-2d-shadowOffsetX"><code>shadowOffsetX</code></dfn>
  and <dfn id="dom-context-2d-shadowoffsety" title="dom-context-2d-shadowOffsetY"><code>shadowOffsetY</code></dfn>
  attributes specify the distance that the shadow will be offset in
  the positive horizontal and positive vertical distance
  respectively. Their values are in coordinate space units. They are
  not affected by the current transformation matrix.</p>

  <p>When the context is created, the shadow offset attributes must
  initially have the value <code>0</code>.</p>

  <p>On getting, they must return their current value. On setting, the
  attribute being set must be set to the new value, except if the
  value is infinite or NaN, in which case the new value must be
  ignored.</p>

  <p>The <dfn id="dom-context-2d-shadowblur" title="dom-context-2d-shadowBlur"><code>shadowBlur</code></dfn>
  attribute specifies the level of the blurring effect. (The units do
  not map to coordinate space units, and are not affected by the
  current transformation matrix.)</p>

  <p>When the context is created, the <code title="dom-context-2d-shadowBlur"><a href="#dom-context-2d-shadowblur">shadowBlur</a></code> attribute must
  initially have the value <code>0</code>.</p>

  <p>On getting, the attribute must return its current value. On
  setting the attribute must be set to the new value, except if the
  value is negative, infinite or NaN, in which case the new value must
  be ignored.</p>

  <p><dfn id="when-shadows-are-drawn" title="when shadows are drawn">Shadows are only drawn
  if</dfn> the opacity component of the alpha component of the color
  of <code title="dom-context-2d-shadowColor"><a href="#dom-context-2d-shadowcolor">shadowColor</a></code> is
  non-zero and either the <code title="dom-context-2d-shadowBlur"><a href="#dom-context-2d-shadowblur">shadowBlur</a></code> is non-zero, or
  the <code title="dom-context-2d-shadowOffsetX"><a href="#dom-context-2d-shadowoffsetx">shadowOffsetX</a></code>
  is non-zero, or the <code title="dom-context-2d-shadowOffsetY"><a href="#dom-context-2d-shadowoffsety">shadowOffsetY</a></code> is
  non-zero.</p>

  <p><a href="#when-shadows-are-drawn">When shadows are drawn</a>, they must be rendered as follows:</p>

  <ol><li> <p>Let <var title="">A</var> be an infinite transparent black
   bitmap on which the source image for which a shadow is being
   created has been rendered.</p> </li>

   <li> <p>Let <var title="">B</var> be an infinite transparent black
   bitmap, with a coordinate space and an origin identical to <var title="">A</var>.</p> </li>

   <li> <p>Copy the alpha channel of <var title="">A</var> to <var title="">B</var>, offset by <code title="dom-context-2d-shadowOffsetX"><a href="#dom-context-2d-shadowoffsetx">shadowOffsetX</a></code> in the
   positive <var title="">x</var> direction, and <code title="dom-context-2d-shadowOffsetY"><a href="#dom-context-2d-shadowoffsety">shadowOffsetY</a></code> in the
   positive <var title="">y</var> direction.</p> </li>

   <li> <p>If <code title="dom-context-2d-shadowBlur"><a href="#dom-context-2d-shadowblur">shadowBlur</a></code> is greater than
   0:</p>

    <ol><li> <p>Let <var title="">&sigma;</var> be half the value of
     <code title="dom-context-2d-shadowBlur"><a href="#dom-context-2d-shadowblur">shadowBlur</a></code>.</li>

     <li> <p>Perform a 2D Gaussian Blur on <var title="">B</var>,
     using <var title="">&sigma;</var> as the standard deviation.</p>
     <!-- wish i could find a reference for this --> </li>

    </ol><p>User agents may limit values of <var title="">&sigma;</var> to
    an implementation-specific maximum value to avoid exceeding
    hardware limitations during the Gaussian blur operation.</p>

   </li>

   <li> <p>Set the red, green, and blue components of every pixel in
   <var title="">B</var> to the red, green, and blue components
   (respectively) of the color of <code title="dom-context-2d-shadowColor"><a href="#dom-context-2d-shadowcolor">shadowColor</a></code>.</p> </li>

   <li> <p>Multiply the alpha component of every pixel in <var title="">B</var> by the alpha component of the color of <code title="dom-context-2d-shadowColor"><a href="#dom-context-2d-shadowcolor">shadowColor</a></code>.</p> </li>

   <li> <p>The shadow is in the bitmap <var title="">B</var>, and is
   rendered as part of the <a href="#drawing-model">drawing model</a> described below.</p> </li>

  </ol></div>

  <p>If the current composition operation is <code title="gcop-copy"><a href="#gcop-copy">copy</a></code>, shadows effectively won't render
  (since the shape will overwrite the shadow).</p>


  <h6 id="simple-shapes-(rectangles)"><span class="secno">4.8.11.1.7 </span>Simple shapes (rectangles)</h6>

  <p>There are three methods that immediately draw rectangles to the
  bitmap. They each take four arguments; the first two give the <var title="">x</var> and <var title="">y</var> coordinates of the top
  left of the rectangle, and the second two give the width <var title="">w</var> and height <var title="">h</var> of the rectangle,
  respectively.</p>

  <div class="impl">

  <p>The <a href="#transformations" title="dom-context-2d-transformation">current
  transformation matrix</a> must be applied to the following four
  coordinates, which form the path that must then be closed to get the
  specified rectangle: <span title="">(<var title="">x</var>, <var title="">y</var>)</span>, <span title="">(<span title=""><var title="">x</var>+<var title="">w</var></span>, <var title="">y</var>)</span>,
  <span title="">(<span title=""><var title="">x</var>+<var title="">w</var></span>,
  <span title=""><var title="">y</var>+<var title="">h</var></span>)</span>,
  <span title="">(<var title="">x</var>, <span title=""><var title="">y</var>+<var title="">h</var></span>)</span>.</p>

  <p>Shapes are painted without affecting the current path, and are
  subject to the <a href="#clipping-region" title="clipping region">clipping region</a>,
  and, with the exception of <code title="dom-context-2d-clearRect"><a href="#dom-context-2d-clearrect">clearRect()</a></code>, also <a href="#shadows" title="shadows">shadow effects</a>, <a href="#dom-context-2d-globalalpha" title="dom-context-2d-globalAlpha">global alpha</a>, and <a href="#dom-context-2d-globalcompositeoperation" title="dom-context-2d-globalCompositeOperation">global composition
  operators</a>.</p>

  </div>

  <dl class="domintro"><dt><var title="">context</var> . <code title="dom-context-2d-clearRect"><a href="#dom-context-2d-clearrect">clearRect</a></code>(<var title="">x</var>, <var title="">y</var>, <var title="">w</var>, <var title="">h</var>)</dt>

   <dd>

    <p>Clears all pixels on the canvas in the given rectangle to transparent black.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-fillRect"><a href="#dom-context-2d-fillrect">fillRect</a></code>(<var title="">x</var>, <var title="">y</var>, <var title="">w</var>, <var title="">h</var>)</dt>

   <dd>

    <p>Paints the given rectangle onto the canvas, using the current fill style.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-strokeRect"><a href="#dom-context-2d-strokerect">strokeRect</a></code>(<var title="">x</var>, <var title="">y</var>, <var title="">w</var>, <var title="">h</var>)</dt>

   <dd>

    <p>Paints the box that outlines the given rectangle onto the canvas, using the current stroke style.</p>

   </dd>

  </dl><div class="impl">

  <p>The <dfn id="dom-context-2d-clearrect" title="dom-context-2d-clearRect"><code>clearRect(<var title="">x</var>, <var title="">y</var>, <var title="">w</var>, <var title="">h</var>)</code></dfn> method must clear the pixels in the
  specified rectangle that also intersect the current clipping region
  to a fully transparent black, erasing any previous image. If either
  height or width are zero, this method has no effect.</p>

  <p>The <dfn id="dom-context-2d-fillrect" title="dom-context-2d-fillRect"><code>fillRect(<var title="">x</var>, <var title="">y</var>, <var title="">w</var>, <var title="">h</var>)</code></dfn> method must paint the specified
  rectangular area using the <code title="dom-context-2d-fillStyle"><a href="#dom-context-2d-fillstyle">fillStyle</a></code>. If either height
  or width are zero, this method has no effect.</p>

  <p>The <dfn id="dom-context-2d-strokerect" title="dom-context-2d-strokeRect"><code>strokeRect(<var title="">x</var>, <var title="">y</var>, <var title="">w</var>, <var title="">h</var>)</code></dfn> method must stroke the specified
  rectangle's path using the <code title="dom-context-2d-strokeStyle"><a href="#dom-context-2d-strokestyle">strokeStyle</a></code>, <code title="dom-context-2d-lineWidth"><a href="#dom-context-2d-linewidth">lineWidth</a></code>, <code title="dom-context-2d-lineJoin"><a href="#dom-context-2d-linejoin">lineJoin</a></code>, and (if
  appropriate) <code title="dom-context-2d-miterLimit"><a href="#dom-context-2d-miterlimit">miterLimit</a></code> attributes. If
  both height and width are zero, this method has no effect, since
  there is no path to stroke (it's a point). If only one of the two is
  zero, then the method will draw a line instead (the path for the
  outline is just a straight line along the non-zero dimension).</p>

  </div>


  <h6 id="complex-shapes-(paths)"><span class="secno">4.8.11.1.8 </span>Complex shapes (paths)</h6>

  <p>The context always has a current path. There is only one current
  path, it is not part of the <a href="#drawing-state">drawing state</a>.</p>

  <p>A <dfn id="path">path</dfn> has a list of zero or more subpaths. Each
  subpath consists of a list of one or more points, connected by
  straight or curved lines, and a flag indicating whether the subpath
  is closed or not. A closed subpath is one where the last point of
  the subpath is connected to the first point of the subpath by a
  straight line. Subpaths with fewer than two points are ignored when
  painting the path.</p>

  <dl class="domintro"><dt><var title="">context</var> . <code title="dom-context-2d-beginPath"><a href="#dom-context-2d-beginpath">beginPath</a></code>()</dt>

   <dd>

    <p>Resets the current path.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-moveTo"><a href="#dom-context-2d-moveto">moveTo</a></code>(<var title="">x</var>, <var title="">y</var>)</dt>

   <dd>

    <p>Creates a new subpath with the given point.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-closePath"><a href="#dom-context-2d-closepath">closePath</a></code>()</dt>

   <dd>

    <p>Marks the current subpath as closed, and starts a new subpath with a point the same as the start and end of the newly closed subpath.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-lineTo"><a href="#dom-context-2d-lineto">lineTo</a></code>(<var title="">x</var>, <var title="">y</var>)</dt>

   <dd>

    <p>Adds the given point to the current subpath, connected to the previous one by a straight line.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-quadraticCurveTo"><a href="#dom-context-2d-quadraticcurveto">quadraticCurveTo</a></code>(<var title="">cpx</var>, <var title="">cpy</var>, <var title="">x</var>, <var title="">y</var>)</dt>

   <dd>

    <p>Adds the given point to the current subpath, connected to the previous one by a quadratic B&eacute;zier curve with the given control point.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-bezierCurveTo"><a href="#dom-context-2d-beziercurveto">bezierCurveTo</a></code>(<var title="">cp1x</var>, <var title="">cp1y</var>, <var title="">cp2x</var>, <var title="">cp2y</var>, <var title="">x</var>, <var title="">y</var>)</dt>

   <dd>

    <p>Adds the given point to the current subpath, connected to the previous one by a cubic B&eacute;zier curve with the given control points.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-arcTo"><a href="#dom-context-2d-arcto">arcTo</a></code>(<var title="">x1</var>, <var title="">y1</var>, <var title="">x2</var>, <var title="">y2</var>, <var title="">radius</var>)</dt>

   <dd>

    <p>Adds an arc with the given control points and radius to the
    current subpath, connected to the previous point by a straight
    line.</p>

    <p>Throws an <code><a href="urls.html#index_size_err">INDEX_SIZE_ERR</a></code> exception if the given
    radius is negative.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-arc"><a href="#dom-context-2d-arc">arc</a></code>(<var title="">x</var>, <var title="">y</var>, <var title="">radius</var>, <var title="">startAngle</var>, <var title="">endAngle</var> [, <var title="">anticlockwise</var> ] )</dt>

   <dd>

    <p>Adds points to the subpath such that the arc described by the
    circumference of the circle described by the arguments, starting
    at the given start angle and ending at the given end angle, going
    in the given direction (defaulting to clockwise), is added to the
    path, connected to the previous point by a straight line.</p>

    <p>Throws an <code><a href="urls.html#index_size_err">INDEX_SIZE_ERR</a></code> exception if the given
    radius is negative.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-rect"><a href="#dom-context-2d-rect">rect</a></code>(<var title="">x</var>, <var title="">y</var>, <var title="">w</var>, <var title="">h</var>)</dt>

   <dd>

    <p>Adds a new closed subpath to the path, representing the given rectangle.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-fill"><a href="#dom-context-2d-fill">fill</a></code>()</dt>

   <dd>

    <p>Fills the subpaths with the current fill style.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-stroke"><a href="#dom-context-2d-stroke">stroke</a></code>()</dt>

   <dd>

    <p>Strokes the subpaths with the current stroke style.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-clip"><a href="#dom-context-2d-clip">clip</a></code>()</dt>

   <dd>

    <p>Further constrains the clipping region to the given path.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-isPointInPath"><a href="#dom-context-2d-ispointinpath">isPointInPath</a></code>(<var title="">x</var>, <var title="">y</var>)</dt>

   <dd>

    <p>Returns true if the given point is in the current path.</p>

   </dd>

  </dl><div class="impl">

  <p>Initially, the context's path must have zero subpaths.</p>

  <p>The points and lines added to the path by these methods must be
  transformed according to the <a href="#transformations" title="dom-context-2d-transformation">current transformation
  matrix</a> as they are added.</p>


  <p>The <dfn id="dom-context-2d-beginpath" title="dom-context-2d-beginPath"><code>beginPath()</code></dfn>
  method must empty the list of subpaths so that the context once
  again has zero subpaths.</p>


  <p>The <dfn id="dom-context-2d-moveto" title="dom-context-2d-moveTo"><code>moveTo(<var title="">x</var>, <var title="">y</var>)</code></dfn> method must
  create a new subpath with the specified point as its first (and
  only) point.</p>

  <p>When the user agent is to <dfn id="ensure-there-is-a-subpath">ensure there is a subpath</dfn>
  for a coordinate (<var title="">x</var>, <var title="">y</var>), the
  user agent must check to see if the context has any subpaths, and if
  it does not, then the user agent must create a new subpath with the
  point (<var title="">x</var>, <var title="">y</var>) as its first
  (and only) point, as if the <code title="dom-context-2d-moveTo"><a href="#dom-context-2d-moveto">moveTo()</a></code> method had been
  called.</p>


  <p>The <dfn id="dom-context-2d-closepath" title="dom-context-2d-closePath"><code>closePath()</code></dfn>
  method must do nothing if the context has no subpaths. Otherwise, it
  must mark the last subpath as closed, create a new subpath whose
  first point is the same as the previous subpath's first point, and
  finally add this new subpath to the path.</p>

  <p class="note">If the last subpath had more than one point in its
  list of points, then this is equivalent to adding a straight line
  connecting the last point back to the first point, thus "closing"
  the shape, and then repeating the last (possibly implied) <code title="dom-context-2d-moveTo"><a href="#dom-context-2d-moveto">moveTo()</a></code> call.</p>


  <p>New points and the lines connecting them are added to subpaths
  using the methods described below. In all cases, the methods only
  modify the last subpath in the context's paths.</p>


  <p>The <dfn id="dom-context-2d-lineto" title="dom-context-2d-lineTo"><code>lineTo(<var title="">x</var>, <var title="">y</var>)</code></dfn> method must
  <a href="#ensure-there-is-a-subpath">ensure there is a subpath</a> for <span title="">(<var title="">x</var>, <var title="">y</var>)</span> if the context has
  no subpaths. Otherwise, it must connect the last point in the
  subpath to the given point (<var title="">x</var>, <var title="">y</var>) using a straight line, and must then add the given
  point (<var title="">x</var>, <var title="">y</var>) to the
  subpath.</p>


  <p>The <dfn id="dom-context-2d-quadraticcurveto" title="dom-context-2d-quadraticCurveTo"><code>quadraticCurveTo(<var title="">cpx</var>, <var title="">cpy</var>, <var title="">x</var>,
  <var title="">y</var>)</code></dfn> method must <a href="#ensure-there-is-a-subpath">ensure there
  is a subpath</a> for <span title="">(<var title="">cpx</var>,
  <var title="">cpy</var>)</span>, and then must connect the last
  point in the subpath to the given point (<var title="">x</var>, <var title="">y</var>) using a quadratic B&eacute;zier curve with control
  point (<var title="">cpx</var>, <var title="">cpy</var>), and must
  then add the given point (<var title="">x</var>, <var title="">y</var>) to the subpath. <a href="references.html#refsBEZIER">[BEZIER]</a></p>


  <p>The <dfn id="dom-context-2d-beziercurveto" title="dom-context-2d-bezierCurveTo"><code>bezierCurveTo(<var title="">cp1x</var>, <var title="">cp1y</var>, <var title="">cp2x</var>, <var title="">cp2y</var>, <var title="">x</var>, <var title="">y</var>)</code></dfn> method must
  <a href="#ensure-there-is-a-subpath">ensure there is a subpath</a> for <span title="">(<var title="">cp1x</var>, <var title="">cp1y</var>)</span>, and then must
  connect the last point in the subpath to the given point (<var title="">x</var>, <var title="">y</var>) using a cubic B&eacute;zier
  curve with control points (<var title="">cp1x</var>, <var title="">cp1y</var>) and (<var title="">cp2x</var>, <var title="">cp2y</var>). Then, it must add the point (<var title="">x</var>, <var title="">y</var>) to the subpath. <a href="references.html#refsBEZIER">[BEZIER]</a></p>

  <hr><p>The <dfn id="dom-context-2d-arcto" title="dom-context-2d-arcTo"><code>arcTo(<var title="">x1</var>, <var title="">y1</var>, <var title="">x2</var>,
  <var title="">y2</var>, <var title="">radius</var>)</code></dfn>
  method must first <a href="#ensure-there-is-a-subpath">ensure there is a subpath</a> for <span title="">(<var title="">x1</var>, <var title="">y1</var>)</span>. Then, the behavior depends on the
  arguments and the last point in the subpath, as described below.</p>

  <p>Negative values for <var title="">radius</var> must cause the
  implementation to raise an <code><a href="urls.html#index_size_err">INDEX_SIZE_ERR</a></code>
  exception.</p>

  <p>Let the point (<var title="">x0</var>, <var title="">y0</var>) be
  the last point in the subpath.</p>

  <p>If the point (<var title="">x0</var>, <var title="">y0</var>) is
  equal to the point (<var title="">x1</var>, <var title="">y1</var>),
  or if the point (<var title="">x1</var>, <var title="">y1</var>) is
  equal to the point (<var title="">x2</var>, <var title="">y2</var>),
  or if the radius <var title="">radius</var> is zero, then the method
  must add the point (<var title="">x1</var>, <var title="">y1</var>)
  to the subpath, and connect that point to the previous point (<var title="">x0</var>, <var title="">y0</var>) by a straight line.</p>

  <p>Otherwise, if the points (<var title="">x0</var>, <var title="">y0</var>), (<var title="">x1</var>, <var title="">y1</var>), and (<var title="">x2</var>, <var title="">y2</var>) all lie on a single straight line, then the
  method must add the point (<var title="">x1</var>, <var title="">y1</var>) to the subpath, and connect that point to the
  previous point (<var title="">x0</var>, <var title="">y0</var>) by a
  straight line.</p>

  <p>Otherwise, let <var title="">The Arc</var> be the shortest arc
  given by circumference of the circle that has radius <var title="">radius</var>, and that has one point tangent to the
  half-infinite line that crosses the point (<var title="">x0</var>,
  <var title="">y0</var>) and ends at the point (<var title="">x1</var>, <var title="">y1</var>), and that has a different
  point tangent to the half-infinite line that ends at the point (<var title="">x1</var>, <var title="">y1</var>) and crosses the point
  (<var title="">x2</var>, <var title="">y2</var>). The points at
  which this circle touches these two lines are called the start and
  end tangent points respectively. The method must connect the point
  (<var title="">x0</var>, <var title="">y0</var>) to the start
  tangent point by a straight line, adding the start tangent point to
  the subpath, and then must connect the start tangent point to the
  end tangent point by <var title="">The Arc</var>, adding the end
  tangent point to the subpath.</p>

  <hr><p>The <dfn id="dom-context-2d-arc" title="dom-context-2d-arc"><code>arc(<var title="">x</var>, <var title="">y</var>, <var title="">radius</var>,
  <var title="">startAngle</var>, <var title="">endAngle</var>, <var title="">anticlockwise</var>)</code></dfn> method draws an arc. If
  the context has any subpaths, then the method must add a straight
  line from the last point in the subpath to the start point of the
  arc. In any case, it must draw the arc between the start point of
  the arc and the end point of the arc, and add the start and end
  points of the arc to the subpath. The arc and its start and end
  points are defined as follows:</p>

  <p>Consider a circle that has its origin at (<var title="">x</var>,
  <var title="">y</var>) and that has radius <var title="">radius</var>. The points at <var title="">startAngle</var>
  and <var title="">endAngle</var> along this circle's circumference,
  measured in radians clockwise from the positive x-axis, are the
  start and end points respectively.</p>

  <p>If the <var title="">anticlockwise</var> argument is omitted or
  false and <span title=""><var title="">endAngle</var>-<var title="">startAngle</var></span> is equal to or greater than <span title="">2&pi;</span>, or, if the <var title="">anticlockwise</var>
  argument is <em>true</em> and <span title=""><var title="">startAngle</var>-<var title="">endAngle</var></span> is
  equal to or greater than <span title="">2&pi;</span>, then the arc
  is the whole circumference of this circle.</p>

  <p>Otherwise, the arc is the path along the circumference of this
  circle from the start point to the end point, going anti-clockwise
  if the <var title="">anticlockwise</var> argument is true, and
  clockwise otherwise. Since the points are on the circle, as opposed
  to being simply angles from zero, the arc can never cover an angle
  greater than <span title="">2&pi;</span> radians. If the two points are the
  same, or if the radius is zero, then the arc is defined as being of
  zero length in both directions.</p>

  <p>Negative values for <var title="">radius</var> must cause the
  implementation to raise an <code><a href="urls.html#index_size_err">INDEX_SIZE_ERR</a></code>
  exception.</p>

  <hr><p>The <dfn id="dom-context-2d-rect" title="dom-context-2d-rect"><code>rect(<var title="">x</var>, <var title="">y</var>, <var title="">w</var>, <var title="">h</var>)</code></dfn> method must create a new subpath
  containing just the four points (<var title="">x</var>, <var title="">y</var>), (<var title="">x</var>+<var title="">w</var>,
  <var title="">y</var>), (<var title="">x</var>+<var title="">w</var>, <var title="">y</var>+<var title="">h</var>),
  (<var title="">x</var>, <var title="">y</var>+<var title="">h</var>), with those four points connected by straight
  lines, and must then mark the subpath as closed. It must then create
  a new subpath with the point (<var title="">x</var>, <var title="">y</var>) as the only point in the subpath.</p>


  <!-- v5 feature request:
        * points as a primitive shape
          http://home.comcast.net/~urbanjost/canvas/vogle4.html
  -->


  <p>The <dfn id="dom-context-2d-fill" title="dom-context-2d-fill"><code>fill()</code></dfn>
  method must fill all the subpaths of the current path, using
  <code title="dom-context-2d-fillStyle"><a href="#dom-context-2d-fillstyle">fillStyle</a></code>, and using
  the non-zero winding number rule. Open subpaths must be implicitly
  closed when being filled (without affecting the actual
  subpaths).</p>

  <p class="note">Thus, if two overlapping but otherwise independent
  subpaths have opposite windings, they cancel out and result in no
  fill. If they have the same winding, that area just gets painted
  once.</p>

  <p>The <dfn id="dom-context-2d-stroke" title="dom-context-2d-stroke"><code>stroke()</code></dfn> method
  must calculate the strokes of all the subpaths of the current path,
  using the <code title="dom-context-2d-lineWidth"><a href="#dom-context-2d-linewidth">lineWidth</a></code>,
  <code title="dom-context-2d-lineCap"><a href="#dom-context-2d-linecap">lineCap</a></code>, <code title="dom-context-2d-lineJoin"><a href="#dom-context-2d-linejoin">lineJoin</a></code>, and (if
  appropriate) <code title="dom-context-2d-miterLimit"><a href="#dom-context-2d-miterlimit">miterLimit</a></code> attributes, and
  then fill the combined stroke area using the <code title="dom-context-2d-strokeStyle"><a href="#dom-context-2d-strokestyle">strokeStyle</a></code>
  attribute.</p>

  <p class="note">Since the subpaths are all stroked as one,
  overlapping parts of the paths in one stroke operation are treated
  as if their union was what was painted.</p>

  <p>Paths, when filled or stroked, must be painted without affecting
  the current path, and must be subject to <a href="#shadows" title="shadows">shadow effects</a>, <a href="#dom-context-2d-globalalpha" title="dom-context-2d-globalAlpha">global alpha</a>, the <a href="#clipping-region" title="clipping region">clipping region</a>, and <a href="#dom-context-2d-globalcompositeoperation" title="dom-context-2d-globalCompositeOperation">global composition
  operators</a>. (Transformations affect the path when the path is
  created, not when it is painted, though the stroke <em>style</em> is
  still affected by the transformation during painting.)</p>

  <p>Zero-length line segments must be pruned before stroking a
  path. Empty subpaths must be ignored.</p>


  <p>The <dfn id="dom-context-2d-clip" title="dom-context-2d-clip"><code>clip()</code></dfn>
  method must create a new <dfn id="clipping-region">clipping region</dfn> by calculating
  the intersection of the current clipping region and the area
  described by the current path, using the non-zero winding number
  rule. Open subpaths must be implicitly closed when computing the
  clipping region, without affecting the actual subpaths. The new
  clipping region replaces the current clipping region.</p>

  <p>When the context is initialized, the clipping region must be set
  to the rectangle with the top left corner at (0,0) and the width and
  height of the coordinate space.</p>

  <!-- v5
   Jordan OSETE suggests:
    * support ways of extending the clipping region (union instead of intersection)
       - also "add", "subtract", "replace", "intersect" and "xor"
    * support ways of resetting the clipping region without save/restore
  -->


  <p>The <dfn id="dom-context-2d-ispointinpath" title="dom-context-2d-isPointInPath"><code>isPointInPath(<var title="">x</var>, <var title="">y</var>)</code></dfn> method must
  return true if the point given by the <var title="">x</var> and <var title="">y</var> coordinates passed to the method, when treated as
  coordinates in the canvas coordinate space unaffected by the current
  transformation, is inside the current path as determined by the
  non-zero winding number rule; and must return false
  otherwise. Points on the path itself are considered to be inside the
  path. If either of the arguments is infinite or NaN, then the method
  must return false.</p>

  </div>


  <h6 id="focus-management-0"><span class="secno">4.8.11.1.9 </span>Focus management</h6> <!-- a v4 feature -->

  <p>When a canvas is interactive, authors should include focusable
  elements in the element's fallback content corresponding to each
  focusable part of the canvas.</p>

  <p>To indicate which focusable part of the canvas is currently
  focused, authors should use the <code title="dom-context-2d-drawFocusRing"><a href="#dom-context-2d-drawfocusring">drawFocusRing()</a></code> method,
  passing it the element for which a ring is being drawn. This method
  only draws the focus ring if the element is focused, so that it can
  simply be called whenever drawing the element, without checking
  whether the element is focused or not first. The position of the
  center of the control, or of the editing caret if the control has
  one, should be given in the <var title="">x</var> and <var title="">y</var> arguments.</p>

  <dl class="domintro"><dt><var title="">shouldDraw</var> = <var title="">context</var> . <code title="dom-context-2d-drawFocusRing"><a href="#dom-context-2d-drawfocusring">drawFocusRing</a></code>(<var title="">element</var>, <var title="">x</var>, <var title="">y</var>, [ <var title="">canDrawCustom</var> ])</dt>

   <dd>

    <p>If the given element is focused, draws a focus ring around the
    current path, following the platform conventions for focus
    rings. The given coordinate is used if the user's attention needs
    to be brought to a particular position (e.g. if a magnifier is
    following the editing caret in a text field).</p>

    <p>If the <var title="">canDrawCustom</var> argument is true, then
    the focus ring is only drawn if the user has configured his system
    to draw focus rings in a particular manner. (For example, high
    contrast focus rings.)</p>

    <p>Returns true if the given element is focused, the <var title="">canDrawCustom</var> argument is true, and the user has
    not configured his system to draw focus rings in a particular
    manner. Otherwise, returns false.</p>

    <p>When the method returns true, the author is expected to
    manually draw a focus ring.</p>

   </dd>

  </dl><div class="impl">

  <p>The <dfn id="dom-context-2d-drawfocusring" title="dom-context-2d-drawFocusRing"><code>drawFocusRing(<var title="">element</var>, <var title="">x</var>, <var title="">y</var>, [<var title="">canDrawCustom</var>])</code></dfn>
  method, when invoked, must run the following steps:</p>

  <ol><li><p>If <var title="">element</var> is not focused or is not a
   descendant of the element with whose context the method is
   associated, then return false and abort these steps.</li>

   <li><p>Transform the given point (<var title="">x</var>, <var title="">y</var>) according to the <a href="#transformations" title="dom-context-2d-transformation">current transformation
   matrix</a>.</li>

   <li><p>Optionally, inform the user that the focus is at the given
   (transformed) coordinate on the canvas. (For example, this could
   involve moving the user's magnification tool.)</li>

   <li>

    <p>If the user has requested the use of particular focus rings
    (e.g. high-contrast focus rings), or if the <var title="">canDrawCustom</var> argument is absent or false, then
    draw a focus ring of the appropriate style along the path,
    following platform conventions, return false, and abort these
    steps.</p>

    <p>The focus ring should not be subject to the <a href="#shadows" title="shadows">shadow effects</a>, the <a href="#dom-context-2d-globalalpha" title="dom-context-2d-globalAlpha">global alpha</a>, or the <a href="#dom-context-2d-globalcompositeoperation" title="dom-context-2d-globalCompositeOperation">global composition
    operators</a>, but <em>should</em> be subject to the <a href="#clipping-region" title="clipping region">clipping region</a>.</p>

   </li>

   <li><p>Return true.</li>

  </ol></div>

  <div class="example">

   <p>This <code><a href="#the-canvas-element">canvas</a></code> element has a couple of checkboxes:</p>

   <pre>&lt;canvas height=400 width=750&gt;
 &lt;label&gt;&lt;input type=checkbox id=showA&gt; Show As&lt;/label&gt;
 &lt;label&gt;&lt;input type=checkbox id=showB&gt; Show Bs&lt;/label&gt;
 &lt;!-- ... --&gt;
&lt;/canvas&gt;
&lt;script&gt;
 function drawCheckbox(context, element, x, y) {
   context.save();
   context.font = '10px sans-serif';
   context.textAlign = 'left';
   context.textBaseline = 'middle';
   var metrics = context.measureText(element.labels[0].textContent);
   context.beginPath();
   context.strokeStyle = 'black';
   context.rect(x-5, y-5, 10, 10);
   context.stroke();
   if (element.checked) {
     context.fillStyle = 'black';
     context.fill();
   }
   context.fillText(element.labels[0].textContent, x+5, y);
   context.beginPath();
   context.rect(x-7, y-7, 12 + metrics.width+2, 14);
   if (context.drawFocusRing(element, x, y, true)) {
     context.strokeStyle = 'silver';
     context.stroke();
   }
   context.restore();
 }
 function drawBase() { /* ... */ }
 function drawAs() { /* ... */ }
 function drawBs() { /* ... */ }
 function redraw() {
   var canvas = document.getElementsByTagName('canvas')[0];
   var context = canvas.getContext('2d');
   context.clearRect(0, 0, canvas.width, canvas.height);
   drawCheckbox(context, document.getElementById('showA'), 20, 40);
   drawCheckbox(context, document.getElementById('showB'), 20, 60);
   drawBase();
   if (document.getElementById('showA').checked)
     drawAs();
   if (document.getElementById('showB').checked)
     drawBs();
 }
 function processClick(event) {
   var canvas = document.getElementsByTagName('canvas')[0];
   var context = canvas.getContext('2d');
   var x = event.clientX - canvas.offsetLeft;
   var y = event.clientY - canvas.offsetTop;
   drawCheckbox(context, document.getElementById('showA'), 20, 40);
   if (context.isPointInPath(x, y))
     document.getElementById('showA').checked = !(document.getElementById('showA').checked);
   drawCheckbox(context, document.getElementById('showB'), 20, 60);
   if (context.isPointInPath(x, y))
     document.getElementById('showB').checked = !(document.getElementById('showB').checked);
   redraw();
 }
 document.getElementsByTagName('canvas')[0].addEventListener('focus', redraw, true);
 document.getElementsByTagName('canvas')[0].addEventListener('blur', redraw, true);
 document.getElementsByTagName('canvas')[0].addEventListener('change', redraw, true);
 document.getElementsByTagName('canvas')[0].addEventListener('click', processClick, false);
 redraw();
&lt;/script&gt;</pre>
<!-- http://software.hixie.ch/utilities/js/live-dom-viewer/saved/340 -->

  </div>


  <h6 id="text-0"><span class="secno">4.8.11.1.10 </span>Text</h6> <!-- a v3 feature -->

  <dl class="domintro"><dt><var title="">context</var> . <code title="dom-context-2d-font"><a href="#dom-context-2d-font">font</a></code> [ = <var title="">value</var> ]</dt>

   <dd>

    <p>Returns the current font settings.</p>

    <p>Can be set, to change the font. The syntax is the same as for
    the CSS 'font' property; values that cannot be parsed as CSS font
    values are ignored.</p>

    <p>Relative keywords and lengths are computed relative to the font
    of the <code><a href="#the-canvas-element">canvas</a></code> element.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-textAlign"><a href="#dom-context-2d-textalign">textAlign</a></code> [ = <var title="">value</var> ]</dt>

   <dd>

    <p>Returns the current text alignment settings.</p>

    <p>Can be set, to change the alignment. The possible values are
    <code title="">start</code>, <code title="">end</code>, <code title="">left</code>, <code title="">right</code>, and <code title="">center</code>. Other values are ignored. The default is
    <code title="">start</code>.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-textBaseline"><a href="#dom-context-2d-textbaseline">textBaseline</a></code> [ = <var title="">value</var> ]</dt>

   <dd>

    <p>Returns the current baseline alignment settings.</p>

    <p>Can be set, to change the baseline alignment. The possible
    values and their meanings are given below. Other values are
    ignored. The default is <code title="">alphabetic</code>.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-fillText"><a href="#dom-context-2d-filltext">fillText</a></code>(<var title="">text</var>, <var title="">x</var>, <var title="">y</var> [, <var title="">maxWidth</var> ] )</dt>
   <dt><var title="">context</var> . <code title="dom-context-2d-strokeText"><a href="#dom-context-2d-stroketext">strokeText</a></code>(<var title="">text</var>, <var title="">x</var>, <var title="">y</var> [, <var title="">maxWidth</var> ] )</dt>

   <dd>

    <p>Fills or strokes (respectively) the given text at the given
    position. If a maximum width is provided, the text will be scaled
    to fit that width if necessary.</p>

   </dd>

   <dt><var title="">metrics</var> = <var title="">context</var> . <code title="dom-context-2d-measureText"><a href="#dom-context-2d-measuretext">measureText</a></code>(<var title="">text</var>)</dt>

   <dd>

    <p>Returns a <code><a href="#textmetrics">TextMetrics</a></code> object with the metrics of the given text in the current font.</p>

   </dd>

   <dt><var title="">metrics</var> . <code title="dom-textmetrics-width"><a href="#dom-textmetrics-width">width</a></code></dt>

   <dd>

    <p>Returns the advance width of the text that was passed to the
    <code title="dom-context-2d-measureText"><a href="#dom-context-2d-measuretext">measureText()</a></code>
    method.</p>

   </dd>

  </dl><div class="impl">

  <p>The <dfn id="dom-context-2d-font" title="dom-context-2d-font"><code>font</code></dfn> IDL
  attribute, on setting, must be parsed the same way as the 'font'
  property of CSS (but without supporting property-independent style
  sheet syntax like 'inherit'), and the resulting font must be
  assigned to the context, with the 'line-height' component forced to
  'normal', with the 'font-size' component converted to CSS pixels,
  and with system fonts being computed to explicit values. If the new
  value is syntactically incorrect (including using
  property-independent style sheet syntax like 'inherit' or
  'initial'), then it must be ignored, without assigning a new font
  value. <a href="references.html#refsCSS">[CSS]</a></p>

  <p>Font names must be interpreted in the context of the
  <code><a href="#the-canvas-element">canvas</a></code> element's stylesheets; any fonts embedded using
  <code title="">@font-face</code> must therefore be available once
  they are loaded. (If a font is referenced before it is fully loaded,
  then it must be treated as if it was an unknown font, falling back
  to another as described by the relevant CSS specifications.) <a href="references.html#refsCSSFONTS">[CSSFONTS]</a></p>

  <p>Only vector fonts should be used by the user agent; if a user
  agent were to use bitmap fonts then transformations would likely
  make the font look very ugly.</p>

  <p>On getting, the <code title="dom-context-2d-font"><a href="#dom-context-2d-font">font</a></code>
  attribute must return the <span title="serializing a CSS
  value">serialized form</span> of the current font of the context
  (with no 'line-height' component). <a href="references.html#refsCSSOM">[CSSOM]</a></p>

  <div class="example">

   <p>For example, after the following statement:</p>

   <pre>context.font = 'italic 400 12px/2 Unknown Font, sans-serif';</pre>

   <p>...the expression <code title="">context.font</code> would
   evaluate to the string "<code title="">italic&nbsp;12px&nbsp;"Unknown&nbsp;Font",&nbsp;sans-serif</code>". The
   "400" font-weight doesn't appear because that is the default
   value. The line-height doesn't appear because it is forced to
   "normal", the default value.</p>

  </div>

  <p>When the context is created, the font of the context must be set
  to 10px sans-serif. When the 'font-size' component is set to lengths
  using percentages, 'em' or 'ex' units, or the 'larger' or 'smaller'
  keywords, these must be interpreted relative to the computed value
  of the 'font-size' property of the corresponding <code><a href="#the-canvas-element">canvas</a></code>
  element at the time that the attribute is set. When the
  'font-weight' component is set to the relative values 'bolder' and
  'lighter', these must be interpreted relative to the computed value
  of the 'font-weight' property of the corresponding
  <code><a href="#the-canvas-element">canvas</a></code> element at the time that the attribute is
  set. If the computed values are undefined for a particular case
  (e.g. because the <code><a href="#the-canvas-element">canvas</a></code> element is not <a href="infrastructure.html#in-a-document">in a
  <code>Document</code></a>), then the relative keywords must be
  interpreted relative to the normal-weight 10px sans-serif
  default.</p>

  <p>The <dfn id="dom-context-2d-textalign" title="dom-context-2d-textAlign"><code>textAlign</code></dfn> IDL
  attribute, on getting, must return the current value. On setting, if
  the value is one of <code title="">start</code>, <code title="">end</code>, <code title="">left</code>, <code title="">right</code>, or <code title="">center</code>, then the
  value must be changed to the new value. Otherwise, the new value
  must be ignored. When the context is created, the <code title="dom-context-2d-textAlign"><a href="#dom-context-2d-textalign">textAlign</a></code> attribute must
  initially have the value <code title="">start</code>.</p>

  <p>The <dfn id="dom-context-2d-textbaseline" title="dom-context-2d-textBaseline"><code>textBaseline</code></dfn>
  IDL attribute, on getting, must return the current value. On
  setting, if the value is one of <code title="dom-context-2d-textBaseline-top"><a href="#dom-context-2d-textbaseline-top">top</a></code>, <code title="dom-context-2d-textBaseline-hanging"><a href="#dom-context-2d-textbaseline-hanging">hanging</a></code>, <code title="dom-context-2d-textBaseline-middle"><a href="#dom-context-2d-textbaseline-middle">middle</a></code>, <code title="dom-context-2d-textBaseline-alphabetic"><a href="#dom-context-2d-textbaseline-alphabetic">alphabetic</a></code>,
  <code title="dom-context-2d-textBaseline-ideographic"><a href="#dom-context-2d-textbaseline-ideographic">ideographic</a></code>,
  or <code title="dom-context-2d-textBaseline-bottom"><a href="#dom-context-2d-textbaseline-bottom">bottom</a></code>,
  then the value must be changed to the new value. Otherwise, the new
  value must be ignored. When the context is created, the <code title="dom-context-2d-textBaseline"><a href="#dom-context-2d-textbaseline">textBaseline</a></code> attribute
  must initially have the value <code title="">alphabetic</code>.</p>

  </div>

  <p>The <code title="dom-context-2d-textBaseline"><a href="#dom-context-2d-textbaseline">textBaseline</a></code>
  attribute's allowed keywords correspond to alignment points in the
  font:</p>

  <p><img alt="The top of the em square is roughly at the top of the glyphs in a font, the hanging baseline is where some glyphs like &#2310; are anchored, the middle is half-way between the top of the em square and the bottom of the em square, the alphabetic baseline is where characters like &Aacute;, &yuml;, f, and &Omega; are anchored, the ideographic baseline is where glyphs like &#31169; and &#36948; are anchored, and the bottom of the em square is roughly at the bottom of the glyphs in a font. The top and bottom of the bounding box can be far from these baselines, due to glyphs extending far outside the em square." height="300" src="http://images.whatwg.org/baselines.png" width="738"></p>

  <p>The keywords map to these alignment points as follows:</p>

  <dl><dt><dfn id="dom-context-2d-textbaseline-top" title="dom-context-2d-textBaseline-top"><code>top</code></dfn>
   <dd>The top of the em square</dd>

   <dt><dfn id="dom-context-2d-textbaseline-hanging" title="dom-context-2d-textBaseline-hanging"><code>hanging</code></dfn>
   <dd>The hanging baseline</dd>

   <dt><dfn id="dom-context-2d-textbaseline-middle" title="dom-context-2d-textBaseline-middle"><code>middle</code></dfn>
   <dd>The middle of the em square</dd>

   <dt><dfn id="dom-context-2d-textbaseline-alphabetic" title="dom-context-2d-textBaseline-alphabetic"><code>alphabetic</code></dfn>
   <dd>The alphabetic baseline</dd>

   <dt><dfn id="dom-context-2d-textbaseline-ideographic" title="dom-context-2d-textBaseline-ideographic"><code>ideographic</code></dfn>
   <dd>The ideographic baseline</dd>

   <dt><dfn id="dom-context-2d-textbaseline-bottom" title="dom-context-2d-textBaseline-bottom"><code>bottom</code></dfn>
   <dd>The bottom of the em square</dd>

  </dl><div class="impl">

  <p>The <dfn id="dom-context-2d-filltext" title="dom-context-2d-fillText"><code>fillText()</code></dfn> and
  <dfn id="dom-context-2d-stroketext" title="dom-context-2d-strokeText"><code>strokeText()</code></dfn>
  methods take three or four arguments, <var title="">text</var>, <var title="">x</var>, <var title="">y</var>, and optionally <var title="">maxWidth</var>, and render the given <var title="">text</var> at the given (<var title="">x</var>, <var title="">y</var>) coordinates ensuring that the text isn't wider
  than <var title="">maxWidth</var> if specified, using the current
  <code title="dom-context-2d-font"><a href="#dom-context-2d-font">font</a></code>, <code title="dom-context-2d-textAlign"><a href="#dom-context-2d-textalign">textAlign</a></code>, and <code title="dom-context-2d-textBaseline"><a href="#dom-context-2d-textbaseline">textBaseline</a></code>
  values. Specifically, when the methods are called, the user agent
  must run the following steps:</p>

  <ol><li><p>If <var title="">maxWidth</var> is present but less than or
   equal to zero, return without doing anything; abort these
   steps.</li>

   <li><p>Let <var title="">font</var> be the current font of the
   context, as given by the <code title="dom-context-2d-font"><a href="#dom-context-2d-font">font</a></code> attribute.</li>

   <li><p>Replace all the <a href="common-microsyntaxes.html#space-character" title="space character">space
   characters</a> in <var title="">text</var> with U+0020 SPACE
   characters.</li>

   <li><p>Form a hypothetical infinitely wide CSS line box containing
   a single inline box containing the text <var title="">text</var>,
   with all the properties at their initial values except the 'font'
   property of the inline box set to <var title="">font</var> and the
   'direction' property of the inline box set to <a href="elements.html#the-directionality">the
   directionality</a> of the <code><a href="#the-canvas-element">canvas</a></code> element. <a href="references.html#refsCSS">[CSS]</a></li>

   <!-- if you insert a step here, make sure to adjust the next step's
   final words -->

   <li><p>If the <var title="">maxWidth</var> argument was specified
   and the hypothetical width of the inline box in the hypothetical
   line box is greater than <var title="">maxWidth</var> CSS pixels,
   then change <var title="">font</var> to have a more condensed font
   (if one is available or if a reasonably readable one can be
   synthesized by applying a horizontal scale factor to the font) or a
   smaller font, and return to the previous step.</li>

   <li>

    <p>Let the <var title="">anchor point</var> be a point on the
    inline box, determined by the <code title="dom-context-2d-textAlign"><a href="#dom-context-2d-textalign">textAlign</a></code> and <code title="dom-context-2d-textBaseline"><a href="#dom-context-2d-textbaseline">textBaseline</a></code> values, as
    follows:</p>

    <p>Horizontal position:</p>

    <dl><dt> If <code title="dom-context-2d-textAlign"><a href="#dom-context-2d-textalign">textAlign</a></code> is <code title="">left</code></dt>
     <dt> If <code title="dom-context-2d-textAlign"><a href="#dom-context-2d-textalign">textAlign</a></code> is <code title="">start</code> and <a href="elements.html#the-directionality">the directionality</a> of the
     <code><a href="#the-canvas-element">canvas</a></code> element is 'ltr'</dt>
     <dt> If <code title="dom-context-2d-textAlign"><a href="#dom-context-2d-textalign">textAlign</a></code> is <code title="">end</code> and <a href="elements.html#the-directionality">the directionality</a> of the
     <code><a href="#the-canvas-element">canvas</a></code> element is 'rtl'</dt>

     <dd>Let the <var title="">anchor point</var>'s horizontal
     position be the left edge of the inline box.</dd>


     <dt> If <code title="dom-context-2d-textAlign"><a href="#dom-context-2d-textalign">textAlign</a></code> is <code title="">right</code></dt>
     <dt> If <code title="dom-context-2d-textAlign"><a href="#dom-context-2d-textalign">textAlign</a></code> is <code title="">end</code> and  <a href="elements.html#the-directionality">the directionality</a> of the
     <code><a href="#the-canvas-element">canvas</a></code> element is 'ltr'</dt>
     <dt> If <code title="dom-context-2d-textAlign"><a href="#dom-context-2d-textalign">textAlign</a></code> is <code title="">start</code> and <a href="elements.html#the-directionality">the directionality</a> of the
     <code><a href="#the-canvas-element">canvas</a></code> element is 'rtl'</dt>

     <dd>Let the <var title="">anchor point</var>'s horizontal
     position be the right edge of the inline box.</dd>


     <dt> If <code title="dom-context-2d-textAlign"><a href="#dom-context-2d-textalign">textAlign</a></code> is <code title="">center</code></dt>

     <dd>Let the <var title="">anchor point</var>'s horizontal
     position be half way between the left and right edges of the
     inline box.</dd>

    </dl><p>Vertical position:</p>

    <dl><dt> If <code title="dom-context-2d-textBaseline"><a href="#dom-context-2d-textbaseline">textBaseline</a></code> is <code title="dom-context-2d-textBaseline-top"><a href="#dom-context-2d-textbaseline-top">top</a></code></dt>

     <dd>Let the <var title="">anchor point</var>'s vertical position
     be the top of the em box of the first available font of the
     inline box.</dd>


     <dt> If <code title="dom-context-2d-textBaseline"><a href="#dom-context-2d-textbaseline">textBaseline</a></code> is <code title="dom-context-2d-textBaseline-hanging"><a href="#dom-context-2d-textbaseline-hanging">hanging</a></code></dt>

     <dd>Let the <var title="">anchor point</var>'s vertical position
     be the hanging baseline of the first available font of the inline
     box.</dd>


     <dt> If <code title="dom-context-2d-textBaseline"><a href="#dom-context-2d-textbaseline">textBaseline</a></code> is <code title="dom-context-2d-textBaseline-middle"><a href="#dom-context-2d-textbaseline-middle">middle</a></code></dt>

     <dd>Let the <var title="">anchor point</var>'s vertical position
     be half way between the bottom and the top of the em box of the
     first available font of the inline box.</dd>


     <dt> If <code title="dom-context-2d-textBaseline"><a href="#dom-context-2d-textbaseline">textBaseline</a></code> is <code title="dom-context-2d-textBaseline-alphabetic"><a href="#dom-context-2d-textbaseline-alphabetic">alphabetic</a></code></dt>

     <dd>Let the <var title="">anchor point</var>'s vertical position
     be the alphabetic baseline of the first available font of the inline
     box.</dd>


     <dt> If <code title="dom-context-2d-textBaseline"><a href="#dom-context-2d-textbaseline">textBaseline</a></code> is <code title="dom-context-2d-textBaseline-ideographic"><a href="#dom-context-2d-textbaseline-ideographic">ideographic</a></code></dt>

     <dd>Let the <var title="">anchor point</var>'s vertical position
     be the ideographic baseline of the first available font of the inline
     box.</dd>


     <dt> If <code title="dom-context-2d-textBaseline"><a href="#dom-context-2d-textbaseline">textBaseline</a></code> is <code title="dom-context-2d-textBaseline-bottom"><a href="#dom-context-2d-textbaseline-bottom">bottom</a></code></dt>

     <dd>Let the <var title="">anchor point</var>'s vertical position
     be the bottom of the em box of the first available font of the
     inline box.</dd>

    </dl></li>

   <li>

    <p>Paint the hypothetical inline box as the shape given by the
    text's glyphs, as transformed by the <a href="#transformations" title="dom-context-2d-transformation">current transformation
    matrix</a>, and anchored and sized so that before applying the
    <a href="#transformations" title="dom-context-2d-transformation">current transformation
    matrix</a>, the <var title="">anchor point</var> is at (<var title="">x</var>, <var title="">y</var>) and each CSS pixel is
    mapped to one coordinate space unit.</p>

    <p>For <code title="dom-context-2d-fillText"><a href="#dom-context-2d-filltext">fillText()</a></code>
    <code title="dom-context-2d-fillStyle"><a href="#dom-context-2d-fillstyle">fillStyle</a></code> must be
    applied to the glyphs and <code title="dom-context-2d-strokeStyle"><a href="#dom-context-2d-strokestyle">strokeStyle</a></code> must be
    ignored. For <code title="dom-context-2d-strokeText"><a href="#dom-context-2d-stroketext">strokeText()</a></code> the reverse
    holds and <code title="dom-context-2d-strokeStyle"><a href="#dom-context-2d-strokestyle">strokeStyle</a></code> must be
    applied to the glyph outlines and <code title="dom-context-2d-fillStyle"><a href="#dom-context-2d-fillstyle">fillStyle</a></code> must be
    ignored.</p>

    <p>Text is painted without affecting the current path, and is
    subject to <a href="#shadows" title="shadows">shadow effects</a>, <a href="#dom-context-2d-globalalpha" title="dom-context-2d-globalAlpha">global alpha</a>, the <a href="#clipping-region" title="clipping region">clipping region</a>, and <a href="#dom-context-2d-globalcompositeoperation" title="dom-context-2d-globalCompositeOperation">global composition
    operators</a>.</p>

   </li>

  </ol><!--v5DVT - this is commented out until CSS can get its act together
enough to actual specify vertical text rendering (how long have we
been waiting now?)

WHEN EDITING THIS, FIX THE PARTS MARKED "&#x0058;&#x0058;&#x0058;" BELOW

  <p>The <dfn
  title="dom-context-2d-fillVerticalText"><code>fillVerticalText()</code></dfn>
  and <dfn
  title="dom-context-2d-strokeVerticalText"><code>strokeVerticalText()</code></dfn>
  methods take three or four arguments, <var title="">text</var>, <var
  title="">x</var>, <var title="">y</var>, and optionally <var
  title="">maxHeight</var>, and render the given <var
  title="">text</var> as vertical text at the given (<var
  title="">x</var>, <var title="">y</var>) coordinates ensuring that
  the text isn't taller than <var title="">maxHeight</var> if
  specified, using the current <code
  title="dom-context-2d-font">font</code> and <code
  title="dom-context-2d-textAlign">textAlign</code>
  values. Specifically, when the methods are called, the user agent
  must run the following steps:</p>

  <ol>

   <li><p>If <var title="">maxHeight</var> is present but less than or
   equal to zero, return without doing anything; abort these
   steps.</p></li>

   <li><p>Let <var title="">font</var> be the current font of the
   context, as given by the <code
   title="dom-context-2d-font">font</code> attribute.</p></li>

   <li><p>Replace all the <span title="space character">space
   characters</span> in <var title="">text</var> with U+0020 SPACE
   characters.</p></li>

   <li><p>Form a <em class="&#x0058;&#x0058;&#x0058;">whatever CSS ends up calling
   vertical line boxes and inline boxes</em> containing the text <var
   title="">text</var>, with all the properties at their initial
   values except the 'font' property of the inline box set to <var
   title="">font</var> and the 'direction' property of the inline
   box set to <span>the directionality</span> of the <code>canvas</code>
   element.</p></li>

   <!- - if you insert a step here, make sure to adjust the next step's
   final words - ->

   <li><p>If the <var title="">maxHeight</var> argument was specified
   and the hypothetical height of the <em class="&#x0058;&#x0058;&#x0058;">box</em>
   in the hypothetical line box is greater than <var
   title="">maxHeight</var> CSS pixels, then change <var
   title="">font</var> to have a more condensed font (if one is
   available or if a reasonably readable one can be synthesized by
   applying an appropriate scale factor to the font) or a smaller
   font, and return to the previous step.</p></li>

   <li>

    <p>Let the <var title="">anchor point</var> be a point on the <em
    class="&#x0058;&#x0058;&#x0058;">inline box</var>, determined by the <code
    title="dom-context-2d-textAlign">textAlign</code>, as follows:</p>

    <p>Vertical position:</p>

    <dl>

     <dt> If <code
     title="dom-context-2d-textAlign">textAlign</code> is <code
     title="">start</code></dt>
     <dt> If <code
     title="dom-context-2d-textAlign">textAlign</code> is <code
     title="">left</code> and <span>the directionality</span> of the
     <code>canvas</code> element is 'ltr'</dt>
     <dt> If <code
     title="dom-context-2d-textAlign">textAlign</code> is <code
     title="">right</code> and <span>the directionality</span> of the
     <code>canvas</code> element is 'rtl'</dt>

     <dd>Let the <var title="">anchor point</var>'s vertical
     position be the top edge of the <em class="&#x0058;&#x0058;&#x0058;">inline
     box</em>.</dd>

     <dt> If <code
     title="dom-context-2d-textAlign">textAlign</code> is <code
     title="">end</code></dt>
     <dt> If <code
     title="dom-context-2d-textAlign">textAlign</code> is <code
     title="">right</code> and <span>the directionality</span> of the
     <code>canvas</code> element is 'ltr'</dt>
     <dt> If <code
     title="dom-context-2d-textAlign">textAlign</code> is <code
     title="">left</code> and <span>the directionality</span> of the
     <code>canvas</code> element is 'rtl'</dt>

     <dd>Let the <var title="">anchor point</var>'s vertical
     position be the bottom edge of the <em class="&#x0058;&#x0058;&#x0058;">inline
     box</em>.</dd>


     <dt> If <code
     title="dom-context-2d-textAlign">textAlign</code> is <code
     title="">center</code></dt>

     <dd>Let the <var title="">anchor point</var>'s vertical position
     be half way between the top and bottom edges of the <em
     class="&#x0058;&#x0058;&#x0058;">inline box</em>.</dd>

    </dl>

    <p>Let the horizontal position be half way between the left and
    right edges of the em box of the first available font of the <em
    class="&#x0058;&#x0058;&#x0058;">inline box</em>.</p>

   </li>

   <li>

    <p>Paint the hypothetical inline box as the shape given by the
    text's glyphs, as transformed by the <span
    title="dom-context-2d-transformation">current transformation
    matrix</span>, and anchored and sized so that before applying the
    <span title="dom-context-2d-transformation">current transformation
    matrix</span>, the <var title="">anchor point</var> is at (<var
    title="">x</var>, <var title="">y</var>) and each CSS pixel is
    mapped to one coordinate space unit.</p>

    <p>For <code
    title="dom-context-2d-fillVerticalText">fillVerticalText()</code>
    <code title="dom-context-2d-fillStyle">fillStyle</code> must be
    applied and <code
    title="dom-context-2d-strokeStyle">strokeStyle</code> must be
    ignored. For <code
    title="dom-context-2d-strokeVerticalText">strokeVerticalText()</code>
    the reverse holds and <code
    title="dom-context-2d-strokeStyle">strokeStyle</code> must be
    applied and <code
    title="dom-context-2d-fillStyle">fillStyle</code> must be
    ignored.</p>

    <p>Text is painted without affecting the current path, and is
    subject to <span title="shadows">shadow effects</span>, <span
    title="dom-context-2d-globalAlpha">global alpha</span>, the <span
    title="clipping region">clipping region</span>, and <span
    title="dom-context-2d-globalCompositeOperation">global composition
    operators</span>.</p>

   </li>

  </ol>

v5DVT (also check for '- -' bits in the part above) --><p>The <dfn id="dom-context-2d-measuretext" title="dom-context-2d-measureText"><code>measureText()</code></dfn>
  method takes one argument, <var title="">text</var>. When the method
  is invoked, the user agent must replace all the <a href="common-microsyntaxes.html#space-character" title="space
  character">space characters</a> in <var title="">text</var> with
  U+0020 SPACE characters, and then must form a hypothetical
  infinitely wide CSS line box containing a single inline box
  containing the text <var title="">text</var>, with all the
  properties at their initial values except the 'font' property of the
  inline element set to the current font of the context, as given by
  the <code title="dom-context-2d-font"><a href="#dom-context-2d-font">font</a></code> attribute, and
  must then return a new <code><a href="#textmetrics">TextMetrics</a></code> object with its
  <code title="dom-textmetrics-width"><a href="#dom-textmetrics-width">width</a></code> attribute set to
  the width of that inline box, in CSS pixels. <a href="references.html#refsCSS">[CSS]</a></p>

  <p>The <code><a href="#textmetrics">TextMetrics</a></code> interface is used for the objects
  returned from <code title="dom-context-2d-measureText"><a href="#dom-context-2d-measuretext">measureText()</a></code>. It has one
  attribute, <dfn id="dom-textmetrics-width" title="dom-textmetrics-width"><code>width</code></dfn>, which is set
  by the <code title="dom-context-2d-measureText"><a href="#dom-context-2d-measuretext">measureText()</a></code>
  method.</p>

  <p class="note">Glyphs rendered using <code title="dom-context-2d-fillText"><a href="#dom-context-2d-filltext">fillText()</a></code> and <code title="dom-context-2d-strokeText"><a href="#dom-context-2d-stroketext">strokeText()</a></code> can spill out
  of the box given by the font size (the em square size) and the width
  returned by <code title="dom-context-2d-measureText"><a href="#dom-context-2d-measuretext">measureText()</a></code> (the text
  width). This version of the specification does not provide a way to
  obtain the bounding box dimensions of the text. If the text is to be
  rendered and removed, care needs to be taken to replace the entire
  area of the canvas that the clipping region covers, not just the box
  given by the em square height and measured text width.</p>

  <!-- v5: Drawing text along a given path -->
  <!-- v5: Adding text to a path -->
  <!-- see also: http://www.w3.org/TR/SVG11/text.html#TextpathLayoutRules -->
  <!-- see also: http://developer.mozilla.org/en/docs/Drawing_text_using_a_canvas -->

  </div>

  <p class="note">A future version of the 2D context API may provide a
  way to render fragments of documents, rendered using CSS, straight
  to the canvas. This would be provided in preference to a dedicated
  way of doing multiline layout.</p>



  <h6 id="images"><span class="secno">4.8.11.1.11 </span>Images</h6>

  <p>To draw images onto the canvas, the <dfn id="dom-context-2d-drawimage" title="dom-context-2d-drawImage"><code>drawImage</code></dfn> method
  can be used.</p>

  <p>This method can be invoked with three different sets of arguments:</p>

  <ul class="brief"><li><code title="">drawImage(<var title="">image</var>, <var title="">dx</var>, <var title="">dy</var>)</code>
   <li><code title="">drawImage(<var title="">image</var>, <var title="">dx</var>, <var title="">dy</var>, <var title="">dw</var>, <var title="">dh</var>)</code>
   <li><code title="">drawImage(<var title="">image</var>, <var title="">sx</var>, <var title="">sy</var>, <var title="">sw</var>, <var title="">sh</var>, <var title="">dx</var>, <var title="">dy</var>, <var title="">dw</var>, <var title="">dh</var>)</code>
  </ul><!-- v3: drawImage() of an ImageData object might make sense (when resizing as well as filtering) - ack Charles Pritchard --><p>Each of those three can take either an
  <code><a href="embedded-content-1.html#htmlimageelement">HTMLImageElement</a></code>, an <code><a href="#htmlcanvaselement">HTMLCanvasElement</a></code>, or
  an <code><a href="video.html#htmlvideoelement">HTMLVideoElement</a></code> for the <var title="">image</var>
  argument.</p>

  <dl class="domintro"><dt><var title="">context</var> . <code title="dom-context-2d-drawImage"><a href="#dom-context-2d-drawimage">drawImage</a></code>(<var title="">image</var>, <var title="">dx</var>, <var title="">dy</var>)</dt>
   <dt><var title="">context</var> . <code title="dom-context-2d-drawImage"><a href="#dom-context-2d-drawimage">drawImage</a></code>(<var title="">image</var>, <var title="">dx</var>, <var title="">dy</var>, <var title="">dw</var>, <var title="">dh</var>)</dt>
   <dt><var title="">context</var> . <code title="dom-context-2d-drawImage"><a href="#dom-context-2d-drawimage">drawImage</a></code>(<var title="">image</var>, <var title="">sx</var>, <var title="">sy</var>, <var title="">sw</var>, <var title="">sh</var>, <var title="">dx</var>, <var title="">dy</var>, <var title="">dw</var>, <var title="">dh</var>)</dt>

   <dd>

    <p>Draws the given image onto the canvas. The arguments are
    interpreted as follows:</p>

    <p><img alt="The sx and sy parameters give the x and y coordinates of the source rectangle; the sw and sh arguments give the width and height of the source rectangle; the dx and dy give the x and y coordinates of the destination rectangle; and the dw and dh arguments give the width and height of the destination rectangle." height="356" src="http://images.whatwg.org/drawImage.png" width="356"></p>

    <p>If the first argument isn't an <code><a href="embedded-content-1.html#the-img-element">img</a></code>,
    <code><a href="#the-canvas-element">canvas</a></code>, or <code><a href="video.html#video">video</a></code> element, throws a
    <code><a href="urls.html#type_mismatch_err">TYPE_MISMATCH_ERR</a></code> exception. If the image has no
    image data, throws an <code><a href="urls.html#invalid_state_err">INVALID_STATE_ERR</a></code> exception. If
    the numeric arguments don't make sense (e.g. the destination is a
    0&times;0 rectangle), throws an <code><a href="urls.html#index_size_err">INDEX_SIZE_ERR</a></code>
    exception. If the image isn't yet fully decoded, then nothing is
    drawn.</p>

   </dd>

  </dl><div class="impl">

  <p>If not specified, the <var title="">dw</var> and <var title="">dh</var> arguments must default to the values of <var title="">sw</var> and <var title="">sh</var>, interpreted such that
  one CSS pixel in the image is treated as one unit in the canvas
  coordinate space. If the <var title="">sx</var>, <var title="">sy</var>, <var title="">sw</var>, and <var title="">sh</var> arguments are omitted, they must default to 0, 0,
  the image's intrinsic width in image pixels, and the image's
  intrinsic height in image pixels, respectively.</p>

  <p>The <var title="">image</var> argument is an instance of either
  <code><a href="embedded-content-1.html#htmlimageelement">HTMLImageElement</a></code>, <code><a href="#htmlcanvaselement">HTMLCanvasElement</a></code>, or
  <code><a href="video.html#htmlvideoelement">HTMLVideoElement</a></code>. If the <var title="">image</var> is
  null, the implementation must raise a <code><a href="urls.html#type_mismatch_err">TYPE_MISMATCH_ERR</a></code>
  exception.</p> <!-- createPattern() has an equivalent paragraph -->

  <p>If the <var title="">image</var> argument is an
  <code><a href="embedded-content-1.html#htmlimageelement">HTMLImageElement</a></code> object that is not <a href="embedded-content-1.html#img-good" title="img-good">fully decodable</a>, or if the <var title="">image</var> argument is an <code><a href="video.html#htmlvideoelement">HTMLVideoElement</a></code>
  object whose <code title="dom-media-readyState"><a href="video.html#dom-media-readystate">readyState</a></code>
  attribute is either <code title="dom-media-HAVE_NOTHING"><a href="video.html#dom-media-have_nothing">HAVE_NOTHING</a></code> or <code title="dom-media-HAVE_METADATA"><a href="video.html#dom-media-have_metadata">HAVE_METADATA</a></code>, then the
  implementation must return without drawing anything.</p> <!--
  createPattern() has an equivalent paragraph -->

  <p>If the <var title="">image</var> argument is an
  <code><a href="#htmlcanvaselement">HTMLCanvasElement</a></code> object with either a horizontal
  dimension or a vertical dimension equal to zero, then the
  implementation must raise an <code><a href="urls.html#invalid_state_err">INVALID_STATE_ERR</a></code>
  exception.</p>
  <!-- createPattern() has an equivalent paragraph -->

  <p>The source rectangle is the rectangle whose corners are the four
  points (<var title="">sx</var>, <var title="">sy</var>), (<span title=""><var title="">sx</var>+<var title="">sw</var></span>, <var title="">sy</var>), (<span title=""><var title="">sx</var>+<var title="">sw</var></span>, <span title=""><var title="">sy</var>+<var title="">sh</var></span>), (<var title="">sx</var>, <span title=""><var title="">sy</var>+<var title="">sh</var></span>).</p>

  <p>If one of the <var title="">sw</var> or <var title="">sh</var>
  arguments is zero, the implementation must raise an
  <code><a href="urls.html#index_size_err">INDEX_SIZE_ERR</a></code> exception.</p>

  <p>The destination rectangle is the rectangle whose corners are the
  four points (<var title="">dx</var>, <var title="">dy</var>),
  (<span title=""><var title="">dx</var>+<var title="">dw</var></span>, <var title="">dy</var>), (<span title=""><var title="">dx</var>+<var title="">dw</var></span>, <span title=""><var title="">dy</var>+<var title="">dh</var></span>), (<var title="">dx</var>, <span title=""><var title="">dy</var>+<var title="">dh</var></span>).</p>

  <p>When <code title="dom-context-2d-drawImage"><a href="#dom-context-2d-drawimage">drawImage()</a></code> is
  invoked, the region of the image specified by the source rectangle
  must be painted on the region of the canvas specified by the
  destination rectangle, after applying the <a href="#transformations" title="dom-context-2d-transformation">current transformation
  matrix</a> to the points of the destination rectangle.</p>

  <p>The original image data of the source image must be used, not the
  image as it is rendered (e.g. <code title="attr-dim-width"><a href="the-map-element.html#attr-dim-width">width</a></code> and <code title="attr-dim-height"><a href="the-map-element.html#attr-dim-height">height</a></code> attributes on the source
  element have no effect). The image data must be processed in the
  original direction, even if the dimensions given are negative. <!--
  remove that last sentence if it causes confusion. Someone once
  suggested that 5,5,-2,-2 was different than 3,3,2,2; this is trying
  to clarify that this is no the case. --></p>

  <p class="note">This specification does not define the algorithm to
  use when scaling the image, if necessary.</p>

  <p class="note">When a canvas is drawn onto itself, the <a href="#drawing-model">drawing
  model</a> requires the source to be copied before the image is drawn
  back onto the canvas, so it is possible to copy parts of a canvas
  onto overlapping parts of itself.</p>

  <p>If the original image data is a bitmap image, the value painted
  at a point in the destination rectangle is computed by filtering the
  original image data. The user agent may use any filtering algorithm
  (for example bilinear interpolation or nearest-neighbor). When the
  filtering algorithm requires a pixel value from outside the original
  image data, it must instead use the value from the nearest edge
  pixel. (That is, the filter uses 'clamp-to-edge' behavior.)</p>
  <!-- see CORE-32111 and:
       http://krijnhoetmer.nl/irc-logs/whatwg/20100818#l-737
       http://www.w3.org/Bugs/Public/show_bug.cgi?id=10799#c11
  -->
  <!-- createPattern() has a similar paragraph with different rules -->

  <p>When the <code title="dom-context-2d-drawImage"><a href="#dom-context-2d-drawimage">drawImage()</a></code> method
  is passed an animated image as its <var title="">image</var>
  argument, the user agent must use the poster frame of the animation,
  or, if there is no poster frame, the first frame of the
  animation.</p>
  <!-- createPattern() has an equivalent paragraph -->

  <p>When the <var title="">image</var> argument is an
  <code><a href="video.html#htmlvideoelement">HTMLVideoElement</a></code>, then the frame at the <a href="video.html#current-playback-position">current
  playback position</a> must be used as the source image, and the
  source image's dimensions must be the <a href="video.html#concept-video-intrinsic-width" title="concept-video-intrinsic-width">intrinsic width</a> and
  <a href="video.html#concept-video-intrinsic-height" title="concept-video-intrinsic-height">intrinsic height</a>
  of the <a href="video.html#media-resource">media resource</a> (i.e. after any aspect-ratio
  correction has been applied).</p>
  <!-- createPattern() has an equivalent paragraph -->

  <p>Images are painted without affecting the current path, and are
  subject to <a href="#shadows" title="shadows">shadow effects</a>, <a href="#dom-context-2d-globalalpha" title="dom-context-2d-globalAlpha">global alpha</a>, the <a href="#clipping-region" title="clipping region">clipping region</a>, and <a href="#dom-context-2d-globalcompositeoperation" title="dom-context-2d-globalCompositeOperation">global composition
  operators</a>.</p>

  </div>



  <h6 id="pixel-manipulation"><span class="secno">4.8.11.1.12 </span><dfn>Pixel manipulation</dfn></h6>

  <dl class="domintro"><dt><var title="">imagedata</var> = <var title="">context</var> . <code title="dom-context-2d-createImageData"><a href="#dom-context-2d-createimagedata">createImageData</a></code>(<var title="">sw</var>, <var title="">sh</var>)</dt>

   <dd>

    <p>Returns an <code><a href="#imagedata">ImageData</a></code> object with the given
    dimensions in CSS pixels (which might map to a different number of
    actual device pixels exposed by the object itself). All the pixels
    in the returned object are transparent black.</p>

   </dd>

   <dt><var title="">imagedata</var> = <var title="">context</var> . <code title="dom-context-2d-createImageData"><a href="#dom-context-2d-createimagedata">createImageData</a></code>(<var title="">imagedata</var>)</dt>

   <dd>

    <p>Returns an <code><a href="#imagedata">ImageData</a></code> object with the same
    dimensions as the argument. All the pixels in the returned object
    are transparent black.</p>

    <p>Throws a <code><a href="urls.html#not_supported_err">NOT_SUPPORTED_ERR</a></code> exception if the
    argument is null.</p>

   </dd>

   <dt><var title="">imagedata</var> = <var title="">context</var> . <code title="dom-context-2d-getImageData"><a href="#dom-context-2d-getimagedata">getImageData</a></code>(<var title="">sx</var>, <var title="">sy</var>, <var title="">sw</var>, <var title="">sh</var>)</dt>

   <dd>

    <p>Returns an <code><a href="#imagedata">ImageData</a></code> object containing the image
    data for the given rectangle of the canvas.</p>

    <p>Throws a <code><a href="urls.html#not_supported_err">NOT_SUPPORTED_ERR</a></code> exception if any of the
    arguments are not finite. Throws an <code><a href="urls.html#index_size_err">INDEX_SIZE_ERR</a></code>
    exception if the either of the width or height arguments are
    zero.</p>

   </dd>

   <dt><var title="">imagedata</var> . <code title="dom-imagedata-width"><a href="#dom-imagedata-width">width</a></code></dt>
   <dt><var title="">imagedata</var> . <code title="dom-imagedata-height"><a href="#dom-imagedata-height">height</a></code></dt>

   <dd>

    <p>Returns the actual dimensions of the data in the <code><a href="#imagedata">ImageData</a></code> object, in device pixels.</p>

   </dd>

   <dt><var title="">imagedata</var> . <code title="dom-imagedata-data"><a href="#dom-imagedata-data">data</a></code></dt>

   <dd>

    <p>Returns the one-dimensional array containing the data in RGBA order, as integers in the range 0 to 255.</p>

   </dd>

   <dt><var title="">context</var> . <code title="dom-context-2d-putImageData"><a href="#dom-context-2d-putimagedata">putImageData</a></code>(<var title="">imagedata</var>, <var title="">dx</var>, <var title="">dy</var> [, <var title="">dirtyX</var>, <var title="">dirtyY</var>, <var title="">dirtyWidth</var>, <var title="">dirtyHeight</var> ])</dt>

   <dd>

    <p>Paints the data from the given <code><a href="#imagedata">ImageData</a></code> object
    onto the canvas. If a dirty rectangle is provided, only the pixels
    from that rectangle are painted.</p>

    <p>The <code title="dom-context-2d-globalAlpha"><a href="#dom-context-2d-globalalpha">globalAlpha</a></code>
    and <code title="dom-context-2d-globalCompositeOperation"><a href="#dom-context-2d-globalcompositeoperation">globalCompositeOperation</a></code>
    attributes, as well as the shadow attributes, are ignored for the
    purposes of this method call; pixels in the canvas are replaced
    wholesale, with no composition, alpha blending, no shadows,
    etc.</p>

    <p>If the first argument is null, throws a
    <code><a href="urls.html#type_mismatch_err">TYPE_MISMATCH_ERR</a></code> exception. Throws a
    <code><a href="urls.html#not_supported_err">NOT_SUPPORTED_ERR</a></code> exception if any of the other
    arguments are not finite.</p>

   </dd>

  </dl><div class="impl">

  <p>The <dfn id="dom-context-2d-createimagedata" title="dom-context-2d-createImageData"><code>createImageData()</code></dfn>
  method is used to instantiate new blank <code><a href="#imagedata">ImageData</a></code>
  objects. When the method is invoked with two arguments <var title="">sw</var> and <var title="">sh</var>, it must return an
  <code><a href="#imagedata">ImageData</a></code> object representing a rectangle with a width
  in CSS pixels equal to the absolute magnitude of <var title="">sw</var> and a height in CSS pixels equal to the absolute
  magnitude of <var title="">sh</var>. When invoked with a single <var title="">imagedata</var> argument, it must return an
  <code><a href="#imagedata">ImageData</a></code> object representing a rectangle with the same
  dimensions as the <code><a href="#imagedata">ImageData</a></code> object passed as the
  argument. The <code><a href="#imagedata">ImageData</a></code> object returned must be filled
  with transparent black.</p>

  <p>The <dfn id="dom-context-2d-getimagedata" title="dom-context-2d-getImageData"><code>getImageData(<var title="">sx</var>, <var title="">sy</var>, <var title="">sw</var>,
  <var title="">sh</var>)</code></dfn> method must return an
  <code><a href="#imagedata">ImageData</a></code> object representing the underlying pixel data
  for the area of the canvas denoted by the rectangle whose corners are
  the four points (<var title="">sx</var>, <var title="">sy</var>),
  (<span title=""><var title="">sx</var>+<var title="">sw</var></span>, <var title="">sy</var>), (<span title=""><var title="">sx</var>+<var title="">sw</var></span>, <span title=""><var title="">sy</var>+<var title="">sh</var></span>), (<var title="">sx</var>, <span title=""><var title="">sy</var>+<var title="">sh</var></span>), in canvas
  coordinate space units. Pixels outside the canvas must be returned
  as transparent black. Pixels must be returned as non-premultiplied
  alpha values.</p>

  <p>If any of the arguments to <code title="dom-context-2d-createImageData"><a href="#dom-context-2d-createimagedata">createImageData()</a></code> or
  <code title="dom-context-2d-getImageData"><a href="#dom-context-2d-getimagedata">getImageData()</a></code> are
  infinite or NaN, or if the <code title="dom-context-2d-createImageData"><a href="#dom-context-2d-createimagedata">createImageData()</a></code>
  method is invoked with only one argument but that argument is null,
  the method must instead raise a <code><a href="urls.html#not_supported_err">NOT_SUPPORTED_ERR</a></code>
  exception. If either the <var title="">sw</var> or <var title="">sh</var> arguments are zero, the method must instead raise
  an <code><a href="urls.html#index_size_err">INDEX_SIZE_ERR</a></code> exception.</p>

  <p><code><a href="#imagedata">ImageData</a></code> objects must be initialized so that their
  <dfn id="dom-imagedata-width" title="dom-imagedata-width"><code>width</code></dfn> attribute
  is set to <var title="">w</var>, the number of physical device
  pixels per row in the image data, their <dfn id="dom-imagedata-height" title="dom-imagedata-height"><code>height</code></dfn> attribute is
  set to <var title="">h</var>, the number of rows in the image data,
  and their <dfn id="dom-imagedata-data" title="dom-imagedata-data"><code>data</code></dfn>
  attribute is initialized to a <code><a href="#canvaspixelarray">CanvasPixelArray</a></code> object
  holding the image data. At least one pixel's worth of image data
  must be returned.</p>

  <p>The <code><a href="#canvaspixelarray">CanvasPixelArray</a></code> object provides ordered,
  indexed access to the color components of each pixel of the image
  data. The data must be represented in left-to-right order, row by
  row top to bottom, starting with the top left, with each pixel's
  red, green, blue, and alpha components being given in that order for
  each pixel. Each component of each device pixel represented in this
  array must be in the range 0..255, representing the 8 bit value for
  that component. The components must be assigned consecutive indices
  starting with 0 for the top left pixel's red component.</p>

  <p>The <code><a href="#canvaspixelarray">CanvasPixelArray</a></code> object thus represents <var title="">h</var>&times;<var title="">w</var>&times;4 integers. The
  <dfn id="dom-canvaspixelarray-length" title="dom-canvaspixelarray-length"><code>length</code></dfn>
  attribute of a <code><a href="#canvaspixelarray">CanvasPixelArray</a></code> object must return this
  number.</p>

  <p>The object's <a href="infrastructure.html#supported-property-indices">supported property indices</a> are the
  numbers in the range 0 .. <span title=""><var title="">h</var>&times;<var title="">w</var>&times;4-1</span>.</p>

  <p>To <dfn id="dom-canvaspixelarray-get" title="dom-CanvasPixelArray-get">determine the value of
  an indexed property</dfn> <var title="">index</var>, the user agent
  must return the value of the <var title="">index</var>th component
  in the array.</p>

  <p>To <dfn id="dom-canvaspixelarray-set" title="dom-CanvasPixelArray-set">set the value of an
  existing indexed property</dfn> <var title="">index</var> to value
  <var title="">value</var>, the value of the <var title="">index</var>th component in the array must be set to <var title="">value</var>.</p>

  <p class="note">The width and height (<var title="">w</var> and <var title="">h</var>) might be different from the <var title="">sw</var>
  and <var title="">sh</var> arguments to the above methods, e.g. if
  the canvas is backed by a high-resolution bitmap, or if the <var title="">sw</var> and <var title="">sh</var> arguments are
  negative.</p>

  <p>The <dfn id="dom-context-2d-putimagedata" title="dom-context-2d-putImageData"><code>putImageData(<var title="">imagedata</var>, <var title="">dx</var>, <var title="">dy</var>, <var title="">dirtyX</var>, <var title="">dirtyY</var>, <var title="">dirtyWidth</var>, <var title="">dirtyHeight</var>)</code></dfn> method writes data from
  <code><a href="#imagedata">ImageData</a></code> structures back to the canvas.</p>

  <p>If any of the arguments to the method are infinite or NaN, the
  method must raise a <code><a href="urls.html#not_supported_err">NOT_SUPPORTED_ERR</a></code> exception.</p>

  <p>If the first argument to the method is null, then the <code title="dom-context-2d-putImageData"><a href="#dom-context-2d-putimagedata">putImageData()</a></code> method
  must raise a <code><a href="urls.html#type_mismatch_err">TYPE_MISMATCH_ERR</a></code> exception.</p>

  <p>When the last four arguments are omitted, they must be assumed to
  have the values 0, 0, the <code title="dom-imagedata-width"><a href="#dom-imagedata-width">width</a></code> member of the <var title="">imagedata</var> structure, and the <code title="dom-imagedata-height"><a href="#dom-imagedata-height">height</a></code> member of the <var title="">imagedata</var> structure, respectively.</p>

  <p>When invoked with arguments that do not, per the last few
  paragraphs, cause an exception to be raised, the <code title="dom-context-2d-putImageData"><a href="#dom-context-2d-putimagedata">putImageData()</a></code> method
  must act as follows:</p>

  <ol><li>

    <p>Let <var title="">dx<sub>device</sub></var> be the x-coordinate
    of the device pixel in the underlying pixel data of the canvas
    corresponding to the <var title="">dx</var> coordinate in the
    canvas coordinate space.</p>

    <p>Let <var title="">dy<sub>device</sub></var> be the y-coordinate
    of the device pixel in the underlying pixel data of the canvas
    corresponding to the <var title="">dy</var> coordinate in the
    canvas coordinate space.</p>

   </li>

   <li>

    <p>If <var title="">dirtyWidth</var> is negative, let <var title="">dirtyX</var> be <span title=""><var title="">dirtyX</var>+<var title="">dirtyWidth</var></span>, and let <var title="">dirtyWidth</var> be equal to the absolute magnitude of
    <var title="">dirtyWidth</var>.</p>

    <p>If <var title="">dirtyHeight</var> is negative, let <var title="">dirtyY</var> be <span title=""><var title="">dirtyY</var>+<var title="">dirtyHeight</var></span>, and let <var title="">dirtyHeight</var> be equal to the absolute magnitude of
    <var title="">dirtyHeight</var>.</p>

   </li>

   <li>

    <p>If <var title="">dirtyX</var> is negative, let <var title="">dirtyWidth</var> be <span title=""><var title="">dirtyWidth</var>+<var title="">dirtyX</var></span>, and
    let <var title="">dirtyX</var> be zero.</p>

    <p>If <var title="">dirtyY</var> is negative, let <var title="">dirtyHeight</var> be <span title=""><var title="">dirtyHeight</var>+<var title="">dirtyY</var></span>, and
    let <var title="">dirtyY</var> be zero.</p>

   </li>

   <li>

    <p>If <span title=""><var title="">dirtyX</var>+<var title="">dirtyWidth</var></span> is greater than the <code title="dom-imagedata-width"><a href="#dom-imagedata-width">width</a></code> attribute of the <var title="">imagedata</var> argument, let <var title="">dirtyWidth</var> be the value of that <code title="dom-imagedata-width"><a href="#dom-imagedata-width">width</a></code> attribute, minus the
    value of <var title="">dirtyX</var>.</p>

    <p>If <span title=""><var title="">dirtyY</var>+<var title="">dirtyHeight</var></span> is greater than the <code title="dom-imagedata-height"><a href="#dom-imagedata-height">height</a></code> attribute of the <var title="">imagedata</var> argument, let <var title="">dirtyHeight</var> be the value of that <code title="dom-imagedata-height"><a href="#dom-imagedata-height">height</a></code> attribute, minus the
    value of <var title="">dirtyY</var>.</p>

   </li>

   <li>

    <p>If, after those changes, either <var title="">dirtyWidth</var>
    or <var title="">dirtyHeight</var> is negative or zero, stop these
    steps without affecting the canvas.</p>

   </li>

   <li><p>Otherwise, for all integer values of <var title="">x</var>
   and <var title="">y</var> where <span title=""><var title="">dirtyX</var>&nbsp;&le;&nbsp;<var title="">x</var>&nbsp;&lt;&nbsp;<span title=""><var title="">dirtyX</var>+<var title="">dirtyWidth</var></span></span>
   and <span title=""><var title="">dirtyY</var>&nbsp;&le;&nbsp;<var title="">y</var>&nbsp;&lt;&nbsp;<span title=""><var title="">dirtyY</var>+<var title="">dirtyHeight</var></span></span>, copy the four channels of
   the pixel with coordinate (<var title="">x</var>, <var title="">y</var>) in the <var title="">imagedata</var> data
   structure to the pixel with coordinate (<span title=""><var title="">dx<sub>device</sub></var>+<var title="">x</var></span>,
   <span title=""><var title="">dy<sub>device</sub></var>+<var title="">y</var></span>) in the underlying pixel data of the
   canvas.</li>

  </ol><p>The handling of pixel rounding when the specified coordinates do
  not exactly map to the device coordinate space is not defined by
  this specification, except that the following must result in no
  visible changes to the rendering:</p>

  <pre>context.putImageData(context.getImageData(x, y, w, h), p, q);</pre>

  <p>...for any value of <var title="">x</var>, <var title="">y</var>,
  <var title="">w</var>, and <var title="">h</var> and where <var title="">p</var> is the smaller of <var title="">x</var> and the sum
  of <var title="">x</var> and <var title="">w</var>, and <var title="">q</var> is the smaller of <var title="">y</var> and the sum
  of <var title="">y</var> and <var title="">h</var>; and except that
  the following two calls:</p>

  <pre>context.createImageData(w, h);
context.getImageData(0, 0, w, h);</pre>

  <p>...must return <code><a href="#imagedata">ImageData</a></code> objects with the same
  dimensions, for any value of <var title="">w</var> and <var title="">h</var>. In other words, while user agents may round the
  arguments of these methods so that they map to device pixel
  boundaries, any rounding performed must be performed consistently
  for all of the <code title="dom-context-2d-getImageData"><a href="#dom-context-2d-getimagedata">createImageData()</a></code>, <code title="dom-context-2d-getImageData"><a href="#dom-context-2d-getimagedata">getImageData()</a></code> and <code title="dom-context-2d-putImageData"><a href="#dom-context-2d-putimagedata">putImageData()</a></code>
  operations.</p>

  <p class="note">Due to the lossy nature of converting to and from
  premultiplied alpha color values, pixels that have just been set
  using <code title="dom-context-2d-putImageData"><a href="#dom-context-2d-putimagedata">putImageData()</a></code> might be
  returned to an equivalent <code title="dom-context-2d-getImageData"><a href="#dom-context-2d-getimagedata">getImageData()</a></code> as
  different values.</p>

  <p>The current path, <a href="#transformations" title="dom-context-2d-transformation">transformation matrix</a>,
  <a href="#shadows" title="shadows">shadow attributes</a>, <a href="#dom-context-2d-globalalpha" title="dom-context-2d-globalAlpha">global alpha</a>, the <a href="#clipping-region" title="clipping region">clipping region</a>, and <a href="#dom-context-2d-globalcompositeoperation" title="dom-context-2d-globalCompositeOperation">global composition
  operator</a> must not affect the <code title="dom-context-2d-getImageData"><a href="#dom-context-2d-getimagedata">getImageData()</a></code> and <code title="dom-context-2d-putImageData"><a href="#dom-context-2d-putimagedata">putImageData()</a></code>
  methods.</p>

  </div>

  <div class="example">

   <p>The data returned by <code title="dom-context-2d-getImageData"><a href="#dom-context-2d-getimagedata">getImageData()</a></code> is at the
   resolution of the canvas backing store, which is likely to not be
   one device pixel to each CSS pixel if the display used is a high
   resolution display.</p>

   <p>In the following example, the script generates an
   <code><a href="#imagedata">ImageData</a></code> object so that it can draw onto it.</p>

   <pre>// canvas is a reference to a &lt;canvas&gt; element
var context = canvas.getContext('2d');

// create a blank slate
var data = context.createImageData(canvas.width, canvas.height);

// create some plasma
FillPlasma(data, 'green'); // green plasma

// add a cloud to the plasma
AddCloud(data, data.width/2, data.height/2); // put a cloud in the middle

// paint the plasma+cloud on the canvas
context.putImageData(data, 0, 0);

// support methods
function FillPlasma(data, color) { ... }
function AddCloud(data, x, y) { ... }</pre>

  </div>

  <div class="example">

   <p>Here is an example of using <code title="dom-context-2d-getImageData"><a href="#dom-context-2d-getimagedata">getImageData()</a></code> and <code title="dom-context-2d-putImageData"><a href="#dom-context-2d-putimagedata">putImageData()</a></code> to
   implement an edge detection filter.</p>

   <pre>&lt;!DOCTYPE HTML&gt;
&lt;html&gt;
 &lt;head&gt;
  &lt;title&gt;Edge detection demo&lt;/title&gt;
  &lt;script&gt;
   var image = new Image();
   function init() {
     image.onload = demo;
     image.src = "image.jpeg";
   }
   function demo() {
     var canvas = document.getElementsByTagName('canvas')[0];
     var context = canvas.getContext('2d');

     // draw the image onto the canvas
     context.drawImage(image, 0, 0);

     // get the image data to manipulate
     var input = context.getImageData(0, 0, canvas.width, canvas.height);

     // get an empty slate to put the data into
     var output = context.createImageData(canvas.width, canvas.height);

     // alias some variables for convenience
     // notice that we are using input.width and input.height here
     // as they might not be the same as canvas.width and canvas.height
     // (in particular, they might be different on high-res displays)
     var w = input.width, h = input.height;
     var inputData = input.data;
     var outputData = output.data;

     // edge detection
     for (var y = 1; y &lt; h-1; y += 1) {
       for (var x = 1; x &lt; w-1; x += 1) {
         for (var c = 0; c &lt; 3; c += 1) {
           var i = (y*w + x)*4 + c;
           outputData[i] = 127 + -inputData[i - w*4 - 4] -   inputData[i - w*4] - inputData[i - w*4 + 4] +
                                 -inputData[i - 4]       + 8*inputData[i]       - inputData[i + 4] +
                                 -inputData[i + w*4 - 4] -   inputData[i + w*4] - inputData[i + w*4 + 4];
         }
         outputData[(y*w + x)*4 + 3] = 255; // alpha
       }
     }

     // put the image data back after manipulation
     context.putImageData(output, 0, 0);
   }
  &lt;/script&gt;
 &lt;/head&gt;
 &lt;body onload="init()"&gt;
  &lt;canvas&gt;&lt;/canvas&gt;
 &lt;/body&gt;
&lt;/html&gt;</pre>

  </div>


  <div class="impl">

  <h6 id="drawing-model"><span class="secno">4.8.11.1.13 </span><dfn>Drawing model</dfn></h6>

  <p>When a shape or image is painted, user agents must follow these
  steps, in the order given (or act as if they do):</p>

  <ol><li><p>Render the shape or image onto an infinite transparent black
   bitmap, creating image <var title="">A</var>, as described in the
   previous sections. For shapes, the current fill, stroke, and line
   styles must be honored, and the stroke must itself also be
   subjected to the current transformation matrix.</li>

   <li><p><a href="#when-shadows-are-drawn">When shadows are drawn</a>, render the shadow from
   image <var title="">A</var>, using the current shadow styles,
   creating image <var title="">B</var>.</li>

   <li><p><a href="#when-shadows-are-drawn">When shadows are drawn</a>, multiply the alpha
   component of every pixel in <var title="">B</var> by <code title="dom-context-2d-globalAlpha"><a href="#dom-context-2d-globalalpha">globalAlpha</a></code>.</li>

   <li><p><a href="#when-shadows-are-drawn">When shadows are drawn</a>, composite <var title="">B</var> within the <a href="#clipping-region">clipping region</a> over the
   current canvas bitmap using the current composition
   operator.</li>

   <li><p>Multiply the alpha component of every pixel in <var title="">A</var> by <code title="dom-context-2d-globalAlpha"><a href="#dom-context-2d-globalalpha">globalAlpha</a></code>.</li>

   <li><p>Composite <var title="">A</var> within the <a href="#clipping-region">clipping
   region</a> over the current canvas bitmap using the current
   composition operator.</li>

  </ol></div>


  <h6 id="examples"><span class="secno">4.8.11.1.14 </span>Examples</h6>

  <p><i>This section is non-normative.</i></p>

  <div class="example">

  <p>Here is an example of a script that uses canvas to draw pretty
  glowing lines.</p>

  <pre>&lt;canvas width="800" height="450"&gt;&lt;/canvas&gt;
&lt;script&gt;

 var context = document.getElementsByTagName('canvas')[0].getContext('2d');

 var lastX = context.canvas.width * Math.random();
 var lastY = context.canvas.height * Math.random();
 var hue = 0;
 function line() {
   context.save();
   context.translate(context.canvas.width/2, context.canvas.height/2);
   context.scale(0.9, 0.9);
   context.translate(-context.canvas.width/2, -context.canvas.height/2);
   context.beginPath();
   context.lineWidth = 5 + Math.random() * 10;
   context.moveTo(lastX, lastY);
   lastX = context.canvas.width * Math.random();
   lastY = context.canvas.height * Math.random();
   context.bezierCurveTo(context.canvas.width * Math.random(),
                         context.canvas.height * Math.random(),
                         context.canvas.width * Math.random(),
                         context.canvas.height * Math.random(),
                         lastX, lastY);

   hue = hue + 10 * Math.random();
   context.strokeStyle = 'hsl(' + hue + ', 50%, 50%)';
   context.shadowColor = 'white';
   context.shadowBlur = 10;
   context.stroke();
   context.restore();
 }
 setInterval(line, 50);

 function blank() {
   context.fillStyle = 'rgba(0,0,0,0.1)';
   context.fillRect(0, 0, context.canvas.width, context.canvas.height);
 }
 setInterval(blank, 40);

&lt;/script&gt;</pre>

  </div>



  </div><!--data-component-->

  <!--2DCONTEXT-->

  <div class="impl">

  <h5 id="color-spaces-and-color-correction"><span class="secno">4.8.11.2 </span>Color spaces and color correction</h5>

  <p>The <code><a href="#the-canvas-element">canvas</a></code> APIs must perform color correction at
  only two points: when rendering images with their own gamma
  correction and color space information onto the canvas, to convert
  the image to the color space used by the canvas (e.g. using the 2D
  Context's <code title="dom-context-2d-drawImage"><a href="#dom-context-2d-drawimage">drawImage()</a></code>
  method with an <code><a href="embedded-content-1.html#htmlimageelement">HTMLImageElement</a></code> object), and when
  rendering the actual canvas bitmap to the output device.</p>

  <p class="note">Thus, in the 2D context, colors used to draw shapes
  onto the canvas will exactly match colors obtained through the <code title="dom-context-2d-getImageData"><a href="#dom-context-2d-getimagedata">getImageData()</a></code>
  method.</p>

  <p>The <code title="dom-canvas-toDataURL"><a href="#dom-canvas-todataurl">toDataURL()</a></code> method
  must not include color space information in the resource
  returned. Where the output format allows it, the color of pixels in
  resources created by <code title="dom-canvas-toDataURL"><a href="#dom-canvas-todataurl">toDataURL()</a></code> must match those
  returned by the <code title="dom-context-2d-getImageData"><a href="#dom-context-2d-getimagedata">getImageData()</a></code>
  method.</p>

  <p>In user agents that support CSS, the color space used by a
  <code><a href="#the-canvas-element">canvas</a></code> element must match the color space used for
  processing any colors for that element in CSS.</p>

  <p>The gamma correction and color space information of images must
  be handled in such a way that an image rendered directly using an
  <code><a href="embedded-content-1.html#the-img-element">img</a></code> element would use the same colors as one painted on
  a <code><a href="#the-canvas-element">canvas</a></code> element that is then itself
  rendered. Furthermore, the rendering of images that have no color
  correction information (such as those returned by the <code title="dom-canvas-toDataURL"><a href="#dom-canvas-todataurl">toDataURL()</a></code> method) must be
  rendered with no color correction.</p>

  <p class="note">Thus, in the 2D context, calling the <code title="dom-context-2d-drawImage"><a href="#dom-context-2d-drawimage">drawImage()</a></code> method to render
  the output of the <code title="dom-canvas-toDataURL"><a href="#dom-canvas-todataurl">toDataURL()</a></code> method to the
  canvas, given the appropriate dimensions, has no visible effect.</p>

  </div>


  <div class="impl">

  <h5 id="security-with-canvas-elements"><span class="secno">4.8.11.3 </span>Security with <code><a href="#the-canvas-element">canvas</a></code> elements</h5>

  <p><strong>Information leakage</strong> can occur if scripts from
  one <a href="origin-0.html#origin">origin</a> can access information (e.g. read pixels)
  from images from another origin (one that isn't the <a href="origin-0.html#same-origin" title="same origin">same</a>).</p>

  <p>To mitigate this, <code><a href="#the-canvas-element">canvas</a></code> elements are defined to
  have a flag indicating whether they are <i>origin-clean</i>. All
  <code><a href="#the-canvas-element">canvas</a></code> elements must start with their
  <i>origin-clean</i> set to true. The flag must be set to false if
  any of the following actions occur:</p>

  <ul><li><p>The element's 2D context's <code title="dom-context-2d-drawImage"><a href="#dom-context-2d-drawimage">drawImage()</a></code> method is
   called with an <code><a href="embedded-content-1.html#htmlimageelement">HTMLImageElement</a></code> or an
   <code><a href="video.html#htmlvideoelement">HTMLVideoElement</a></code> whose <a href="origin-0.html#origin">origin</a> is not the
   <a href="origin-0.html#same-origin" title="same origin">same</a> as that of the
   <code><a href="infrastructure.html#document">Document</a></code> object that owns the <code><a href="#the-canvas-element">canvas</a></code>
   element.</li>

   <li><p>The element's 2D context's <code title="dom-context-2d-drawImage"><a href="#dom-context-2d-drawimage">drawImage()</a></code> method is
   called with an <code><a href="#htmlcanvaselement">HTMLCanvasElement</a></code> whose
   <i>origin-clean</i> flag is false.</li>

   <li><p>The element's 2D context's <code title="dom-context-2d-fillStyle"><a href="#dom-context-2d-fillstyle">fillStyle</a></code> attribute is set
   to a <code><a href="#canvaspattern">CanvasPattern</a></code> object that was created from an
   <code><a href="embedded-content-1.html#htmlimageelement">HTMLImageElement</a></code> or an <code><a href="video.html#htmlvideoelement">HTMLVideoElement</a></code>
   whose <a href="origin-0.html#origin">origin</a> was not the <a href="origin-0.html#same-origin" title="same
   origin">same</a> as that of the <code><a href="infrastructure.html#document">Document</a></code> object
   that owns the <code><a href="#the-canvas-element">canvas</a></code> element when the pattern was
   created.</li>

   <li><p>The element's 2D context's <code title="dom-context-2d-fillStyle"><a href="#dom-context-2d-fillstyle">fillStyle</a></code> attribute is set
   to a <code><a href="#canvaspattern">CanvasPattern</a></code> object that was created from an
   <code><a href="#htmlcanvaselement">HTMLCanvasElement</a></code> whose <i>origin-clean</i> flag was
   false when the pattern was created.</li>

   <li><p>The element's 2D context's <code title="dom-context-2d-strokeStyle"><a href="#dom-context-2d-strokestyle">strokeStyle</a></code> attribute is
   set to a <code><a href="#canvaspattern">CanvasPattern</a></code> object that was created from an
   <code><a href="embedded-content-1.html#htmlimageelement">HTMLImageElement</a></code> or an <code><a href="video.html#htmlvideoelement">HTMLVideoElement</a></code>
   whose <a href="origin-0.html#origin">origin</a> was not the <a href="origin-0.html#same-origin" title="same
   origin">same</a> as that of the <code><a href="infrastructure.html#document">Document</a></code> object
   that owns the <code><a href="#the-canvas-element">canvas</a></code> element when the pattern was
   created.</li>

   <li><p>The element's 2D context's <code title="dom-context-2d-strokeStyle"><a href="#dom-context-2d-strokestyle">strokeStyle</a></code> attribute is
   set to a <code><a href="#canvaspattern">CanvasPattern</a></code> object that was created from an
   <code><a href="#htmlcanvaselement">HTMLCanvasElement</a></code> whose <i>origin-clean</i> flag was
   false when the pattern was created.</li>

   <li><p>The element's 2D context's <code title="dom-context-2d-fillText"><a href="#dom-context-2d-filltext">fillText()</a></code> or <code title="dom-context-2d-fillText"><a href="#dom-context-2d-filltext">strokeText()</a></code> methods are
   invoked and end up using a font that has an <a href="origin-0.html#origin">origin</a>
   that is not the <a href="origin-0.html#same-origin" title="same origin">same</a> as that of
   the <code><a href="infrastructure.html#document">Document</a></code> object that owns the <code><a href="#the-canvas-element">canvas</a></code>
   element.</li>

  </ul><p>Whenever the <code title="dom-canvas-toDataURL"><a href="#dom-canvas-todataurl">toDataURL()</a></code> method of a
  <code><a href="#the-canvas-element">canvas</a></code> element whose <i>origin-clean</i> flag is set to
  false is called, the method must raise a <code><a href="urls.html#security_err">SECURITY_ERR</a></code>
  exception.</p>

  <p>Whenever the <code title="dom-context-2d-getImageData"><a href="#dom-context-2d-getimagedata">getImageData()</a></code> method of
  the 2D context of a <code><a href="#the-canvas-element">canvas</a></code> element whose
  <i>origin-clean</i> flag is set to false is called with otherwise
  correct arguments, the method must raise a <code><a href="urls.html#security_err">SECURITY_ERR</a></code>
  exception.</p>

  <p>Whenever the <code title="dom-context-2d-measureText"><a href="#dom-context-2d-measuretext">measureText()</a></code> method of
  the 2D context of a <code><a href="#the-canvas-element">canvas</a></code> element ends up using a font
  that has an <a href="origin-0.html#origin">origin</a> that is not the <a href="origin-0.html#same-origin" title="same
  origin">same</a> as that of the <code><a href="infrastructure.html#document">Document</a></code> object that
  owns the <code><a href="#the-canvas-element">canvas</a></code> element, the method must raise a
  <code><a href="urls.html#security_err">SECURITY_ERR</a></code> exception.</p>

  <p class="note">Even resetting the canvas state by changing its
  <code title="attr-canvas-width"><a href="#attr-canvas-width">width</a></code> or <code title="attr-canvas-height"><a href="#attr-canvas-height">height</a></code> attributes doesn't reset
  the <i>origin-clean</i> flag.</p>

  </div>



  