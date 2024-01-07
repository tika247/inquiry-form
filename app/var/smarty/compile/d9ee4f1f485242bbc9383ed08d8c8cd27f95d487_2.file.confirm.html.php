<?php
/* Smarty version 4.3.2, created on 2024-01-07 16:53:12
  from 'C:\works\inquiry-form\app\templates\confirm.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.2',
  'unifunc' => 'content_659a58685a7592_06993375',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd9ee4f1f485242bbc9383ed08d8c8cd27f95d487' => 
    array (
      0 => 'C:\\works\\inquiry-form\\app\\templates\\confirm.html',
      1 => 1695257549,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_659a58685a7592_06993375 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Confirm | Inquiry Form</title>
<link rel="stylesheet" href="/assets/css/init.css">
<link rel="stylesheet" href="/assets/css/style.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body class="confirm">
<header class="header">
<div class="header__inner">
<h1 class="hdg-1">Inquiry for Services</h1>
</div>
</header>

<main class="main">
<div class="main__inner">

<ol class="step">
<li class="step__item"><span>Enter</span></li>
<li class="step__item" aria-current="step"><span>Confirm</span></li>
<li class="step__item"><span>Complete</span></li>
</ol>

<div class="hdg-2-wrap">
<h2 class="hdg-2">Confirm the entered below</h2>
</div>

<form action="/" method="POST" class="form --confirm">
<input type="hidden" name="target_page" value="complete">

<div class="form__inner">

<ul class="form__list">

<li class="form__item">
<em class="form__name">Service</em>
<div class="form__contents">
<span><?php echo htmlspecialchars((string) $_smarty_tpl->tpl_vars['service_list']->value[$_smarty_tpl->tpl_vars['service']->value], ENT_QUOTES, 'UTF-8');?>
</span>
</div><!-- form__contents -->
</li><!-- form__item -->

<li class="form__item">
<em class="form__name">Contents</em>
<div class="form__contents">
<span><?php echo nl2br((string) htmlspecialchars((string)$_smarty_tpl->tpl_vars['contents']->value, ENT_QUOTES, 'UTF-8', true), (bool) 1);?>
</span>
</div><!-- form__contents -->
</li><!-- form__item -->

<li class="form__item">
<div class="form__name">Name</div>
<div class="form__contents">
<div class="form__wrap">
<span><?php echo htmlspecialchars((string) $_smarty_tpl->tpl_vars['name1']->value, ENT_QUOTES, 'UTF-8');?>
</span>
<span><?php echo htmlspecialchars((string) $_smarty_tpl->tpl_vars['name2']->value, ENT_QUOTES, 'UTF-8');?>
</span>
</div><!-- form__wrap -->
</div><!-- form__contents -->
</li><!-- form__item -->

<li class="form__item">
<em class="form__name">Occupation</em>
<div class="form__contents">
<span>
<?php if ((isset($_smarty_tpl->tpl_vars['occupation_list']->value[$_smarty_tpl->tpl_vars['occupation']->value]))) {
echo htmlspecialchars((string) $_smarty_tpl->tpl_vars['occupation_list']->value[$_smarty_tpl->tpl_vars['occupation']->value], ENT_QUOTES, 'UTF-8');?>

<?php }?>
</span>
</div><!-- form__contents -->
</li><!-- form__item -->

<li class="form__item">
<div class="form__name">Address</div>
<div class="form__contents">
<span><?php echo htmlspecialchars((string) (($tmp = $_smarty_tpl->tpl_vars['address1']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8');?>
</span>
<span><?php echo htmlspecialchars((string) (($tmp = $_smarty_tpl->tpl_vars['address2']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8');?>
</span>
<div class="form__wrap">
<span><?php echo htmlspecialchars((string) (($tmp = $_smarty_tpl->tpl_vars['address3']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8');?>
</span>
<span><?php echo htmlspecialchars((string) (($tmp = $_smarty_tpl->tpl_vars['address4']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8');?>
</span>
<span><?php echo htmlspecialchars((string) (($tmp = $_smarty_tpl->tpl_vars['address5']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8');?>
</span>
</div><!-- form__wrap -->
</div><!-- form__contents -->
</li><!-- form__item -->

<li class="form__item">
<div class="form__name">Phone</div>
<div class="form__contents">
<div class="form__wrap">
<span><?php echo htmlspecialchars((string) $_smarty_tpl->tpl_vars['phone1']->value, ENT_QUOTES, 'UTF-8');?>
</span>
<span><?php echo htmlspecialchars((string) $_smarty_tpl->tpl_vars['phone2']->value, ENT_QUOTES, 'UTF-8');?>
</span>
</div><!-- form__wrap -->
</div><!-- form__contents -->
</li><!-- form__item -->

<li class="form__item">
<em class="form__name">Email</em>
<div class="form__contents">
<span><?php echo htmlspecialchars((string) $_smarty_tpl->tpl_vars['email']->value, ENT_QUOTES, 'UTF-8');?>
</span>
</div><!-- form__contents -->
</li><!-- form__item -->

<li class="form__item">
<em class="form__name">Re-enter <br class="br-pc">Email</em>
<div class="form__contents">
<span><?php echo htmlspecialchars((string) $_smarty_tpl->tpl_vars['email2']->value, ENT_QUOTES, 'UTF-8');?>
</span>
</div><!-- form__contents -->
</li><!-- form__item -->

</ul><!-- form__list -->

<div class="form__btnWrap">
<a href="/" class="form__btn --back">Back</a>
<button type="submit" class="form__btn">Submit</button>
</div>

</div>
</form>

</div>
</main>

</body>
</html><?php }
}
