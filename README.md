# Inquiry Form

- `/app/templates/index.html`
- `/app/templates/confirm.html`
    - set default value with `|default:''` or checking with `isset()` are needed
        - because Smarty variables, such as `$service`, are defined with SESSION and there is a case that index.php is loaded without SESSION
