# MEMO

https://www.w3.org/WAI/ARIA/apg/patterns/

## pass

```json
"OpenAI": [
    "nishina-takahiro@mitsue.co.jp",
    "Taka7115mitsue",
    "Taka 247",
    "taka-secret-key",
    "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"
],

"LinkedIn": [
    "nishina-takahiro@mitsue.co.jp",
    "&fU4gY2h"
],
```

## Design documents

https://lucid.app/documents#/documents?folder_id=recent

## to tech_memo

### 1

use `getElementByClassName` `getElementById` `getElementsByTagName` instead of `querySellector` `querySelectorAll`

[Ref](https://qiita.com/ari-chel/items/b06c68aec8849d0409dd)

### 2

【Express】

■Front Side

const articleID = 12;
const rest = axios.post(`/api/articles/${articleID}/upvote`);

■Backend Side

app.post('/api/articles/:name/upvote', async (req, res) => {
 console.log(req.params.name;);  // 12
});

## Coding

### 1

```
<!-- EJS_1 -->
<% var arr = 
[
{
ttl: '',
link:''
},
{
ttl: '',
link:''
}
]%>
<% arr.forEach(function(el,i){%>
<!-- <% i += 1 %> -->
<%- el.ttl %>
<% }); %>
```

### 2

```
<!-- EJS_2 -->
<% var arr = [
{
ttl: '',
list: [
{
ttl: '',
text: '',
link: '',
},
]
},
{
ttl: '',
list: [
{
ttl: '',
text: '',
link: '',
},
]
},
{
ttl: '',
list: [
{
ttl: '',
text: '',
link: '',
},
]
},
]%>

<% arr.forEach(function(el,i){%>
<!-- <% i += 1 %> -->

<%- el.ttl %>

<% el.list.forEach(function(el2,j){%>
<%- el2.ttl %>
<%});%>

<% }); %>

```

### 3

```
■hidden text for accessibility
clip: rect(0 0 0 0);
clip-path: inset(50%);
height: 2px;
overflow: hidden;
position: absolute;
white-space: nowrap;
width: 2px;
```

### 4

```
■grid: column fall by specific width
grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
```

### 5

```
■grid: never column fall (always 100%)
grid-template-columns: repeat(3, minmax(0, 1fr));
```

### 6

```
■stretch width over the parent
width: 100vw;
margin-left: calc(50% - 50vw);
margin-right: calc(50% - 50vw);
```

### 7

```
■to prevent a rattle movement when a multiple of modals
html {
scrollbar-gutter: stable;
}
```

## CMD

### 1

```
■get folder tree
Tree {folder path} /f
```

### 2

```
■operate file & folder

・make folder
md {new_folder_name}

・make file
echo "sample txt" > sample.txt

・remove file
del {file_name}

・remove folder
rmdir {folder_name} 
```

### 3

■list up all files in a folder
dir {folder_name}

### 4

```
■check IP address
ipconfig
```

### 5

```
■check MAC address
getmac
```

### 6

```
■operate PC

・shutdown PC
shutdown -s

・reboot PC
shutdown -r
```

### 7

```
■list up all past version of a npm package
npm v {package_name} versions
```

### 8

```
■check if the port number is used by any App
netstat -nao | find "80"

■to detect the APP using the port
①see PID value written in the result of `netstat`
②Task Manager > Detail > PID
```

## Git

### 1

```
■stash

・to save
git stash save -m 'my-stash'

・to use
git stash 'my-stash'
```

### 2

```
■checkout the previous branch
git checkout -
```

### 3

```
■fetch & checkout remote branch 

git fetch origin {branch_name}
↓
git checkout {branch_name}
```

### 4

```
■delete local branch
git branch -D {branch_name}
```

### 5

```
■get current branch name
git branch --contains
```

### 6

```
■merge from 〇〇〇 to △△△
①git checkout △△△
②git merge 〇〇〇
```

### 7

```
■dispose the latest correction

①dispose the latest
git checkout HEAD .

②dispose the correction of a specific file
git checkout HEAD <FILE_NAME>

※Regardless of before or after `git add`
```

### 8

```
■reset latest 1 commit
git reset HEAD^
```

## Regex

### 1

```
【Basic Regex】

■any one letter
.

■more than 0 repetition of a previous letter
*

■more than 1 repetition of a previous letter
+
e.g) ab+ = ab, abbbbbbbbbbbbb

■0 or 1 of repetition of a previous letter
?
e.g.) ab? = a, ab

■beginning of a line
^
\A

■end of a line
$
\Z

■one of the letters
[ ]
e.g) [F-K] = F, G, H, I, J, K

※with `^`, it means denial
e.g) [^F-K] = All letters except F, G, H, I, J and K

■specify the number of repetition
{ }
e.g) ab{3} = abbb

■alphabet || number || _
\w

■except `\w`
\W

■number
\d

■except number
\D

■space
\s

■except space
\S

■beginning or end of a word
\b
e.g) `\bnoon\b` matches `noon` and do not match `afternoon`

■letters that is not beginning or end
\B
e.g) \Bmile\B matches `Smiles` and do not match `mile`

■new line
\n
```

### 2

``` js
// Testing if regex is correct
const testString = 'My test string';
const testRegex = /string/;
testRegex.test(testString);
```

### 3

```
■new line
\n|\r\n|\r 
```

### 4

```
■line that is not including 〇〇〇
^(?!.*〇〇〇).*\n
```

### 5

```
■letters from A to B
(A.*?)({B})
```

### 6

```
■letters from A to B
(A.*?)({B})
```

### 7

```
■● is not included between ▼ and ▲
▼.*^(?!.*●).*▲
```

### 8

```
■word surronded by double quotation marks
\"[^\"]*\"
```

### 9

```
■Flag
https://www.javadrive.jp/javascript/regexp/index15.html
```

### 10

```
■letters that includes AAA, but not BBB
^(?=.*AAA)(?!.*BBB).*$
```

### 11

```
【serch by regex and replace by regex】

■before
<td colspan="5" class="ta-c">625万円</td>
<td colspan="4">

■serch
<td\scolspan="5"(.+)\n(.+)colspan="4">

■replace
<td$1\n$2colspan="4">

■after
<td colspan="5" class="ta-c">625万円</td>
<td colspan="4">
```

## TypeScript

### 1

■avoid Type-Check in a file
// @ts-nocheck

### 2

■ignore a Single-Line Type-Check
// @ts-ignore

### 3

■`e.currentTarget` Type 

define which element `e.currentTarget` is with `instanceof HTMLElement`

``` vue

<select
  name="project"
  id="project"
  class="one__project"
  @change="changeColor"
>
  <option value="">Please select</option>
  <option value="yayoi">yayoi</option>
  <option value="tamagawa">tamagawa</option>
</select>

```

``` js

const changeColor = (e: Event) => {
  if (e.currentTarget instanceof HTMLElement) {
    if (!e.currentTarget.value) {
        console.log("do something!");
    }
  }
};

```

### 4

■global.d.ts

// at tsconfig.json
"include":["src/js","types/global.d.ts"],

// at types/global.d.ts
interface sampleType {
sample?: string
}

### 5

■EventListenerOrEventListenerObject

private readonly listenerFunc: EventListenerOrEventListenerObject;

### 6

■Type of axios
Promise<AxiosResponse<○○>>

### 7

■get HTMLTemplateElement by getElementById
this._overlayTemplate = <HTMLTemplateElement>document.getElementById('js-modal-overlay');

## Shell

### 1

#!/usr/bin/bash

## Vim

### 1

■remove all file contents
:%d

### 2

■save and exit
:wq