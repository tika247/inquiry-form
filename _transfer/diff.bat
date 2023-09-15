:: 処理開始
@echo off
setlocal ENABLEDELAYEDEXPANSION

:: 文字コードをUTF-8に
chcp 65001
:: 文字コードをShift-Jisに
:: chcp 932

:: コミット変数定義
if "%2" EQU "" (
  set NEW=HEAD
  set OLD=%1
) else (
  set NEW=%1
  set OLD=%2
)

:: ディレクトリ定義
set OUTPUT_DIR_ROOT=%~dp3
set OUTPUT_DIR_NAME=@archive
set OUTPUT_DIR_NAME_ZIP=@archive.zip
set OUTPUT_PARENT=..\

:: 差分定義 ※--diff-filterの指定はアルファベット順でないとエラーになる（例：AMDCRはエラー）
setlocal enabledelayedexpansion
set RET_DIR=
for /F "usebackq" %%i in (`git diff --name-only --diff-filter=ACMR %OLD%..%NEW%`) do (
  set RET_DIR=!RET_DIR! "%%i"
)

:: 差分を指定場所にzipで作成
git archive --format=zip --prefix=%OUTPUT_DIR_NAME%/ %NEW% %RET_DIR% -o %OUTPUT_PARENT%%OUTPUT_DIR_NAME_ZIP%

:: zipを展開
call powershell -command "Expand-Archive -Force %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%%OUTPUT_DIR_NAME_ZIP%" -DestinationPath %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%

:: 展開したzipを削除
del /s /q %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%%OUTPUT_DIR_NAME_ZIP%


:: 階層を1つ上に(git archiveは必ず.gitのある階層に出力されてしまう)

:: txtファイルの変数定義
set FILE_NAME="files_tree.txt"
set GIT_INFO="git_info.txt"
set GIT_NAME=

:: 出力内容 > 出力先 ※/A→ASCII文字使用 /f→全ファイル対象に
tree /A /f %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%%OUTPUT_DIR_NAME% > %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%FILE_NAME%

:: 念のため処理の遅延
timeout 4

:: 現在のブランチ名を変数に格納
@Echo off
git config --global core.quotepath false
for /f "tokens=1-2 delims=-" %%A in ('
    git rev-parse --abbrev-ref @
') Do Set "GIT_NAME=%%A-%%B"

set GIT_NAME=%GIT_NAME:~0,-1%

:: Teamsに流す第三者チェックのテキストを「git_info.txt」として作成

echo. > %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo. >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo. >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo. >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo お疲れさまです！納品物チェックをお願いします！ >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo. >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo ▼バックログ >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo. >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo. >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo ▼ブランチ >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo %GIT_NAME% >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo. >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo ▼コミット >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo %NEW% >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo ↓ >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo %OLD% >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo. >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo ▼格納先 >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo. >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo. >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo 鄭さん >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo ご連絡いただきありがとうございます。 >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo. >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo 下記に納品物格納しました。 >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo お手すきでご確認お願いできますでしょうか。 >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo. >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo ## 格納先 >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo. >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo ``` >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo. >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo ``` >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo. >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo ## ファイル構造 >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo. >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo ``` >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo. >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo ``` >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo. >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo よろしくお願いいたします。 >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%
echo. >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%

:: 「git_info.txt」の内容を「files_tree.txt」に統合
type %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO% >> %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%FILE_NAME%

::「git_info.txt」削除
del /s /q %OUTPUT_PARENT%%OUTPUT_DIR_ROOT%\%GIT_INFO%

:: 処理終了
exit /b
