<?php
/* Smarty version 4.3.2, created on 2023-12-05 16:57:42
  from 'C:\works\inquiry-form\app\templates\index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.2',
  'unifunc' => 'content_656ed7f66d2a22_17248663',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '23e0d6780434c089a8a1d2c8cc9df9234163ef3b' => 
    array (
      0 => 'C:\\works\\inquiry-form\\app\\templates\\index.html',
      1 => 1695257549,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_656ed7f66d2a22_17248663 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\works\\inquiry-form\\vendor\\smarty\\smarty\\libs\\plugins\\modifier.count.php','function'=>'smarty_modifier_count',),1=>array('file'=>'C:\\works\\inquiry-form\\vendor\\smarty\\smarty\\libs\\plugins\\function.html_options.php','function'=>'smarty_function_html_options',),));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Index | Inquiry Form</title>
<link rel="stylesheet" href="/assets/css/init.css">
<link rel="stylesheet" href="/assets/css/style.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<?php echo '<script'; ?>
 src="/assets/js/script.js" defer><?php echo '</script'; ?>
>
</head>
<body>
<header class="header">
<div class="header__inner">
<h1 class="hdg-1">Inquiry for Services</h1>
</div>
</header>

<main class="main">
<div class="main__inner">

<ol class="step">
<li class="step__item" aria-current="step"><span>Enter</span></li>
<li class="step__item"><span>Confirm</span></li>
<li class="step__item"><span>Complete</span></li>
</ol>

<div class="hdg-2-wrap">
<h2 class="hdg-2">Enter the form below</h2>
</div>

<ul class="note">
<li class="note__item">note1</li>
<li class="note__item">note2</li>
<li class="note__item">note3</li>
<li class="note__item">note4</li>
</ul>

<?php if ((isset($_smarty_tpl->tpl_vars['is_error']->value)) && (isset($_smarty_tpl->tpl_vars['error_list']->value))) {
if (smarty_modifier_count($_smarty_tpl->tpl_vars['error_list']->value) === 1) {?>
<p><strong>Error is thrown. Fix it and submit again.</strong></p>
<?php } else { ?>
<p><strong>Errors are thrown. Fix them and submit again.</strong></p>
<?php }?>
<ul>
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['error_list']->value, 'item');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
<li><p><strong><?php echo htmlspecialchars((string) $_smarty_tpl->tpl_vars['item']->value, ENT_QUOTES, 'UTF-8');?>
</p></strong></li>
<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
</ul>
<?php }?>

<form action="/" method="POST" class="form js-form">
<input type="hidden" name="target_page" value="confirm">

<div class="form__inner">

<ul class="form__list">

<li class="form__item">
<label for="service" class="form__name">Service<span aria-hidden="true">*</span></label>
<div class="form__contents">
<select name="service" id="service" class="form__select<?php if ((isset($_smarty_tpl->tpl_vars['errors_service']->value))) {?> error<?php }?>" required>
<option value="">選択してください</option>
<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['service_list']->value,'selected'=>(($tmp = $_smarty_tpl->tpl_vars['service']->value ?? null)===null||$tmp==='' ? '0' ?? null : $tmp)),$_smarty_tpl);?>

</select>
</div><!-- form__contents -->
<?php if ((isset($_smarty_tpl->tpl_vars['errors_service']->value))) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['errors_service']->value, 'item');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
<p class="form__error"><strong>Error: <?php echo htmlspecialchars((string) $_smarty_tpl->tpl_vars['item']->value, ENT_QUOTES, 'UTF-8');?>
</strong></p>
<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}?>
</li><!-- form__item -->

<li class="form__item">
<label for="contents" class="form__name">Contents<span aria-hidden="true">*</span></label>
<div class="form__contents">
<textarea name="contents" id="contents" rows="5" class="form__textarea<?php if ((isset($_smarty_tpl->tpl_vars['errors_contents']->value))) {?> error<?php }?>" required><?php echo htmlspecialchars((string) (($tmp = $_smarty_tpl->tpl_vars['contents']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8');?>
</textarea>
</div><!-- form__contents -->
<?php if ((isset($_smarty_tpl->tpl_vars['errors_contents']->value))) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['errors_contents']->value, 'item');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?><p class="form__error"><strong>Error: <?php echo htmlspecialchars((string) $_smarty_tpl->tpl_vars['item']->value, ENT_QUOTES, 'UTF-8');?>
</strong></p><?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}?>
</li><!-- form__item -->

<li class="form__item">
<div class="form__name">Name<span aria-hidden="true">*</span></div>
<div class="form__contents">
<div class="form__wrap">
<div class="form__group">
<label for="name1" class="form__miniLabel">First Name</label>
<input type="text" id="name1" name="name1" value="<?php echo htmlspecialchars((string) (($tmp = $_smarty_tpl->tpl_vars['name1']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8');?>
"<?php if ((isset($_smarty_tpl->tpl_vars['errors_name1']->value))) {?> class="error"<?php }?> required>
<?php if ((isset($_smarty_tpl->tpl_vars['errors_name1']->value))) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['errors_name1']->value, 'item');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?><p class="form__error"><strong>Error: <?php echo htmlspecialchars((string) $_smarty_tpl->tpl_vars['item']->value, ENT_QUOTES, 'UTF-8');?>
</strong></p><?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}?>
</div><!-- form__group -->
<div class="form__group">
<label for="name2" class="form__miniLabel">Last Name</label>
<input type="text" id="name2" name="name2" value="<?php echo htmlspecialchars((string) (($tmp = $_smarty_tpl->tpl_vars['name2']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8');?>
"<?php if ((isset($_smarty_tpl->tpl_vars['errors_name2']->value))) {?> class="error"<?php }?> required>
<?php if ((isset($_smarty_tpl->tpl_vars['errors_name2']->value))) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['errors_name2']->value, 'item');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?><p class="form__error"><strong>Error: <?php echo htmlspecialchars((string) $_smarty_tpl->tpl_vars['item']->value, ENT_QUOTES, 'UTF-8');?>
</strong></p><?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}?>
</div><!-- form__group -->
</div><!-- form__wrap -->
</div><!-- form__contents -->
</li><!-- form__item -->

<li class="form__item">
<label for="occupation" class="form__name">Occupation</label>
<div class="form__contents">
<select name="occupation" id="occupation" class="form__select<?php if ((isset($_smarty_tpl->tpl_vars['errors_occupation']->value))) {?> error<?php }?>">
<option value="">選択してください</option>
<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['occupation_list']->value,'selected'=>(($tmp = $_smarty_tpl->tpl_vars['occupation']->value ?? null)===null||$tmp==='' ? '0' ?? null : $tmp)),$_smarty_tpl);?>

</select>
</div><!-- form__contents -->
<?php if ((isset($_smarty_tpl->tpl_vars['errors_occupation']->value))) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['errors_occupation']->value, 'item');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
<p class="form__error"><strong>Error: <?php echo htmlspecialchars((string) $_smarty_tpl->tpl_vars['item']->value, ENT_QUOTES, 'UTF-8');?>
</strong></p>
<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}?>
</li><!-- form__item -->

<li class="form__item">
<div class="form__name">Address</div>
<div class="form__contents">
<div class="form__group">
<label for="address1" class="form__miniLabel">Street Address</label>
<input type="text" id="address1" name="address1" value="<?php echo htmlspecialchars((string) (($tmp = $_smarty_tpl->tpl_vars['address1']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8');?>
">
</div>
<div class="form__group">
<label for="address2" class="form__miniLabel">Street Address Line2</label>
<input type="text" id="address2" name="address2" value="<?php echo htmlspecialchars((string) (($tmp = $_smarty_tpl->tpl_vars['address2']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8');?>
">
</div>
<div class="form__wrap">
<div class="form__group">
<label for="address3" class="form__miniLabel">City</label>
<input type="text" id="address3" name="address3" value="<?php echo htmlspecialchars((string) (($tmp = $_smarty_tpl->tpl_vars['address3']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8');?>
">
</div><!-- form__group -->
<div class="form__group">
<label for="address4" class="form__miniLabel">State / Province</label>
<input type="text" id="address4" name="address4" value="<?php echo htmlspecialchars((string) (($tmp = $_smarty_tpl->tpl_vars['address4']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8');?>
">
</div><!-- form__group -->
<div class="form__group">
<label for="address5" class="form__miniLabel">Postal / Zip Code</label>
<input type="text" id="address5" name="address5" value="<?php echo htmlspecialchars((string) (($tmp = $_smarty_tpl->tpl_vars['address5']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8');?>
">
</div><!-- form__group -->
</div><!-- form__wrap -->
</div><!-- form__contents -->
<?php if ((isset($_smarty_tpl->tpl_vars['errors_address']->value))) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['errors_address']->value, 'item');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
<p class="form__error"><strong>Error: <?php echo htmlspecialchars((string) $_smarty_tpl->tpl_vars['item']->value, ENT_QUOTES, 'UTF-8');?>
</strong></p>
<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}?>
</li><!-- form__item -->

<li class="form__item">
<div class="form__name">Phone<span aria-hidden="true">*</span></div>
<div class="form__contents">
<div class="form__wrap">
<div class="form__group">
<label for="phone1" class="form__miniLabel">Area Code</label>
<input type="text" id="phone1" name="phone1" value="<?php echo htmlspecialchars((string) (($tmp = $_smarty_tpl->tpl_vars['phone1']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8');?>
"<?php if ((isset($_smarty_tpl->tpl_vars['errors_phone']->value))) {?> class="error"<?php }?> required>
</div><!-- form__group -->
<div class="form__group">
<label for="phone2" class="form__miniLabel">Individual Number<small>*No space needed</small></label>
<input type="text" id="phone2" name="phone2" value="<?php echo htmlspecialchars((string) (($tmp = $_smarty_tpl->tpl_vars['phone2']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8');?>
"<?php if ((isset($_smarty_tpl->tpl_vars['errors_phone']->value))) {?> class="error"<?php }?> required>
</div><!-- form__group -->
</div><!-- form__wrap -->
</div><!-- form__contents -->
<?php if ((isset($_smarty_tpl->tpl_vars['errors_phone']->value))) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['errors_phone']->value, 'item');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
<p class="form__error"><strong>Error: <?php echo htmlspecialchars((string) $_smarty_tpl->tpl_vars['item']->value, ENT_QUOTES, 'UTF-8');?>
</strong></p>
<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}?>
</li><!-- form__item -->

<li class="form__item">
<label for="email" class="form__name">Email<span aria-hidden="true">*</span></label>
<div class="form__contents">
<input type="text" id="email" name="email" value="<?php echo htmlspecialchars((string) (($tmp = $_smarty_tpl->tpl_vars['email']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8');?>
" required>
</div><!-- form__contents -->
<?php if ((isset($_smarty_tpl->tpl_vars['errors_email']->value))) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['errors_email']->value, 'item');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
<p class="form__error"><strong>Error: <?php echo htmlspecialchars((string) $_smarty_tpl->tpl_vars['item']->value, ENT_QUOTES, 'UTF-8');?>
</strong></p>
<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}?>
</li><!-- form__item -->

<li class="form__item">
<label for="email2" class="form__name">Re-enter <br class="br-pc">Email<span aria-hidden="true">*</span></label>
<div class="form__contents">
<input type="text" id="email2" name="email2" value="<?php echo htmlspecialchars((string) (($tmp = $_smarty_tpl->tpl_vars['email2']->value ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8');?>
" required>
</div><!-- form__contents -->
<?php if ((isset($_smarty_tpl->tpl_vars['errors_email2']->value))) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['errors_email2']->value, 'item');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
<p class="form__error"><strong>Error: <?php echo htmlspecialchars((string) $_smarty_tpl->tpl_vars['item']->value, ENT_QUOTES, 'UTF-8');?>
</strong></p>
<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}?>
</li><!-- form__item -->

</ul><!-- form__list -->

<button type="submit" class="form__btn fn-form-btn" disabled>Confirm</button>

</div>
</form>

</div>
</main>

</body>
</html><?php }
}
