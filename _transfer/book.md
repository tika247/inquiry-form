# Book

```
■w3c

javascript:(e => { "use strict"; const t = e.createElement("form"), n = e.createElement("input"), a = e.createElement("textarea"), p = e.createElement("input"); n.type = "checkbox", n.name = "showsource", n.value = "yes", n.checked = !0, a.name = "content", t.method = "post", t.action = "https://validator.w3.org/nu/#textarea%22,%20t.enctype%20=%20%22multipart/form-data%22,%20t.acceptCharset%20=%20%22UTF-8%22,%20t.append(n),%20t.append(a),%20t.append(p),%20e.body.append(t),%20new%20Promise(t%20=%3E%20{%20const%20n%20=%20new%20XMLHttpRequest;%20n.open(%22GET%22,%20e.URL,%20!0),%20n.onload%20=%20(()%20=%3E%20t(n.response)),%20n.send()%20}).then(e%20=%3E%20{%20a.value%20=%20e,%20t.submit()%20})%20})(document);
```