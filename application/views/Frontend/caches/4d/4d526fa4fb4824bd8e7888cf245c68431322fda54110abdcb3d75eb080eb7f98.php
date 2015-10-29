<?php

/* index.php */
class __TwigTemplate_28b65d7975bf6f9aeed1f12f6816350acb7d63054e798084c4c53f6cd659b2d4 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layouts/layout1.php", "index.php", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'header' => array($this, 'block_header'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layouts/layout1.php";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo "这是测试";
    }

    // line 5
    public function block_header($context, array $blocks = array())
    {
        // line 6
        echo "\t<ul>
\t\t  <li><a href=\"/\">Home2</a></li>
\t\t  <li><a href=\"/blog\">Blog1</a></li>
\t</ul>
";
    }

    public function getTemplateName()
    {
        return "index.php";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  38 => 6,  35 => 5,  29 => 3,  11 => 1,);
    }
}
/* {% extends "layouts/layout1.php" %}*/
/* */
/* {% block title %}这是测试{% endblock %}*/
/* */
/* {% block header %}*/
/* 	<ul>*/
/* 		  <li><a href="/">Home2</a></li>*/
/* 		  <li><a href="/blog">Blog1</a></li>*/
/* 	</ul>*/
/* {% endblock %}*/
