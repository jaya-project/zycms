<?php

/* layouts/layout1.php */
class __TwigTemplate_fbf9875e133e1cd15a8fb19e0c294ae5ab30d92894d89a9bc92894596ff2a85a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'header' => array($this, 'block_header'),
            'content' => array($this, 'block_content'),
            'footer' => array($this, 'block_footer'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "﻿<!DOCTYPE HTML>
<html lang=\"en-US\">
<head>
\t<meta charset=\"UTF-8\">
\t<title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
</head>
<body>
\t<div id=\"header\">
\t\t";
        // line 9
        $this->displayBlock('header', $context, $blocks);
        // line 15
        echo "\t</div>
\t
\t<div id=\"content\">
\t\t";
        // line 18
        $this->displayBlock('content', $context, $blocks);
        // line 21
        echo "\t</div>
\t
\t<div id=\"footer\">
\t\t";
        // line 24
        $this->displayBlock('footer', $context, $blocks);
        // line 27
        echo "\t</div>
</body>
</html>";
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        echo "Test";
    }

    // line 9
    public function block_header($context, array $blocks = array())
    {
        // line 10
        echo "\t\t\t<ul>
\t\t\t\t  <li><a href=\"/\">Home</a></li>
\t\t\t\t  <li><a href=\"/blog\">Blog</a></li>
\t\t\t</ul>
\t\t";
    }

    // line 18
    public function block_content($context, array $blocks = array())
    {
        // line 19
        echo "\t\t\t
\t\t";
    }

    // line 24
    public function block_footer($context, array $blocks = array())
    {
        // line 25
        echo "\t\t\t尾部
\t\t";
    }

    public function getTemplateName()
    {
        return "layouts/layout1.php";
    }

    public function getDebugInfo()
    {
        return array (  86 => 25,  83 => 24,  78 => 19,  75 => 18,  67 => 10,  64 => 9,  58 => 5,  52 => 27,  50 => 24,  45 => 21,  43 => 18,  38 => 15,  36 => 9,  29 => 5,  23 => 1,);
    }
}
/* ﻿<!DOCTYPE HTML>*/
/* <html lang="en-US">*/
/* <head>*/
/* 	<meta charset="UTF-8">*/
/* 	<title>{% block title %}Test{% endblock %}</title>*/
/* </head>*/
/* <body>*/
/* 	<div id="header">*/
/* 		{% block header %}*/
/* 			<ul>*/
/* 				  <li><a href="/">Home</a></li>*/
/* 				  <li><a href="/blog">Blog</a></li>*/
/* 			</ul>*/
/* 		{% endblock %}*/
/* 	</div>*/
/* 	*/
/* 	<div id="content">*/
/* 		{% block content %}*/
/* 			*/
/* 		{% endblock %}*/
/* 	</div>*/
/* 	*/
/* 	<div id="footer">*/
/* 		{% block footer %}*/
/* 			尾部*/
/* 		{% endblock %}*/
/* 	</div>*/
/* </body>*/
/* </html>*/
